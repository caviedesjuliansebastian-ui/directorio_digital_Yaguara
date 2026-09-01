<!-- ============================================================
     PERFIL DE USUARIO
     ============================================================ -->
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Menú Usuario -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4" style="background:var(--bg-card);">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-4">
                        <a href="<?= BASE_URL ?>index.php?url=usuario/perfil" class="list-group-item list-group-item-action active p-3" style="background:var(--color-primary);border-color:var(--color-primary);color:white;">
                            <i class="fas fa-user-circle me-2"></i> Mi Perfil
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/mis_negocios" class="list-group-item list-group-item-action p-3 text-secondary" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-store me-2"></i> Mis Negocios
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/favoritos" class="list-group-item list-group-item-action p-3 text-secondary" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-heart me-2"></i> Favoritos Guardados
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=autenticacion/logout" class="list-group-item list-group-item-action p-3 text-danger" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Perfil -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4" style="background:var(--bg-card); border: 1px solid var(--border-color) !important;">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-gradient"><i class="fas fa-user-edit me-2"></i>Datos Personales</h4>
                    
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=usuario/perfil" enctype="multipart/form-data" class="form-premium">
                        
                        <div class="d-flex align-items-center mb-4 gap-4">
                            <?php if (!empty($datos['foto_perfil'])): ?>
                                <img src="<?= BASE_URL . $datos['foto_perfil'] ?>" alt="Foto" style="width:100px;height:100px;object-fit:cover;border-radius:50%;box-shadow:var(--shadow-md);">
                            <?php else: ?>
                                <div style="width:100px;height:100px;border-radius:50%;background:var(--border-color);display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:var(--text-muted);">
                                    <i class="fas fa-camera"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div>
                                <label for="foto_perfil" class="form-label mb-1">Cambiar Foto de Perfil</label>
                                <input type="file" name="foto_perfil" id="foto_perfil" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($datos['nombre']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo Electrónico (No editable)</label>
                                <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($datos['correo']) ?>" readonly>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Celular</label>
                                <input type="text" name="celular" class="form-control" value="<?= htmlspecialchars($datos['celular'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nueva Contraseña (Dejar en blanco para no cambiar)</label>
                                <input type="password" name="nueva_contrasena" class="form-control" placeholder="••••••••">
                            </div>
                        </div>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fas fa-save me-1"></i> Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
