/**
 * JS para Búsqueda en vivo (Live Search) en el Navbar
 */
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('navbar-search-input');
    const resultsContainer = document.getElementById('navbar-search-results');
    
    if (!input || !resultsContainer) return;

    let timeoutId;

    // Elemento global BASE_URL inferido del current location para AJAX
    const baseUrl = window.location.origin + window.location.pathname.replace('/index.php', '').replace(/\/$/, '') + '/';

    input.addEventListener('input', function(e) {
        clearTimeout(timeoutId);
        const query = e.target.value.trim();

        if (query.length < 2) {
            resultsContainer.classList.remove('active');
            return;
        }

        timeoutId = setTimeout(() => {
            fetch(`${baseUrl}index.php?url=api/buscar&q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                resultsContainer.innerHTML = '';
                
                if (data.total === 0) {
                    resultsContainer.innerHTML = `<div class="p-3 text-center text-muted small">No se encontraron resultados para "${query}"</div>`;
                } else {
                    data.resultados.slice(0, 5).forEach(item => {
                        const iconHtml = item.logo 
                            ? `<img src="${baseUrl}${item.logo}" style="width:100%;height:100%;object-fit:cover;">`
                            : `<i class="${item.categoria_icono}"></i>`;

                        const html = `
                            <a href="${item.url}" class="search-result-item text-decoration-none">
                                <div class="result-icon" style="background:${item.categoria_color || 'var(--color-primary)'}">
                                    ${iconHtml}
                                </div>
                                <div class="result-info flex-grow-1">
                                    <h6 class="text-dark mb-0">${item.nombre} ${item.verificado ? '<i class="fas fa-check-circle text-success" style="font-size:0.75rem;"></i>' : ''}</h6>
                                    <small>${item.categoria} • ${item.sector}</small>
                                </div>
                            </a>
                        `;
                        resultsContainer.insertAdjacentHTML('beforeend', html);
                    });

                    if (data.total > 5) {
                        resultsContainer.insertAdjacentHTML('beforeend', `
                            <a href="${baseUrl}index.php?url=negocio/listado&q=${encodeURIComponent(query)}" class="d-block text-center p-2 text-decoration-none bg-light small fw-bold" style="border-top:1px solid var(--border-light);border-radius:0 0 8px 8px;">
                                Ver todos los ${data.total} resultados
                            </a>
                        `);
                    }
                }
                
                resultsContainer.classList.add('active');
            })
            .catch(error => console.error('Error en búsqueda:', error));
        }, 300); // Debounce 300ms
    });

    // Cerrar al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.classList.remove('active');
        }
    });
});
