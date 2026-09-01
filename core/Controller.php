<?php
class Controller {
    // Cargar un modelo
    protected function model($model) {
        $file = ROOT_PATH . 'models/' . $model . '.php';
        if (!file_exists($file)) {
            die("Modelo $model no encontrado.");
        }
        require_once $file;
        return new $model();
    }

    // Cargar una vista
    protected function view($view, $data = []) {
        extract($data);
        $viewFile = ROOT_PATH . 'views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("La vista $view no existe.");
        }
    }
    
    // Redirigir
    protected function redirect($url) {
        header("Location: " . BASE_URL . "index.php?url=" . $url);
        exit();
    }

    // Responder JSON (para API)
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Verificar autenticación
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder a esta página.';
            $this->redirect('autenticacion/login');
        }
    }

    // Verificar rol administrador
    protected function requireAdmin() {
        $this->requireAuth();
        if ($_SESSION['usuario_rol'] !== 'administrador') {
            $_SESSION['error'] = 'No tienes permisos para acceder a esta sección.';
            $this->redirect('home/index');
        }
    }

    // ¿Está logueado?
    protected function isLoggedIn() {
        return isset($_SESSION['usuario_id']);
    }

    // Obtener datos del usuario actual
    protected function currentUser() {
        if (!$this->isLoggedIn()) return null;
        return [
            'id' => $_SESSION['usuario_id'],
            'nombre' => $_SESSION['usuario_nombre'],
            'rol' => $_SESSION['usuario_rol'],
            'correo' => $_SESSION['usuario_correo'] ?? '',
            'foto' => $_SESSION['usuario_foto'] ?? null
        ];
    }

    // Subir imagen
    protected function subirImagen($fileInput, $directorio = 'negocios') {
        if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $file = $_FILES[$fileInput];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ALLOWED_IMAGE_TYPES)) {
            return null;
        }

        if ($file['size'] > MAX_UPLOAD_SIZE) {
            return null;
        }

        $uploadDir = UPLOADS_DIR . $directorio . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $nuevoNombre = uniqid($directorio . '_') . '.' . $ext;
        $destino = $uploadDir . $nuevoNombre;

        if (move_uploaded_file($file['tmp_name'], $destino)) {
            return 'uploads/' . $directorio . '/' . $nuevoNombre;
        }

        return null;
    }
}
