<?php
class ApiController extends Controller {

    // Búsqueda AJAX en vivo
    public function buscar() {
        $query = trim($_GET['q'] ?? '');
        if (mb_strlen($query) < 1) {
            $this->json(['resultados' => [], 'negocios' => [], 'productos' => [], 'categorias' => [], 'total' => 0]);
        }

        $db = (new Database())->getConnection();
        $param = '%' . $query . '%';

        // 1. Negocios coincidentes (por nombre, descripción, categoría o sector)
        $stmtNeg = $db->prepare("
            SELECT n.id, n.nombre, n.slug, n.descripcion, n.direccion, n.logo, n.imagen_portada, n.verificado,
                   c.nombre as categoria_nombre, c.icono as categoria_icono, c.color as categoria_color,
                   s.nombre as sector_nombre
            FROM negocios n
            LEFT JOIN categorias c ON n.categoria_id = c.id
            LEFT JOIN sectores s ON n.sector_id = s.id
            WHERE n.estado = 'activo'
              AND (
                  n.nombre LIKE ? 
                  OR n.descripcion LIKE ? 
                  OR n.direccion LIKE ? 
                  OR c.nombre LIKE ? 
                  OR s.nombre LIKE ?
                  OR EXISTS (
                      SELECT 1 FROM productos p 
                      WHERE p.negocio_id = n.id AND (p.nombre LIKE ? OR p.descripcion LIKE ?)
                  )
              )
            ORDER BY n.destacado DESC, n.verificado DESC, n.visitas DESC
            LIMIT 6
        ");
        $stmtNeg->execute([$param, $param, $param, $param, $param, $param, $param]);
        $negociosRaw = $stmtNeg->fetchAll(PDO::FETCH_ASSOC);

        $negocios = array_map(function($n) {
            return [
                'id' => $n['id'],
                'nombre' => $n['nombre'],
                'slug' => $n['slug'],
                'descripcion' => mb_substr($n['descripcion'] ?? '', 0, 90) . '...',
                'direccion' => $n['direccion'],
                'categoria' => $n['categoria_nombre'] ?? '',
                'categoria_icono' => $n['categoria_icono'] ?? 'fas fa-store',
                'categoria_color' => $n['categoria_color'] ?? '#ff6000',
                'sector' => $n['sector_nombre'] ?? '',
                'logo' => $n['logo'],
                'imagen_portada' => $n['imagen_portada'],
                'verificado' => (bool)$n['verificado'],
                'url' => BASE_URL . 'index.php?url=negocio/ficha/' . $n['slug']
            ];
        }, $negociosRaw);

        // 2. Productos y platos coincidentes
        $stmtProd = $db->prepare("
            SELECT p.id, p.nombre, p.precio, p.unidad_medida, p.foto,
                   n.id as negocio_id, n.nombre as negocio_nombre, n.slug as negocio_slug,
                   c.nombre as categoria_nombre
            FROM productos p
            JOIN negocios n ON p.negocio_id = n.id
            LEFT JOIN categorias c ON n.categoria_id = c.id
            WHERE n.estado = 'activo'
              AND (p.nombre LIKE ? OR p.descripcion LIKE ?)
            LIMIT 5
        ");
        $stmtProd->execute([$param, $param]);
        $productosRaw = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

        $productos = array_map(function($p) {
            return [
                'id' => $p['id'],
                'nombre' => $p['nombre'],
                'precio' => (float)$p['precio'],
                'precio_formato' => '$' . number_format($p['precio'], 0, ',', '.') . ' COP',
                'unidad' => $p['unidad_medida'] ?? 'Unidad',
                'foto' => $p['foto'],
                'negocio_nombre' => $p['negocio_nombre'],
                'url' => BASE_URL . 'index.php?url=negocio/ficha/' . $p['negocio_slug']
            ];
        }, $productosRaw);

        // 3. Categorías coincidentes
        $stmtCat = $db->prepare("
            SELECT id, nombre, slug, icono, color
            FROM categorias
            WHERE nombre LIKE ? OR descripcion LIKE ?
            LIMIT 4
        ");
        $stmtCat->execute([$param, $param]);
        $categoriasRaw = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

        $categorias = array_map(function($c) {
            return [
                'id' => $c['id'],
                'nombre' => $c['nombre'],
                'icono' => $c['icono'],
                'color' => $c['color'],
                'url' => BASE_URL . 'index.php?url=negocio/listado&categoria=' . $c['id']
            ];
        }, $categoriasRaw);

        $this->json([
            'query' => $query,
            'resultados' => $negocios, // Compatibilidad anterior
            'negocios' => $negocios,
            'productos' => $productos,
            'categorias' => $categorias,
            'total' => count($negocios) + count($productos) + count($categorias)
        ]);
    }

    // Toggle favorito AJAX
    public function favorito() {
        if (!$this->isLoggedIn()) {
            $this->json(['error' => 'Debes iniciar sesión'], 401);
        }

        $negocioId = (int)($_POST['negocio_id'] ?? $_GET['id'] ?? 0);
        if ($negocioId <= 0) {
            $this->json(['error' => 'ID inválido'], 400);
        }

        $favoritoModel = $this->model('Favorito');
        $resultado = $favoritoModel->toggle($_SESSION['usuario_id'], $negocioId);
        $this->json($resultado);
    }

    // Negocios GeoJSON para mapa
    public function negocios() {
        $negocioModel = $this->model('Negocio');
        $negocios = $negocioModel->getParaMapa();

        $features = array_map(function($n) {
            return [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [(float)$n['longitud'], (float)$n['latitud']]
                ],
                'properties' => [
                    'id' => $n['id'],
                    'nombre' => $n['nombre'],
                    'slug' => $n['slug'],
                    'direccion' => $n['direccion'],
                    'categoria' => $n['categoria_nombre'] ?? '',
                    'icono' => $n['categoria_icono'] ?? 'fas fa-store',
                    'color' => $n['categoria_color'] ?? '#059669',
                    'sector' => $n['sector_nombre'] ?? '',
                    'logo' => $n['logo'],
                    'url' => BASE_URL . 'index.php?url=negocio/ficha/' . $n['slug']
                ]
            ];
        }, $negocios);

        $this->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }

    // Filtrado y renderizado dinámico de tarjetas para el grid de negocios
    public function filtrar_negocios() {
        $query = trim($_GET['q'] ?? '');
        $categoriaId = !empty($_GET['categoria']) ? (int)$_GET['categoria'] : null;
        $sectorId = !empty($_GET['sector']) ? (int)$_GET['sector'] : null;
        $soloVerificados = !empty($_GET['verificados']) && $_GET['verificados'] === 'true';

        $negocioModel = $this->model('Negocio');
        $negocios = $negocioModel->buscar($query, $categoriaId, $sectorId, 1, $soloVerificados);
        $total = $negocioModel->contarBusqueda($query, $categoriaId, $sectorId, $soloVerificados);

        // Renderizar las tarjetas HTML
        ob_start();
        if (empty($negocios)) {
            echo '<div class="col-12 p-5 text-center rounded-4" style="background: var(--bg-card); border: 1px dashed var(--border-color);">
                <i class="fas fa-search fa-3x mb-3 text-secondary opacity-50"></i>
                <h5 class="text-white">No se encontraron comercios para "' . htmlspecialchars($query) . '"</h5>
                <p class="text-secondary small mb-3">Intenta buscar por producto (ej. quesillo, mojarra, achiras, asado, hotel) o borra el filtro para ver todos.</p>
                <button type="button" class="btn btn-warning btn-sm text-white fw-bold px-3" onclick="limpiarFiltroBusqueda()" style="background: var(--color-primary); border: none; border-radius: 8px;">
                    Ver Todos los Comercios
                </button>
            </div>';
        } else {
            foreach ($negocios as $negocio) {
                include ROOT_PATH . 'views/components/card_negocio.php';
            }
        }
        $cardsHtml = ob_get_clean();

        $this->json([
            'total' => $total,
            'total_mostrados' => count($negocios),
            'html' => $cardsHtml
        ]);
    }
}
