<?php
// Configuración de la base de datos MySQL
class Database {
    private $host = 'localhost';
    private $db_name = 'casas_vida';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

// Crear tablas si no existen
function createTables() {
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        try {
            // Tabla usuarios
            $sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                rol VARCHAR(20) NOT NULL DEFAULT 'miembro',
                telefono VARCHAR(20),
                fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                activo BOOLEAN DEFAULT TRUE
            )";
            $conn->exec($sql_usuarios);

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
            $conn->exec($sql_casas);

            // Tabla miembros
            $sql_miembros = "CREATE TABLE IF NOT EXISTS miembros (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(100) NOT NULL,
                email VARCHAR(100),
                telefono VARCHAR(20),
                fecha_nacimiento DATE,
                direccion TEXT,
                id_casa_vida INT,
                activo BOOLEAN DEFAULT TRUE,
                FOREIGN KEY (id_casa_vida) REFERENCES casas_vida(id)
            )";
            $conn->exec($sql_miembros);

            // Tabla reuniones
            $sql_reuniones = "CREATE TABLE IF NOT EXISTS reuniones (
                id INT AUTO_INCREMENT PRIMARY KEY,
                id_casa_vida INT,
                fecha DATE NOT NULL,
                hora TIME,
                tema VARCHAR(200),
                descripcion TEXT,
                activa BOOLEAN DEFAULT TRUE,
                FOREIGN KEY (id_casa_vida) REFERENCES casas_vida(id)
            )";
            $conn->exec($sql_reuniones);

            // Tabla asistencia
            $sql_asistencia = "CREATE TABLE IF NOT EXISTS asistencia (
                id INT AUTO_INCREMENT PRIMARY KEY,
                id_reunion INT,
                id_miembro INT,
                asistio BOOLEAN DEFAULT TRUE,
                fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (id_reunion) REFERENCES reuniones(id),
                FOREIGN KEY (id_miembro) REFERENCES miembros(id)
            )";
            $conn->exec($sql_asistencia);

            // Insertar usuario administrador si no existe
            $check_admin = "SELECT id FROM usuarios WHERE email = 'admin@casasvida.com'";
            $stmt = $conn->prepare($check_admin);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                $insert_admin = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_admin);
                $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
                $stmt->execute(['Administrador', 'admin@casasvida.com', $hashed_password, 'admin']);
            }

            return true;
        } catch(PDOException $exception) {
            echo "Error creando tablas: " . $exception->getMessage();
            return false;
        }
    }
    return false;
}

// Inicializar tablas
createTables();
?>
