<!-- ============================================================
     ADMIN - GESTIÓN DE SECTORES
     ============================================================ -->
<div class="admin-layout pb-5">
    <div style="background:var(--bg-dark);color:white;padding:1.5rem 0;">
        <div class="container d-flex justify-content-between align-items-center">
            <h3 style="font-family:var(--font-display);margin:0;">Gestión de Sectores</h3>
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
                    <a class="nav-link border-0 text-muted" href="<?= BASE_URL ?>index.php?url=admin/negocios"><i class="fas fa-store me-1"></i> Negocios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link border-0 text-muted" href="<?= BASE_URL ?>index.php?url=admin/categorias"><i class="fas fa-tags me-1"></i> Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active border-0 border-bottom border-3" style="color:var(--color-primary);border-color:var(--color-primary) !important;font-weight:600;" href="<?= BASE_URL ?>index.php?url=admin/sectores"><i class="fas fa-map-marker-alt me-1"></i> Sectores</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="admin-table p-4">
                    <h5 class="mb-4">Nuevo Sector/Barrio</h5>
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/crearSector" class="form-premium">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Sector</label>
                            <input type="text" name="nombre" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción (opcional)</label>
                            <textarea name="descripcion" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label">Latitud Centro</label>
                                <input type="text" name="latitud" class="form-control form-control-sm" placeholder="2.6633">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Longitud Centro</label>
                                <input type="text" name="longitud" class="form-control form-control-sm" placeholder="-75.5225">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i> Guardar</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="admin-table">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">Sectores Registrados (<?= count($sectores) ?>)</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Sector / Barrio</th>
                                    <th>Slug</th>
                                    <th>Coordenadas</th>
                                    <th>Negocios</th>
                                    <th width="120">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sectores as $sec): ?>
                                <tr>
                                    <td>
                                        <strong><i class="fas fa-map-pin me-2 text-primary"></i><?= htmlspecialchars($sec['nombre']) ?></strong>
                                        <?php if(!$sec['activo']): ?><span class="badge bg-secondary ms-1">Inactivo</span><?php endif; ?>
                                        <br><small class="text-muted text-truncate d-inline-block" style="max-width:200px;"><?= htmlspecialchars($sec['descripcion'] ?? 'Sin descripción') ?></small>
                                    </td>
                                    <td><code><?= htmlspecialchars($sec['slug']) ?></code></td>
                                    <td>
                                        <small class="text-muted">
                                            <?= $sec['latitud'] ?? 'N/A' ?><br><?= $sec['longitud'] ?? 'N/A' ?>
                                        </small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?= $sec['total_negocios'] ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSec<?= $sec['id'] ?>"><i class="fas fa-edit"></i></button>
                                        <a href="<?= BASE_URL ?>index.php?url=admin/eliminarSector/<?= $sec['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que deseas eliminar este sector?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal Editar -->
                                <div class="modal fade" id="editSec<?= $sec['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/editarSector" class="modal-content form-premium">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Sector</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $sec['id'] ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['nombre']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($sec['descripcion'] ?? '') ?></textarea>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label">Latitud</label>
                                                        <input type="text" name="latitud" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['latitud'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Longitud</label>
                                                        <input type="text" name="longitud" class="form-control form-control-sm" value="<?= htmlspecialchars($sec['longitud'] ?? '') ?>">
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="activo" id="acts<?= $sec['id'] ?>" <?= $sec['activo'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="acts<?= $sec['id'] ?>">Sector Activo</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
