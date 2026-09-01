<!-- ============================================================
     ADMIN DASHBOARD — SERVI-GO / VECIRED MODERATION & LEDGER
     ============================================================ -->
<div class="container py-5">
    
    <!-- Admin Metrics Header -->
    <div class="admin-header mb-4">
        <div class="admin-metric-card">
            <div class="metric-title">Verificaciones Pendientes</div>
            <div class="metric-value text-warning-custom"><?= count($negociosPendientes ?? []) ?></div>
            <div class="metric-sub">En cola de revisión</div>
        </div>
        
        <div class="admin-metric-card">
            <div class="metric-title">Chats Moderados</div>
            <div class="metric-value" style="color:#ef4444;">1</div>
            <div class="metric-sub">Riesgo fuera de app</div>
        </div>
        
        <div class="admin-metric-card">
            <div class="metric-title">Ventas Plataforma (GMV)</div>
            <div class="metric-value">$300.000</div>
            <div class="metric-sub">Total transaccionado</div>
        </div>
        
        <div class="admin-metric-card">
            <div class="metric-title">Comisiones Recaudadas</div>
            <div class="metric-value green">$20.200</div>
            <div class="metric-sub">5% tarifa de servicio</div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-pills admin-tabs mb-4 border-0" id="adminTabs" role="tablist">
        <li class="nav-item">
            <button class="admin-tab active border-0" id="aprobaciones-tab" data-bs-toggle="pill" data-bs-target="#tab-aprobaciones" type="button" role="tab">
                <i class="fas fa-check-circle me-1"></i> Aprobaciones de Proveedores (<?= count($negociosPendientes ?? []) ?: '4' ?>)
            </button>
        </li>
        <li class="nav-item">
            <button class="admin-tab border-0" id="moderacion-tab" data-bs-toggle="pill" data-bs-target="#tab-moderacion" type="button" role="tab">
                <i class="fas fa-shield-alt me-1"></i> Moderación de Chats (1)
            </button>
        </li>
        <li class="nav-item">
            <button class="admin-tab border-0" id="metricas-tab" data-bs-toggle="pill" data-bs-target="#tab-metricas" type="button" role="tab">
                <i class="fas fa-chart-line me-1"></i> Libro Mayor de Tratos (Deals Ledger)
            </button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="adminTabsContent">
        
        <!-- TAB 1: Aprobaciones -->
        <div class="tab-pane fade show active" id="tab-aprobaciones" role="tabpanel">
            <p class="text-secondary mb-4" style="font-size:0.85rem;">Revisa la documentación adjuntada (Cédula / RUT / Invima) para otorgar el sello verde de verificación oficial.</p>

            <div class="d-flex flex-column gap-3">
                <?php if(empty($negociosPendientes)): ?>
                    <div class="approval-card">
                        <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                        <div class="approval-info">
                            <h6>Lácteos & Quesillos San Pedro Yaguará <span class="badge-status badge-pending">PENDING</span></h6>
                            <p class="approval-desc">Solicitante: Pedro José Bahamón • Yaguará (Comidas Típicas, Quesillos & Pescaderías)</p>
                            <p class="approval-doc">Doc: Registro Sanitario Invima & Cédula (#12.180.452)</p>
                            <p class="approval-note">Nota auditoría: "Documentos radicados en Alcaldía de Yaguará, pendientes de validación."</p>
                        </div>
                        <div class="approval-actions">
                            <button class="btn-approve" onclick="alert('¡Negocio verificado y publicado!')"><i class="fas fa-check-circle me-1"></i> Aprobar y Verificar</button>
                            <button class="btn-reject" onclick="alert('Solicitud rechazada')"><i class="fas fa-times-circle me-1"></i> Rechazar</button>
                        </div>
                    </div>

                    <div class="approval-card">
                        <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                        <div class="approval-info">
                            <h6>Droguería La Fe Yaguará <span class="badge-status badge-pending">PENDING</span></h6>
                            <p class="approval-desc">Solicitante: Claudia Patricia Tovar • Yaguará (Droguerías & Farmacias)</p>
                            <p class="approval-doc">Doc: Permiso Secretaría de Salud Huila & RUT (#55.321.890)</p>
                            <p class="approval-note">Nota auditoría: "Certificado de droguería vigente expedido en Neiva."</p>
                        </div>
                        <div class="approval-actions">
                            <button class="btn-approve" onclick="alert('¡Negocio verificado!')"><i class="fas fa-check-circle me-1"></i> Aprobar y Verificar</button>
                            <button class="btn-reject"><i class="fas fa-times-circle me-1"></i> Rechazar</button>
                        </div>
                    </div>

                    <div class="approval-card">
                        <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                        <div class="approval-info">
                            <h6>Taller Electromecánico Campoalegre <span class="badge-status" style="background:#fef3c7;color:#d97706;">ON_HOLD</span></h6>
                            <p class="approval-desc">Solicitante: Gustavo Perdomo • Campoalegre (Electricistas & Motobombas)</p>
                            <p class="approval-doc">Doc: Tarjeta Profesional CONTE & Cédula (#83.210.456)</p>
                            <p class="approval-note">Nota auditoría: "Solicitó foto de cédula por el reverso en mejor resolución."</p>
                        </div>
                        <div class="approval-actions">
                            <span class="badge bg-warning text-dark px-3 py-2">En Espera de Documento</span>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($negociosPendientes as $np): ?>
                        <div class="approval-card">
                            <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                            <div class="approval-info">
                                <h6><?= htmlspecialchars($np['nombre']) ?> <span class="badge-status badge-pending">PENDING</span></h6>
                                <p class="approval-desc">Solicitante: <?= htmlspecialchars($np['propietario_nombre'] ?? 'Usuario Registrado') ?> • <?= htmlspecialchars($np['categoria_nombre'] ?? 'Sin categoría') ?></p>
                                <p class="approval-doc">Doc: Cédula & RUT del Comercio</p>
                                <p class="approval-note">Nota auditoría: "Pendiente de validación manual en sistema."</p>
                            </div>
                            <div class="approval-actions">
                                <a href="<?= BASE_URL ?>index.php?url=admin/aprobar/<?= $np['id'] ?>" class="btn-approve text-decoration-none" onclick="return confirm('¿Aprobar y otorgar sello verificado?')"><i class="fas fa-check-circle me-1"></i> Aprobar y Verificar</a>
                                <a href="<?= BASE_URL ?>index.php?url=admin/rechazar/<?= $np['id'] ?>" class="btn-reject text-decoration-none" onclick="return confirm('¿Rechazar solicitud?')"><i class="fas fa-times-circle me-1"></i> Rechazar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- TAB 2: Moderación de Chats (Flagged Chats) -->
        <div class="tab-pane fade" id="tab-moderacion" role="tabpanel">
            <p class="text-secondary mb-4" style="font-size:0.85rem;">Monitoreo preventivo de mensajes por palabras clave de fraude, evasión de pagos o contactos no autorizados.</p>

            <div class="card border-0 rounded-4 p-4 mb-3" style="background: var(--bg-card); border: 1px solid rgba(239, 68, 68, 0.3) !important;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(239, 68, 68, 0.15); color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h6 class="text-white fw-bold mb-0">Alerta de Evasión Fuera de Plataforma</h6>
                            <small class="text-secondary">Negocio: Quesillos y Tradición Yaguareña Doña Stella • Usuario: Carlos G.</small>
                        </div>
                    </div>
                    <span class="badge bg-danger">FLAGGED</span>
                </div>
                
                <div class="p-3 rounded-3 mb-3" style="background: #111315; border: 1px solid var(--border-color); font-family: monospace; font-size: 0.85rem; color: #e5e5e5;">
                    "Escríbeme mejor al WhatsApp personal tres diez dos dos ocho... para no pagar la tarifa del 5%"
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-sm btn-outline-secondary text-white border-secondary" onclick="alert('Advertencia enviada al usuario')">
                        <i class="fas fa-paper-plane me-1"></i> Enviar Advertencia
                    </button>
                    <button class="btn btn-sm btn-outline-success text-success border-success" onclick="this.closest('.card').remove(); alert('Marcado como resuelto')">
                        <i class="fas fa-check me-1"></i> Marcar Seguro / Ignorar
                    </button>
                </div>
            </div>
        </div>

        <!-- TAB 3: Deals Ledger (Libro Mayor de Tratos) -->
        <div class="tab-pane fade" id="tab-metricas" role="tabpanel">
            <p class="text-secondary mb-4" style="font-size:0.85rem;">Historial consolidado de tratos cerrados, montos brutos y comisiones de plataforma recaudadas.</p>

            <div class="card border-0 rounded-4 overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-color) !important;">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0" style="font-size: 0.85rem; background: transparent;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-secondary);">
                                <th class="p-3">ID</th>
                                <th class="p-3">Fecha</th>
                                <th class="p-3">Comercio / Proveedor</th>
                                <th class="p-3">Concepto Acordado</th>
                                <th class="p-3">Monto Total</th>
                                <th class="p-3">Comisión 5%</th>
                                <th class="p-3 text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td class="p-3 text-muted">#TR-001</td>
                                <td class="p-3">01/09/2026</td>
                                <td class="p-3 fw-bold text-white">Quesillos Doña Stella</td>
                                <td class="p-3">Combo 5 Libras Quesillo Tradicional</td>
                                <td class="p-3 text-white fw-bold">$70.000 COP</td>
                                <td class="p-3 text-success fw-bold">$3.500 COP</td>
                                <td class="p-3 text-center"><span class="badge bg-success">CERRADO</span></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td class="p-3 text-muted">#TR-002</td>
                                <td class="p-3">01/09/2026</td>
                                <td class="p-3 fw-bold text-white">Pescadería El Malecón</td>
                                <td class="p-3">2 Mojarras Fritas + Viudo de Capaz</td>
                                <td class="p-3 text-white fw-bold">$98.000 COP</td>
                                <td class="p-3 text-success fw-bold">$4.900 COP</td>
                                <td class="p-3 text-center"><span class="badge bg-success">CERRADO</span></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td class="p-3 text-muted">#TR-003</td>
                                <td class="p-3">01/09/2026</td>
                                <td class="p-3 fw-bold text-white">Asados Huilense Don Pedro</td>
                                <td class="p-3">3 Platos de Asado con Insulso</td>
                                <td class="p-3 text-white fw-bold">$84.000 COP</td>
                                <td class="p-3 text-success fw-bold">$4.200 COP</td>
                                <td class="p-3 text-center"><span class="badge bg-success">CERRADO</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
