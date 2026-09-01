<!-- ============================================================
     HOME (SERVI-GO THEME)
     ============================================================ -->

<div class="container pb-5">
    
    <!-- Header Block (Servi-Go Home UI) -->
    <div class="hero-box">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <div>
                <h1 class="h3 fw-bold text-white mb-1">Servicios y Comercios Locales en Yaguará</h1>
                <p class="text-secondary mb-0" style="font-size:0.9rem;">15 prestadores verificados listos para cotizar y atender en tu zona.</p>
            </div>
            <a href="<?= BASE_URL ?>index.php?url=negocio/crear" class="btn-orange text-decoration-none">
                <i class="fas fa-plus-circle"></i> Registrar mi Negocio
            </a>
        </div>

        <!-- Pills Scrollable (Categorías Dinámicas con Enlaces) -->
        <div class="d-flex align-items-center mb-4 pb-2" style="overflow-x:auto; white-space:nowrap; -ms-overflow-style:none; scrollbar-width:none; gap:0.75rem;">
            <!-- Hide scrollbar for Chrome, Safari and Opera -->
            <style>.d-flex::-webkit-scrollbar { display: none; }</style>
            
            <a href="<?= BASE_URL ?>" class="pill text-decoration-none <?= empty($_GET['categoria']) ? 'active' : '' ?>">Todos los Rubros</a>
            <?php foreach ($categorias as $cat): ?>
                <a href="<?= BASE_URL ?>index.php?url=negocio/listado&categoria=<?= $cat['id'] ?>" class="pill text-decoration-none text-secondary">
                    <i class="<?= $cat['icono'] ?? 'fas fa-tag' ?>"></i> <?= htmlspecialchars($cat['nombre']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid var(--border-color);">
            <div class="d-flex gap-2">
                <div class="pill bg-dark text-white border-0" style="padding:0.25rem 0.75rem; font-size:0.75rem;">Todos</div>
                <div class="pill bg-transparent text-secondary border-0" style="padding:0.25rem 0.75rem; font-size:0.75rem;"><i class="fas fa-bolt" style="color:var(--color-primary)"></i> Servicios</div>
                <div class="pill bg-transparent text-secondary border-0" style="padding:0.25rem 0.75rem; font-size:0.75rem;"><i class="fas fa-shopping-basket text-secondary"></i> Comercios</div>
                <a href="<?= BASE_URL ?>index.php?url=negocio/listado&verificados=true" class="pill bg-transparent text-secondary border-0 text-decoration-none" style="padding:0.25rem 0.75rem; font-size:0.75rem;"><i class="fas fa-shield-alt text-warning"></i> Solo Verificados</a>
            </div>
            <a href="#mapa-section" class="btn btn-sm btn-outline-warning text-warning d-flex align-items-center gap-2" style="border-radius: var(--radius-full); font-weight: 600;">
                <i class="fas fa-map"></i> Ver Mapa Interactivo
            </a>
        </div>
    </div>

    <!-- Directorio Grid -->
    <?php if (empty($negocios)): ?>
        <div class="text-center py-5">
            <h4 class="text-secondary">Aún no hay negocios registrados</h4>
            <p class="text-muted">Sé el primero en agregar tu comercio a Servi-Go Yaguará.</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5">
            <?php foreach ($negocios as $negocio): ?>
                <?php include ROOT_PATH . 'views/components/card_negocio.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Mapa Interactivo Section -->
    <div id="mapa-section" class="hero-box mt-5 p-0 overflow-hidden" style="position:relative; height:450px;">
        <div style="position:absolute; top:1rem; left:1rem; z-index:400; background:var(--bg-navbar); padding:0.75rem 1rem; border-radius:var(--radius-lg); border:1px solid var(--border-color);">
            <h5 class="m-0 text-white fw-bold"><i class="fas fa-map-marked-alt text-warning me-2"></i>Explora por Ubicación</h5>
            <small class="text-secondary">Encuentra prestadores cerca a tu barrio</small>
        </div>
        <div id="mapa-negocios" style="height:100%; width:100%; z-index:1; filter: invert(90%) hue-rotate(180deg) brightness(85%) contrast(85%);"></div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="<?= BASE_URL ?>public/assets/js/maps.js"></script>
