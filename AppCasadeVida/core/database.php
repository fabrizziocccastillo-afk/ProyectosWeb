<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'casas_vida';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            echo "✅ Conexión a MySQL establecida correctamente";
            return $this->conn;
            
        } catch(PDOException $exception) {
            echo "❌ Error de conexión: " . $exception->getMessage();
            return null;
        }
    }

    // Verificar si MySQL está disponible
    public function checkMySQL() {
        try {
            $dsn = "mysql:host=" . $this->host . ";charset=" . $this->charset;
            $conn = new PDO($dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Verificar si la base de datos existe
            $stmt = $conn->query("SHOW DATABASES LIKE '" . $this->db_name . "'");
            $db_exists = $stmt->rowCount() > 0;
            
            if ($db_exists) {
                echo "✅ Base de datos '" . $this->db_name . "' existe";
            } else {
                echo "⚠️ Base de datos '" . $this->db_name . "' no existe. Creándola...";
                $conn->exec("CREATE DATABASE " . $this->db_name);
                echo "✅ Base de datos creada";
            }
            
            return true;
            
        } catch(PDOException $exception) {
            echo "❌ Error verificando MySQL: " . $exception->getMessage();
            return false;
        }
    }

    // Crear tablas necesarias
    public function createTables() {
        try {
            $this->getConnection();
            
            // Tabla usuarios
            $sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                rol VARCHAR(20) DEFAULT 'miembro',
                telefono VARCHAR(20),
                fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                activo BOOLEAN DEFAULT TRUE
            )";
            $this->conn->exec($sql_usuarios);
            
            // Tabla casas_vida
            $sql_casas = "CREATE TABLE IF NOT EXISTS casas_vida (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                direccion TEXT,
                dia_reunion VARCHAR(20),
                hora_reunion TIME,
                capacidad_maxima INT DEFAULT 15,
                id_lider INT,
                activa BOOLEAN DEFAULT TRUE,
                FOREIGN KEY (id_lider) REFERENCES usuarios(id)
            )";
            $this->conn->exec($sql_casas);
            
            // Insertar usuario administrador si no existe
            $check_admin = "SELECT id FROM usuarios WHERE email = 'admin@casasvida.com'";
            $stmt = $this->conn->prepare($check_admin);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                $insert_admin = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($insert_admin);
                $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
                $stmt->execute(['Administrador', 'admin@casasvida.com', $hashed_password, 'admin']);
                echo "✅ Usuario administrador creado";
            }
            
            echo "✅ Tablas creadas correctamente";
            return true;
            
        } catch(PDOException $exception) {
            echo "❌ Error creando tablas: " . $exception->getMessage();
            return false;
        }
    }
}

// Función para verificar instalación
function verificarInstalacion() {
    echo "<h2>🔍 Verificación de Instalación</h2>";
    
    // Verificar PHP
    echo "<h3>📌 PHP</h3>";
    if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
        echo "✅ PHP " . PHP_VERSION . " (Compatible)";
    } else {
        echo "❌ PHP " . PHP_VERSION . " (Requiere PHP 7.4 o superior)";
    }
    
    // Verificar extensiones necesarias
    echo "<h3>📌 Extensiones PHP</h3>";
    $extensions = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'mbstring'];
    foreach ($extensions as $ext) {
        if (extension_loaded($ext)) {
            echo "✅ $ext - Instalado<br>";
        } else {
            echo "❌ $ext - No instalado<br>";
        }
    }
    
    // Verificar MySQL
    echo "<h3>📌 MySQL</h3>";
    $db = new Database();
    if ($db->checkMySQL()) {
        if ($db->createTables()) {
            echo "✅ MySQL configurado correctamente";
        }
    }
    
    echo "<h3>📌 Archivos del Sistema</h3>";
    $files = [
        './core/configGeneral.php' => 'Configuración General',
        './core/database.php' => 'Base de Datos',
        './controllers/viewsController.php' => 'Controlador de Vistas',
        './models/viewsModel.php' => 'Modelo de Vistas',
        './views/template.php' => 'Plantilla Principal'
    ];
    
    foreach ($files as $file => $description) {
        if (file_exists($file)) {
            echo "✅ $description - $file<br>";
        } else {
            echo "❌ $description - $file (Faltante)<br>";
        }
    }
}

// Ejecutar verificación si se accede directamente
if (basename($_SERVER['PHP_SELF']) == 'database.php') {
    verificarInstalacion();
}
?>
