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
        <img src="<?= BASE_URL . $n['imagen_portada'] ?>" alt="<?= htmlspecialchars($n['nombre']) ?>">
    <?php else: ?>
        <div style="width:100%;height:100%;background:<?= $catColor ?>;display:flex;align-items:center;justify-content:center;">
            <i class="<?= $n['categoria_icono'] ?? 'fas fa-store' ?>" style="font-size:5rem;color:rgba(255,255,255,0.2)"></i>
        </div>
    <?php endif; ?>
    <div class="overlay"></div>
    <div class="header-content">
        <div class="d-flex align-items-end gap-3">
            <?php if (!empty($n['logo'])): ?>
                <img src="<?= BASE_URL . $n['logo'] ?>" alt="" class="ficha-logo">
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
                <span class="text-muted" style="font-size:0.85rem;">
                    <i class="fas fa-heart me-1"></i> <?= $totalFavoritos ?> favoritos
                </span>
                
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=negocio/favorito" class="d-inline">
                        <input type="hidden" name="negocio_id" value="<?= $n['id'] ?>">
                        <button type="submit" class="btn btn-sm <?= $esFavorito ? 'btn-danger' : 'btn-outline-secondary' ?>" style="border-radius:var(--radius-full);">
                            <i class="fas fa-heart"></i> <?= $esFavorito ? 'Guardado' : 'Guardar' ?>
                        </button>
                    </form>
                <?php endif; ?>
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
                            <div class="p-3 rounded-4 h-100 d-flex flex-column justify-content-between" style="background:var(--bg-card-light); border:1px solid var(--border-color);">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <h6 class="fw-bold text-white mb-0"><?= htmlspecialchars($prod['nombre']) ?></h6>
                                        <span class="badge bg-warning text-dark fw-bold">$<?= number_format($prod['precio'], 0, ',', '.') ?></span>
                                    </div>
                                    <p class="text-secondary mb-3" style="font-size:0.8rem; line-height:1.5;">
                                        <?= htmlspecialchars($prod['descripcion']) ?>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top gap-2" style="border-color:var(--border-color)!important;">
                                    <small class="text-muted" style="font-size:0.7rem;">Por <?= htmlspecialchars($prod['unidad_medida']) ?></small>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1" onclick="addToCart(<?= $prod['id'] ?>, '<?= addslashes($prod['nombre']) ?>', <?= $prod['precio'] ?>, <?= $n['id'] ?>, '<?= addslashes($n['nombre']) ?>')" style="font-size:0.75rem; border-radius:8px;">
                                            <i class="fas fa-cart-plus"></i> Carrito
                                        </button>
                                        <a href="<?= isset($_SESSION['usuario_id']) ? BASE_URL . 'index.php?url=chat/conversacion/' . $n['id'] : BASE_URL . 'index.php?url=autenticacion/login' ?>" class="btn btn-sm btn-warning text-dark fw-bold d-flex align-items-center gap-1" style="background: var(--color-primary); color: white !important; border: none; font-size:0.75rem; border-radius:8px;">
                                            <i class="fas fa-comment-dots"></i> Chat
                                        </a>
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
                            <img src="<?= BASE_URL . $img['url_imagen'] ?>" alt="<?= htmlspecialchars($img['descripcion'] ?? '') ?>" loading="lazy">
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

                <?php if (!empty($n['whatsapp'])): ?>
                <div class="info-row">
                    <i class="fab fa-whatsapp info-icon" style="color:#25d366;"></i>
                    <div>
                        <strong>WhatsApp</strong><br>
                        <a href="https://wa.me/57<?= preg_replace('/[^0-9]/', '', $n['whatsapp']) ?>" target="_blank" style="color:#25d366;">
                            Enviar mensaje <i class="fas fa-external-link-alt" style="font-size:0.7rem;"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

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
