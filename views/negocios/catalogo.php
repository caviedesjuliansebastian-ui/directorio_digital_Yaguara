<!-- ============================================================
     GESTIÓN DE CATÁLOGO (SERVI-GO DARK THEME)
     ============================================================ -->
<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="m-0 text-white"><i class="fas fa-box-open me-2" style="color:var(--color-primary)"></i>Catálogo de Productos y Servicios</h4>
            <small class="text-secondary">Estás gestionando el catálogo de: <strong><?= htmlspecialchars($negocio['nombre']) ?></strong></small>
        </div>
        <a href="<?= BASE_URL ?>index.php?url=usuario/mis_negocios" class="btn btn-outline-secondary text-white border-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Mis Negocios
        </a>
    </div>

    <div class="row">
        <!-- Formulario Nuevo Producto -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4" style="background:var(--bg-card);">
                <div class="card-body p-4">
                    <h5 class="text-white mb-4 fw-bold">Agregar al Catálogo</h5>
                    
                    <form action="<?= BASE_URL ?>index.php?url=producto/guardar" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="negocio_id" value="<?= $negocio['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label text-secondary small">Nombre del Producto/Servicio *</label>
                            <input type="text" name="nombre" class="form-control" style="background:var(--bg-card-light); border-color:var(--border-color); color:white;" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-secondary small">Descripción Breve</label>
                            <textarea name="descripcion" class="form-control" rows="2" style="background:var(--bg-card-light); border-color:var(--border-color); color:white;"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-secondary small">Precio (COP) *</label>
                                <input type="number" step="0.01" name="precio" class="form-control" style="background:var(--bg-card-light); border-color:var(--border-color); color:white;" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-secondary small">Unidad de Medida</label>
                                <select name="unidad_medida" class="form-select" style="background:var(--bg-card-light); border-color:var(--border-color); color:white;">
                                    <option value="Unidad">Unidad</option>
                                    <option value="Libra">Libra</option>
                                    <option value="Kilo">Kilo</option>
                                    <option value="Hora">Hora</option>
                                    <option value="Día">Día</option>
                                    <option value="Servicio">Servicio</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small">Foto (Opcional)</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" style="background:var(--bg-card-light); border-color:var(--border-color); color:white;">
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" name="disponible" id="disponible" checked>
                            <label class="form-check-label text-white" for="disponible">Disponible Inmediatamente</label>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold" style="background:var(--color-primary); border:none; color:white; border-radius:12px; padding:0.75rem;">
                            <i class="fas fa-plus-circle me-1"></i> Agregar al Catálogo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listado de Productos -->
        <div class="col-lg-8">
            <?php if (empty($productos)): ?>
                <div class="empty-state bg-white rounded-4 shadow-sm border-0 d-flex flex-column align-items-center justify-content-center p-5 text-center" style="background:var(--bg-card) !important; min-height: 400px;">
                    <div style="font-size:4rem; color:var(--border-light); margin-bottom:1rem;"><i class="fas fa-box-open"></i></div>
                    <h4 class="text-white">Tu catálogo está vacío</h4>
                    <p class="text-secondary">Agrega tus productos o servicios usando el formulario de la izquierda.</p>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <?php foreach ($productos as $p): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4" style="background:var(--bg-card-light);">
                                <div class="row g-0 h-100">
                                    <div class="col-4 position-relative" style="min-height:100px;">
                                        <?php if ($p['foto']): ?>
                                            <img src="<?= (str_starts_with($p['foto'], 'http') ? '' : BASE_URL) . $p['foto'] ?>" class="img-fluid rounded-start-4 h-100 w-100" style="object-fit:cover;" alt="<?= htmlspecialchars($p['nombre']) ?>">
                                        <?php else: ?>
                                            <div class="bg-dark rounded-start-4 h-100 w-100 d-flex align-items-center justify-content-center text-muted">
                                                <i class="fas fa-image fa-2x"></i>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!$p['disponible']): ?>
                                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center rounded-start-4">
                                                <span class="badge bg-danger">Agotado</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-3 d-flex flex-column h-100">
                                            <h6 class="card-title text-white fw-bold mb-1"><?= htmlspecialchars($p['nombre']) ?></h6>
                                            <p class="card-text text-secondary mb-2" style="font-size:0.75rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                                <?= htmlspecialchars($p['descripcion']) ?>
                                            </p>
                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="text-warning fw-bold">$<?= number_format($p['precio'], 0, ',', '.') ?></span>
                                                    <small class="text-muted" style="font-size:0.65rem;">/ <?= htmlspecialchars($p['unidad_medida']) ?></small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-danger border-0 p-1" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
