<?php
    /* La clase UsuarioModel en PHP se utiliza para interactuar con una base de datos y buscar un usuario por su nombre de usuario. */
    namespace Models;

    use Config\Database;
    use PDO;
    use PDOException;

    class UsuarioModel {
        private PDO $conexion;

        /* La función crea un nuevo objeto Database y establece una conexión con la base de datos. */
        public function __construct()
        {
            $db = new Database();
            $this->conexion = $db->connect();
        }

        /* La función busca un usuario en una base de datos por su nombre de usuario y 
        devuelve un array de datos de usuario o null. @param string username El fragmento de 
        código proporcionado es una función PHP que busca un usuario en una tabla de base de 
        datos según el nombre de usuario proporcionado como parámetro. La función toma un 
        parámetro de cadena `` e intenta obtener el registro del usuario de la base de datos 
        donde la columna `username` coincide con el nombre de usuario proporcionado. @return ?array La 
        función `buscarPorUsername` devuelve un array que contiene los datos del usuario si se encuentra 
        un usuario con el nombre de usuario especificado en la base de datos. Si no se encuentra ningún usuario, devuelve `null`. */
        public function buscarPorUsername(string $username): ?array 
        {
            try {
                $sql = 'SELECT * FROM usuarios WHERE username = :username LIMIT 1';
                $stmt = $this->conexion->prepare($sql);
                $stmt ->bindParam(':username', $username);
                $stmt ->execute();
                $usuario = $stmt->fetch();
                return  $usuario ?: null;
            } catch (PDOException $e) {
                return null;
            }
        }
    }
?>