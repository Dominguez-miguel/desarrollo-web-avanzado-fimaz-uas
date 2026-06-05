<?php
    namespace Controllers;

    use Models\UsuarioModel;

    /* La clase AuthController en PHP gestiona la autenticación de usuarios, incluyendo el inicio de sesión, el cierre 
    de sesión y la visualización del formulario de inicio de sesión. */
    class AuthController {
        public function showLogin(): void {
            require_once __DIR__ . '/../views/auth/login.php';
        }

        /* Esta función gestiona el inicio de sesión del usuario verificando las credenciales y configurando los datos de sesión en consecuencia. */
        public function login(): void {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                header('Location: index.php?route=login');
                exit;
            }

            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->buscarPorUsername($username);

            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['admin'] = [
                    'id' => $usuario['id'],
                    'username' => $usuario['username'],
                    'nombre_completo' => $usuario['nombre_completo']
                ];

                $_SESSION['success'] = 'Bienvenido, ' . $usuario['nombre_completo'] . '.';
                header('Location: index.php?route=productos');
                exit;
            }

            $_SESSION['error'] = 'Credenciales incorrectas.';
            header('Location: index.php?route=login');
            exit;
        }

        /* La función `logout` en PHP cierra la sesión del usuario destruyendo la sesión y redirigiéndolo a la página de inicio de sesión. */
        public function logout(): void {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_destroy();
            header('Location: index.php?route=login');
            exit;
        }
    }
?>