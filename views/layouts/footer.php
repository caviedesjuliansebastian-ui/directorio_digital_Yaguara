</main>

    <!-- Footer -->
    <?php if (empty($sinFooter)): ?>
        <?php include ROOT_PATH . 'views/components/footer_component.php'; ?>
        <?php include ROOT_PATH . 'views/components/cart_drawer.php'; ?>
    <?php endif; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- App JS -->
    <script src="<?= BASE_URL ?>public/assets/js/search.js?v=<?= time() ?>"></script>
    <script src="<?= BASE_URL ?>public/assets/js/maps.js?v=<?= time() ?>"></script>

    <script>
        // Auto-dismiss alerts
        document.querySelectorAll('.alert-directorio').forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s, transform 0.5s';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Global Favoritos Toggle
        function toggleFavorito(negocioId, btnEl, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            if (btnEl) {
                btnEl.style.transform = 'scale(1.25)';
                setTimeout(() => btnEl.style.transform = 'scale(1)', 200);
            }

            const formData = new FormData();
            formData.append('negocio_id', negocioId);
            formData.append('ajax', '1');

            fetch('<?= BASE_URL ?>index.php?url=negocio/favorito', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = '<?= BASE_URL ?>index.php?url=autenticacion/login';
                    throw new Error('Login requerido');
                }
                return res.json();
            })
            .then(data => {
                if (data.login_requerido) {
                    window.location.href = data.login_url || '<?= BASE_URL ?>index.php?url=autenticacion/login';
                    return;
                }

                const isFav = data.favorito;

                // Actualizar todos los botones de este negocio en la vista
                document.querySelectorAll(`.card-fav-btn[data-negocio-id="${negocioId}"]`).forEach(btn => {
                    btn.setAttribute('title', isFav ? 'Quitar de favoritos' : 'Guardar en favoritos');
                    btn.style.background = isFav ? '#ef4444' : 'rgba(0,0,0,0.6)';
                    btn.innerHTML = `<i class="${isFav ? 'fas' : 'far'} fa-heart"></i>`;
                });

                // Si estamos en la ficha de detalle
                const fichaBtn = document.getElementById('btn-favorito-ficha');
                if (fichaBtn) {
                    if (isFav) {
                        fichaBtn.className = 'btn btn-sm btn-danger';
                        fichaBtn.innerHTML = '<i class="fas fa-heart"></i> Guardado';
                    } else {
                        fichaBtn.className = 'btn btn-sm btn-outline-secondary';
                        fichaBtn.innerHTML = '<i class="far fa-heart"></i> Guardar en Favoritos';
                    }
                }

                const counterEl = document.getElementById('ficha-favoritos-counter');
                if (counterEl && data.total_favoritos !== undefined) {
                    counterEl.innerHTML = `<i class="fas fa-heart me-1 text-danger"></i> ${data.total_favoritos} favoritos`;
                }
            })
            .catch(err => {
                console.error('Error al guardar favorito:', err);
            });
        }
    </script>
</body>
</html>
