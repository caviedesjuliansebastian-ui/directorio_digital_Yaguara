<!-- ============================================================
     REGISTRO — Directorio Digital Yaguará (Servi-Go 2-Column Card)
     ============================================================ -->
<div class="auth-container" style="min-height: calc(100vh - 200px); display: flex; align-items: center; justify-content: center; padding: 2.5rem 1rem;">
    <div class="card border-0 shadow-lg overflow-hidden" style="max-width: 960px; width: 100%; background: #141414; border: 1px solid #282828 !important; border-radius: 24px;">
        <div class="row g-0">
            
            <!-- Left Column: Info / Branding -->
            <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-between p-4 p-xl-5 position-relative" style="background: radial-gradient(circle at top left, #2a1508 0%, #141414 100%); border-right: 1px solid #282828;">
                <div>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="brand-box" style="width: 42px; height: 42px; font-size: 1.2rem;">SG</div>
                        <div>
                            <h5 class="fw-bold text-white mb-0" style="line-height: 1.1;">Servi-Go</h5>
                            <small class="text-warning fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">YAGUARÁ • HUILA</small>
                        </div>
                    </div>
                    
                    <h3 class="fw-bold text-white mb-3" style="font-size: 1.6rem; line-height: 1.25;">
                        Únete a la <span style="color: var(--color-primary);">red comercial</span> más grande de Yaguará
                    </h3>
                    <p class="text-secondary" style="font-size: 0.875rem; line-height: 1.6;">
                        Registra tu negocio, publica tus productos o simplemente guarda y califica tus servicios locales favoritos.
                    </p>
                </div>

                <div class="d-flex flex-column gap-3 my-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 96, 0, 0.15); color: #ff6000; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <span class="text-light" style="font-size: 0.85rem;">Alta de negocio rápida y sencilla</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 96, 0, 0.15); color: #ff6000; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span class="text-light" style="font-size: 0.85rem;">Solicita insignia de Verificado</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 96, 0, 0.15); color: #ff6000; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <span class="text-light" style="font-size: 0.85rem;">Catálogo de productos y cotizaciones</span>
                    </div>
                </div>

                <div class="pt-3 border-top" style="border-color: #262626 !important;">
                    <small class="text-muted" style="font-size: 0.75rem;">© 2026 Directorio Digital Yaguará</small>
                </div>
            </div>

            <!-- Right Column: Register Form -->
            <div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                
                <div class="mb-4">
                    <h3 class="fw-bold text-white mb-1" style="font-size: 1.6rem;">Crear Cuenta</h3>
                    <p class="text-secondary mb-0" style="font-size: 0.9rem;">Diligencia los campos para unirte</p>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 mb-4 d-flex align-items-center gap-2" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border-radius: 12px; font-size: 0.875rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        <div><?= $_SESSION['error'] ?></div>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>index.php?url=autenticacion/procesarRegistro">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre Completo *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Juan Pérez">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="celular" class="form-label">Teléfono / Celular</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control" id="celular" name="celular" placeholder="310 123 4567">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo" required placeholder="tu@correo.com" autocomplete="email">
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="contrasena" class="form-label">Contraseña *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required placeholder="Mín. 6 chars" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="contrasena_confirmar" class="form-label">Confirmar *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="contrasena_confirmar" name="contrasena_confirmar" required placeholder="Repite contraseña" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="terminos" required style="background-color: #1a1a1a; border-color: #333333;" checked>
                        <label class="form-check-label text-secondary" for="terminos" style="font-size: 0.825rem;">
                            Acepto los <a href="#" class="text-warning text-decoration-none">Términos</a> y la <a href="#" class="text-warning text-decoration-none">Privacidad</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-auth mb-4">
                        <span>Registrarme gratis</span>
                        <i class="fas fa-user-plus"></i>
                    </button>
                </form>

                <div class="text-center text-secondary pt-3 border-top" style="border-color: #222222 !important; font-size: 0.9rem;">
                    ¿Ya tienes una cuenta? <a href="<?= BASE_URL ?>index.php?url=autenticacion/login" class="text-white fw-bold text-decoration-none border-bottom border-warning pb-1 ms-1">Inicia Sesión</a>
                </div>
                
            </div>

        </div>
    </div>
</div>
