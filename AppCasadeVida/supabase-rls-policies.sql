-- Políticas RLS (Row Level Security) para App Casas de Vida
-- Estas políticas permiten acceso seguro a los datos según el rol del usuario

-- ========================================
-- POLÍTICAS PARA TABLA USUARIOS
-- ========================================

-- Permitir que cualquier usuario autenticado vea todos los usuarios activos
CREATE POLICY "Usuarios activos visibles para todos" ON usuarios
FOR SELECT USING (auth.role() = 'authenticated');

-- Permitir que usuarios autenticados puedan insertar nuevos usuarios
CREATE POLICY "Insertar usuarios" ON usuarios
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- Permitir que usuarios actualicen su propio perfil
CREATE POLICY "Actualizar propio perfil" ON usuarios
FOR UPDATE USING (auth.email() = email);

-- ========================================
-- POLÍTICAS PARA TABLA CASAS_DE_VIDA
-- ========================================

-- Permitir ver casas de vida activas
CREATE POLICY "Casas de vida activas visibles" ON casas_vida
FOR SELECT USING (activa = true);

-- Permitir insertar casas de vida
CREATE POLICY "Insertar casas de vida" ON casas_vida
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- Permitir que líderes actualicen sus casas asignadas
CREATE POLICY "Líder puede actualizar su casa" ON casas_vida
FOR UPDATE USING (id_lider IN (
    SELECT id FROM usuarios WHERE email = auth.email()
));

-- ========================================
-- POLÍTICAS PARA TABLA MIEMBROS
-- ========================================

-- Permitir ver miembros activos
CREATE POLICY "Miembros activos visibles" ON miembros
FOR SELECT USING (activo = true);

-- Permitir insertar miembros
CREATE POLICY "Insertar miembros" ON miembros
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- Permitir actualizar miembros
CREATE POLICY "Actualizar miembros" ON miembros
FOR UPDATE WITH CHECK (auth.role() = 'authenticated');

-- ========================================
-- POLÍTICAS PARA TABLA REUNIONES
-- ========================================

-- Permitir ver reuniones
CREATE POLICY "Reuniones visibles" ON reuniones
FOR SELECT USING (true);

-- Permitir insertar reuniones
CREATE POLICY "Insertar reuniones" ON reuniones
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- ========================================
-- POLÍTICAS PARA TABLA ASISTENCIA
-- ========================================

-- Permitir ver asistencia
CREATE POLICY "Asistencia visible" ON asistencia
FOR SELECT USING (true);

-- Permitir insertar asistencia
CREATE POLICY "Insertar asistencia" ON asistencia
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- ========================================
-- POLÍTICAS PARA TABLA ENSEÑANZAS
-- ========================================

-- Permitir ver enseñanzas activas
CREATE POLICY "Enseñanzas activas visibles" ON enseñanzas
FOR SELECT USING (activo = true);

-- Permitir insertar enseñanzas
CREATE POLICY "Insertar enseñanzas" ON enseñanzas
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- ========================================
-- POLÍTICAS PARA TABLA NOTIFICACIONES
-- ========================================

-- Permitir ver solo las notificaciones del usuario actual
CREATE POLICY "Ver propias notificaciones" ON notificaciones
FOR SELECT USING (id_usuario = (
    SELECT id FROM usuarios WHERE email = auth.email()
));

-- Permitir insertar notificaciones
CREATE POLICY "Insertar notificaciones" ON notificaciones
FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- ========================================
-- ACTIVAR RLS EN TODAS LAS TABLAS
-- ========================================

ALTER TABLE usuarios ENABLE ROW LEVEL SECURITY;
ALTER TABLE casas_vida ENABLE ROW LEVEL SECURITY;
ALTER TABLE miembros ENABLE ROW LEVEL SECURITY;
ALTER TABLE reuniones ENABLE ROW LEVEL SECURITY;
ALTER TABLE asistencia ENABLE ROW LEVEL SECURITY;
ALTER TABLE enseñanzas ENABLE ROW LEVEL SECURITY;
ALTER TABLE notificaciones ENABLE ROW LEVEL SECURITY;
ALTER TABLE configuracion ENABLE ROW LEVEL SECURITY;
ALTER TABLE auditoria ENABLE ROW LEVEL SECURITY;
