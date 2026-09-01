<?php
// Obtener productos destacados de este negocio
$prodModel = new Producto();
$prodsDestacados = $prodModel->getByNegocio($negocio['id']);

// Verificar si este negocio está en favoritos del usuario
global $favoritosIdsUsuario;
if (!isset($favoritosIdsUsuario) && isset($_SESSION['usuario_id'])) {
    $favModel = new Favorito();
    $favoritosIdsUsuario = $favModel->getIdsPorUsuario($_SESSION['usuario_id']);
}
$esFavCard = isset($_SESSION['usuario_id']) && in_array($negocio['id'], $favoritosIdsUsuario ?? []);
?>
<div class="col">
    <div class="servigo-card h-100">
        <!-- Header Image & Badges -->
        <div class="card-header-img position-relative overflow-hidden" style="height: 190px; background: #1a1a1a;">
            <?php if (!empty($negocio['imagen_portada'])): ?>
                <img src="<?= (str_starts_with($negocio['imagen_portada'], 'http') ? '' : BASE_URL) . $negocio['imagen_portada'] ?>" alt="<?= htmlspecialchars($negocio['nombre']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
            <?php elseif (!empty($negocio['logo'])): ?>
                <img src="<?= (str_starts_with($negocio['logo'], 'http') ? '' : BASE_URL) . $negocio['logo'] ?>" alt="<?= htmlspecialchars($negocio['nombre']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
                <div style="width:100%; height:100%; background: #262626; display:flex; align-items:center; justify-content:center; color: #666; font-size: 3rem;">
                    <i class="fas fa-store"></i>
                </div>
            <?php endif; ?>
            
            <!-- Badge Superior -->
            <div class="card-badge-top" style="position: absolute; top: 0.75rem; left: 0.75rem; background: #ff6000; color: white; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 9999px; display: flex; align-items: center; gap: 0.35rem; box-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                <i class="fas fa-store"></i> Comercio / Catálogo
            </div>
            
            <button type="button" class="card-fav-btn" data-negocio-id="<?= $negocio['id'] ?>" onclick="toggleFavorito(<?= $negocio['id'] ?>, this, event)" style="position: absolute; top: 0.75rem; right: 0.75rem; width: 34px; height: 34px; border-radius: 50%; background: <?= $esFavCard ? '#ef4444' : 'rgba(0,0,0,0.6)' ?>; color: white; display: flex; align-items: center; justify-content: center; border: none; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; backdrop-filter: blur(4px); z-index: 10;" title="<?= $esFavCard ? 'Quitar de favoritos' : 'Guardar en favoritos' ?>">
                <i class="<?= $esFavCard ? 'fas' : 'far' ?> fa-heart"></i>
            </button>
            
            <div class="card-distance" style="position: absolute; bottom: 0.75rem; right: 0.75rem; background: rgba(0,0,0,0.75); color: #e5e5e5; font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 6px; backdrop-filter: blur(4px); display: flex; align-items: center; gap: 0.35rem;">
                <i class="fas fa-map-marker-alt text-warning"></i> 0.8 km • <?= htmlspecialchars($negocio['sector_nombre'] ?? 'Centro') ?>
            </div>
        </div>

        <!-- Content -->
        <div class="card-content p-3 d-flex flex-column" style="flex-grow: 1; position: relative;">
            <!-- Owner Avatar / Logo -->
            <img src="<?= !empty($negocio['logo']) ? (str_starts_with($negocio['logo'], 'http') ? '' : BASE_URL) . $negocio['logo'] : BASE_URL . 'public/assets/img/default-avatar.png' ?>" alt="Propietario" class="avatar-overlap" style="position: absolute; top: -24px; left: 1rem; width: 48px; height: 48px; border-radius: 12px; border: 3px solid #171717; object-fit: cover; background: #262626; box-shadow: 0 4px 10px rgba(0,0,0,0.5);" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%23ff6000\'%3E%3Cpath d=\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\'/%3E%3C/svg%3E'">
            
            <div class="card-title-box mt-3 mb-2">
                <h4 class="card-title-text text-truncate text-white fw-bold mb-1" style="font-size: 1.05rem;" title="<?= htmlspecialchars($negocio['nombre']) ?>">
                    <?= htmlspecialchars($negocio['nombre']) ?>
                </h4>
                
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <?php if ($negocio['verificado']): ?>
                        <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); font-size: 0.65rem; font-weight: 700; padding: 0.15rem 0.45rem;">
                            <i class="fas fa-check-circle me-1"></i> Verificado
                        </span>
                    <?php endif; ?>
                    <span class="text-secondary" style="font-size: 0.75rem;">
                        <?= htmlspecialchars($negocio['categoria_nombre'] ?? 'Comercio') ?> • Yaguará
                    </span>
                </div>
            </div>

            <!-- Stats: Rating & Resp -->
            <div class="stats-row d-flex justify-content-between align-items-center py-2 mb-2 border-bottom border-top" style="border-color: #262626 !important; font-size: 0.75rem;">
                <div class="stat-rating text-white fw-semibold">
                    <i class="fas fa-star text-warning me-1"></i> <?= number_format($negocio['calificacion'] ?? 4.9, 1) ?> <span class="text-secondary">(<?= $negocio['total_resenas'] ?? 82 ?>)</span>
                </div>
                <div class="stat-response fw-semibold" style="color: #ff6000;">
                    <i class="fas fa-circle me-1" style="font-size: 0.45rem; vertical-align: middle;"></i> 99% resp. (~4 min)
                </div>
            </div>

            <!-- Description -->
            <p class="card-desc text-secondary mb-3" style="font-size: 0.8rem; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.35rem;">
                <?= htmlspecialchars($negocio['descripcion'] ?? 'Conoce nuestros productos y servicios en Yaguará.') ?>
            </p>

            <!-- Highlights / Products -->
            <div class="menu-highlights text-uppercase fw-bold mb-2" style="font-size: 0.68rem; color: #737373; letter-spacing: 0.5px;">
                DESTACADOS DEL MENÚ / CATÁLOGO:
            </div>
            
            <div class="d-flex flex-column gap-1 mb-3">
                <?php if (!empty($prodsDestacados)): ?>
                    <?php foreach (array_slice($prodsDestacados, 0, 2) as $prod): ?>
                        <div class="highlight-pill px-2 py-1 text-truncate d-flex justify-content-between align-items-center" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); font-size: 0.75rem; font-weight: 500; border-radius: 6px; cursor: pointer;" title="Clic para agregar al carrito" onclick="addToCart(<?= $prod['id'] ?>, '<?= addslashes($prod['nombre']) ?>', <?= $prod['precio'] ?>, <?= $negocio['id'] ?>, '<?= addslashes($negocio['nombre']) ?>')">
                            <span class="text-truncate"><?= htmlspecialchars($prod['nombre']) ?> $<?= number_format($prod['precio'], 0, ',', '.') ?></span>
                            <i class="fas fa-plus-circle ms-1 text-warning" style="font-size: 0.75rem;"></i>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="highlight-pill px-2 py-1 text-truncate" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); font-size: 0.75rem; font-weight: 500; border-radius: 6px;">
                        Atención directa y pedidos por catálogo
                    </div>
                <?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="card-actions mt-auto d-flex gap-2 pt-2">
                <a href="<?= BASE_URL ?>index.php?url=negocio/ficha/<?= $negocio['slug'] ?>" class="btn-card-gray flex-fill text-decoration-none d-flex align-items-center justify-content-center gap-1" style="background: #262626; color: white; padding: 0.6rem; border-radius: 10px; font-size: 0.85rem; font-weight: 600;">
                    Ver Menú <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
                
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="<?= BASE_URL ?>index.php?url=chat/conversacion/<?= $negocio['id'] ?>" class="btn-card-orange flex-fill text-decoration-none d-flex align-items-center justify-content-center gap-1" style="background: #ff5c00; color: white; padding: 0.6rem; border-radius: 10px; font-size: 0.85rem; font-weight: 600;">
                        <i class="far fa-comment-dots"></i> Iniciar Chat
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>index.php?url=autenticacion/login" class="btn-card-orange flex-fill text-decoration-none d-flex align-items-center justify-content-center gap-1" title="Inicia sesión para chatear y pedir" style="background: #ff5c00; color: white; padding: 0.6rem; border-radius: 10px; font-size: 0.85rem; font-weight: 600;">
                        <i class="far fa-comment-dots"></i> Iniciar Chat
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
