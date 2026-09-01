<!-- ============================================================
     CHAT BIDIRECCIONAL & CIERRE DE TRATOS — SERVI-GO
     ============================================================ -->
<div class="container py-4">
    
    <!-- Top Breadcrumb / Return -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?= BASE_URL ?>index.php?url=negocio/ficha/<?= $negocio['slug'] ?>" class="btn btn-sm btn-outline-secondary text-white border-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a <?= htmlspecialchars($negocio['nombre']) ?>
        </a>
        <a href="<?= BASE_URL ?>index.php?url=chat/inbox" class="btn btn-sm btn-outline-warning text-warning border-warning">
            <i class="fas fa-comments me-1"></i> Mi Bandeja de Mensajes
        </a>
    </div>

    <!-- Security Header -->
    <div class="p-3 mb-4 rounded-4 d-flex align-items-center justify-content-between" style="background: rgba(0, 179, 126, 0.1); border: 1px solid rgba(0, 179, 126, 0.25);">
        <div class="d-flex align-items-center gap-3">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--color-success); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <h6 class="text-white fw-bold mb-0">Chat con Protección Servi-Go</h6>
                <small class="text-secondary" style="font-size: 0.75rem;">Tus transacciones y cotizaciones están respaldadas y auditadas localmente en Yaguará.</small>
            </div>
        </div>
        <span class="badge d-none d-md-inline-block" style="background: var(--color-success); color: white; font-weight: 600; font-size: 0.75rem;">
            <i class="fas fa-lock me-1"></i> Encriptado & Seguro
        </span>
    </div>

    <div class="row g-4">
        
        <!-- Left / Main: Chat Box -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-color) !important; height: 600px; display: flex; flex-direction: column;">
                
                <!-- Chat Business Header -->
                <div class="p-3 d-flex align-items-center justify-content-between border-bottom" style="background: var(--bg-card-light); border-color: var(--border-color) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= !empty($negocio['logo']) ? (str_starts_with($negocio['logo'], 'http') ? '' : BASE_URL) . $negocio['logo'] : BASE_URL . 'public/assets/img/default-avatar.png' ?>" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover; border: 2px solid var(--border-color);">
                        <div>
                            <h6 class="text-white fw-bold mb-0"><?= htmlspecialchars($negocio['nombre']) ?></h6>
                            <small class="text-warning fw-semibold" style="font-size: 0.75rem;"><i class="fas fa-circle me-1" style="font-size: 0.45rem;"></i> En línea • 99% resp. (~4 min)</small>
                        </div>
                    </div>
                    <?php if ($esPropietario): ?>
                        <button class="btn btn-sm btn-warning fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#modalProponerTrato" style="font-size: 0.8rem; border-radius: 8px;">
                            <i class="fas fa-file-invoice-dollar me-1"></i> Crear Cotización / Trato
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Chat Messages Body -->
                <div class="p-4 flex-grow-1 overflow-y-auto" id="chat-messages-container" style="display: flex; flex-direction: column; gap: 1rem;">
                    
                    <div class="text-center my-2">
                        <span class="px-3 py-1 rounded-pill text-muted" style="background: #111315; font-size: 0.7rem; border: 1px solid var(--border-color);">
                            Inicio de la conversación segura • Yaguará
                        </span>
                    </div>

                    <?php if (empty($mensajes)): ?>
                        <div class="text-center text-muted my-auto">
                            <i class="far fa-comments fa-3x mb-2 text-secondary opacity-50"></i>
                            <p class="small text-secondary mb-0">Escribe tu consulta sobre productos o servicios para iniciar la conversación con el proveedor.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($mensajes as $msg): ?>
                            <?php $esMio = ($msg['emisor_id'] == $_SESSION['usuario_id']); ?>
                            <div class="d-flex <?= $esMio ? 'justify-content-end' : 'justify-content-start' ?>">
                                <div class="p-3 rounded-4" style="max-width: 75%; background: <?= $esMio ? 'var(--color-primary)' : 'var(--bg-card-light)' ?>; color: white; border-bottom-<?= $esMio ? 'right' : 'left' ?>-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-1" style="font-size: 0.7rem; opacity: 0.85;">
                                        <strong><?= htmlspecialchars($msg['emisor_nombre']) ?></strong>
                                        <span><?= date('h:i A', strtotime($msg['fecha_envio'])) ?></span>
                                    </div>
                                    <div style="font-size: 0.875rem; white-space: pre-line; line-height: 1.45;">
                                        <?= htmlspecialchars($msg['mensaje']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>

                <!-- Chat Input Footer -->
                <div class="p-3 border-top" style="background: var(--bg-card-light); border-color: var(--border-color) !important;">
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=chat/enviar" class="d-flex gap-2">
                        <input type="hidden" name="negocio_id" value="<?= $negocio['id'] ?>">
                        <input type="hidden" name="receptor_id" value="<?= $otroUsuarioId ?>">
                        
                        <input type="text" name="mensaje" class="form-control" placeholder="Escribe un mensaje o consulta..." required autocomplete="off" style="border-radius: 12px; background: #111315 !important;">
                        <button type="submit" class="btn btn-warning px-4 fw-bold text-dark" style="background: var(--color-primary); border: none; color: white !important; border-radius: 12px;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- Right: Deals / Tratos Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4" style="background: var(--bg-card); border: 1px solid var(--border-color) !important;">
                
                <h5 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fas fa-handshake text-warning"></i> Tratos & Acuerdos
                </h5>
                <p class="text-secondary" style="font-size: 0.8rem; line-height: 1.5;">
                    Formaliza pedidos o cotizaciones dentro del chat para contar con respaldo y calificar el servicio al completarse.
                </p>

                <hr style="border-color: var(--border-color);">

                <?php if (empty($tratos)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-file-contract fa-2x mb-2 text-secondary opacity-50"></i>
                        <p class="small text-secondary mb-0">No hay tratos activos en este momento.</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($tratos as $t): ?>
                            <div class="p-3 rounded-3" style="background: var(--bg-card-light); border: 1px solid <?= $t['estado'] === 'cerrado' ? 'var(--color-success)' : 'var(--border-light)' ?>;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="text-white fw-bold mb-0" style="font-size: 0.9rem;"><?= htmlspecialchars($t['concepto']) ?></h6>
                                    <?php if ($t['estado'] === 'cerrado'): ?>
                                        <span class="badge bg-success" style="font-size: 0.65rem;">CERRADO</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">PROPUESTO</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                                    <span class="text-secondary">Monto Acordado:</span>
                                    <strong class="text-white">$<?= number_format($t['monto_total'], 0, ',', '.') ?> COP</strong>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3 text-muted" style="font-size: 0.72rem;">
                                    <span>Comisión Servi-Go (5%):</span>
                                    <span>$<?= number_format($t['comision_plataforma'], 0, ',', '.') ?> COP</span>
                                </div>

                                <?php if ($t['estado'] === 'propuesto'): ?>
                                    <a href="<?= BASE_URL ?>index.php?url=chat/cerrarTrato/<?= $t['id'] ?>" class="btn btn-sm btn-success w-100 fw-bold" onclick="return confirm('¿Confirmas que se acordó este servicio/pedido satisfactoriamente?')" style="background: var(--color-success); border: none; border-radius: 8px;">
                                        <i class="fas fa-check-circle me-1"></i> Confirmar & Cerrar Trato
                                    </a>
                                <?php else: ?>
                                    <div class="text-center text-success small fw-semibold">
                                        <i class="fas fa-check-double me-1"></i> Trato Concretado
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<!-- Modal: Proponer Trato (Solo Proveedor) -->
<?php if ($esPropietario): ?>
<div class="modal fade" id="modalProponerTrato" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-file-signature text-warning me-2"></i>Crear Propuesta de Trato</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>index.php?url=chat/proponerTrato">
                <input type="hidden" name="negocio_id" value="<?= $negocio['id'] ?>">
                <input type="hidden" name="cliente_id" value="<?= $otroUsuarioId ?>">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Concepto o Detalle del Servicio/Pedido *</label>
                        <input type="text" name="concepto" class="form-control" placeholder="Ej. Instalación de motobomba 2HP / Pedido de 5 Quesillos" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Método de Pago Acordado</label>
                        <select name="metodo_pago" class="form-select bg-dark text-white border-secondary">
                            <option value="Efectivo Contraentrega">💵 Efectivo Contraentrega</option>
                            <option value="Nequi">🟣 Transferencia Nequi</option>
                            <option value="Daviplata">🔴 Daviplata</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Valor Total Acordado (COP) *</label>
                        <input type="number" name="monto_total" class="form-control" placeholder="Ej. 65000" min="1000" step="500" required>
                        <small class="text-muted" style="font-size: 0.72rem;">La plataforma calculará automáticamente la tarifa de protección del 5%.</small>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-3" style="background: var(--color-primary); color: white; border: none;">
                        Enviar al Chat <i class="fas fa-paper-plane ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Auto-scroll al final de los mensajes
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('chat-messages-container');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
});
</script>
