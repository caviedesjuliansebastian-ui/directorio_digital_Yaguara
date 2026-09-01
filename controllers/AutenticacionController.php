<?php
class AutenticacionController extends Controller {

    public function login() {
        // Si ya está logueado, redirigir
        if ($this->isLoggedIn()) {
            $this->redirigirSegunRol($_SESSION['usuario_rol']);
        }
        $this->view('layouts/header', ['titulo' => 'Iniciar Sesión — ' . APP_NAME]);
        $this->view('auth/login');
        $this->view('layouts/footer', ['sinFooter' => true]);
    }

    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('autenticacion/login');
        }

        $correo = trim($_POST['correo'] ?? '');
        $contrasena = trim($_POST['contrasena'] ?? '');

        if (empty($correo) || empty($contrasena)) {
            $_SESSION['error'] = "Por favor, complete todos los campos.";
            $this->redirect('autenticacion/login');
        }

        $usuarioModel = $this->model('Usuario');
        $resultado = $usuarioModel->login($correo, $contrasena);

        if ($resultado['exito']) {
            $this->redirigirSegunRol($resultado['usuario']['rol']);
        } else {
            $_SESSION['error'] = $resultado['mensaje'];
            $this->redirect('autenticacion/login');
        }
    }

    public function registro() {
        if ($this->isLoggedIn()) {
            $this->redirigirSegunRol($_SESSION['usuario_rol']);
        }
        $this->view('layouts/header', ['titulo' => 'Crear Cuenta — ' . APP_NAME]);
        $this->view('auth/registro');
        $this->view('layouts/footer', ['sinFooter' => true]);
    }

    public function procesarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('autenticacion/registro');
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $celular = trim($_POST['celular'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';
        $contrasena_confirmar = $_POST['contrasena_confirmar'] ?? '';

        if (empty($nombre) || empty($correo) || empty($contrasena) || empty($contrasena_confirmar)) {
            $_SESSION['error'] = "Por favor, complete todos los campos obligatorios.";
            $this->redirect('autenticacion/registro');
        }

        if ($contrasena !== $contrasena_confirmar) {
            $_SESSION['error'] = "Las contraseñas no coinciden.";
            $this->redirect('autenticacion/registro');
        }

        if (strlen($contrasena) < 6) {
            $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres.";
            $this->redirect('autenticacion/registro');
        }

        $usuarioModel = $this->model('Usuario');
        $resultado = $usuarioModel->registrar($nombre, $correo, $celular, $contrasena);

        if ($resultado['exito']) {
            $loginResult = $usuarioModel->login($correo, $contrasena);
            if ($loginResult['exito']) {
                $_SESSION['mensaje'] = "¡Bienvenido/a a " . APP_NAME . "!";
                $this->redirect('home/index');
            } else {
                $this->redirect('autenticacion/login');
            }
        } else {
            $_SESSION['error'] = $resultado['mensaje'];
            $this->redirect('autenticacion/registro');
        }
    }

    public function logout() {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mensaje'] = 'Has cerrado sesión correctamente.';
        $this->redirect('home/index');
    }

    private function redirigirSegunRol($rol) {
        if ($rol === 'administrador') {
            $this->redirect('admin/dashboard');
        } else {
            $this->redirect('usuario/mis_negocios');
        }
    }
}
