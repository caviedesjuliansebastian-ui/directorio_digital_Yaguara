<?php
class AdminController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_rol'] ?? '') !== 'administrador') {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                http_response_code(403);
                echo json_encode(['error' => 'No autorizado']);
                exit;
            }
            $_SESSION['error'] = 'Acceso no autorizado.';
            header("Location: " . (defined('BASE_URL') ? BASE_URL : '/') . "index.php?url=autenticacion/login");
            exit;
        }
    }

    // Dashboard principal
    public function dashboard() {
        $negocioModel = $this->model('Negocio');
        $usuarioModel = $this->model('Usuario');
        $categoriaModel = $this->model('Categoria');
        $reporteModel = $this->model('Reporte');

        $data = [
            'estadisticas' => $negocioModel->getEstadisticas(),
            'usuarios' => $usuarioModel->contarPorRol(),
            'categorias' => $categoriaModel->conConteoNegocios(),
            'reportesPendientes' => $reporteModel->contarPendientes(),
            'negociosPendientes' => $negocioModel->getAll('pendiente', 1, 100),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Panel Admin — ' . APP_NAME]);
        $this->view('admin/dashboard', $data);
        $this->view('layouts/footer');
    }

    // Gestión de negocios
    public function negocios() {
        $negocioModel = $this->model('Negocio');

        $data = [
            'negocios' => $negocioModel->getAllAdmin(),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Gestión de Negocios — ' . APP_NAME]);
        $this->view('admin/negocios', $data);
        $this->view('layouts/footer');
    }

    // Aprobar negocio
    public function aprobar($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $negocioModel = $this->model('Negocio');
            $negocioModel->cambiarEstado($id, 'activo');
            $negocioModel->verificar($id, true);
            $_SESSION['mensaje'] = '¡Negocio aprobado y verificado con éxito!';
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer) {
            header("Location: " . $referer);
            exit;
        }
        $this->redirect('admin/dashboard');
    }

    // Rechazar negocio
    public function rechazar($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $negocioModel = $this->model('Negocio');
            $negocioModel->cambiarEstado($id, 'rechazado');
            $_SESSION['mensaje'] = 'Negocio rechazado.';
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer) {
            header("Location: " . $referer);
            exit;
        }
        $this->redirect('admin/dashboard');
    }

    // Desactivar negocio
    public function desactivar($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $negocioModel = $this->model('Negocio');
            $negocioModel->cambiarEstado($id, 'inactivo');
            $_SESSION['mensaje'] = 'Negocio desactivado.';
        }
        $this->redirect('admin/negocios');
    }

    // Verificar negocio
    public function verificar($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $negocioModel = $this->model('Negocio');
            $negocioModel->verificar($id, true);
            $_SESSION['mensaje'] = 'Negocio verificado.';
        }
        $this->redirect('admin/negocios');
    }

    // Destacar negocio
    public function destacar($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $negocioModel = $this->model('Negocio');
            $negocio = $negocioModel->getById($id);
            $negocioModel->destacar($id, !$negocio['destacado']);
            $_SESSION['mensaje'] = 'Estado de destacado actualizado.';
        }
        $this->redirect('admin/negocios');
    }

    // Eliminar negocio
    public function eliminarNegocio($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $negocioModel = $this->model('Negocio');
            $negocioModel->eliminar($id);
            $_SESSION['mensaje'] = 'Negocio eliminado del sistema.';
        }
        $this->redirect('admin/negocios');
    }

    // Gestión de categorías
    public function categorias() {
        $categoriaModel = $this->model('Categoria');

        $data = [
            'categorias' => $categoriaModel->conConteoNegocios(),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Gestión de Categorías — ' . APP_NAME]);
        $this->view('admin/categorias', $data);
        $this->view('layouts/footer');
    }

    // Crear categoría
    public function crearCategoria() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('admin/categorias');

        $categoriaModel = $this->model('Categoria');
        $categoriaModel->crear([
            'nombre' => trim($_POST['nombre'] ?? ''),
            'icono' => trim($_POST['icono'] ?? 'fas fa-store'),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'color' => trim($_POST['color'] ?? '#059669'),
            'orden' => (int)($_POST['orden'] ?? 0)
        ]);

        $_SESSION['mensaje'] = '¡Categoría creada!';
        $this->redirect('admin/categorias');
    }

    // Editar categoría
    public function editarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('admin/categorias');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) $this->redirect('admin/categorias');

        $categoriaModel = $this->model('Categoria');
        $categoriaModel->actualizar($id, [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'icono' => trim($_POST['icono'] ?? 'fas fa-store'),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'color' => trim($_POST['color'] ?? '#059669'),
            'orden' => (int)($_POST['orden'] ?? 0),
            'activo' => isset($_POST['activo']) ? 1 : 0
        ]);

        $_SESSION['mensaje'] = '¡Categoría actualizada!';
        $this->redirect('admin/categorias');
    }

    // Eliminar categoría
    public function eliminarCategoria($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $categoriaModel = $this->model('Categoria');
            $categoriaModel->eliminar($id);
            $_SESSION['mensaje'] = 'Categoría eliminada.';
        }
        $this->redirect('admin/categorias');
    }

    // Gestión de sectores
    public function sectores() {
        $sectorModel = $this->model('Sector');

        $data = [
            'sectores' => $sectorModel->conConteoNegocios(),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Gestión de Sectores — ' . APP_NAME]);
        $this->view('admin/sectores', $data);
        $this->view('layouts/footer');
    }

    // Crear sector
    public function crearSector() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('admin/sectores');

        $sectorModel = $this->model('Sector');
        $sectorModel->crear([
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'latitud' => $_POST['latitud'] ?? null,
            'longitud' => $_POST['longitud'] ?? null
        ]);

        $_SESSION['mensaje'] = '¡Sector creado!';
        $this->redirect('admin/sectores');
    }

    // Editar sector
    public function editarSector() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('admin/sectores');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) $this->redirect('admin/sectores');

        $sectorModel = $this->model('Sector');
        $sectorModel->actualizar($id, [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'latitud' => $_POST['latitud'] ?? null,
            'longitud' => $_POST['longitud'] ?? null,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ]);

        $_SESSION['mensaje'] = '¡Sector actualizado!';
        $this->redirect('admin/sectores');
    }

    // Eliminar sector
    public function eliminarSector($id = 0) {
        $id = (int)$id;
        if ($id > 0) {
            $sectorModel = $this->model('Sector');
            $sectorModel->eliminar($id);
            $_SESSION['mensaje'] = 'Sector eliminado.';
        }
        $this->redirect('admin/sectores');
    }
}
