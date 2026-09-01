<!-- ============================================================
     FAVORITOS GUARDADOS
     ============================================================ -->
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4" style="background:var(--bg-card);">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-4">
                        <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="list-group-item list-group-item-action p-3 text-warning fw-semibold" style="background:rgba(245, 158, 11, 0.08); border-color:var(--border-color);">
                            <i class="fas fa-th-large me-2"></i> Ver Comercios Y Servicios
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/perfil" class="list-group-item list-group-item-action p-3 text-secondary" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-user-circle me-2"></i> Mi Perfil
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/mis_negocios" class="list-group-item list-group-item-action p-3 text-secondary" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-store me-2"></i> Mis Negocios
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/favoritos" class="list-group-item list-group-item-action active p-3" style="background:var(--color-primary);border-color:var(--color-primary);color:white;">
                            <i class="fas fa-heart me-2"></i> Favoritos Guardados
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=autenticacion/logout" class="list-group-item list-group-item-action p-3 text-danger" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="col-lg-9">
            <h4 class="mb-4 text-gradient"><i class="fas fa-heart me-2"></i>Mis Favoritos</h4>

            <?php if (empty($negocios)): ?>
                <div class="empty-state bg-white rounded-4 shadow-sm border-0" style="background:var(--bg-card) !important;">
                    <div class="empty-icon"><i class="far fa-heart"></i></div>
                    <h4 class="text-white">Aún no tienes favoritos</h4>
                    <p class="text-secondary">Guarda los negocios que más te gusten para acceder a ellos rápidamente.</p>
                    <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn-primary-custom mt-2">Explorar Directorio</a>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    <?php foreach ($negocios as $negocio): ?>
                        <?php include ROOT_PATH . 'views/components/card_negocio.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
