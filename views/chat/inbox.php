<!-- ============================================================
     BANDEJA DE ENTRADA (INBOX) — SERVI-GO / DIRECT DIGITAL YAGUARÁ
     ============================================================ -->
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="text-white fw-bold m-0"><i class="fas fa-inbox text-warning me-2"></i>Bandeja de Mensajes & Tratos</h4>
            <p class="text-secondary small mb-0">Conversaciones activas en tiempo real con comercios y clientes de Yaguará.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn btn-outline-warning btn-sm fw-semibold" style="border-radius: 8px;">
                <i class="fas fa-store me-1"></i> Explorar Directorio
            </a>
            <a href="<?= BASE_URL ?>index.php?url=usuario/mis_negocios" class="btn btn-outline-secondary text-white btn-sm" style="border-radius: 8px;">
                <i class="fas fa-user me-1"></i> Mi Panel
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-color) !important;">
        
        <?php if (empty($chats)): ?>
            <div class="p-5 text-center text-muted">
                <i class="far fa-comments fa-3x mb-3 text-secondary opacity-50"></i>
                <h5 class="text-white">No tienes mensajes activos aún</h5>
                <p class="text-secondary small mb-3">Inicia una conversación desde la ficha de cualquier negocio de Yaguará para cotizar, consultar o pedir productos.</p>
                <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn btn-warning btn-sm fw-bold px-4 text-white" style="background: var(--color-primary); border: none; border-radius: 8px;">
                    <i class="fas fa-search me-1"></i> Ver Comercios y Servicios
                </a>
            </div>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($chats as $c): ?>
                    <?php 
                    $otroId = ($c['emisor_id'] != $_SESSION['usuario_id'] ? $c['emisor_id'] : $c['receptor_id']);
                    $imgUrl = !empty($c['negocio_logo']) 
                        ? (str_starts_with($c['negocio_logo'], 'http') ? $c['negocio_logo'] : BASE_URL . $c['negocio_logo']) 
                        : BASE_URL . 'public/assets/img/default-avatar.png';
                    ?>
                    <a href="<?= BASE_URL ?>index.php?url=chat/conversacion/<?= $c['negocio_id'] ?>?cliente_id=<?= $otroId ?>" class="list-group-item list-group-item-action p-3 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: transparent; border-color: var(--border-color); color: white; transition: background 0.15s ease;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="position-relative">
                                <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($c['negocio_nombre']) ?>" style="width: 52px; height: 52px; border-radius: 14px; object-fit: cover; border: 2px solid var(--border-color);">
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-dark rounded-circle" style="width: 12px; height: 12px;" title="En línea"></span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h6 class="text-white fw-bold mb-0" style="font-size: 0.95rem;"><?= htmlspecialchars($c['negocio_nombre']) ?></h6>
                                    <?php if (!empty($c['categoria_nombre'])): ?>
                                        <span class="badge bg-dark text-secondary border border-secondary" style="font-size: 0.65rem;"><?= htmlspecialchars($c['categoria_nombre']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-secondary small mb-0 text-truncate mt-1" style="max-width: 520px; font-size: 0.82rem;">
                                    <strong class="<?= ($c['emisor_id'] == $_SESSION['usuario_id'] ? 'text-warning' : 'text-white') ?>">
                                        <?= ($c['emisor_id'] == $_SESSION['usuario_id'] ? 'Tú' : htmlspecialchars($c['emisor_nombre'])) ?>:
                                    </strong> 
                                    <?= htmlspecialchars($c['mensaje']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="text-end d-flex flex-column align-items-end gap-1">
                            <small class="text-muted" style="font-size: 0.72rem;"><?= date('d/m/Y h:i A', strtotime($c['fecha_envio'])) ?></small>
                            <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); font-size: 0.7rem; font-weight: 600;">
                                Abrir Chat <i class="fas fa-chevron-right ms-1"></i>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>
