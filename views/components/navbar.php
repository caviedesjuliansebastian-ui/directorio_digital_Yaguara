<nav class="navbar-servigo">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        
        <!-- Brand & Location -->
        <div class="d-flex align-items-center gap-4">
            <a href="<?= BASE_URL ?>" class="navbar-brand text-decoration-none">
                <div class="brand-box">SG</div>
                <div class="brand-text">
                    <span>Servi-Go</span>
                    <span>HUILA • YAGUARÁ & PUEBLOS</span>
                </div>
            </a>
            
            <button class="btn btn-dark-pill d-none d-lg-flex" style="border-color: #f97316; color: #f97316;" data-bs-toggle="modal" data-bs-target="#locationModal">
                <i class="fas fa-map-marker-alt"></i> Yaguará (Huila) <i class="fas fa-chevron-down ms-1" style="font-size:0.7rem;"></i>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="search-container d-none d-md-block">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="¿Qué buscas en Yaguará o Huila? (ej. quesillos, mojarra, motobomba)" id="navbar-search-input" autocomplete="off">
            <div id="navbar-search-results" class="search-results-dropdown" style="display:none; position:absolute; top:100%; left:0; right:0; background:var(--bg-card); border:1px solid var(--border-color); border-radius:12px; margin-top:0.5rem; z-index:1001; max-height:400px; overflow-y:auto;"></div>
        </div>

        <!-- Actions -->
        <div class="nav-actions">
            <a href="<?= isset($_SESSION['usuario_id']) ? BASE_URL . 'index.php?url=usuario/favoritos' : BASE_URL . 'index.php?url=autenticacion/login' ?>" class="icon-btn text-decoration-none" title="Mis Favoritos"><i class="far fa-heart"></i><span class="badge-count">5</span></a>
            <a href="<?= isset($_SESSION['usuario_id']) ? BASE_URL . 'index.php?url=chat/inbox' : BASE_URL . 'index.php?url=autenticacion/login' ?>" class="icon-btn text-decoration-none" title="Bandeja de Mensajes"><i class="far fa-comment-alt"></i><span class="badge-count yellow">1</span></a>
            
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <div class="dropdown">
                    <button class="btn-dark-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border-color:#333;">
                        <i class="far fa-user"></i> 
                        <?= $_SESSION['usuario_rol'] === 'administrador' ? 'Admin' : 'Cliente' ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="background:var(--bg-card); border:1px solid var(--border-color) !important; border-radius:12px;">
                        <li><span class="dropdown-item-text text-muted small pb-2 border-bottom" style="border-color:var(--border-color) !important;"><?= htmlspecialchars($_SESSION['usuario_correo'] ?? '') ?></span></li>
                        <li><a class="dropdown-item pt-2 text-white" href="<?= BASE_URL ?>index.php?url=usuario/perfil"><i class="fas fa-user-circle me-2 text-muted"></i> Mi Perfil</a></li>
                        <li><a class="dropdown-item text-white" href="<?= BASE_URL ?>index.php?url=chat/inbox"><i class="fas fa-comments me-2 text-warning"></i> Inbox de Mensajes</a></li>
                        <li><a class="dropdown-item text-white" href="<?= BASE_URL ?>index.php?url=usuario/favoritos"><i class="fas fa-heart me-2 text-danger"></i> Mis Favoritos</a></li>
                        <li><a class="dropdown-item text-white" href="<?= BASE_URL ?>index.php?url=usuario/mis_negocios"><i class="fas fa-store me-2 text-muted"></i> Panel de Negocios</a></li>
                        <?php if($_SESSION['usuario_rol'] === 'administrador'): ?>
                            <li><hr class="dropdown-divider" style="border-color:var(--border-color);"></li>
                            <li><a class="dropdown-item text-warning" href="<?= BASE_URL ?>index.php?url=admin/dashboard"><i class="fas fa-shield-alt me-2"></i> Panel Admin</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider" style="border-color:var(--border-color);"></li>
                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>index.php?url=autenticacion/logout"><i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= BASE_URL ?>index.php?url=autenticacion/login" class="btn-orange">
                    <i class="far fa-user"></i> Acceso / Ingreso
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Location Modal (UI mock for now) -->
<div class="modal fade" id="locationModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog">
        <div class="modal-content" style="background:var(--bg-navbar); border:1px solid var(--border-color); border-radius:var(--radius-lg);">
            <div class="modal-header border-0">
                <h5 class="modal-title d-flex align-items-center gap-2 text-white">
                    <div style="width:40px;height:40px;border-radius:50%;border:1px solid #f97316;display:flex;align-items:center;justify-content:center;color:#f97316;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div style="font-size:1.1rem;font-weight:700;">Seleccionar Pueblo o Municipio</div>
                        <div style="font-size:0.8rem;color:#f97316;">Departamento del Huila • Cobertura Local</div>
                    </div>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-warning w-100 mb-4" style="background:#f97316; border:none; color:white; font-weight:600; padding:0.75rem; border-radius:12px;">
                    <i class="fas fa-location-arrow me-2"></i> Usar mi ubicación GPS actual (Detectar Yaguará)
                </button>
                <div class="search-container mx-0 max-w-100 mb-4">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Buscar pueblo o barrio (ej. Yaguará, Neiva, Campoalegre, Rivera)...">
                </div>
                
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action mb-3" style="background:var(--bg-card); border:1px solid #f97316; border-radius:12px; padding:1rem;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:40px;height:40px;background:#ea580c;color:white;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-building"></i></div>
                                <div>
                                    <h6 class="mb-1 text-white fw-bold d-flex align-items-center gap-2">Yaguará <span class="badge bg-secondary" style="font-size:0.6rem;">Huila</span> <span class="badge bg-warning text-dark" style="font-size:0.6rem;"><i class="fas fa-star"></i> Principal</span></h6>
                                    <small class="text-muted">38 comercios y prestadores registrados</small>
                                </div>
                            </div>
                            <div style="width:24px;height:24px;background:#ea580c;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.7rem;"><i class="fas fa-check"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
