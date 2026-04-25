<?php
session_start();
require_once 'config/database.php';

// Verificar si está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener estadísticas
function getEstadisticas() {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        try {
            $stats = [];
            
            // Total usuarios
            $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios WHERE activo = 1");
            $stats['total_usuarios'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total casas de vida
            $stmt = $conn->query("SELECT COUNT(*) as total FROM casas_vida WHERE activa = 1");
            $stats['total_casas_vida'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total miembros
            $stmt = $conn->query("SELECT COUNT(*) as total FROM miembros WHERE activo = 1");
            $stats['total_miembros'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Reuniones esta semana
            $stmt = $conn->query("SELECT COUNT(*) as total FROM reuniones WHERE YEARWEEK(fecha) = YEARWEEK(CURDATE()) AND activa = 1");
            $stats['reuniones_semana'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Promedio asistencia
            $stmt = $conn->query("SELECT AVG(CASE WHEN asistio = 1 THEN 1 ELSE 0 END) * 100 as promedio FROM asistencia WHERE fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
            $stats['promedio_asistencia'] = round($stmt->fetch(PDO::FETCH_ASSOC)['promedio'] ?? 0);
            
            return $stats;
        } catch(PDOException $exception) {
            return [];
        }
    }
    return [];
}

$estadisticas = getEstadisticas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Casa de Vida</title>
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
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
                        <a href="dashboard.php" class="nav-link active">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                        <a href="usuarios.php" class="nav-link">
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
                        <h5 class="mb-0">Dashboard</h5>
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

                <!-- Stats Cards -->
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">Total Usuarios</h6>
                                            <h3 class="mb-0"><?php echo $estadisticas['total_usuarios'] ?? 0; ?></h3>
                                        </div>
                                        <div class="stat-icon bg-primary text-white ms-3">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">Casas de Vida</h6>
                                            <h3 class="mb-0"><?php echo $estadisticas['total_casas_vida'] ?? 0; ?></h3>
                                        </div>
                                        <div class="stat-icon bg-success text-white ms-3">
                                            <i class="fas fa-home"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">Total Miembros</h6>
                                            <h3 class="mb-0"><?php echo $estadisticas['total_miembros'] ?? 0; ?></h3>
                                        </div>
                                        <div class="stat-icon bg-info text-white ms-3">
                                            <i class="fas fa-user-friends"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">Reuniones Semana</h6>
                                            <h3 class="mb-0"><?php echo $estadisticas['reuniones_semana'] ?? 0; ?></h3>
                                        </div>
                                        <div class="stat-icon bg-warning text-white ms-3">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-clock me-2"></i>
                                        Actividad Reciente
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-user-plus me-2 text-primary"></i>
                                                    Nuevo usuario registrado
                                                </div>
                                                <small class="text-muted">Hace 2 horas</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-home me-2 text-success"></i>
                                                    Casa de vida creada
                                                </div>
                                                <small class="text-muted">Hace 5 horas</small>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-calendar-check me-2 text-info"></i>
                                                    Reunión registrada
                                                </div>
                                                <small class="text-muted">Hace 1 día</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
