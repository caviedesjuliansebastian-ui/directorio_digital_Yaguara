<!-- ============================================================
     CREAR NEGOCIO — Directorio Digital Yaguará
     ============================================================ -->
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb" style="font-size:0.85rem;">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?url=negocio/listado">Negocios</a></li>
                        <li class="breadcrumb-item active">Registrar Negocio</li>
                    </ol>
                </nav>

                <div class="ficha-info-card">
                    <h2 style="font-family:var(--font-display);margin-bottom:0.5rem;">
                        <i class="fas fa-plus-circle me-2" style="color:var(--color-primary)"></i>
                        Registrar Negocio
                    </h2>
                    <p class="text-muted mb-4" style="font-size:0.9rem;">Completa la información de tu negocio. Será revisado antes de publicarse.</p>

                    <form method="POST" action="<?= BASE_URL ?>index.php?url=negocio/guardar" enctype="multipart/form-data" class="form-premium">
                        
                        <!-- Información básica -->
                        <h6 class="text-gradient mb-3"><i class="fas fa-info-circle me-1"></i> Información Básica</h6>
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Negocio *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Restaurante El Embalse">
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe tu negocio, productos y servicios..."></textarea>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label">Categoría</label>
                                <select class="form-select" id="categoria_id" name="categoria_id">
                                    <option value="">Seleccionar categoría</option>
                                    <?php foreach (($categorias ?? []) as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="sector_id" class="form-label">Sector / Barrio</label>
                                <select class="form-select" id="sector_id" name="sector_id">
                                    <option value="">Seleccionar sector</option>
                                    <?php foreach (($sectores ?? []) as $sec): ?>
                                        <option value="<?= $sec['id'] ?>"><?= htmlspecialchars($sec['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Contacto -->
                        <h6 class="text-gradient mb-3 mt-4"><i class="fas fa-phone me-1"></i> Contacto</h6>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej: Calle 4 # 5-23, Centro">
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label for="telefono" class="form-label">Teléfono de Contacto</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="3001234567">
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="negocio@correo.com">
                            </div>
                            <div class="col-md-6">
                                <label for="sitio_web" class="form-label">Sitio Web</label>
                                <input type="url" class="form-control" id="sitio_web" name="sitio_web" placeholder="https://...">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="text" class="form-control" id="facebook" name="facebook" placeholder="URL de Facebook">
                            </div>
                            <div class="col-md-6">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="text" class="form-control" id="instagram" name="instagram" placeholder="@tu_negocio">
                            </div>
                        </div>

                        <!-- Imágenes -->
                        <h6 class="text-gradient mb-3 mt-4"><i class="fas fa-camera me-1"></i> Imágenes</h6>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                <small class="text-muted">Máx. 5MB (JPG, PNG, WebP)</small>
                            </div>
                            <div class="col-md-6">
                                <label for="imagen_portada" class="form-label">Imagen de Portada</label>
                                <input type="file" class="form-control" id="imagen_portada" name="imagen_portada" accept="image/*">
                                <small class="text-muted">Recomendado: 1200x400px</small>
                            </div>
                        </div>

                        <!-- Ubicación en mapa -->
                        <h6 class="text-gradient mb-3 mt-4"><i class="fas fa-map-marker-alt me-1"></i> Ubicación (opcional)</h6>
                        <p class="text-muted" style="font-size:0.85rem;">Haz clic en el mapa para marcar la ubicación de tu negocio.</p>
                        
                        <div id="mapa-crear" style="height:300px;border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--border-color);margin-bottom:1rem;"></div>
                        <input type="hidden" name="latitud" id="latitud">
                        <input type="hidden" name="longitud" id="longitud">

                        <!-- Horarios -->
                        <h6 class="text-gradient mb-3 mt-4"><i class="fas fa-clock me-1"></i> Horarios de Atención</h6>
                        
                        <?php
                        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                        foreach ($dias as $i => $dia):
                        ?>
                        <div class="row g-2 mb-2 align-items-center">
                            <div class="col-3">
                                <label class="form-check-label" style="font-size:0.85rem;font-weight:600;"><?= $dia ?></label>
                            </div>
                            <div class="col-3">
                                <input type="time" class="form-control form-control-sm" name="horarios[<?= $i ?>][hora_apertura]" value="<?= $i > 0 && $i < 6 ? '08:00' : '' ?>">
                            </div>
                            <div class="col-3">
                                <input type="time" class="form-control form-control-sm" name="horarios[<?= $i ?>][hora_cierre]" value="<?= $i > 0 && $i < 6 ? '18:00' : '' ?>">
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="horarios[<?= $i ?>][cerrado]" value="1" <?= $i === 0 ? 'checked' : '' ?>>
                                    <label class="form-check-label" style="font-size:0.8rem;">Cerrado</label>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <hr class="my-4">
                        
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn-primary-custom flex-fill justify-content-center">
                                <i class="fas fa-paper-plane"></i> Enviar para Revisión
                            </button>
                            <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn-outline-custom">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof L !== 'undefined' && document.getElementById('mapa-crear')) {
        var map = L.map('mapa-crear').setView([<?= YAGUARA_LAT ?>, <?= YAGUARA_LNG ?>], <?= YAGUARA_ZOOM ?>);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        
        var marker = null;
        map.on('click', function(e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitud').value = e.latlng.lat.toFixed(8);
            document.getElementById('longitud').value = e.latlng.lng.toFixed(8);
        });
    }
});
</script>
