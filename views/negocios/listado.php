<!-- ============================================================
     LISTADO DE NEGOCIOS — Directorio Digital Yaguará
     ============================================================ -->
<section class="py-4">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="font-size:0.85rem;">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                <?php if (!empty($categoriaActual)): ?>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?url=negocio/listado">Negocios</a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($categoriaActual['nombre']) ?></li>
                <?php elseif (!empty($sectorActual)): ?>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?url=negocio/listado">Negocios</a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($sectorActual['nombre']) ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item active">Negocios</li>
                <?php endif; ?>
            </ol>
        </nav>

        <div class="row">
            <!-- Sidebar Filtros -->
            <div class="col-lg-3 mb-4">
                <div class="filter-sidebar">
                    <h5><i class="fas fa-filter me-2"></i>Filtros</h5>
                    
                    <!-- Búsqueda -->
                    <div class="filter-group">
                        <label>Buscar</label>
                        <form method="GET" action="<?= BASE_URL ?>index.php">
                            <input type="hidden" name="url" value="negocio/listado">
                            <div class="input-group input-group-sm">
                                <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($query ?? '') ?>" placeholder="Nombre, servicio...">
                                <button type="submit" class="btn btn-sm" style="background:var(--color-primary);color:white;"><i class="fas fa-search"></i></button>
                            </div>
                            <?php if ($categoriaId): ?><input type="hidden" name="categoria" value="<?= $categoriaId ?>"><?php endif; ?>
                            <?php if ($sectorId): ?><input type="hidden" name="sector" value="<?= $sectorId ?>"><?php endif; ?>
                        </form>
                    </div>
                    
                    <!-- Categorías -->
                    <div class="filter-group">
                        <label>Categorías</label>
                        <a href="<?= BASE_URL ?>index.php?url=negocio/listado<?= $sectorId ? '&sector='.$sectorId : '' ?>" 
                           class="filter-item <?= !$categoriaId ? 'active' : '' ?>">
                            <span><i class="fas fa-th-large me-2"></i>Todas</span>
                        </a>
                        <?php foreach (($categorias ?? []) as $cat): ?>
                            <a href="<?= BASE_URL ?>index.php?url=negocio/listado&categoria=<?= $cat['id'] ?><?= $sectorId ? '&sector='.$sectorId : '' ?>" 
                               class="filter-item <?= ($categoriaId == $cat['id']) ? 'active' : '' ?>">
                                <span><i class="<?= $cat['icono'] ?> me-2" style="color:<?= $cat['color'] ?? '' ?>"></i><?= htmlspecialchars($cat['nombre']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Sectores -->
                    <div class="filter-group">
                        <label>Sectores</label>
                        <a href="<?= BASE_URL ?>index.php?url=negocio/listado<?= $categoriaId ? '&categoria='.$categoriaId : '' ?>" 
                           class="filter-item <?= !$sectorId ? 'active' : '' ?>">
                            <span><i class="fas fa-map me-2"></i>Todos</span>
                        </a>
                        <?php foreach (($sectores ?? []) as $sec): ?>
                            <a href="<?= BASE_URL ?>index.php?url=negocio/listado&sector=<?= $sec['id'] ?><?= $categoriaId ? '&categoria='.$categoriaId : '' ?>" 
                               class="filter-item <?= ($sectorId == $sec['id']) ? 'active' : '' ?>">
                                <span><i class="fas fa-map-pin me-2"></i><?= htmlspecialchars($sec['nombre']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Grid de Negocios -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 style="font-family:var(--font-display);font-size:1.35rem;">
                        <?php if (!empty($categoriaActual)): ?>
                            <i class="<?= $categoriaActual['icono'] ?> me-2" style="color:<?= $categoriaActual['color'] ?>"></i>
                            <?= htmlspecialchars($categoriaActual['nombre']) ?>
                        <?php elseif (!empty($sectorActual)): ?>
                            <i class="fas fa-map-marker-alt me-2" style="color:var(--color-primary)"></i>
                            <?= htmlspecialchars($sectorActual['nombre']) ?>
                        <?php elseif (!empty($query)): ?>
                            Resultados para "<?= htmlspecialchars($query) ?>"
                        <?php else: ?>
                            Todos los Negocios
                        <?php endif; ?>
                    </h4>
                    <span class="text-muted" style="font-size:0.85rem;"><?= $total ?? 0 ?> resultados</span>
                </div>
                
                <?php if (empty($negocios)): ?>
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-search"></i></div>
                        <h4>No se encontraron negocios</h4>
                        <p>Intenta con otros filtros o términos de búsqueda.</p>
                        <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn-outline-custom mt-3">
                            <i class="fas fa-redo me-1"></i> Ver todos
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        <?php foreach ($negocios as $negocio): ?>
                            <?php include ROOT_PATH . 'views/components/card_negocio.php'; ?>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Paginación -->
                    <?php if (($totalPaginas ?? 0) > 1): ?>
                        <nav class="mt-4 d-flex justify-content-center">
                            <ul class="pagination pagination-custom">
                                <?php if ($pagina > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= BASE_URL ?>index.php?url=negocio/listado&pagina=<?= $pagina - 1 ?><?= $query ? '&q='.urlencode($query) : '' ?><?= $categoriaId ? '&categoria='.$categoriaId : '' ?><?= $sectorId ? '&sector='.$sectorId : '' ?>">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = max(1, $pagina - 2); $i <= min($totalPaginas, $pagina + 2); $i++): ?>
                                    <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>index.php?url=negocio/listado&pagina=<?= $i ?><?= $query ? '&q='.urlencode($query) : '' ?><?= $categoriaId ? '&categoria='.$categoriaId : '' ?><?= $sectorId ? '&sector='.$sectorId : '' ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($pagina < $totalPaginas): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= BASE_URL ?>index.php?url=negocio/listado&pagina=<?= $pagina + 1 ?><?= $query ? '&q='.urlencode($query) : '' ?><?= $categoriaId ? '&categoria='.$categoriaId : '' ?><?= $sectorId ? '&sector='.$sectorId : '' ?>">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
