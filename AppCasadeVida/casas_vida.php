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
    $direccion = $_POST['direccion'] ?? '';
    $dia_reunion = $_POST['dia_reunion'] ?? '';
    $hora_reunion = $_POST['hora_reunion'] ?? '';
    $capacidad_maxima = $_POST['capacidad_maxima'] ?? 15;
    $id_lider = $_POST['id_lider'] ?? null;

    if (!empty($nombre)) {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            if ($conn) {
                $sql = "INSERT INTO casas_vida (nombre, direccion, dia_reunion, hora_reunion, capacidad_maxima, id_lider) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([$nombre, $direccion, $dia_reunion, $hora_reunion, $capacidad_maxima, $id_lider]);

                if ($result) {
                    $message = '<div class="alert alert-success">Casa de vida creada exitosamente</div>';
                } else {
                    $message = '<div class="alert alert-danger">Error al crear casa de vida</div>';
                }
            }
        } catch(PDOException $exception) {
            $message = '<div class="alert alert-danger">Error: ' . $exception->getMessage() . '</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Por favor complete el nombre de la casa de vida</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $database = new Database();
        $conn = $database->getConnection();

        if ($conn) {
            $sql = "UPDATE casas_vida SET activa = 0 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$id]);

            if ($result) {
                $message = '<div class="alert alert-success">Casa de vida eliminada exitosamente</div>';
            } else {
                $message = '<div class="alert alert-danger">Error al eliminar casa de vida</div>';
            }
        }
    } catch(PDOException $exception) {
        $message = '<div class="alert alert-danger">Error: ' . $exception->getMessage() . '</div>';
    }
}

// Obtener casas de vida
function getCasasVida() {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        try {
            $sql = "SELECT cv.*, u.nombre as lider_nombre 
                    FROM casas_vida cv 
                    LEFT JOIN usuarios u ON cv.id_lider = u.id 
                    WHERE cv.activa = 1 
                    ORDER BY cv.nombre";
            $stmt = $conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            return [];
        }
    }
    return [];
}

// Obtener usuarios para select de líderes
function getUsuarios() {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        try {
            $sql = "SELECT id, nombre FROM usuarios WHERE activo = 1 AND rol IN ('lider', 'anciano', 'pastor', 'admin') ORDER BY nombre";
            $stmt = $conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            return [];
        }
    }
    return [];
}

$casas_vida = getCasasVida();
$usuarios = getUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casas de Vida - Casa de Vida</title>
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
                        <a href="usuarios.php" class="nav-link">
                            <i class="fas fa-users me-2"></i>
                            Usuarios
                        </a>
                        <a href="casas_vida.php" class="nav-link active">
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
                        <h5 class="mb-0">Gestión de Casas de Vida</h5>
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

                    <!-- Create Casa Button -->
                    <div class="mb-4">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCasaModal">
                            <i class="fas fa-plus me-2"></i>
                            Nueva Casa de Vida
                        </button>
                    </div>

                    <!-- Casas Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Día Reunión</th>
                                            <th>Hora</th>
                                            <th>Líder</th>
                                            <th>Capacidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($casas_vida as $casa): ?>
                                            <tr>
                                                <td><?php echo $casa['id']; ?></td>
                                                <td><?php echo htmlspecialchars($casa['nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($casa['direccion'] ?? '-'); ?></td>
                                                <td><?php echo htmlspecialchars($casa['dia_reunion'] ?? '-'); ?></td>
                                                <td><?php echo $casa['hora_reunion'] ? date('H:i', strtotime($casa['hora_reunion'])) : '-'; ?></td>
                                                <td><?php echo htmlspecialchars($casa['lider_nombre'] ?? 'Sin líder'); ?></td>
                                                <td><?php echo $casa['capacidad_maxima']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary btn-action">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="casas_vida.php?action=delete&id=<?php echo $casa['id']; ?>" 
                                                       class="btn btn-sm btn-outline-danger btn-action"
                                                       onclick="return confirm('¿Está seguro de eliminar esta casa de vida?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
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

    <!-- Create Casa Modal -->
    <div class="modal fade" id="createCasaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Casa de Vida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="casas_vida.php?action=create" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dia_reunion" class="form-label">Día de Reunión</label>
                            <select class="form-select" id="dia_reunion" name="dia_reunion">
                                <option value="">Seleccionar día</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hora_reunion" class="form-label">Hora de Reunión</label>
                            <input type="time" class="form-control" id="hora_reunion" name="hora_reunion">
                        </div>
                        <div class="mb-3">
                            <label for="capacidad_maxima" class="form-label">Capacidad Máxima</label>
                            <input type="number" class="form-control" id="capacidad_maxima" name="capacidad_maxima" value="15" min="1" max="50">
                        </div>
                        <div class="mb-3">
                            <label for="id_lider" class="form-label">Líder</label>
                            <select class="form-select" id="id_lider" name="id_lider">
                                <option value="">Seleccionar líder</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?php echo $usuario['id']; ?>">
                                        <?php echo htmlspecialchars($usuario['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Casa de Vida</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
