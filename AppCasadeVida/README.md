# Casa de Vida - Sistema de Gestión Integral

Una aplicación web completa para la gestión de casas de vida, control de asistencias y seguimiento de integrantes.

## Características Principales

### Gestión de Usuarios y Roles
- **Sistema de autenticación** con login seguro
- **Roles definidos**: Pastor, Anciano, Lider, Colaborador, Anfitrión, Integrante
- **Control de acceso** basado en permisos por rol

### Gestión de Entidades
- **CRUD completo** para todas las entidades:
  - Iglesias
  - Roles
  - Usuarios
  - Territorios
  - Casas de Vida
  - Integrantes
  - Enseñanzas
  - Tareas

### Sistema de Asistencias
- **Registro semanal** de asistencias a reuniones
- **Control por casa de vida** con fotos de integrantes
- **Historial completo** con estados (Pendiente, Aprobada, Reversada)
- **Secuencial único** para cada registro

### Gestión de Enseñanzas
- **Subida de archivos** por Pastores y Ancianos
- **Visualización y descarga** para Líderes
- **Soporte para múltiples formatos** (PDF, DOC, PPT, MP4, MP3)

### Sistema de Tareas
- **Asignación de tareas** por Pastores y Ancianos
- **Seguimiento de estados**: Pendiente, Iniciando, Terminada
- **Comentarios y fechas de culminación**
- **Bloqueo de edición** al finalizar

### Notificaciones
- **Sistema en tiempo real** con sonido de alerta
- **Notificaciones personalizadas** por rol
- **Alertas de cumpleaños** automáticas
- **Contador de notificaciones** pendientes

### Dashboard Principal
- **Estadísticas en tiempo real**:
  - Personas por bautizar
  - Total de integrantes
  - Casas asignadas
  - Notificaciones pendientes
- **Lista de cumpleañeros** del mes
- **Actividad reciente**

## Estructura del Proyecto

```
AppCasadeVida/
|-- index.html              # Página principal
|-- css/
|   `-- style.css          # Estilos principales
|-- js/
|   |-- database.js        # Gestión de base de datos (JSON)
|   |-- auth.js            # Sistema de autenticación
|   |-- app.js             # Controlador principal
|   |-- crud.js            # Operaciones CRUD
|   |-- notifications.js   # Sistema de notificaciones
|   `-- views.js           # Vistas de la aplicación
|-- sounds/
|   `-- notification.mp3   # Sonido de notificación
`-- README.md              # Este archivo
```

## Instalación y Uso

### Requisitos
- Navegador web moderno (Chrome, Firefox, Safari, Edge)
- No requiere instalación de servidor

### Pasos para iniciar

1. **Descargar** los archivos del proyecto
2. **Abrir** `index.html` en un navegador web
3. **Iniciar sesión** con las credenciales por defecto:
   - Usuario: `admin`
   - Contraseña: `admin123`

### Configuración Inicial

1. **Crear roles** si es necesario (ya vienen predefinidos)
2. **Registrar usuarios** con sus respectivos roles
3. **Configurar territorios** y asignar ancianos
4. **Crear casas de vida** y asignar líderes
5. **Registrar integrantes** en cada casa de vida

## Base de Datos

La aplicación utiliza **localStorage** del navegador para almacenar todos los datos en formato JSON. Esto permite:

- **Persistencia de datos** sin necesidad de servidor
- **Exportación/importación** de datos
- **Backup sencillo** copiando el archivo de almacenamiento

## Roles y Permisos

### Pastor
- **Acceso completo** a todas las funciones
- **Visibilidad total** de todos los territorios y casas de vida
- **Gestión de usuarios** y configuración del sistema

### Anciano
- **Visibilidad** de su territorio asignado
- **Gestión** de casas de vida e integrantes de su territorio
- **Creación** de enseñanzas y tareas

### Líder
- **Visibilidad** solo de su casa de vida asignada
- **Registro** de asistencias
- **Visualización** de enseñanzas
- **Gestión** de tareas asignadas

### Colaborador, Anfitrión, Integrante
- **Acceso limitado** a información básica
- **Visualización** de su información personal

## Características Técnicas

### Frontend
- **Bootstrap 5** para diseño responsive
- **Font Awesome** para iconos
- **JavaScript vanilla** para funcionalidad

### Almacenamiento
- **LocalStorage** para persistencia
- **JSON** como formato de datos
- **Sistema de IDs autoincrementales**

### Seguridad
- **Hashing** básico de contraseñas
- **Validación** de formularios
- **Control de acceso** por roles

## Funcionalidades Especiales

### Sistema de Notificaciones
- **Alertas automáticas** para nuevos registros
- **Sonido de notificación** personalizable
- **Filtrado** por usuario y tipo

### Gestión de Archivos
- **Soporte** para múltiples formatos
- **Descarga segura** de enseñanzas
- **Validación** de tipos de archivo

### Reportes y Estadísticas
- **Dashboard en tiempo real**
- **Conteos automáticos** por categorías
- **Filtros** por fechas y estados

## Personalización

### Colores de Territorios
Cada territorio puede tener un color asignado para mejor identificación visual.

### Tema Visual
La aplicación utiliza gradientes modernos y diseños responsivos que pueden personalizarse modificando el archivo CSS.

### Sonidos
El sonido de notificación puede reemplazarse cambiando el archivo `sounds/notification.mp3`.

## Soporte y Mantenimiento

### Backup de Datos
Para realizar un backup:
1. Abrir las herramientas de desarrollador del navegador
2. Ir a la pestaña Application/Storage
3. Localizar el localStorage
4. Copiar el valor de `casadevida_db.json`
5. Guardar en un archivo de texto

### Restauración de Datos
Para restaurar datos:
1. Abrir las herramientas de desarrollador
2. Ir a localStorage
3. Crear nueva clave `casadevida_db.json`
4. Pegar el contenido del backup

## Licencia

Este proyecto es de código abierto y puede utilizarse libremente para fines educativos y religiosos.

## Contacto

Para soporte técnico o sugerencias, contactar al desarrollador del proyecto.

---

**Nota**: Esta aplicación está diseñada específicamente para la gestión de comunidades religiosas y casas de vida, adaptada a las necesidades organizacionales descritas en los requisitos.
