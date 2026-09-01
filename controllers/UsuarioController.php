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
        
        // Obtener los negocios que pertenecen a este usuario
        // Como no hicimos un getByUsuarioId específico antes, 
        // usaremos el método general o una consulta directa si fuera necesario, 
        // pero tenemos la conexión $this->db en el modelo. 
        // Haremos una búsqueda filtrada o añadiremos el método aquí temporalmente.
        
        $stmt = $negocioModel->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color, s.nombre as sector_nombre
            FROM negocios n 
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE n.usuario_id = ?
            ORDER BY n.fecha_creacion DESC
        ");
        $stmt->execute([$_SESSION['usuario_id']]);
        $negocios = $stmt->fetchAll();

        $this->view('layouts/header', ['titulo' => 'Mis Negocios — ' . APP_NAME]);
        $this->view('usuario/mis_negocios', ['negocios' => $negocios]);
        $this->view('layouts/footer');
    }

    // Listado de negocios favoritos
    public function favoritos() {
        $negocioModel = $this->model('Negocio');
        
        // Consultar favoritos del usuario
        $stmt = $negocioModel->db->prepare("
            SELECT n.*, c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color, s.nombre as sector_nombre
            FROM negocios n 
            INNER JOIN favoritos f ON n.id = f.negocio_id
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE f.usuario_id = ?
            ORDER BY f.fecha_creacion DESC
        ");
        $stmt->execute([$_SESSION['usuario_id']]);
        $favoritos = $stmt->fetchAll();

        $this->view('layouts/header', ['titulo' => 'Mis Favoritos — ' . APP_NAME]);
        $this->view('usuario/favoritos', ['negocios' => $favoritos]);
        $this->view('layouts/footer');
    }
}
