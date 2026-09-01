<!-- ============================================================
     LOGIN — Directorio Digital Yaguará (Servi-Go 2-Column Card)
     ============================================================ -->
<div class="auth-container" style="min-height: calc(100vh - 200px); display: flex; align-items: center; justify-content: center; padding: 2.5rem 1rem;">
    <div class="card border-0 shadow-lg overflow-hidden" style="max-width: 920px; width: 100%; background: #141414; border: 1px solid #282828 !important; border-radius: 24px;">
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
                        Impulsa y encuentra <span style="color: var(--color-primary);">negocios locales</span>
                    </h3>
                    <p class="text-secondary" style="font-size: 0.875rem; line-height: 1.6;">
                        Accede a tu panel para gestionar tus servicios, recibir cotizaciones y conectar con clientes en Yaguará.
                    </p>
                </div>

                <div class="d-flex flex-column gap-3 my-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 96, 0, 0.15); color: #ff6000; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="text-light" style="font-size: 0.85rem;">Directorio oficial georreferenciado</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 96, 0, 0.15); color: #ff6000; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="text-light" style="font-size: 0.85rem;">Cotizaciones y tratos directos</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(255, 96, 0, 0.15); color: #ff6000; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="text-light" style="font-size: 0.85rem;">Comercios verificados con sello</span>
                    </div>
                </div>

                <div class="pt-3 border-top" style="border-color: #262626 !important;">
                    <small class="text-muted" style="font-size: 0.75rem;">© 2026 Directorio Digital Yaguará</small>
                </div>
            </div>

            <!-- Right Column: Login Form -->
            <div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                
                <div class="mb-4">
                    <h3 class="fw-bold text-white mb-1" style="font-size: 1.6rem;">Iniciar Sesión</h3>
                    <p class="text-secondary mb-0" style="font-size: 0.9rem;">Ingresa tus credenciales para acceder</p>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 mb-4 d-flex align-items-center gap-2" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border-radius: 12px; font-size: 0.875rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        <div><?= $_SESSION['error'] ?></div>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['mensaje'])): ?>
                    <div class="alert alert-success border-0 mb-4 d-flex align-items-center gap-2" style="background: rgba(16, 185, 129, 0.12); color: #34d399; border-radius: 12px; font-size: 0.875rem;">
                        <i class="fas fa-check-circle"></i>
                        <div><?= $_SESSION['mensaje'] ?></div>
                    </div>
                    <?php unset($_SESSION['mensaje']); ?>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>index.php?url=autenticacion/procesarLogin">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo" required placeholder="tu@correo.com" autocomplete="email">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="contrasena" class="form-label mb-0">Contraseña</label>
                            <a href="#" class="text-warning text-decoration-none" style="font-size: 0.8rem;">¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required placeholder="••••••••" autocomplete="current-password">
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="recordarme" style="background-color: #1a1a1a; border-color: #333333;">
                        <label class="form-check-label text-secondary" for="recordarme" style="font-size: 0.85rem;">Mantener sesión iniciada</label>
                    </div>
                    
                    <button type="submit" class="btn-auth mb-4">
                        <span>Ingresar a mi cuenta</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="text-center text-secondary pt-3 border-top" style="border-color: #222222 !important; font-size: 0.9rem;">
                    ¿No tienes una cuenta? <a href="<?= BASE_URL ?>index.php?url=autenticacion/registro" class="text-white fw-bold text-decoration-none border-bottom border-warning pb-1 ms-1">Regístrate gratis</a>
                </div>
                
            </div>

        </div>
    </div>
</div>
