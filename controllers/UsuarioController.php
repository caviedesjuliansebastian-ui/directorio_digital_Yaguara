<?php
class UsuarioController extends Controller {

    public function __construct() {
        // Todas las rutas de usuario requieren autenticación
        $this->requireAuth();
    }

    // Ver y editar perfil
    public function perfil() {
        $usuarioModel = $this->model('Usuario');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $celular = trim($_POST['celular'] ?? '');
            $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';
            
            // Subir foto si existe
            $foto_perfil = $this->subirImagen('foto_perfil', 'perfiles');
            
            if (empty($nombre)) {
                $_SESSION['error'] = 'El nombre es obligatorio.';
            } else {
                $actualizado = $usuarioModel->actualizarPerfil(
                    $_SESSION['usuario_id'], 
                    $nombre, 
                    $celular, 
                    $foto_perfil, 
                    !empty($nueva_contrasena) ? $nueva_contrasena : null
                );

                if ($actualizado) {
                    $_SESSION['usuario_nombre'] = $nombre;
                    if ($foto_perfil) {
                        $_SESSION['usuario_foto'] = $foto_perfil;
                    }
                    $_SESSION['mensaje'] = 'Perfil actualizado correctamente.';
                } else {
                    $_SESSION['error'] = 'Hubo un error al actualizar el perfil.';
                }
            }
            $this->redirect('usuario/perfil');
        }

        $datosUsuario = $usuarioModel->getById($_SESSION['usuario_id']);
        
        $this->view('layouts/header', ['titulo' => 'Mi Perfil — ' . APP_NAME]);
        $this->view('usuario/perfil', ['datos' => $datosUsuario]);
        $this->view('layouts/footer');
    }

    // Listado de negocios del usuario
    public function mis_negocios() {
        $negocioModel = $this->model('Negocio');
        $negocios = $negocioModel->getByUsuarioId($_SESSION['usuario_id']);

        $this->view('layouts/header', ['titulo' => 'Mis Negocios — ' . APP_NAME]);
        $this->view('usuario/mis_negocios', ['negocios' => $negocios]);
        $this->view('layouts/footer');
    }

    // Listado de negocios favoritos
    public function favoritos() {
        $favoritoModel = $this->model('Favorito');
        $favoritos = $favoritoModel->getPorUsuario($_SESSION['usuario_id']);

        $this->view('layouts/header', ['titulo' => 'Mis Favoritos — ' . APP_NAME]);
        $this->view('usuario/favoritos', ['negocios' => $favoritos]);
        $this->view('layouts/footer');
    }
}
