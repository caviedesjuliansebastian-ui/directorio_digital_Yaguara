<!-- ============================================================
     FICHA DE NEGOCIO — Directorio Digital Yaguará
     ============================================================ -->
<?php
$n = $negocio;
$cal = $calificacion;
$catColor = $n['categoria_color'] ?? '#059669';
$diaHoy = (int)date('w');
?>

<!-- Header con imagen -->
<div class="ficha-header">
    <?php if (!empty($n['imagen_portada'])): ?>
        <img src="<?= (str_starts_with($n['imagen_portada'], 'http') ? '' : BASE_URL) . $n['imagen_portada'] ?>" alt="<?= htmlspecialchars($n['nombre']) ?>">
    <?php else: ?>
        <div style="width:100%;height:100%;background:<?= $catColor ?>;display:flex;align-items:center;justify-content:center;">
            <i class="<?= $n['categoria_icono'] ?? 'fas fa-store' ?>" style="font-size:5rem;color:rgba(255,255,255,0.2)"></i>
        </div>
    <?php endif; ?>
    <div class="overlay"></div>
    <div class="header-content">
        <div class="d-flex align-items-end gap-3">
            <?php if (!empty($n['logo'])): ?>
                <img src="<?= (str_starts_with($n['logo'], 'http') ? '' : BASE_URL) . $n['logo'] ?>" alt="" class="ficha-logo">
            <?php endif; ?>
            <div>
                <span class="badge mb-2" style="background:<?= $catColor ?>;font-size:0.75rem;">
                    <i class="<?= $n['categoria_icono'] ?? '' ?> me-1"></i><?= htmlspecialchars($n['categoria_nombre'] ?? '') ?>
                </span>
                <h1 style="font-size:1.75rem;margin:0;color:white;font-family:var(--font-display);">
                    <?= htmlspecialchars($n['nombre']) ?>
                    <?php if ($n['verificado']): ?>
                        <i class="fas fa-check-circle" style="color:var(--color-primary-light);font-size:1.2rem;" title="Verificado"></i>
                    <?php endif; ?>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="font-size:0.85rem;">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?url=negocio/listado">Negocios</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($n['nombre']) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Columna principal -->
        <div class="col-lg-8">
            <!-- Estado + Acciones -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <?php if ($estaAbierto): ?>
                    <span class="badge-open"><i class="fas fa-door-open me-1"></i> Abierto ahora</span>
                <?php else: ?>
                    <span class="badge-closed"><i class="fas fa-door-closed me-1"></i> Cerrado</span>
                <?php endif; ?>
                
                <span class="text-muted" style="font-size:0.85rem;">
                    <i class="fas fa-eye me-1"></i> <?= number_format($n['visitas']) ?> visitas
                </span>
                <span class="text-muted" style="font-size:0.85rem;" id="ficha-favoritos-counter">
                    <i class="fas fa-heart me-1 text-danger"></i> <?= $totalFavoritos ?> favoritos
                </span>
                
                <button type="button" id="btn-favorito-ficha" class="btn btn-sm <?= $esFavorito ? 'btn-danger' : 'btn-outline-secondary' ?>" onclick="toggleFavorito(<?= $n['id'] ?>, this, event)" style="border-radius:var(--radius-full);">
                    <i class="<?= $esFavorito ? 'fas' : 'far' ?> fa-heart"></i> <?= $esFavorito ? 'Guardado' : 'Guardar en Favoritos' ?>
                </button>
            </div>

            <!-- Descripción -->
            <div class="ficha-info-card mb-4">
                <h5 style="font-family:var(--font-display);margin-bottom:1rem;">Acerca de</h5>
                <p style="font-size:0.95rem;color:var(--text-secondary);line-height:1.8;">
                    <?= nl2br(htmlspecialchars($n['descripcion'] ?? 'Sin descripción.')) ?>
                </p>
            </div>

            <!-- Catálogo de Productos y Servicios (US-08 / E-commerce) -->
            <?php if (!empty($productos)): ?>
            <div class="ficha-info-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 style="font-family:var(--font-display); margin:0;"><i class="fas fa-shopping-bag me-2 text-warning"></i>Catálogo & Menú</h5>
                    <span class="badge bg-dark border border-secondary text-warning" style="font-size:0.75rem;"><?= count($productos) ?> Disponibles</span>
                </div>
                
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <?php foreach ($productos as $prod): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background:var(--bg-card-light); border:1px solid var(--border-color) !important;">
                                <div class="row g-0 h-100">
                                    <div class="col-4 position-relative" style="min-height: 140px; background: #171717;">
                                        <?php if (!empty($prod['foto'])): ?>
                                            <img src="<?= (str_starts_with($prod['foto'], 'http') ? '' : BASE_URL) . $prod['foto'] ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80'">
                                        <?php else: ?>
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary">
                                                <i class="fas fa-utensils fa-2x opacity-50"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-8">
                                        <div class="p-3 d-flex flex-column justify-content-between h-100">
                                            <div>
                                                <div class="d-flex justify-content-between align-items-start gap-1 mb-1">
                                                    <h6 class="fw-bold text-white mb-0 text-truncate" style="font-size: 0.95rem; line-height: 1.3;" title="<?= htmlspecialchars($prod['nombre']) ?>"><?= htmlspecialchars($prod['nombre']) ?></h6>
                                                </div>
                                                <div class="mb-2">
                                                    <span class="fw-bold" style="color: #ffb703; font-size: 0.95rem;">
                                                        $<?= number_format($prod['precio'], 0, ',', '.') ?> COP
                                                    </span>
                                                    <small class="text-secondary fw-normal">/ <?= htmlspecialchars($prod['unidad_medida'] ?? 'Unidad') ?></small>
                                                </div>
                                                <p class="text-secondary mb-3" style="font-size:0.78rem; line-height:1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="<?= htmlspecialchars($prod['descripcion']) ?>">
                                                    <?= htmlspecialchars($prod['descripcion']) ?>
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between pt-2 border-top gap-2" style="border-color:var(--border-color)!important;">
                                                <!-- Selector de Cantidad - 1 + -->
                                                <div class="d-flex align-items-center bg-dark rounded-pill border border-secondary px-1" style="height: 32px;">
                                                    <button type="button" class="btn btn-sm text-secondary px-2 py-0 border-0" onclick="const input = document.getElementById('qty-prod-<?= $prod['id'] ?>'); if(parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;">-</button>
                                                    <input type="text" id="qty-prod-<?= $prod['id'] ?>" value="1" readonly class="bg-transparent text-white text-center fw-bold border-0 p-0" style="width: 24px; font-size: 0.8rem;">
                                                    <button type="button" class="btn btn-sm text-secondary px-2 py-0 border-0" onclick="const input = document.getElementById('qty-prod-<?= $prod['id'] ?>'); input.value = parseInt(input.value) + 1;">+</button>
                                                </div>

                                                <!-- Botones de Acción -->
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-sm btn-warning text-white fw-bold d-flex align-items-center gap-1" onclick="addToCart(<?= $prod['id'] ?>, '<?= addslashes($prod['nombre']) ?>', <?= $prod['precio'] ?>, <?= $n['id'] ?>, '<?= addslashes($n['nombre']) ?>', document.getElementById('qty-prod-<?= $prod['id'] ?>').value)" style="background: var(--color-primary); border: none; font-size:0.75rem; border-radius:8px; padding: 0.35rem 0.65rem;">
                                                        <i class="fas fa-plus"></i> Añadir al Pedido
                                                    </button>
                                                    <a href="<?= isset($_SESSION['usuario_id']) ? BASE_URL . 'index.php?url=chat/conversacion/' . $n['id'] : BASE_URL . 'index.php?url=autenticacion/login' ?>" class="btn btn-sm btn-dark text-secondary d-flex align-items-center justify-content-center" title="Chat directo" style="border-radius:8px; width: 32px; height: 32px; padding: 0;">
                                                        <i class="fas fa-comment-dots"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Galería -->
            <?php if (!empty($imagenes)): ?>
            <div class="ficha-info-card mb-4">
                <h5 style="font-family:var(--font-display);margin-bottom:1rem;"><i class="fas fa-images me-2"></i>Galería</h5>
                <div class="gallery-grid">
                    <?php foreach ($imagenes as $img): ?>
                        <div class="gallery-item">
                            <img src="<?= (str_starts_with($img['url_imagen'], 'http') ? '' : BASE_URL) . $img['url_imagen'] ?>" alt="<?= htmlspecialchars($img['descripcion'] ?? '') ?>" loading="lazy">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Reseñas -->
            <div class="ficha-info-card mb-4">
                <h5 style="font-family:var(--font-display);margin-bottom:1rem;"><i class="fas fa-star me-2" style="color:var(--color-accent)"></i>Reseñas</h5>
                
                <!-- Resumen -->
                <?php if ($cal['total'] > 0): ?>
                <div class="rating-summary">
                    <div class="rating-big">
                        <div class="number"><?= $cal['promedio'] ?></div>
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star<?= $i <= round($cal['promedio']) ? '' : '-half-alt' ?>" style="font-size:0.9rem;"></i>
                            <?php endfor; ?>
                        </div>
                        <div class="total"><?= $cal['total'] ?> reseñas</div>
                    </div>
                    <div class="rating-bars">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <?php $pct = $cal['total'] > 0 ? (($distribucion[$i] ?? 0) / $cal['total']) * 100 : 0; ?>
                            <div class="rating-bar-row">
                                <span class="label"><?= $i ?></span>
                                <div class="bar"><div class="fill" style="width:<?= $pct ?>%"></div></div>
                                <span class="count"><?= $distribucion[$i] ?? 0 ?></span>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Lista de reseñas -->
                <?php foreach (($resenas ?? []) as $r): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-avatar"><?= strtoupper(mb_substr($r['usuario_nombre'], 0, 1)) ?></div>
                            <div>
                                <strong style="font-size:0.9rem;"><?= htmlspecialchars($r['usuario_nombre']) ?></strong>
                                <div class="review-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star" style="color:<?= $i <= $r['calificacion'] ? 'var(--color-accent)' : '#e2e8f0' ?>;font-size:0.75rem;"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="review-text"><?= htmlspecialchars($r['comentario']) ?></p>
                        <div class="review-date"><i class="fas fa-clock me-1"></i><?= date('d M Y', strtotime($r['fecha_creacion'])) ?></div>
                    </div>
                <?php endforeach; ?>

                <!-- Formulario nueva reseña -->
                <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="mt-3 p-3" style="background:var(--bg-card-hover);border-radius:var(--radius-md);">
                    <h6>Dejar una reseña</h6>
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=negocio/resena">
                        <input type="hidden" name="negocio_id" value="<?= $n['id'] ?>">
                        <div class="mb-2">
                            <label class="form-label" style="font-size:0.85rem;">Calificación</label>
                            <select name="calificacion" class="form-select form-select-sm" style="width:auto;" required>
                                <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
                                <option value="4">⭐⭐⭐⭐ Bueno</option>
                                <option value="3">⭐⭐⭐ Regular</option>
                                <option value="2">⭐⭐ Malo</option>
                                <option value="1">⭐ Pésimo</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea name="comentario" class="form-control form-control-sm" rows="2" placeholder="Escribe tu experiencia..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary-custom btn-sm">
                            <i class="fas fa-paper-plane"></i> Publicar
                        </button>
                    </form>
                </div>
                <?php else: ?>
                <p class="text-muted mt-3" style="font-size:0.85rem;">
                    <a href="<?= BASE_URL ?>index.php?url=autenticacion/login">Inicia sesión</a> para dejar una reseña.
                </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Info de contacto -->
            <div class="ficha-info-card mb-4">
                <h5 style="font-family:var(--font-display);margin-bottom:1rem;"><i class="fas fa-info-circle me-2"></i>Información</h5>
                
                <?php if (!empty($n['direccion'])): ?>
                <div class="info-row">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <div>
                        <strong>Dirección</strong><br>
                        <span style="color:var(--text-secondary)"><?= htmlspecialchars($n['direccion']) ?></span>
                        <?php if (!empty($n['sector_nombre'])): ?>
                            <br><small class="text-muted"><?= htmlspecialchars($n['sector_nombre']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($n['telefono'])): ?>
                <div class="info-row">
                    <i class="fas fa-phone info-icon"></i>
                    <div>
                        <strong>Teléfono</strong><br>
                        <a href="tel:<?= $n['telefono'] ?>"><?= htmlspecialchars($n['telefono']) ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <div class="info-row">
                    <i class="fas fa-comment-dots info-icon" style="color:var(--color-primary);"></i>
                    <div>
                        <strong>Chat Directo en la App</strong><br>
                        <a href="<?= isset($_SESSION['usuario_id']) ? BASE_URL . 'index.php?url=chat/conversacion/' . $n['id'] : BASE_URL . 'index.php?url=autenticacion/login' ?>" style="color:var(--color-primary); font-weight:600;">
                            <i class="fas fa-paper-plane me-1"></i> Hablar con el Proveedor
                        </a>
                    </div>
                </div>

                <?php if (!empty($n['email'])): ?>
                <div class="info-row">
                    <i class="fas fa-envelope info-icon"></i>
                    <div>
                        <strong>Email</strong><br>
                        <a href="mailto:<?= $n['email'] ?>"><?= htmlspecialchars($n['email']) ?></a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($n['sitio_web'])): ?>
                <div class="info-row">
                    <i class="fas fa-globe info-icon"></i>
                    <div>
                        <strong>Sitio Web</strong><br>
                        <a href="<?= $n['sitio_web'] ?>" target="_blank"><?= htmlspecialchars($n['sitio_web']) ?></a>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Horarios -->
            <?php if (!empty($horarios)): ?>
            <div class="ficha-info-card mb-4">
                <h5 style="font-family:var(--font-display);margin-bottom:1rem;"><i class="fas fa-clock me-2"></i>Horarios</h5>
                <table class="schedule-table">
                    <?php foreach ($diasSemana as $num => $nombre): ?>
                        <?php $h = $horarios[$num] ?? null; ?>
                        <tr class="<?= ($num == $diaHoy) ? 'today' : '' ?>">
                            <td class="day"><?= $nombre ?></td>
                            <td class="hours">
                                <?php if ($h && !$h['cerrado']): ?>
                                    <?= substr($h['hora_apertura'], 0, 5) ?> - <?= substr($h['hora_cierre'], 0, 5) ?>
                                <?php elseif ($h && $h['cerrado']): ?>
                                    <span class="closed">Cerrado</span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>

            <!-- Mapa del negocio -->
            <?php if (!empty($n['latitud']) && !empty($n['longitud'])): ?>
            <div class="ficha-info-card mb-4">
                <h5 style="font-family:var(--font-display);margin-bottom:1rem;"><i class="fas fa-map me-2"></i>Ubicación</h5>
                <div id="mapa-negocio" style="height:250px;border-radius:var(--radius-md);overflow:hidden;"></div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof L !== 'undefined') {
                    var map = L.map('mapa-negocio').setView([<?= $n['latitud'] ?>, <?= $n['longitud'] ?>], 16);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(map);
                    L.marker([<?= $n['latitud'] ?>, <?= $n['longitud'] ?>])
                        .addTo(map)
                        .bindPopup('<strong><?= htmlspecialchars($n['nombre']) ?></strong><br><?= htmlspecialchars($n['direccion'] ?? '') ?>')
                        .openPopup();
                }
            });
            </script>
            <?php endif; ?>

            <!-- Reportar -->
            <?php if (isset($_SESSION['usuario_id'])): ?>
            <div class="text-center">
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#reportForm" style="font-size:0.8rem;">
                    <i class="fas fa-flag me-1"></i> Reportar este negocio
                </button>
                <div class="collapse mt-2" id="reportForm">
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=negocio/reportar" class="text-start">
                        <input type="hidden" name="negocio_id" value="<?= $n['id'] ?>">
                        <select name="motivo" class="form-select form-select-sm mb-2" required>
                            <option value="">Selecciona un motivo</option>
                            <option value="Información incorrecta">Información incorrecta</option>
                            <option value="Negocio cerrado">Negocio cerrado permanentemente</option>
                            <option value="Contenido inapropiado">Contenido inapropiado</option>
                            <option value="Spam">Spam / Publicidad engañosa</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <textarea name="descripcion" class="form-control form-control-sm mb-2" rows="2" placeholder="Descripción (opcional)"></textarea>
                        <button type="submit" class="btn btn-sm btn-danger w-100">Enviar Reporte</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
