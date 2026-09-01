<?php
class NegocioController extends Controller {

    // Listado de negocios con búsqueda y filtros
    public function listado() {
        $negocioModel = $this->model('Negocio');
        $categoriaModel = $this->model('Categoria');
        $sectorModel = $this->model('Sector');

        $query = trim($_GET['q'] ?? '');
        $categoriaId = !empty($_GET['categoria']) ? (int)$_GET['categoria'] : null;
        $sectorId = !empty($_GET['sector']) ? (int)$_GET['sector'] : null;
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));
        $soloVerificados = !empty($_GET['verificados']) && $_GET['verificados'] === 'true';

        $negocios = $negocioModel->buscar($query, $categoriaId, $sectorId, $pagina, $soloVerificados);
        $total = $negocioModel->contarBusqueda($query, $categoriaId, $sectorId, $soloVerificados);
        $totalPaginas = ceil($total / ITEMS_PER_PAGE);

        $data = [
            'negocios' => $negocios,
            'categorias' => $categoriaModel->getAll(),
            'sectores' => $sectorModel->getAll(),
            'query' => $query,
            'categoriaId' => $categoriaId,
            'sectorId' => $sectorId,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'total' => $total,
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Negocios — ' . APP_NAME]);
        $this->view('negocios/listado', $data);
        $this->view('layouts/footer');
    }

    // Ficha detalle de un negocio
    public function ficha($slug = '') {
        if (empty($slug)) $this->redirect('negocio/listado');

        $negocioModel = $this->model('Negocio');
        $negocio = $negocioModel->getBySlug($slug);

        if (!$negocio) {
            $this->redirect('negocio/listado');
        }

        // Incrementar visitas
        $negocioModel->incrementarVisitas($negocio['id']);

        // Datos relacionados
        $horarioModel = $this->model('Horario');
        $imagenModel = $this->model('ImagenNegocio');
        $resenaModel = $this->model('Resena');
        $favoritoModel = $this->model('Favorito');

        $esFavorito = false;
        if ($this->isLoggedIn()) {
            $esFavorito = $favoritoModel->esFavorito($_SESSION['usuario_id'], $negocio['id']);
        }

        $productoModel = $this->model('Producto');

        $data = [
            'negocio' => $negocio,
            'productos' => $productoModel->getByNegocio($negocio['id']),
            'horarios' => $horarioModel->getPorNegocio($negocio['id']),
            'estaAbierto' => $horarioModel->estaAbierto($negocio['id']),
            'imagenes' => $imagenModel->getPorNegocio($negocio['id']),
            'resenas' => $resenaModel->getPorNegocio($negocio['id']),
            'calificacion' => $resenaModel->getPromedio($negocio['id']),
            'distribucion' => $resenaModel->getDistribucion($negocio['id']),
            'esFavorito' => $esFavorito,
            'totalFavoritos' => $favoritoModel->contarPorNegocio($negocio['id']),
            'diasSemana' => $horarioModel->getDias(),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => $negocio['nombre'] . ' — ' . APP_NAME]);
        $this->view('negocios/ficha', $data);
        $this->view('layouts/footer');
    }

    // Formulario de crear negocio
    public function crear() {
        $this->requireAuth();

        $categoriaModel = $this->model('Categoria');
        $sectorModel = $this->model('Sector');

        $data = [
            'categorias' => $categoriaModel->getAll(),
            'sectores' => $sectorModel->getAll(),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Registrar Negocio — ' . APP_NAME]);
        $this->view('negocios/crear', $data);
        $this->view('layouts/footer');
    }

    // Guardar negocio
    public function guardar() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('negocio/crear');
        }

        $datos = [
            'usuario_id' => $_SESSION['usuario_id'],
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'categoria_id' => $_POST['categoria_id'] ?? null,
            'sector_id' => $_POST['sector_id'] ?? null,
            'direccion' => trim($_POST['direccion'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'whatsapp' => trim($_POST['whatsapp'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'sitio_web' => trim($_POST['sitio_web'] ?? ''),
            'facebook' => trim($_POST['facebook'] ?? ''),
            'instagram' => trim($_POST['instagram'] ?? ''),
            'latitud' => $_POST['latitud'] ?? null,
            'longitud' => $_POST['longitud'] ?? null,
        ];

        // Validación
        if (empty($datos['nombre'])) {
            $_SESSION['error'] = 'El nombre del negocio es obligatorio.';
            $this->redirect('negocio/crear');
        }

        // Subir imágenes
        $datos['logo'] = $this->subirImagen('logo', 'negocios');
        $datos['imagen_portada'] = $this->subirImagen('imagen_portada', 'negocios');

        $negocioModel = $this->model('Negocio');
        $negocioId = $negocioModel->crear($datos);

        if ($negocioId) {
            // Guardar horarios si se enviaron
            if (!empty($_POST['horarios'])) {
                $horarioModel = $this->model('Horario');
                $horarioModel->guardar($negocioId, $_POST['horarios']);
            }

            // Subir imágenes de galería
            if (!empty($_FILES['galeria']['name'][0])) {
                $imagenModel = $this->model('ImagenNegocio');
                foreach ($_FILES['galeria']['name'] as $i => $name) {
                    if ($_FILES['galeria']['error'][$i] === UPLOAD_ERR_OK) {
                        $_FILES['temp_gallery'] = [
                            'name' => $_FILES['galeria']['name'][$i],
                            'tmp_name' => $_FILES['galeria']['tmp_name'][$i],
                            'error' => $_FILES['galeria']['error'][$i],
                            'size' => $_FILES['galeria']['size'][$i],
                            'type' => $_FILES['galeria']['type'][$i],
                        ];
                        $urlImagen = $this->subirImagen('temp_gallery', 'galeria');
                        if ($urlImagen) {
                            $imagenModel->agregar($negocioId, $urlImagen);
                        }
                    }
                }
            }

            $_SESSION['mensaje'] = '¡Negocio registrado! Será revisado por el administrador antes de publicarse.';
            $this->redirect('negocio/listado');
        } else {
            $_SESSION['error'] = 'Error al registrar el negocio.';
            $this->redirect('negocio/crear');
        }
    }

    // Reseña
    public function resena() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('negocio/listado');
        }

        $negocioId = (int)($_POST['negocio_id'] ?? 0);
        $calificacion = (int)($_POST['calificacion'] ?? 0);
        $comentario = trim($_POST['comentario'] ?? '');

        if ($negocioId <= 0 || $calificacion < 1 || $calificacion > 5) {
            $_SESSION['error'] = 'Datos de reseña inválidos.';
            $this->redirect('negocio/listado');
        }

        $resenaModel = $this->model('Resena');
        $resultado = $resenaModel->crear($negocioId, $_SESSION['usuario_id'], $calificacion, $comentario);

        if ($resultado['exito']) {
            $_SESSION['mensaje'] = $resultado['mensaje'];
        } else {
            $_SESSION['error'] = $resultado['mensaje'];
        }

        // Obtener slug para redirección
        $negocioModel = $this->model('Negocio');
        $negocio = $negocioModel->getById($negocioId);
        $this->redirect('negocio/ficha/' . ($negocio['slug'] ?? ''));
    }

    // Reportar negocio
    public function reportar() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('negocio/listado');
        }

        $negocioId = (int)($_POST['negocio_id'] ?? 0);
        $motivo = trim($_POST['motivo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if ($negocioId <= 0 || empty($motivo)) {
            $_SESSION['error'] = 'Datos de reporte inválidos.';
            $this->redirect('negocio/listado');
        }

        $reporteModel = $this->model('Reporte');
        $resultado = $reporteModel->crear($negocioId, $_SESSION['usuario_id'], $motivo, $descripcion);
        $_SESSION['mensaje'] = $resultado['mensaje'];

        $negocioModel = $this->model('Negocio');
        $negocio = $negocioModel->getById($negocioId);
        $this->redirect('negocio/ficha/' . ($negocio['slug'] ?? ''));
    }

    // Toggle favorito
    // Toggle favorito (agregar o quitar)
    public function favorito() {
        $negocioId = (int)($_POST['negocio_id'] ?? $_GET['id'] ?? 0);
        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
                  || (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'))
                  || isset($_POST['ajax']) || isset($_GET['ajax']);

        if (!$this->isLoggedIn()) {
            if ($isAjax) {
                $this->json([
                    'exito' => false,
                    'login_requerido' => true,
                    'mensaje' => 'Debes iniciar sesión para guardar favoritos',
                    'login_url' => BASE_URL . 'index.php?url=autenticacion/login'
                ], 401);
            }
            $this->requireAuth();
        }

        if ($negocioId <= 0) {
            if ($isAjax) {
                $this->json(['exito' => false, 'mensaje' => 'Negocio inválido'], 400);
            }
            $this->redirect('negocio/listado');
        }

        $favoritoModel = $this->model('Favorito');
        $resultado = $favoritoModel->toggle($_SESSION['usuario_id'], $negocioId);
        $totalFavoritos = $favoritoModel->contarPorNegocio($negocioId);
        $resultado['total_favoritos'] = $totalFavoritos;
        $resultado['exito'] = true;

        if ($isAjax) {
            $this->json($resultado);
        }

        $_SESSION['mensaje'] = $resultado['mensaje'];
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer) {
            header("Location: " . $referer);
            exit;
        }
        $this->redirect('negocio/listado');
    }

    // Búsqueda AJAX
    public function buscarAjax() {
        $query = trim($_GET['q'] ?? '');
        $categoriaId = !empty($_GET['categoria']) ? (int)$_GET['categoria'] : null;
        $sectorId = !empty($_GET['sector']) ? (int)$_GET['sector'] : null;
        $soloVerificados = !empty($_GET['verificados']) && $_GET['verificados'] === 'true';

        $negocioModel = $this->model('Negocio');
        $negocios = $negocioModel->buscar($query, $categoriaId, $sectorId, 1, $soloVerificados);
        
        $html = '';
        if (empty($negocios)) {
            $html = '<div class="p-3 text-center text-muted">No se encontraron resultados.</div>';
        } else {
            foreach ($negocios as $n) {
                $verificadoHtml = $n['verificado'] ? '<i class="fas fa-check-circle text-warning ms-1"></i>' : '';
                $html .= '
                <a href="' . BASE_URL . 'index.php?url=negocio/ficha/' . $n['slug'] . '" class="dropdown-item py-2 d-flex align-items-center gap-3 border-bottom" style="border-color:var(--border-color)!important;">
                    <div style="width:40px; height:40px; border-radius:50%; background:var(--bg-card-light); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        ' . ($n['logo'] ? '<img src="' . BASE_URL . $n['logo'] . '" style="width:100%; height:100%; object-fit:cover;">' : '<i class="' . ($n['categoria_icono'] ?? 'fas fa-store') . ' text-muted"></i>') . '
                    </div>
                    <div>
                        <div class="text-white fw-bold" style="font-size:0.9rem;">' . htmlspecialchars($n['nombre']) . $verificadoHtml . '</div>
                        <div class="text-secondary" style="font-size:0.75rem;">' . htmlspecialchars($n['categoria_nombre'] ?? '') . '</div>
                    </div>
                </a>';
            }
        }

        header('Content-Type: text/html; charset=utf-8');
        echo $html;
        exit;
    }
}
