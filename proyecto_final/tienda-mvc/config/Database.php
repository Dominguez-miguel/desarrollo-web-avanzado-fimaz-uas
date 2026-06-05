<?php
    /* La clase `Database` en el espacio de nombres `Config` establece una conexión de base de datos PDO a una base de datos MySQL con manejo de errores. */
    namespace Config;

    use PDO; 
    use PDOException;

    class Database {
        private string $host = 'localhost';
        private string $dbName = 'tienda_mvc';
        private string $username = 'root';
        private string $password = '';
        private string $charset = 'utf8mb4';

        public function connect(): PDO {
            try {
                $dsn = "mysql:host={$this->host};port=3307;dbname={$this->dbName};charset={$this->charset}";
                $pdo = new PDO($dsn, $this->username, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
            } catch (PDOException $e) {
                die('Error de conexion: ' . $e->getMessage());
            }
        }
    }
?>