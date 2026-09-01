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

    // Listado de negocios del usuario con métricas 100% reales
    public function mis_negocios() {
        $negocioModel = $this->model('Negocio');
        $usuarioId = $_SESSION['usuario_id'];
        $rol = $_SESSION['usuario_rol'] ?? 'usuario';

        // Obtener los negocios del usuario actual (o todos si es administrador para supervisión)
        $negocios = $negocioModel->getByUsuarioId($usuarioId);
        if (empty($negocios) && $rol === 'administrador') {
            $negocios = $negocioModel->getTodos();
        }

        $totalNegocios = count($negocios);
        $totalVisitas = 0;
        $totalProductos = 0;
        $totalMensajes = 0;

        $negocioIds = array_column($negocios, 'id');
        if (!empty($negocioIds)) {
            foreach ($negocios as $n) {
                $totalVisitas += (int)($n['visitas'] ?? 0);
            }
            $db = (new Database())->getConnection();
            $inClause = implode(',', array_map('intval', $negocioIds));
            $stmtProd = $db->query("SELECT COUNT(*) FROM productos WHERE negocio_id IN ($inClause)");
            $totalProductos = (int)$stmtProd->fetchColumn();

            $stmtChats = $db->prepare("SELECT COUNT(*) FROM mensajes_chat WHERE destinatario_id = ? OR remitente_id = ?");
            $stmtChats->execute([$usuarioId, $usuarioId]);
            $totalMensajes = (int)$stmtChats->fetchColumn();
        }

        $this->view('layouts/header', ['titulo' => 'Panel de Negocios — ' . APP_NAME]);
        $this->view('usuario/mis_negocios', [
            'negocios' => $negocios,
            'totalNegocios' => $totalNegocios,
            'totalVisitas' => $totalVisitas,
            'totalProductos' => $totalProductos,
            'totalMensajes' => $totalMensajes
        ]);
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
