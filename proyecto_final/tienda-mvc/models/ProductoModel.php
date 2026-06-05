<?php
    /* La clase `ProductoModel` del espacio de nombres `Models` de PHP proporciona 
    métodos para interactuar con una tabla de base de datos llamada `productos` para 
    realizar operaciones como obtener todos los productos, buscar productos, crear, actualizar y eliminar productos. */
    namespace Models;

    use Config\Database;
    use PDO;
    use PDOException;

    class ProductoModel {
        private PDO $conexion;

        /* La función PHP siguiente es un constructor que crea un nuevo objeto Database y establece una conexión con la base de datos. */
        public function __construct()
        {
            $db = new Database();
            $this->conexion = $db->connect();
        }

        /* La función "obtenerTodos" recupera todos los registros de la 
        tabla "productos" en orden descendente por ID mediante una consulta PDO en PHP. @return array Un array con todas las 
        filas de la tabla "productos", ordenadas por la columna "id" en orden descendente. Cada fila se 
        devuelve como un array asociativo. Si se produce una excepción (PDOException) durante la ejecución de la consulta, se devuelve un array vacío. */
        public function obtenerTodos(): array 
        {
            try {
                $sql = 'SELECT * FROM productos ORDER BY id DESC';
                $stmt = $this->conexion->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [];
            }
        }

        /* Esta función PHP busca productos en una base de datos según un término de búsqueda dado en el nombre o 
        descripción del producto. @param string término La función `buscarPublico` es un método que busca 
        productos en una base de datos según un término de búsqueda dado. Aquí hay un desglose de los 
        parámetros y la funcionalidad: @return array Un array de arrays asociativos que contienen los resultados de 
        la búsqueda de la tabla "productos" según el término de búsqueda proporcionado. Si el término de búsqueda está vacío, 
        devolverá todos los registros de la tabla. Si hay un error durante la ejecución de la consulta a la base de datos, se devolverá un array vacío. */
        public function buscarPublico(string $termino = ''): array
        {
            try {
                $termino = trim($termino);
                if ($termino === '') {
                    return $this->obtenerTodos();
                }

                $sql = 'SELECT * FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino ORDER BY id DESC';
                $stmt = $this->conexion->prepare($sql);
                $busqueda = '%' . $termino . '%';
                $stmt->bindParam(':termino', $busqueda);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);                       
                } catch (PDOException $e) {
                return [];
            }
        }

        /* La función obtiene un producto por su ID de una base de datos usando PDO en PHP. @param int id 
        La función `obtenerPorId` es una función PHP que recupera un producto de una tabla de base de datos 
        llamada `productos` basándose en el `id` proporcionado. La función toma un parámetro entero `` que representa el 
        identificador único del producto a recuperar. @return ?array un array con los datos de un producto que coincide con el ID 
        proporcionado, o null si no se encuentra ningún producto o ocurre una excepción durante la consulta a la base de datos. */
        public function obtenerPorId(int $id): ?array {
            try {
                $sql = 'SELECT * FROM productos WHERE id = :id LIMIT 1';
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $producto = $stmt->fetch();
                return $producto ?: null;
            } catch (PDOException $e) {
                return null;
            }
        }

        /* La función `crear` inserta datos de productos en una tabla de base de datos 
        y gestiona las transacciones en caso de errores. @param array data La función `crear` 
        que proporcionaste es un método PHP que inserta un nuevo registro en una tabla de base 
        de datos llamada `productos`. Toma un array asociativo `` como parámetro, que debe contener 
        las siguientes claves: @return bool Esta función devuelve un valor booleano. Si la inserción del 
        producto en la base de datos es exitosa, devolverá `true`. Si hay un error durante el proceso o se captura una excepción, devolverá `false`. */
        public function crear(array $data): bool {
            try {
                $this->conexion->beginTransaction();

                $sql = 'INSERT INTO productos (sku, nombre, descripcion, precio_compra, precio_venta, existencia) VALUES (:sku, :nombre, :descripcion, :precio_compra, :precio_venta, :existencia)';
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':sku', $data['sku']);
                $stmt->bindParam(':nombre', $data['nombre']);
                $stmt->bindParam(':descripcion', $data['descripcion']);
                $stmt->bindParam(':precio_compra', $data['precio_compra']);
                $stmt->bindParam(':precio_venta', $data['precio_venta']);
                $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);

                $resultado = $stmt->execute();
                if (!$resultado) {
                    $this->conexion->rollBack();
                    return false;
                }

                $this->conexion->commit();
                return true;
            } catch (PDOException $e) {
                if($this->conexion->inTransaction()) {
                    $this->conexion->rollBack();
                }
                return false;
            }
        }

        /* La función `actualizar` actualiza un registro de producto en una base 
        de datos utilizando el array de datos proporcionado dentro de una transacción, 
        revirtiendo si ocurre una excepción. @param int id El parámetro `id` en la 
        función `actualizar` representa el identificador único del producto que desea actualizar 
        en la base de datos. Se utiliza para identificar el registro de producto específico que 
        necesita ser modificado. @param array data La función `actualizar` que proporcionó se 
        utiliza para actualizar un producto en una tabla de base de datos 
        llamada `productos`. Toma dos parámetros: `` que es el ID del producto que se va a 
        actualizar, y `` que es un array que contiene los nuevos datos para los campos 
        del producto. @return bool La función `actualizar` devuelve un valor booleano. Si la operación 
        de actualización es exitosa, devolverá `true`. Si hay una excepción (como una `PDOException`) durante 
        el proceso de actualización, capturará la excepción, revertirá la transacción si aún está en curso y devolverá `false`. */
        public function actualizar(int $id, array $data ): bool {
            try {
                $this->conexion->beginTransaction();

                $sql = 'UPDATE productos SET sku = :sku, nombre = :nombre, descripcion = :descripcion, precio_compra = :precio_compra, precio_venta = :precio_venta, existencia = :existencia WHERE id = :id';
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':sku', $data['sku']);
                $stmt->bindParam(':nombre', $data['nombre']);
                $stmt->bindParam(':descripcion', $data['descripcion']);
                $stmt->bindParam(':precio_compra', $data['precio_compra']);
                $stmt->bindParam(':precio_venta', $data['precio_venta']);
                $stmt->bindParam('existencia', $data['existencia'], PDO::PARAM_INT);
                $stmt->execute();

                $this->conexion->commit();
                return true;
            } catch (PDOException $e) {
                if ($this->conexion->inTransaction()) {
                    $this->conexion->rollBack();
                }
                return false;
            }
        }

     /* La función `eliminar` elimina un registro de la tabla `productos` 
     según el parámetro `id` proporcionado, utilizando transacciones para 
     la integridad de los datos. @param int id El código que proporcionaste es 
     una función PHP que elimina un registro de una tabla de base de datos según el 
     ID dado. La función toma un ID entero como parámetro e intenta eliminar el 
     registro correspondiente de la tabla "productos". @return bool Esta función 
     devuelve un valor booleano. Devuelve verdadero si la operación de eliminación 
     fue exitosa y se afectó al menos una fila, y devuelve falso si la operación de 
     eliminación no fue exitosa o si no se afectó ninguna fila. */
     public function eliminar(int $id): bool {                 
            try {
                $this->conexion->beginTransaction();
                $sql = 'DELETE FROM productos WHERE id = :id';
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() === 0) {
                    $this->conexion->rollBack();
                    return false;
                }
                
                $this->conexion->commit();
                return true;
            } catch (PDOException $e) {
                if ($this->conexion->inTransaction()) {
                    $this->conexion->rollBack();
                }
                return false;
            }
        }
    } 

?>