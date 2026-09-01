<?php
class ChatController extends Controller {

    public function __construct() {
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = 'Debes iniciar sesión para acceder al chat y realizar pedidos.';
            $this->redirect('autenticacion/login');
        }
    }

    // Vista de conversación
    public function conversacion($negocioId = 0) {
        $negocioId = (int)$negocioId;
        if ($negocioId <= 0) {
            $this->redirect('home/index');
        }

        $negocioModel = $this->model('Negocio');
        $negocio = $negocioModel->getById($negocioId);

        if (!$negocio) {
            $this->redirect('home/index');
        }

        $usuarioActualId = $_SESSION['usuario_id'];
        $propietarioId = $negocio['usuario_id'];

        // Determinar quién es el interlocutor
        $otroUsuarioId = ($usuarioActualId == $propietarioId) 
            ? (int)($_GET['cliente_id'] ?? $usuarioActualId) 
            : $propietarioId;

        $mensajeModel = $this->model('MensajeChat');
        $tratoModel = $this->model('Trato');

        // Marcar leídos
        $mensajeModel->marcarLeidos($otroUsuarioId, $usuarioActualId, $negocioId);

        $mensajes = $mensajeModel->getConversacion($usuarioActualId, $otroUsuarioId, $negocioId);
        $tratos = $tratoModel->getPorNegocioYCliente($negocioId, ($usuarioActualId == $propietarioId ? $otroUsuarioId : $usuarioActualId));

        $data = [
            'negocio' => $negocio,
            'mensajes' => $mensajes,
            'tratos' => $tratos,
            'otroUsuarioId' => $otroUsuarioId,
            'esPropietario' => ($usuarioActualId == $propietarioId),
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Chat Seguro — ' . $negocio['nombre']]);
        $this->view('chat/conversacion', $data);
        $this->view('layouts/footer');
    }

    // Enviar mensaje
    public function enviar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('home/index');
        }

        $negocioId = (int)($_POST['negocio_id'] ?? 0);
        $receptorId = (int)($_POST['receptor_id'] ?? 0);
        $mensaje = trim($_POST['mensaje'] ?? '');

        if ($negocioId > 0 && $receptorId > 0 && !empty($mensaje)) {
            $mensajeModel = $this->model('MensajeChat');
            $mensajeModel->enviar($_SESSION['usuario_id'], $receptorId, $negocioId, $mensaje);
        }

        $this->redirect('chat/conversacion/' . $negocioId . ($receptorId != $_SESSION['usuario_id'] ? '?cliente_id=' . $receptorId : ''));
    }

    // Crear / Proponer Trato
    public function proponerTrato() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('home/index');
        }

        $negocioId = (int)($_POST['negocio_id'] ?? 0);
        $clienteId = (int)($_POST['cliente_id'] ?? 0);
        $concepto = trim($_POST['concepto'] ?? '');
        $montoTotal = (float)($_POST['monto_total'] ?? 0);

        if ($negocioId > 0 && $clienteId > 0 && !empty($concepto) && $montoTotal > 0) {
            $tratoModel = $this->model('Trato');
            $tratoModel->crear($clienteId, $negocioId, $concepto, $montoTotal);

            // Generar mensaje automático en el chat
            $mensajeModel = $this->model('MensajeChat');
            $comision = round($montoTotal * 0.05, 2);
            $msgTexto = "📄 [PROPUESTA DE TRATO FORMAL]\nConcepto: {$concepto}\nValor Acordado: $" . number_format($montoTotal, 0, ',', '.') . " COP\nTarifa de Protección Servi-Go (5%): $" . number_format($comision, 0, ',', '.') . " COP";
            $mensajeModel->enviar($_SESSION['usuario_id'], $clienteId, $negocioId, $msgTexto);

            $_SESSION['mensaje'] = '¡Propuesta de trato enviada al chat!';
        }

        $this->redirect('chat/conversacion/' . $negocioId . '?cliente_id=' . $clienteId);
    }

    // Cerrar Trato
    public function cerrarTrato($tratoId = 0) {
        $tratoId = (int)$tratoId;
        if ($tratoId > 0) {
            $tratoModel = $this->model('Trato');
            $tratoModel->cerrar($tratoId);
            $_SESSION['mensaje'] = '🎉 ¡Trato cerrado con éxito!';
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer) {
            header("Location: " . $referer);
            exit;
        }
        $this->redirect('home/index');
    }

    // Bandeja de Entrada (Inbox)
    public function inbox() {
        $mensajeModel = $this->model('MensajeChat');
        $chats = $mensajeModel->getInbox($_SESSION['usuario_id']);

        $data = [
            'chats' => $chats,
            'usuario' => $this->currentUser()
        ];

        $this->view('layouts/header', ['titulo' => 'Bandeja de Mensajes — Servi-Go']);
        $this->view('chat/inbox', $data);
        $this->view('layouts/footer');
    }
}
