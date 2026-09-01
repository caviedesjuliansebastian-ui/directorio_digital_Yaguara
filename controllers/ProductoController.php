<?php
class ProductoController extends Controller {

    public function index() {
        $this->requireAuth();
        
        $negocioId = (int)($_GET['negocio_id'] ?? 0);
        
        $negocioModel = $this->model('Negocio');
        $negocio = $negocioModel->getById($negocioId);

        if (!$negocio || $negocio['usuario_id'] != $_SESSION['usuario_id']) {
            $_SESSION['error'] = 'No tienes permiso para gestionar el catálogo de este negocio.';
            $this->redirect('usuario/mis_negocios');
        }

        $productoModel = $this->model('Producto');
        $productos = $productoModel->getByNegocio($negocioId);

        $data = [
            'negocio' => $negocio,
            'productos' => $productos,
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Catálogo - ' . $negocio['nombre']]);
        $this->view('negocios/catalogo', $data);
        $this->view('layouts/footer');
    }

    public function guardar() {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $negocioId = (int)($_POST['negocio_id'] ?? 0);
            
            $negocioModel = $this->model('Negocio');
            $negocio = $negocioModel->getById($negocioId);

            if (!$negocio || $negocio['usuario_id'] != $_SESSION['usuario_id']) {
                $this->redirect('usuario/mis_negocios');
            }

            $datos = [
                'negocio_id' => $negocioId,
                'nombre' => trim($_POST['nombre'] ?? ''),
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'precio' => (float)($_POST['precio'] ?? 0),
                'unidad_medida' => trim($_POST['unidad_medida'] ?? 'Unidad'),
                'disponible' => isset($_POST['disponible']) ? 1 : 0
            ];

            $datos['foto'] = $this->subirImagen('foto', 'productos');

            $productoModel = $this->model('Producto');
            if ($productoModel->crear($datos)) {
                $_SESSION['mensaje'] = 'Producto agregado exitosamente al catálogo.';
            } else {
                $_SESSION['error'] = 'Error al agregar el producto.';
            }

            $this->redirect('producto/index&negocio_id=' . $negocioId);
        }
    }
}
