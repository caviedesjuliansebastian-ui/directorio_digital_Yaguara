<?php
class HomeController extends Controller {

    public function index() {
        $categoriaModel = $this->model('Categoria');
        $negocioModel = $this->model('Negocio');
        $sectorModel = $this->model('Sector');
        $productoModel = $this->model('Producto');

        $data = [
            'categorias' => $categoriaModel->conConteoNegocios(),
            'negocios' => $negocioModel->getAll('activo', 1, 12),
            'destacados' => $negocioModel->getDestacados(6),
            'sectores' => $sectorModel->getAll(),
            'totalNegocios' => $negocioModel->contarTotal('activo'),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => APP_NAME . ' — Encuentra negocios en Yaguará']);
        $this->view('home/index', $data);
        $this->view('layouts/footer');
    }
}
