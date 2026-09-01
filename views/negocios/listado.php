<!-- ============================================================
     LISTADO DE NEGOCIOS Y SERVICIOS — SERVI-GO
     ============================================================ -->
<section class="py-4">
    <div class="container">
        
        <!-- Header & Breadcrumbs -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-secondary text-decoration-none">Inicio</a></li>
                    <?php if (!empty($categoriaActual)): ?>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="text-secondary text-decoration-none">Negocios</a></li>
                        <li class="breadcrumb-item active text-white"><?= htmlspecialchars($categoriaActual['nombre']) ?></li>
                    <?php elseif (!empty($sectorActual)): ?>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="text-secondary text-decoration-none">Negocios</a></li>
                        <li class="breadcrumb-item active text-white"><?= htmlspecialchars($sectorActual['nombre']) ?></li>
                    <?php else: ?>
                        <li class="breadcrumb-item active text-white">Todos los Comercios</li>
                    <?php endif; ?>
                </ol>
            </nav>
            <span class="text-secondary small"><?= count($negocios ?? []) ?> resultados encontrados</span>
        </div>

        <div class="row g-4">
            
            <!-- Sidebar Filtros -->
            <div class="col-lg-3">
                <div class="p-4 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                    <h5 class="text-white fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fas fa-filter text-warning"></i> Filtros
                    </h5>
                    
                    <!-- Búsqueda -->
                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold">Buscar por Nombre / Producto</label>
                        <form method="GET" action="<?= BASE_URL ?>index.php">
                            <input type="hidden" name="url" value="negocio/listado">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control bg-dark text-white border-secondary" value="<?= htmlspecialchars($query ?? '') ?>" placeholder="Ej. quesillo, mojarra...">
                                <button type="submit" class="btn btn-warning text-dark fw-bold" style="background: var(--color-primary); color: white !important; border: none;"><i class="fas fa-search"></i></button>
                            </div>
                            <?php if (!empty($categoriaId)): ?><input type="hidden" name="categoria" value="<?= $categoriaId ?>"><?php endif; ?>
                            <?php if (!empty($sectorId)): ?><input type="hidden" name="sector" value="<?= $sectorId ?>"><?php endif; ?>
                        </form>
                    </div>
                    
                    <!-- Categorías -->
                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold">Categorías</label>
                        <div class="d-flex flex-column gap-1">
                            <a href="<?= BASE_URL ?>index.php?url=negocio/listado<?= !empty($sectorId) ? '&sector='.$sectorId : '' ?>" 
                               class="btn btn-sm text-start <?= empty($categoriaId) ? 'btn-warning text-dark fw-bold' : 'btn-dark text-secondary border-0' ?>" style="border-radius: 8px;">
                                <i class="fas fa-th-large me-2"></i> Todas
                            </a>
                            <?php foreach (($categorias ?? []) as $cat): ?>
                                <a href="<?= BASE_URL ?>index.php?url=negocio/listado&categoria=<?= $cat['id'] ?><?= !empty($sectorId) ? '&sector='.$sectorId : '' ?>" 
                                   class="btn btn-sm text-start text-truncate <?= (!empty($categoriaId) && $categoriaId == $cat['id']) ? 'btn-warning text-dark fw-bold' : 'btn-dark text-secondary border-0' ?>" style="border-radius: 8px;" title="<?= htmlspecialchars($cat['nombre']) ?>">
                                    <i class="<?= $cat['icono'] ?> me-2 text-warning"></i> <?= htmlspecialchars($cat['nombre']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Sectores -->
                    <div>
                        <label class="form-label text-secondary small fw-bold">Sectores de Yaguará</label>
                        <div class="d-flex flex-column gap-1">
                            <a href="<?= BASE_URL ?>index.php?url=negocio/listado<?= !empty($categoriaId) ? '&categoria='.$categoriaId : '' ?>" 
                               class="btn btn-sm text-start <?= empty($sectorId) ? 'btn-warning text-dark fw-bold' : 'btn-dark text-secondary border-0' ?>" style="border-radius: 8px;">
                                <i class="fas fa-map-marked-alt me-2"></i> Todos
                            </a>
                            <?php foreach (($sectores ?? []) as $sec): ?>
                                <a href="<?= BASE_URL ?>index.php?url=negocio/listado&sector=<?= $sec['id'] ?><?= !empty($categoriaId) ? '&categoria='.$categoriaId : '' ?>" 
                                   class="btn btn-sm text-start <?= (!empty($sectorId) && $sectorId == $sec['id']) ? 'btn-warning text-dark fw-bold' : 'btn-dark text-secondary border-0' ?>" style="border-radius: 8px;">
                                    <i class="fas fa-map-marker-alt me-2 text-warning"></i> <?= htmlspecialchars($sec['nombre']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Grid de Negocios -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-white fw-bold m-0">
                        <?= !empty($categoriaActual) ? htmlspecialchars($categoriaActual['nombre']) : (!empty($sectorActual) ? 'Sector: ' . htmlspecialchars($sectorActual['nombre']) : 'Todos los Comercios y Servicios') ?>
                    </h4>
                </div>

                <?php if (empty($negocios)): ?>
                    <div class="p-5 text-center rounded-4" style="background: var(--bg-card); border: 1px dashed var(--border-color);">
                        <i class="fas fa-search fa-3x mb-3 text-secondary opacity-50"></i>
                        <h5 class="text-white">No se encontraron comercios en esta categoría</h5>
                        <p class="text-secondary small mb-3">Intenta cambiar los filtros de búsqueda o seleccionar otro sector.</p>
                        <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn btn-warning btn-sm text-white fw-bold px-3" style="background: var(--color-primary); border: none; border-radius: 8px;">
                            Ver Todos los Comercios
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php foreach ($negocios as $negocio): ?>
                            <?php include ROOT_PATH . 'views/components/card_negocio.php'; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
