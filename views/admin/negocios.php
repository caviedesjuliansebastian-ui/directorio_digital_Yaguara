<!-- ============================================================
     ADMIN - GESTIÓN DE NEGOCIOS
     ============================================================ -->
<div class="admin-layout pb-5">
    <div style="background:var(--bg-dark);color:white;padding:1.5rem 0;">
        <div class="container d-flex justify-content-between align-items-center">
            <h3 style="font-family:var(--font-display);margin:0;">Gestión de Negocios</h3>
            <div class="d-flex gap-3">
                <a href="<?= BASE_URL ?>" class="btn btn-sm btn-outline-light"><i class="fas fa-external-link-alt"></i> Ver Sitio</a>
            </div>
        </div>
    </div>
    
    <div style="background:white;border-bottom:1px solid var(--border-color);margin-bottom:2rem;">
        <div class="container">
            <ul class="nav nav-tabs border-0" style="gap:1rem;">
                <li class="nav-item">
                    <a class="nav-link border-0 text-muted" href="<?= BASE_URL ?>index.php?url=admin/dashboard"><i class="fas fa-chart-pie me-1"></i> Resumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active border-0 border-bottom border-3" style="color:var(--color-primary);border-color:var(--color-primary) !important;font-weight:600;" href="<?= BASE_URL ?>index.php?url=admin/negocios"><i class="fas fa-store me-1"></i> Negocios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link border-0 text-muted" href="<?= BASE_URL ?>index.php?url=admin/categorias"><i class="fas fa-tags me-1"></i> Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link border-0 text-muted" href="<?= BASE_URL ?>index.php?url=admin/sectores"><i class="fas fa-map-marker-alt me-1"></i> Sectores</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="admin-table">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Todos los Negocios (<?= count($negocios) ?>)</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Negocio</th>
                            <th>Usuario/Contacto</th>
                            <th>Estado</th>
                            <th>Visitas</th>
                            <th>Destacado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($negocios as $n): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <?php if($n['logo']): ?>
                                        <img src="<?= BASE_URL . $n['logo'] ?>" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
                                    <?php else: ?>
                                        <div style="width:40px;height:40px;background:#e2e8f0;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;"><i class="fas fa-store"></i></div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= htmlspecialchars($n['nombre']) ?></strong>
                                        <?php if($n['verificado']): ?> <i class="fas fa-check-circle text-success" title="Verificado"></i> <?php endif; ?>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars($n['categoria_nombre'] ?? 'N/A') ?> • <?= htmlspecialchars($n['sector_nombre'] ?? 'N/A') ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small><i class="fas fa-user me-1 text-muted"></i><?= htmlspecialchars($n['propietario_nombre']) ?></small><br>
                                <small><i class="fas fa-phone me-1 text-muted"></i><?= htmlspecialchars($n['telefono'] ?? $n['whatsapp'] ?? 'N/A') ?></small>
                            </td>
                            <td>
                                <span class="status-badge <?= $n['estado'] ?>"><?= $n['estado'] ?></span>
                            </td>
                            <td><?= number_format($n['visitas']) ?></td>
                            <td>
                                <?php if($n['destacado']): ?>
                                    <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> Sí</span>
                                <?php else: ?>
                                    <span class="text-muted small">No</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= BASE_URL ?>index.php?url=negocio/ficha/<?= $n['slug'] ?>" class="btn btn-outline-secondary" target="_blank" title="Ver en sitio"><i class="fas fa-external-link-alt"></i></a>
                                    
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><h6 class="dropdown-header">Cambiar Estado</h6></li>
                                        <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?url=admin/aprobar/<?= $n['id'] ?>"><i class="fas fa-check text-success me-2"></i>Aprobar / Activar</a></li>
                                        <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?url=admin/desactivar/<?= $n['id'] ?>"><i class="fas fa-pause text-secondary me-2"></i>Desactivar</a></li>
                                        <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?url=admin/rechazar/<?= $n['id'] ?>"><i class="fas fa-times text-danger me-2"></i>Rechazar</a></li>
                                        
                                        <li><hr class="dropdown-divider"></li>
                                        
                                        <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?url=admin/verificar/<?= $n['id'] ?>"><i class="fas fa-certificate text-primary me-2"></i>Verificar (Badge)</a></li>
                                        <li><a class="dropdown-item" href="<?= BASE_URL ?>index.php?url=admin/destacar/<?= $n['id'] ?>"><i class="fas fa-star text-warning me-2"></i>Toggle Destacado</a></li>
                                        
                                        <li><hr class="dropdown-divider"></li>
                                        
                                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>index.php?url=admin/eliminarNegocio/<?= $n['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar permanentemente este negocio?')"><i class="fas fa-trash me-2"></i>Eliminar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
