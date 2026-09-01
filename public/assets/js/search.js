/**
 * SERVI-GO — BÚSQUEDA Y FILTRADO EN VIVO INTELIGENTE (LIVE REALTIME SEARCH)
 * 1. Búsqueda con Autocompletado Flotante en Navbar y Sidebar
 * 2. Filtrado Instantáneo de Tarjetas de Negocios en Tiempo Real (sin recargar)
 */

document.addEventListener('DOMContentLoaded', () => {
    const baseUrl = window.BASE_URL || (window.location.origin + window.location.pathname.replace('/index.php', '').replace(/\/$/, '') + '/');
    
    const navbarInput = document.getElementById('navbar-search-input');
    const navbarResults = document.getElementById('navbar-search-results');
    
    const sidebarInput = document.getElementById('sidebar-search-input');
    const sidebarResults = document.getElementById('sidebar-search-results');
    const sidebarForm = document.getElementById('sidebar-search-form');
    
    const gridContainer = document.getElementById('negocios-grid-container');
    const countSpan = document.getElementById('total-resultados-count');

    let debounceTimer;

    // Helper para escapar texto
    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.toString().replace(/[&<>"']/g, m => map[m]);
    }

    // Renderizar Dropdown de sugerencias flotantes
    function renderDropdown(resultsContainer, data, query) {
        if (!resultsContainer) return;

        const negocios = data.negocios || [];
        const productos = data.productos || [];
        const categorias = data.categorias || [];
        const total = (data.total !== undefined) ? data.total : (negocios.length + productos.length + categorias.length);

        if (total === 0) {
            resultsContainer.innerHTML = `
                <div class="p-3 text-center">
                    <i class="fas fa-search mb-1 text-secondary opacity-50"></i>
                    <div class="text-white fw-bold small">Sin coincidencias</div>
                    <small class="text-secondary" style="font-size:0.75rem;">No encontramos coincidencias para "${escapeHtml(query)}"</small>
                </div>
            `;
            resultsContainer.style.display = 'block';
            return;
        }

        let html = '<div class="p-2 d-flex flex-column gap-2">';

        // Categorías
        if (categorias.length > 0) {
            html += `
                <div class="px-2 pt-1 text-secondary text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                    <i class="fas fa-tags text-warning me-1"></i> Categorías
                </div>
                <div class="d-flex flex-wrap gap-1 px-2 pb-1">
            `;
            categorias.forEach(cat => {
                html += `
                    <a href="${cat.url}" class="badge text-decoration-none py-1 px-2 d-flex align-items-center gap-1" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 6px; font-size: 0.75rem;">
                        <i class="${cat.icono || 'fas fa-tag'}"></i> ${escapeHtml(cat.nombre)}
                    </a>
                `;
            });
            html += `</div>`;
        }

        // Negocios
        if (negocios.length > 0) {
            html += `
                <div class="px-2 pt-1 text-secondary text-uppercase fw-bold border-top" style="font-size: 0.68rem; letter-spacing: 0.5px; border-color: #262930 !important;">
                    <i class="fas fa-store text-warning me-1"></i> Comercios & Prestadores
                </div>
            `;
            negocios.slice(0, 4).forEach(item => {
                const imgUrl = item.logo 
                    ? (item.logo.startsWith('http') ? item.logo : baseUrl + item.logo)
                    : (item.imagen_portada ? (item.imagen_portada.startsWith('http') ? item.imagen_portada : baseUrl + item.imagen_portada) : '');

                const avatarHtml = imgUrl 
                    ? `<img src="${imgUrl}" style="width:34px; height:34px; border-radius:8px; object-fit:cover; border:1px solid #333;">`
                    : `<div style="width:34px; height:34px; border-radius:8px; background:#25282e; color:#f59e0b; display:flex; align-items:center; justify-content:center;"><i class="${item.categoria_icono || 'fas fa-store'}"></i></div>`;

                html += `
                    <a href="${item.url}" class="search-live-item p-2 rounded-2 d-flex align-items-center gap-2 text-decoration-none text-white" style="transition: background 0.15s ease;">
                        ${avatarHtml}
                        <div class="flex-grow-1 text-truncate">
                            <div class="fw-bold d-flex align-items-center gap-1" style="font-size: 0.82rem;">
                                <span class="text-truncate">${escapeHtml(item.nombre)}</span>
                                ${item.verificado ? '<i class="fas fa-check-circle text-success" style="font-size:0.7rem;"></i>' : ''}
                            </div>
                            <small class="text-secondary d-block" style="font-size: 0.7rem;">${escapeHtml(item.categoria)} • ${escapeHtml(item.sector || 'Yaguará')}</small>
                        </div>
                    </a>
                `;
            });
        }

        // Productos
        if (productos.length > 0) {
            html += `
                <div class="px-2 pt-1 text-secondary text-uppercase fw-bold border-top" style="font-size: 0.68rem; letter-spacing: 0.5px; border-color: #262930 !important;">
                    <i class="fas fa-utensils text-warning me-1"></i> Productos & Platos
                </div>
            `;
            productos.slice(0, 4).forEach(prod => {
                const prodImg = prod.foto ? (prod.foto.startsWith('http') ? prod.foto : baseUrl + prod.foto) : '';
                const thumbHtml = prodImg 
                    ? `<img src="${prodImg}" style="width:34px; height:34px; border-radius:6px; object-fit:cover; border:1px solid #333;">`
                    : `<div style="width:34px; height:34px; border-radius:6px; background:#25282e; color:#f59e0b; display:flex; align-items:center; justify-content:center;"><i class="fas fa-box"></i></div>`;

                html += `
                    <a href="${prod.url}" class="search-live-item p-2 rounded-2 d-flex align-items-center gap-2 text-decoration-none text-white" style="transition: background 0.15s ease;">
                        ${thumbHtml}
                        <div class="flex-grow-1 text-truncate">
                            <div class="fw-bold text-truncate" style="font-size: 0.8rem;">${escapeHtml(prod.nombre)}</div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-warning fw-bold" style="font-size: 0.72rem;">${prod.precio_formato}</span>
                                <small class="text-secondary" style="font-size: 0.68rem;">en ${escapeHtml(prod.negocio_nombre)}</small>
                            </div>
                        </div>
                    </a>
                `;
            });
        }

        html += `</div>`;
        resultsContainer.innerHTML = html;
        resultsContainer.style.display = 'block';

        resultsContainer.querySelectorAll('.search-live-item').forEach(el => {
            el.addEventListener('mouseenter', () => el.style.background = '#22262d');
            el.addEventListener('mouseleave', () => el.style.background = 'transparent');
        });
    }

    // Función para filtrar en tiempo real el grid de tarjetas
    function filtrarGridEnVivo(query) {
        if (!gridContainer) return;

        const categoria = gridContainer.dataset.categoria || '';
        const sector = gridContainer.dataset.sector || '';
        const verificados = gridContainer.dataset.verificados || '';

        // Indicador visual de carga en el grid
        gridContainer.style.opacity = '0.4';

        const url = `${baseUrl}index.php?url=api/filtrar_negocios&q=${encodeURIComponent(query)}&categoria=${encodeURIComponent(categoria)}&sector=${encodeURIComponent(sector)}&verificados=${encodeURIComponent(verificados)}`;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            gridContainer.innerHTML = data.html;
            gridContainer.style.opacity = '1';
            
            if (countSpan) {
                countSpan.textContent = `${data.total} resultados encontrados`;
            }

            // Actualizar URL sin recargar
            const urlObj = new URL(window.location.href);
            if (query.trim()) {
                urlObj.searchParams.set('q', query.trim());
            } else {
                urlObj.searchParams.delete('q');
            }
            window.history.replaceState({}, '', urlObj.toString());
        })
        .catch(err => {
            console.error('Error al filtrar grid:', err);
            gridContainer.style.opacity = '1';
        });
    }

    // ==========================================
    // 1. SIDEBAR SEARCH INPUT (LISTADO)
    // ==========================================
    if (sidebarInput) {
        sidebarInput.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            const query = e.target.value.trim();

            debounceTimer = setTimeout(() => {
                // 1. Filtrar el grid de negocios en tiempo real
                filtrarGridEnVivo(query);

                // 2. Si tiene más de 1 caracter, mostrar dropdown flotante
                if (query.length >= 2 && sidebarResults) {
                    fetch(`${baseUrl}index.php?url=api/buscar&q=${encodeURIComponent(query)}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => renderDropdown(sidebarResults, data, query))
                    .catch(err => console.error(err));
                } else if (sidebarResults) {
                    sidebarResults.style.display = 'none';
                }
            }, 180); // Respuesta ultra-rápida de 180ms
        });

        if (sidebarForm) {
            sidebarForm.addEventListener('submit', (e) => {
                e.preventDefault();
                filtrarGridEnVivo(sidebarInput.value.trim());
                if (sidebarResults) sidebarResults.style.display = 'none';
            });
        }
    }

    // ==========================================
    // 2. NAVBAR SEARCH INPUT (GLOBAL)
    // ==========================================
    if (navbarInput && navbarResults) {
        navbarInput.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            const query = e.target.value.trim();

            if (query.length < 2) {
                navbarResults.style.display = 'none';
                return;
            }

            debounceTimer = setTimeout(() => {
                // Si estamos en la página de listado, actualizar también el grid
                if (gridContainer) {
                    filtrarGridEnVivo(query);
                }

                fetch(`${baseUrl}index.php?url=api/buscar&q=${encodeURIComponent(query)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => renderDropdown(navbarResults, data, query))
                .catch(err => console.error(err));
            }, 180);
        });

        navbarInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = navbarInput.value.trim();
                if (query.length > 0) {
                    window.location.href = `${baseUrl}index.php?url=negocio/listado&q=${encodeURIComponent(query)}`;
                }
            } else if (e.key === 'Escape') {
                navbarResults.style.display = 'none';
            }
        });

        navbarInput.addEventListener('focus', function() {
            if (navbarInput.value.trim().length >= 2 && navbarResults.innerHTML.trim() !== '') {
                navbarResults.style.display = 'block';
            }
        });
    }

    // Cerrar dropdowns al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (navbarInput && navbarResults && !navbarInput.contains(e.target) && !navbarResults.contains(e.target)) {
            navbarResults.style.display = 'none';
        }
        if (sidebarInput && sidebarResults && !sidebarInput.contains(e.target) && !sidebarResults.contains(e.target)) {
            sidebarResults.style.display = 'none';
        }
    });

    // Función global para limpiar búsqueda
    window.limpiarFiltroBusqueda = function() {
        if (sidebarInput) sidebarInput.value = '';
        if (navbarInput) navbarInput.value = '';
        filtrarGridEnVivo('');
    };
});
