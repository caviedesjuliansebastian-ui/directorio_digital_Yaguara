<!-- ============================================================
     ADMIN - GESTIÓN DE CATEGORÍAS
     ============================================================ -->
<div class="admin-layout pb-5">
    <div style="background:var(--bg-dark);color:white;padding:1.5rem 0;">
        <div class="container d-flex justify-content-between align-items-center">
            <h3 style="font-family:var(--font-display);margin:0;">Gestión de Categorías</h3>
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
                    <a class="nav-link active border-0 border-bottom border-3" style="color:var(--color-primary);border-color:var(--color-primary) !important;font-weight:600;" href="<?= BASE_URL ?>index.php?url=admin/categorias"><i class="fas fa-tags me-1"></i> Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link border-0 text-muted" href="<?= BASE_URL ?>index.php?url=admin/sectores"><i class="fas fa-map-marker-alt me-1"></i> Sectores</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="admin-table p-4">
                    <h5 class="mb-4">Nueva Categoría</h5>
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/crearCategoria" class="form-premium">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control form-control-sm" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-8">
                                <label class="form-label">Icono (FontAwesome)</label>
                                <input type="text" name="icono" class="form-control form-control-sm" placeholder="fas fa-store" value="fas fa-store">
                            </div>
                            <div class="col-4">
                                <label class="form-label">Color Hex</label>
                                <input type="color" name="color" class="form-control form-control-color form-control-sm w-100" value="#059669">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción (opcional)</label>
                            <textarea name="descripcion" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Orden (Prioridad)</label>
                            <input type="number" name="orden" class="form-control form-control-sm" value="0">
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i> Guardar</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="admin-table">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">Categorías Registradas (<?= count($categorias) ?>)</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="60"></th>
                                    <th>Categoría</th>
                                    <th>Slug</th>
                                    <th>Orden</th>
                                    <th>Negocios</th>
                                    <th width="120">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categorias as $cat): ?>
                                <tr>
                                    <td class="text-center">
                                        <div style="width:36px;height:36px;background:<?= $cat['color'] ?>;color:white;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:auto;">
                                            <i class="<?= $cat['icono'] ?>"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($cat['nombre']) ?></strong>
                                        <?php if(!$cat['activo']): ?><span class="badge bg-secondary ms-1">Inactiva</span><?php endif; ?>
                                        <br><small class="text-muted text-truncate d-inline-block" style="max-width:200px;"><?= htmlspecialchars($cat['descripcion'] ?? 'Sin descripción') ?></small>
                                    </td>
                                    <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                                    <td><?= $cat['orden'] ?></td>
                                    <td><span class="badge bg-light text-dark border"><?= $cat['total_negocios'] ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCat<?= $cat['id'] ?>"><i class="fas fa-edit"></i></button>
                                        <a href="<?= BASE_URL ?>index.php?url=admin/eliminarCategoria/<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que deseas eliminar esta categoría? (Los negocios asociados quedarán sin categoría)')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal Editar -->
                                <div class="modal fade" id="editCat<?= $cat['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="POST" action="<?= BASE_URL ?>index.php?url=admin/editarCategoria" class="modal-content form-premium">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Categoría</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control form-control-sm" value="<?= htmlspecialchars($cat['nombre']) ?>" required>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-8">
                                                        <label class="form-label">Icono (FontAwesome)</label>
                                                        <input type="text" name="icono" class="form-control form-control-sm" value="<?= htmlspecialchars($cat['icono']) ?>">
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label">Color Hex</label>
                                                        <input type="color" name="color" class="form-control form-control-color form-control-sm w-100" value="<?= htmlspecialchars($cat['color']) ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea name="descripcion" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($cat['descripcion'] ?? '') ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Orden</label>
                                                    <input type="number" name="orden" class="form-control form-control-sm" value="<?= $cat['orden'] ?>">
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="activo" id="act<?= $cat['id'] ?>" <?= $cat['activo'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="act<?= $cat['id'] ?>">Categoría Activa</label>
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
