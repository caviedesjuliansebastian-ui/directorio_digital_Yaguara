<?php
class ApiController extends Controller {

    // Búsqueda AJAX
    public function buscar() {
        $query = trim($_GET['q'] ?? '');
        $categoriaId = !empty($_GET['categoria']) ? (int)$_GET['categoria'] : null;
        $sectorId = !empty($_GET['sector']) ? (int)$_GET['sector'] : null;
        $soloVerificados = !empty($_GET['verificados']) && $_GET['verificados'] === 'true';

        $negocioModel = $this->model('Negocio');
        $resultados = $negocioModel->buscar($query, $categoriaId, $sectorId, 1, $soloVerificados);

        // Simplificar datos para JSON
        $data = array_map(function($n) {
            return [
                'id' => $n['id'],
                'nombre' => $n['nombre'],
                'slug' => $n['slug'],
                'descripcion' => mb_substr($n['descripcion'] ?? '', 0, 120) . '...',
                'direccion' => $n['direccion'],
                'categoria' => $n['categoria_nombre'] ?? '',
                'categoria_icono' => $n['categoria_icono'] ?? '',
                'categoria_color' => $n['categoria_color'] ?? '',
                'sector' => $n['sector_nombre'] ?? '',
                'logo' => $n['logo'],
                'verificado' => (bool)$n['verificado'],
                'url' => BASE_URL . 'index.php?url=negocio/ficha/' . $n['slug']
            ];
        }, $resultados);

        $this->json(['resultados' => $data, 'total' => count($data)]);
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
}
