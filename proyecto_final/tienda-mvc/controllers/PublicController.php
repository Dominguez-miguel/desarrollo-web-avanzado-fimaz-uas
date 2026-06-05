<?php
        /* La clase PublicController en PHP contiene métodos para mostrar un catálogo de productos y recuperar todos los productos en formato JSON. */
        namespace Controllers;

        use Models\ProductoModel;

        class PublicController {

            /* La función "catálogo" recupera productos en función de un término de búsqueda y los muestra en una vista de catálogo público. */
            public function catalogo(): void {

            $termino = trim($_GET['buscar'] ?? '');
            $productoModel = new ProductoModel();
            $productos = $productoModel->buscarPublico($termino);
            require_once __DIR__ . '/../views/public/catalogo.php';
            }

            /* La función "productosApi" recupera todos los productos de la base de datos y los muestra en formato JSON. */
            public function productosApi(): void {
                header('Content-Type: application/json');

                $productoModel = new ProductoModel();
                $productos = $productoModel->obtenerTodos();

                echo json_encode($productos);
                exit;
            }
        }
?>