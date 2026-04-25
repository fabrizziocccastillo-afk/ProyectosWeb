<?php
session_start();
require_once 'config/database.php';

// Verificar si está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Manejar acciones CRUD
$action = $_GET['action'] ?? '';
$message = '';

if ($action == 'create' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'miembro';
    $telefono = $_POST['telefono'] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            if ($conn) {
                $sql = "INSERT INTO usuarios (nombre, email, password, rol, telefono) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $result = $stmt->execute([$nombre, $email, $hashed_password, $rol, $telefono]);

                if ($result) {
                    $message = '<div class="alert alert-success">Usuario creado exitosamente</div>';
                } else {
                    $message = '<div class="alert alert-danger">Error al crear usuario</div>';
                }
            }
        } catch(PDOException $exception) {
            $message = '<div class="alert alert-danger">Error: ' . $exception->getMessage() . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Por favor complete todos los campos requeridos</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $database = new Database();
        $conn = $database->getConnection();

        if ($conn) {
            $sql = "UPDATE usuarios SET activo = 0 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$id]);

            if ($result) {
                $message = '<div class="alert alert-success">Usuario eliminado exitosamente</div>';
            } else {
                $message = '<div class="alert alert-danger">Error al eliminar usuario</div>';
            }
        }
    } catch(PDOException $exception) {
        $message = '<div class="alert alert-danger">Error: ' . $exception->getMessage() . '</div>';
    }
}

// Obtener usuarios
function getUsuarios() {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        try {
            $sql = "SELECT id, nombre, email, rol, telefono, fecha_creacion, activo FROM usuarios ORDER BY nombre";
            $stmt = $conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            return [];
        }
    }
    return [];
}

$usuarios = getUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Casa de Vida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-action {
            padding: 5px 10px;
            border-radius: 5px;
            margin: 0 2px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0 sidebar">
                <div class="p-3">
                    <h4 class="mb-4">
                        <i class="fas fa-home me-2"></i>
                        Casa de Vida
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                        <a href="usuarios.php" class="nav-link active">
                            <i class="fas fa-users me-2"></i>
                            Usuarios
                        </a>
                        <a href="casas_vida.php" class="nav-link">
                            <i class="fas fa-home me-2"></i>
                            Casas de Vida
                        </a>
                        <a href="miembros.php" class="nav-link">
                            <i class="fas fa-user-friends me-2"></i>
                            Miembros
                        </a>
                        <a href="reuniones.php" class="nav-link">
                            <i class="fas fa-calendar me-2"></i>
                            Reuniones
                        </a>
                        <a href="asistencia.php" class="nav-link">
                            <i class="fas fa-check-circle me-2"></i>
                            Asistencia
                        </a>
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.3);">
                        <a href="logout.php" class="nav-link">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Cerrar Sesión
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4">
                    <div class="container-fluid">
                        <h5 class="mb-0">Gestión de Usuarios</h5>
                        <div class="d-flex align-items-center">
                            <span class="me-3">
                                <i class="fas fa-user-circle me-2"></i>
                                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </span>
                            <small class="badge bg-primary">
                                <?php echo htmlspecialchars(ucfirst($_SESSION['user_role'])); ?>
                            </small>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="container-fluid">
                    <?php echo $message; ?>

                    <!-- Create User Button -->
                    <div class="mb-4">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            <i class="fas fa-plus me-2"></i>
                            Nuevo Usuario
                        </button>
                    </div>

                    <!-- Users Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Teléfono</th>
                                            <th>Fecha Creación</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <tr>
                                                <td><?php echo $usuario['id']; ?></td>
                                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        <?php echo htmlspecialchars(ucfirst($usuario['rol'])); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($usuario['telefono'] ?? '-'); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($usuario['fecha_creacion'])); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $usuario['activo'] ? 'success' : 'danger'; ?>">
                                                        <?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary btn-action">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if ($usuario['id'] != $_SESSION['user_id']): ?>
                                                        <a href="usuarios.php?action=delete&id=<?php echo $usuario['id']; ?>" 
                                                           class="btn btn-sm btn-outline-danger btn-action"
                                                           onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="usuarios.php?action=create" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select" id="rol" name="rol">
                                <option value="miembro">Miembro</option>
                                <option value="lider">Líder</option>
                                <option value="anciano">Anciano</option>
                                <option value="pastor">Pastor</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
