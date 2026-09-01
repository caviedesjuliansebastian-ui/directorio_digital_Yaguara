<?php
class CategoriaController extends Controller {

    public function index() {
        $categoriaModel = $this->model('Categoria');

        $data = [
            'categorias' => $categoriaModel->conConteoNegocios(),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Categorías — ' . APP_NAME]);
        $this->view('negocios/listado', array_merge($data, [
            'negocios' => [],
            'sectores' => $this->model('Sector')->getAll(),
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
        if (empty($slug)) $this->redirect('categoria/index');

        $categoriaModel = $this->model('Categoria');
        $categoria = $categoriaModel->getBySlug($slug);

        if (!$categoria) $this->redirect('categoria/index');

        $negocioModel = $this->model('Negocio');
        $sectorModel = $this->model('Sector');
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));

        $negocios = $negocioModel->getPorCategoria($categoria['id'], $pagina);
        $total = $negocioModel->contarBusqueda('', $categoria['id'], null);

        $data = [
            'negocios' => $negocios,
            'categorias' => $categoriaModel->getAll(),
            'sectores' => $sectorModel->getAll(),
            'categoriaActual' => $categoria,
            'query' => '',
            'categoriaId' => $categoria['id'],
            'sectorId' => null,
            'pagina' => $pagina,
            'totalPaginas' => ceil($total / ITEMS_PER_PAGE),
            'total' => $total,
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => $categoria['nombre'] . ' — ' . APP_NAME]);
        $this->view('negocios/listado', $data);
        $this->view('layouts/footer');
    }
}
