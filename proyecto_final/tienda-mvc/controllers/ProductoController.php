<?php
    namespace Controllers;

    use Models\ProductoModel;

    /* La clase `ProductoController` en PHP contiene métodos para gestionar productos, incluyendo la creación, 
    actualización y eliminación de información de productos, garantizando al mismo tiempo la verificación de la sesión. */
    class ProductoController {
        private ProductoModel $productoModel;

        /* La función es un constructor que inicializa una nueva instancia de la clase ProductoModel. */
        public function __construct()
        {
            $this->productoModel = new ProductoModel();
        }

        /* La función `verificarSesion` comprueba si una sesión está activa y si el usuario ha iniciado sesión como administrador; de lo 
        contrario, redirige a la página de inicio de sesión. */
        private function verificarSesion(): void {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['admin'])) {
                header('Location: index.php?route=login');
                exit;
            }
        }

        /* La función de index verifica la sesión y recupera todos los productos que se mostrarán en la vista. */
        public function index(): void {
            $this->verificarSesion();
            $productos = $this->productoModel->obtenerTodos();
            require_once __DIR__ . '/../views/productos/index.php';
        }

        /* La función create en PHP verifica la sesión y requiere un archivo de vista específico para crear productos. */
        public function create(): void {
            $this->verificarSesion();
            require_once __DIR__ . '/../views/productos/create.php';
        }

        /* La función `store` en PHP se utiliza para gestionar el almacenamiento de datos de productos, 
        realizar comprobaciones de validación y redirigir en función del resultado. */
        public function store(): void {
            $this->verificarSesion();

            $data = [
                'sku' => trim($_POST['sku'] ?? ''),
                'nombre' => trim($_POST['nombre'] ?? ''),
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'precio_compra' => trim($_POST['precio_compra'] ?? ''),
                'precio_venta' => trim($_POST['precio_venta'] ?? ''),
                'existencia' => trim($_POST['existencia'] ?? '')
            ];

            if (
                $data['sku'] === '' ||
                $data['nombre'] === '' ||
                $data['descripcion'] === '' ||
                $data['precio_compra'] === '' ||
                $data['precio_venta'] === '' ||
                $data['existencia'] === '' 
            ) {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                header('Location: index.php?route=productos/create');
                exit;
            }

            if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
                || !is_numeric($data['existencia'])) {
                $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numericos.';
                header('Location: index.php?route=productos/create');
                exit;
            }

            if ((float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0
            || (int)$data['existencia'] < 0) {
                $_SESSION['error'] = 'No se permiten valres negativos.';
                header('Location: index.php?route=productos/create');
                exit;
            }

            if ($this->productoModel->crear($data)) {
                $_SESSION['success'] = 'Producto registrado correctamente.';
            } else {
                $_SESSION['error'] = 'no fue posible registrar el producto.';
            }

            header('Location: index.php?route=productos');
            exit;
        }

        /* La función `edit` en PHP verifica la sesión del usuario, recupera un producto por su ID y, 
        si se encuentra el producto, lo redirige a la página de edición; de lo contrario, muestra un mensaje de error. */
        public function edit(): void {
            $this->verificarSesion();

            $id = (int)($_GET['id'] ?? 0);
            $producto = $this->productoModel->obtenerPorId($id);

            if(!$producto) {
                $_SESSION['error'] = 'Producto no encontrado.';
                header('Location: index.php?route=productos');
                exit;
            }

            require_once __DIR__ . '/../views/productos/edit.php';
        }

        /* La función `update` en PHP se encarga de actualizar la información del producto con comprobaciones de validación y manejo de errores. */
        public function update(): void {
            $this->verificarSesion();

            $id = (int)($_POST['id'] ?? 0);

            $data = [
                'sku' => trim($_POST['sku'] ?? ''),
                'nombre' => trim($_POST['nombre'] ?? ''),
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'precio_compra' => trim($_POST['precio_compra'] ?? ''),
                'precio_venta' => trim($_POST['precio_venta'] ?? ''),
                'existencia' => trim($_POST['existencia'] ?? '')
            ];

            if ($id <= 0) {
                $_SESSION['error'] = 'ID invalido.';
                header('Location: index.php?route=productos');
                exit;
            }

            if (
                $data['sku'] === '' ||
                $data['nombre'] === '' ||
                $data['descripcion'] === '' ||
                $data['precio_compra'] === '' ||
                $data['precio_venta'] === '' ||
                $data['existencia'] === '' 
            ) {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                header('Location: index.php?route=productos/edit&id=' . $id);
                exit;
            }

            if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
                || !is_numeric($data['existencia'])) {
                $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numericos.';
                header('Location: index.php?route=productos/edit&id=' . $id);
                exit;
            }

            if ((float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0 ||(int)$data['existencia'] < 0) {
                $_SESSION['error'] = 'No se permiten valores negativos.';
                header('Location: index.php?route=productos/edit&id=' . $id);
                exit;
            }

            if ($this->productoModel->actualizar($id, $data)) {
                $_SESSION['success'] = 'Producto actualizaco correctamente.';
            } else {
                $_SESSION['error'] = 'No fue posible actualizar el producto.';
            }

            header('Location: index.php?route=productos');
            exit;
        }

        /* Esta función de PHP se utiliza para eliminar un producto verificando la sesión, 
        obteniendo el ID del producto a partir de los datos POST y, a continuación, 
        eliminando el producto de la base de datos, gestionando los mensajes de éxito y de error. */
        public function delete(): void {
            $this->verificarSesion();
            
            $id = (int)($_POST['id'] ?? 0);

            if ($id <= 0) {
                $_SESSION['error'] = 'ID invalido.';
                header('Location: index.php?route=productos');
                exit;
            }

            if ($this->productoModel->eliminar($id)) {
                $_SESSION['success'] = 'Producto elimindo correctamente.';
            } else {
                $_SESSION['error'] = 'No fue posble eliminar el producto.';
            }

            header('Location: index.php?route=productos');
            exit;
        }
    }
?>
