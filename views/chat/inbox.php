<!-- ============================================================
     BANDEJA DE ENTRADA (INBOX) — SERVI-GO
     ============================================================ -->
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-white fw-bold m-0"><i class="fas fa-inbox text-warning me-2"></i>Bandeja de Mensajes & Tratos</h4>
            <p class="text-secondary small mb-0">Conversaciones activas con proveedores y clientes en Yaguará.</p>
        </div>
        <a href="<?= BASE_URL ?>" class="btn btn-outline-secondary text-white border-secondary btn-sm">
            <i class="fas fa-store me-1"></i> Explorar Directorio
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-color) !important;">
        
        <?php if (empty($chats)): ?>
            <div class="p-5 text-center text-muted">
                <i class="far fa-comments fa-3x mb-3 text-secondary opacity-50"></i>
                <h5 class="text-white">No tienes mensajes activos</h5>
                <p class="text-secondary small mb-3">Inicia una conversación desde la ficha de cualquier negocio para cotizar o pedir productos.</p>
                <a href="<?= BASE_URL ?>" class="btn btn-warning btn-sm fw-bold px-3 text-white" style="background: var(--color-primary); border: none; border-radius: 8px;">
                    Ver Comercios
                </a>
            </div>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($chats as $c): ?>
                    <a href="<?= BASE_URL ?>index.php?url=chat/conversacion/<?= $c['negocio_id'] ?><?= ($c['emisor_id'] != $_SESSION['usuario_id'] ? '?cliente_id=' . $c['emisor_id'] : '?cliente_id=' . $c['receptor_id']) ?>" class="list-group-item list-group-item-action p-3 d-flex align-items-center justify-content-between" style="background: transparent; border-color: var(--border-color); color: white;">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?= !empty($c['negocio_logo']) ? (str_starts_with($c['negocio_logo'], 'http') ? '' : BASE_URL) . $c['negocio_logo'] : BASE_URL . 'public/assets/img/default-avatar.png' ?>" style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover;">
                            <div>
                                <h6 class="text-white fw-bold mb-1"><?= htmlspecialchars($c['negocio_nombre']) ?></h6>
                                <p class="text-secondary small mb-0 text-truncate" style="max-width: 450px;">
                                    <strong><?= ($c['emisor_id'] == $_SESSION['usuario_id'] ? 'Tú' : htmlspecialchars($c['emisor_nombre'])) ?>:</strong> <?= htmlspecialchars($c['mensaje']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block" style="font-size: 0.72rem;"><?= date('d/m/Y h:i A', strtotime($c['fecha_envio'])) ?></small>
                            <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">Ver Chat <i class="fas fa-chevron-right ms-1"></i></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>
