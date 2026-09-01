<!-- ============================================================
     ADMIN DASHBOARD (SERVI-GO THEME)
     ============================================================ -->
<div class="container py-5">
    
    <!-- Admin Metrics Header (Mock data based on Servi-Go UI) -->
    <div class="admin-header">
        <div class="admin-metric-card">
            <div class="metric-title">Verificaciones Pendientes</div>
            <div class="metric-value text-warning-custom"><?= number_format($estadisticas['pendientes'] ?? 2) ?></div>
            <div class="metric-sub">En cola de revisión</div>
        </div>
        
        <div class="admin-metric-card">
            <div class="metric-title">Chats Moderados</div>
            <div class="metric-value" style="color:#ef4444;">1</div>
            <div class="metric-sub">Riesgo fuera de app</div>
        </div>
        
        <div class="admin-metric-card">
            <div class="metric-title">Ventas Plataforma (GMV)</div>
            <div class="metric-value">$183.000</div>
            <div class="metric-sub">Total transaccionado</div>
        </div>
        
        <div class="admin-metric-card">
            <div class="metric-title">Comisiones Recaudadas</div>
            <div class="metric-value green">$9.150</div>
            <div class="metric-sub">5% tarifa de servicio</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="admin-tabs">
        <div class="admin-tab active"><i class="fas fa-check-circle me-1"></i> Aprobaciones de Proveedores (4)</div>
        <div class="admin-tab"><i class="fas fa-shield-alt me-1"></i> Moderación de Chats (2)</div>
        <div class="admin-tab"><i class="fas fa-chart-line me-1"></i> Métricas Globales</div>
    </div>

    <p class="text-secondary mb-4" style="font-size:0.85rem;">Revisa la documentación adjuntada (Cédula / RUT / RETIE / Invima) para otorgar el sello verde de verificación.</p>

    <!-- Approval List -->
    <div>
        <?php if(empty($negociosPendientes)): ?>
            <!-- Static Mocks to match screenshot if database is empty -->
            <div class="approval-card">
                <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                <div class="approval-info">
                    <h6>Lácteos & Quesillos San Pedro Yaguará <span class="badge-status badge-pending">PENDING</span></h6>
                    <p class="approval-desc">Solicitante: Pedro José Bahamón • Yaguará (Comidas Típicas, Quesillos & Pescaderías)</p>
                    <p class="approval-doc">Doc: Registro Sanitario Invima & Cédula (#12.180.452)</p>
                    <p class="approval-note">Nota auditoría: "Documentos radicados en Alcaldía de Yaguará, pendientes de validación."</p>
                </div>
                <div class="approval-actions">
                    <button class="btn-approve"><i class="fas fa-check-circle me-1"></i> Aprobar y Verificar</button>
                    <button class="btn-reject"><i class="fas fa-times-circle me-1"></i> Rechazar</button>
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
                    <button class="btn-approve"><i class="fas fa-check-circle me-1"></i> Aprobar y Verificar</button>
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
                    <!-- Placeholder for on hold actions -->
                </div>
            </div>

            <div class="approval-card">
                <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                <div class="approval-info">
                    <h6>Bizcochería La Rivera Dorada <span class="badge-status badge-approved">APPROVED</span></h6>
                    <p class="approval-desc">Solicitante: Hernando Rivera • Rivera (Bizcochería, Achiras y Panaderías)</p>
                    <p class="approval-doc">Doc: Cámara de Comercio Huila & RUT (#901.421.100-3)</p>
                    <p class="approval-note">Nota auditoría: "Aprobado con sello de verificación Servi-Go."</p>
                </div>
                <div class="approval-actions">
                    <button class="btn-verified" disabled><i class="fas fa-check"></i> Verificado</button>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Dynamic Data Render -->
            <?php foreach ($negociosPendientes as $np): ?>
                <div class="approval-card">
                    <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                    <div class="approval-info">
                        <h6><?= htmlspecialchars($np['nombre']) ?> <span class="badge-status badge-pending">PENDING</span></h6>
                        <p class="approval-desc">Solicitante: <?= htmlspecialchars($np['propietario_nombre']) ?> • <?= htmlspecialchars($np['categoria_nombre'] ?? 'Sin categoría') ?></p>
                        <p class="approval-doc">Doc: Documentación Base</p>
                        <p class="approval-note">Nota auditoría: "Pendiente de validación manual en sistema."</p>
                    </div>
                    <div class="approval-actions">
                        <a href="<?= BASE_URL ?>index.php?url=admin/aprobar/<?= $np['id'] ?>" class="btn-approve text-decoration-none" onclick="return confirm('¿Aprobar y Verificar?')"><i class="fas fa-check-circle me-1"></i> Aprobar y Verificar</a>
                        <a href="<?= BASE_URL ?>index.php?url=admin/rechazar/<?= $np['id'] ?>" class="btn-reject text-decoration-none" onclick="return confirm('¿Rechazar solicitud?')"><i class="fas fa-times-circle me-1"></i> Rechazar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
