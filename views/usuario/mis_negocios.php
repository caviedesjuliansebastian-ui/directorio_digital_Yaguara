<!-- ============================================================
     DASHBOARD DEL PROVEEDOR (SERVI-GO THEME)
     ============================================================ -->
<div class="container py-5">
    
    <!-- Provider Header Metrics (100% REALES DESDE BD) -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="p-3 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <small class="text-secondary d-block mb-1" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-store me-1 text-warning"></i> Comercios Registrados</small>
                <div class="h3 fw-bold text-white mb-0"><?= $totalNegocios ?? count($negocios ?? []) ?></div>
                <small class="text-secondary" style="font-size: 0.72rem;">Locales en Yaguará</small>
            </div>
        </div>
        
        <div class="col-6 col-lg-3">
            <div class="p-3 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <small class="text-secondary d-block mb-1" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-box-open me-1 text-warning"></i> Total Productos</small>
                <div class="h3 fw-bold text-white mb-0"><?= number_format($totalProductos ?? 0) ?></div>
                <small class="text-secondary" style="font-size: 0.72rem;">En vitrina y catálogo</small>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="p-3 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <small class="text-secondary d-block mb-1" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-eye me-1 text-warning"></i> Visitas Totales</small>
                <div class="h3 fw-bold mb-0" style="color: var(--color-success);"><?= number_format($totalVisitas ?? 0) ?></div>
                <small class="text-secondary" style="font-size: 0.72rem;">Visualizaciones de clientes</small>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="p-3 rounded-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                <small class="text-secondary d-block mb-1" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;"><i class="fas fa-comments me-1 text-warning"></i> Mensajes de Chat</small>
                <div class="h3 fw-bold mb-0" style="color: var(--color-primary);"><?= number_format($totalMensajes ?? 0) ?></div>
                <small class="text-secondary" style="font-size: 0.72rem;">Consultas en la app</small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4" style="background:var(--bg-card); border: 1px solid var(--border-color) !important;">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-4">
                        <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="list-group-item list-group-item-action p-3 text-warning fw-semibold" style="background:rgba(245, 158, 11, 0.08); border-color:var(--border-color);">
                            <i class="fas fa-th-large me-2"></i> Ver Comercios & Servicios
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/perfil" class="list-group-item list-group-item-action p-3 text-secondary" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-user-circle me-2"></i> Mi Perfil
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/mis_negocios" class="list-group-item list-group-item-action active p-3" style="background:var(--color-primary); border-color:var(--color-primary); color:white;">
                            <i class="fas fa-store me-2"></i> Panel de Negocios
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=chat/inbox" class="list-group-item list-group-item-action p-3 text-secondary" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-comments me-2 text-warning"></i> Inbox de Clientes
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=usuario/favoritos" class="list-group-item list-group-item-action p-3 text-secondary" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-heart me-2 text-danger"></i> Favoritos Guardados
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=autenticacion/logout" class="list-group-item list-group-item-action p-3 text-danger" style="background:transparent; border-color:var(--border-color);">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="m-0 text-white fw-bold"><i class="fas fa-store-alt me-2 text-warning"></i>Mis Negocios & Comercios</h4>
                    <p class="text-secondary small mb-0">Gestiona tu catálogo de productos, responde a clientes y descarga tu código QR.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn btn-outline-warning btn-sm fw-semibold px-3" style="border-radius: 8px;">
                        <i class="fas fa-th-large me-1"></i> Ver Todos los Comercios
                    </a>
                    <a href="<?= BASE_URL ?>index.php?url=negocio/crear" class="btn btn-warning btn-sm fw-bold px-3 text-white" style="background: var(--color-primary); border: none; border-radius: 8px;">
                        <i class="fas fa-plus-circle me-1"></i> Registrar Otro Negocio
                    </a>
                </div>
            </div>

            <?php if (empty($negocios)): ?>
                <div class="p-5 text-center rounded-4" style="background: var(--bg-card); border: 1px dashed var(--border-color);">
                    <div style="font-size: 3.5rem; color: var(--border-light); margin-bottom: 1rem;"><i class="fas fa-store-slash"></i></div>
                    <h4 class="text-white">Aún no tienes comercios registrados</h4>
                    <p class="text-secondary small mb-4">Puedes explorar todos los 44 comercios y servicios de Yaguará o registrar tu propio negocio en la plataforma.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="<?= BASE_URL ?>index.php?url=negocio/listado" class="btn btn-outline-warning fw-bold px-4 py-2" style="border-radius: 10px;">
                            <i class="fas fa-th-large me-2"></i> Explorar Comercios y Servicios
                        </a>
                        <a href="<?= BASE_URL ?>index.php?url=negocio/crear" class="btn btn-warning fw-bold text-white px-4 py-2" style="background: var(--color-primary); border: none; border-radius: 10px;">
                            <i class="fas fa-plus-circle me-2"></i> Comenzar Registro de Negocio
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php foreach ($negocios as $n): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-color) !important;">
                                <?php if ($n['estado'] === 'pendiente'): ?>
                                    <div class="bg-warning text-dark text-center py-1 fw-bold" style="font-size:0.75rem;"><i class="fas fa-clock me-1"></i> Solicitud en Revisión</div>
                                <?php elseif ($n['estado'] === 'rechazado'): ?>
                                    <div class="bg-danger text-white text-center py-1 fw-bold" style="font-size:0.75rem;"><i class="fas fa-times me-1"></i> Solicitud Rechazada</div>
                                <?php elseif ($n['estado'] === 'inactivo'): ?>
                                    <div class="bg-secondary text-white text-center py-1 fw-bold" style="font-size:0.75rem;"><i class="fas fa-pause me-1"></i> Inactivo</div>
                                <?php else: ?>
                                    <div class="text-white text-center py-1 fw-bold" style="background: var(--color-success); font-size:0.75rem;"><i class="fas fa-check-circle me-1"></i> Publicado & Activo</div>
                                <?php endif; ?>
                                
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title text-white fw-bold mb-0 text-truncate" style="max-width: 240px;"><?= htmlspecialchars($n['nombre']) ?></h5>
                                            <?php if ($n['verificado']): ?>
                                                <span class="badge" style="background: rgba(0, 179, 126, 0.15); color: var(--color-success); border: 1px solid rgba(0, 179, 126, 0.3); font-size: 0.65rem;">
                                                    <i class="fas fa-check-circle me-1"></i> Verificado
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-secondary d-block mb-3"><?= htmlspecialchars($n['categoria_nombre'] ?? 'Comercio') ?> • <?= htmlspecialchars($n['sector_nombre'] ?? 'Yaguará') ?></small>
                                        
                                        <?php 
                                        $prodModel = new Producto();
                                        $prodsCount = count($prodModel->getByNegocio($n['id']));
                                        ?>
                                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom" style="border-color:var(--border-color) !important;">
                                            <div class="text-center">
                                                <div class="h5 m-0 text-warning fw-bold"><?= number_format($n['visitas']) ?></div>
                                                <small class="text-secondary" style="font-size:0.7rem;text-transform:uppercase;">Visitas</small>
                                            </div>
                                            <div class="text-center">
                                                <div class="h5 m-0 text-white fw-bold"><?= $prodsCount ?></div>
                                                <small class="text-secondary" style="font-size:0.7rem;text-transform:uppercase;">Productos</small>
                                            </div>
                                            <div class="text-center">
                                                <div class="h5 m-0 text-warning fw-bold"><?= date('d/m/Y', strtotime($n['fecha_creacion'])) ?></div>
                                                <small class="text-secondary" style="font-size:0.7rem;text-transform:uppercase;">Registro</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column gap-2 mt-2">
                                        <div class="d-flex gap-2">
                                            <a href="<?= BASE_URL ?>index.php?url=negocio/ficha/<?= $n['slug'] ?>" class="btn btn-sm btn-outline-secondary flex-fill text-white" target="_blank" style="border-color:var(--border-light); font-size: 0.8rem;">
                                                <i class="fas fa-eye me-1"></i> Ver Ficha
                                            </a>
                                            <a href="<?= BASE_URL ?>index.php?url=producto/index&negocio_id=<?= $n['id'] ?>" class="btn btn-sm text-white flex-fill fw-semibold" style="background:#f97316; border:none; font-size: 0.8rem;">
                                                <i class="fas fa-box-open me-1"></i> Catálogo / Menú
                                            </a>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-dark border-secondary text-light flex-fill" data-bs-toggle="modal" data-bs-target="#qrModal<?= $n['id'] ?>" style="font-size: 0.8rem;">
                                                <i class="fas fa-qrcode me-1 text-warning"></i> Mi Código QR
                                            </button>
                                            <a href="<?= BASE_URL ?>index.php?url=chat/inbox" class="btn btn-sm btn-dark border-secondary text-light flex-fill" style="font-size: 0.8rem;">
                                                <i class="fas fa-comments me-1 text-warning"></i> Inbox Clientes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal QR -->
                        <div class="modal fade" id="qrModal<?= $n['id'] ?>" tabindex="-1" data-bs-theme="dark">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content text-center p-4" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px;">
                                    <h5 class="text-white fw-bold mb-1"><?= htmlspecialchars($n['nombre']) ?></h5>
                                    <p class="text-secondary small mb-3">Imprime este código para que tus clientes escaneen tu catálogo en tu local físico.</p>
                                    
                                    <!-- QR Image Generator -->
                                    <div class="p-3 bg-white rounded-3 d-inline-block mx-auto mb-3">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= urlencode(BASE_URL . 'index.php?url=negocio/ficha/' . $n['slug']) ?>" alt="QR Negocio" style="width: 180px; height: 180px;">
                                    </div>
                                    
                                    <button type="button" class="btn btn-outline-secondary btn-sm text-white border-secondary w-100" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
