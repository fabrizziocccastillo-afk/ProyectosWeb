<?php
require_once "./core/configGeneral.php";
require_once "./core/database.php";

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Verificación de Instalación - CASADEVIDA</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <div class='card'>
                    <div class='card-header bg-primary text-white'>
                        <h3><i class='fas fa-check-circle me-2'></i>Verificación de Instalación</h3>
                    </div>
                    <div class='card-body'>";

// Verificar PHP
echo "<div class='mb-4'>
    <h5><i class='fas fa-code me-2'></i>PHP</h5>";
if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
    echo "<div class='alert alert-success'>
        <i class='fas fa-check me-2'></i>PHP " . PHP_VERSION . " (Compatible)
    </div>";
} else {
    echo "<div class='alert alert-danger'>
        <i class='fas fa-times me-2'></i>PHP " . PHP_VERSION . " (Requiere PHP 7.4 o superior)
    </div>";
}
echo "</div>";

// Verificar extensiones necesarias
echo "<div class='mb-4'>
    <h5><i class='fas fa-puzzle-piece me-2'></i>Extensiones PHP</h5>";
$extensions = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'mbstring'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<div class='alert alert-success'>
            <i class='fas fa-check me-2'></i>$ext - Instalado
        </div>";
    } else {
        echo "<div class='alert alert-danger'>
            <i class='fas fa-times me-2'></i>$ext - No instalado
        </div>";
    }
}
echo "</div>";

// Verificar MySQL
echo "<div class='mb-4'>
    <h5><i class='fas fa-database me-2'></i>MySQL</h5>";
$db = new Database();
if ($db->checkMySQL()) {
    if ($db->createTables()) {
        echo "<div class='alert alert-success'>
            <i class='fas fa-check me-2'></i>MySQL configurado correctamente
        </div>";
    }
} else {
    echo "<div class='alert alert-danger'>
        <i class='fas fa-times me-2'></i>Error en la configuración de MySQL
    </div>";
}
echo "</div>";

// Verificar archivos del sistema
echo "<div class='mb-4'>
    <h5><i class='fas fa-folder me-2'></i>Archivos del Sistema</h5>";
$files = [
    './core/configGeneral.php' => 'Configuración General',
    './core/database.php' => 'Base de Datos',
    './controllers/viewsController.php' => 'Controlador de Vistas',
    './models/viewsModel.php' => 'Modelo de Vistas',
    './views/template.php' => 'Plantilla Principal'
];

foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "<div class='alert alert-success'>
            <i class='fas fa-check me-2'></i>$description - $file
        </div>";
    } else {
        echo "<div class='alert alert-danger'>
            <i class='fas fa-times me-2'></i>$description - $file (Faltante)
        </div>";
    }
}
echo "</div>";

// Información del servidor
echo "<div class='mb-4'>
    <h5><i class='fas fa-server me-2'></i>Información del Servidor</h5>
    <div class='alert alert-info'>
        <strong>Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>
        <strong>PHP Version:</strong> " . PHP_VERSION . "<br>
        <strong>Servidor:</strong> " . $_SERVER['SERVER_NAME'] . "<br>
        <strong>Raíz del documento:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>
        <strong>URL Base:</strong> " . SERVERURL . "
    </div>
</div>";

echo "</div>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>";
?>
