<?php

    /* Este script PHP configura un sistema de enrutamiento básico para una aplicación web.  */
    require_once __DIR__ . '/config/Autoload.php';

    use Controllers\AuthController;
    use Controllers\ProductoController;
    use Controllers\PublicController;

    $route = $_GET['route'] ?? 'catalogo';

    $authController = new AuthController();
    $productoController = new ProductoController();
    $publicController = new PublicController();

    /* Este script PHP configura un sistema de enrutamiento básico para una 
    aplicación web. Utiliza una sentencia switch basada en el valor de la variable ``, que se 
    obtiene de la superglobal `` o, por defecto, toma 'catalogo' si no se proporciona. */
    switch ($route) {
        case 'login':
            $authController->showLogin();
            break;

        case 'auth/login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $authController->login();
            }
            break;
        
        case 'logout':
            $authController->logout();
            break;
        
        case 'productos':
            $productoController->index();
            break;
        
        case 'productos/create':
            $productoController->create();
            break;

        case 'productos/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productoController->store();
            }
            break;

        case 'productos/edit':
            $productoController->edit();
            break;

        case 'productos/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productoController->update();
            }
            break;

        case 'productos/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productoController->delete();
            }
            break;

        case 'catalogo':
        default:
            $publicController->catalogo();
            break;
        
        
        case 'api-productos':
            $publicController->productosApi();
            break;
    }   
?>