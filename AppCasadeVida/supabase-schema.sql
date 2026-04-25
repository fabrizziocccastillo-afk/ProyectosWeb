-- Esquema de base de datos para App Casas de Vida
-- Sistema de gestión de asistencia y reuniones semanales

-- 1. Tabla de usuarios con roles
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL CHECK (rol IN ('pastor', 'anciano', 'lider', 'miembro', 'admin')),
    telefono VARCHAR(20),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    ultimo_acceso TIMESTAMP
);

-- 2. Tabla de casas de vida (grupos)
CREATE TABLE casas_vida (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(200),
    dia_reunion VARCHAR(20) NOT NULL, -- lunes, martes, etc.
    hora_reunion TIME NOT NULL,
    id_lider INTEGER REFERENCES usuarios(id),
    id_anterior_lider INTEGER REFERENCES usuarios(id),
    capacidad_maxima INTEGER DEFAULT 15,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activa BOOLEAN DEFAULT TRUE,
    descripcion TEXT
);

-- 3. Tabla de miembros
CREATE TABLE miembros (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    direccion VARCHAR(200),
    fecha_conversion DATE,
    id_casa_vida INTEGER REFERENCES casas_vida(id),
    fecha_ingreso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    observaciones TEXT
);

-- 4. Tabla de reuniones
CREATE TABLE reuniones (
    id SERIAL PRIMARY KEY,
    id_casa_vida INTEGER REFERENCES casas_vida(id),
    fecha_reunion DATE NOT NULL,
    tema VARCHAR(200),
    tipo_reunion VARCHAR(20) DEFAULT 'semanal' CHECK (tipo_reunion IN ('semanal', 'especial', 'capacitacion')),
    id_enseñanza INTEGER,
    asistencia_total INTEGER DEFAULT 0,
    visitantes INTEGER DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Tabla de asistencia detallada
CREATE TABLE asistencia (
    id SERIAL PRIMARY KEY,
    id_reunion INTEGER REFERENCES reuniones(id),
    id_miembro INTEGER REFERENCES miembros(id),
    presente BOOLEAN NOT NULL,
    es_visitante BOOLEAN DEFAULT FALSE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    observaciones TEXT,
    UNIQUE(id_reunion, id_miembro)
);

-- 6. Tabla de enseñanzas/material
CREATE TABLE enseñanzas (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    tipo_material VARCHAR(20) CHECK (tipo_material IN ('video', 'documento', 'audio', 'presentacion')),
    url_archivo VARCHAR(500),
    id_creador INTEGER REFERENCES usuarios(id),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    categoria VARCHAR(50),
    activo BOOLEAN DEFAULT TRUE
);

-- 7. Tabla de notificaciones
CREATE TABLE notificaciones (
    id SERIAL PRIMARY KEY,
    id_usuario INTEGER REFERENCES usuarios(id),
    titulo VARCHAR(200) NOT NULL,
    mensaje TEXT NOT NULL,
    tipo VARCHAR(20) DEFAULT 'info' CHECK (tipo IN ('info', 'success', 'warning', 'error')),
    leida BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    url_accion VARCHAR(200)
);

-- 8. Tabla de configuración del sistema
CREATE TABLE configuracion (
    id SERIAL PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descripcion TEXT,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 9. Tabla de auditoría (logs)
CREATE TABLE auditoria (
    id SERIAL PRIMARY KEY,
    id_usuario INTEGER REFERENCES usuarios(id),
    accion VARCHAR(100) NOT NULL,
    tabla_afectada VARCHAR(50),
    id_registro_afectado INTEGER,
    datos_anteriores JSONB,
    datos_nuevos JSONB,
    fecha_accion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45)
);

-- Crear índices para mejor rendimiento
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_rol ON usuarios(rol);
CREATE INDEX idx_casas_vida_lider ON casas_vida(id_lider);
CREATE INDEX idx_miembros_casa_vida ON miembros(id_casa_vida);
CREATE INDEX idx_reuniones_casa_vida_fecha ON reuniones(id_casa_vida, fecha_reunion);
CREATE INDEX idx_asistencia_reunion ON asistencia(id_reunion);
CREATE INDEX idx_asistencia_miembro ON asistencia(id_miembro);
CREATE INDEX idx_notificaciones_usuario ON notificaciones(id_usuario);
CREATE INDEX idx_auditoria_usuario ON auditoria(id_usuario);
CREATE INDEX idx_auditoria_fecha ON auditoria(fecha_accion);

-- Insertar configuración inicial
INSERT INTO configuracion (clave, valor, descripcion) VALUES
('nombre_iglesia', 'Iglesia Local', 'Nombre de la iglesia'),
('dias_semana', '["lunes","martes","miércoles","jueves","viernes","sábado","domingo"]', 'Días de la semana disponibles'),
('hora_inicio_default', '19:00', 'Hora por defecto para reuniones'),
('notificaciones_activas', 'true', 'Activar sistema de notificaciones'),
('backup_automatico', 'true', 'Backup automático de datos');

-- Insertar usuario administrador por defecto
INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES
('Administrador', 'admin@casasvida.com', '$2b$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewdBPj6ukx.LFvO6', 'admin');

-- Crear políticas de seguridad (RLS - Row Level Security)
ALTER TABLE usuarios ENABLE ROW LEVEL SECURITY;
ALTER TABLE casas_vida ENABLE ROW LEVEL SECURITY;
ALTER TABLE miembros ENABLE ROW LEVEL SECURITY;
ALTER TABLE reuniones ENABLE ROW LEVEL SECURITY;
ALTER TABLE asistencia ENABLE ROW LEVEL SECURITY;
ALTER TABLE enseñanzas ENABLE ROW LEVEL SECURITY;
ALTER TABLE notificaciones ENABLE ROW LEVEL SECURITY;

-- Políticas básicas (ajustar según necesidades)
CREATE POLICY "Usuarios pueden ver su propio perfil" ON usuarios
    FOR SELECT USING (auth.uid()::text = email::text);

CREATE POLICY "Líderes pueden ver su casa de vida" ON casas_vida
    FOR ALL USING (id_lider IN (SELECT id FROM usuarios WHERE email = auth.uid()::text));

-- Crear funciones útiles
CREATE OR REPLACE FUNCTION actualizar_asistencia_reunion()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE reuniones 
    SET asistencia_total = (
        SELECT COUNT(*) 
        FROM asistencia 
        WHERE id_reunion = NEW.id_reunion AND presente = true
    )
    WHERE id = NEW.id_reunion;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger para actualizar automáticamente el conteo de asistencia
CREATE TRIGGER trigger_actualizar_asistencia
    AFTER INSERT OR UPDATE ON asistencia
    FOR EACH ROW
    EXECUTE FUNCTION actualizar_asistencia_reunion();

-- Vista para estadísticas rápidas
CREATE VIEW vista_estadisticas AS
SELECT 
    (SELECT COUNT(*) FROM usuarios WHERE activo = true) as total_usuarios,
    (SELECT COUNT(*) FROM casas_vida WHERE activa = true) as total_casas_vida,
    (SELECT COUNT(*) FROM miembros WHERE activo = true) as total_miembros,
    (SELECT COUNT(*) FROM reuniones WHERE fecha_reunion >= CURRENT_DATE - INTERVAL '7 days') as reuniones_semana,
    (SELECT AVG(asistencia_total) FROM reuniones WHERE fecha_reunion >= CURRENT_DATE - INTERVAL '30 days') as promedio_asistencia;
