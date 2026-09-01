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
    <script src="<?= BASE_URL ?>public/assets/js/search.js"></script>
    <script src="<?= BASE_URL ?>public/assets/js/maps.js"></script>

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
    </script>
</body>
</html>
