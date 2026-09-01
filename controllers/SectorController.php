<?php
class SectorController extends Controller {

    public function index() {
        $sectorModel = $this->model('Sector');

        $data = [
            'sectores' => $sectorModel->conConteoNegocios(),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Sectores — ' . APP_NAME]);
        $this->view('negocios/listado', array_merge($data, [
            'negocios' => [],
            'categorias' => $this->model('Categoria')->getAll(),
            'query' => '',
            'categoriaId' => null,
            'sectorId' => null,
            'pagina' => 1,
            'totalPaginas' => 0,
            'total' => 0
        ]));
        $this->view('layouts/footer');
    }

    public function ver($slug = '') {
        if (empty($slug)) $this->redirect('sector/index');

        $sectorModel = $this->model('Sector');
        $sector = $sectorModel->getBySlug($slug);

        if (!$sector) $this->redirect('sector/index');

        $negocioModel = $this->model('Negocio');
        $categoriaModel = $this->model('Categoria');
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));

        $negocios = $negocioModel->getPorSector($sector['id'], $pagina);
        $total = $negocioModel->contarBusqueda('', null, $sector['id']);

        $data = [
            'negocios' => $negocios,
            'categorias' => $categoriaModel->getAll(),
            'sectores' => $sectorModel->getAll(),
            'sectorActual' => $sector,
            'query' => '',
            'categoriaId' => null,
            'sectorId' => $sector['id'],
            'pagina' => $pagina,
            'totalPaginas' => ceil($total / ITEMS_PER_PAGE),
            'total' => $total,
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => $sector['nombre'] . ' — ' . APP_NAME]);
        $this->view('negocios/listado', $data);
        $this->view('layouts/footer');
    }
}
