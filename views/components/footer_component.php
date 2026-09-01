<footer class="footer-directorio">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5><i class="fas fa-map-marker-alt me-2" style="color:var(--color-primary-light)"></i>Directorio Yaguará</h5>
                <p>Conectamos a la comunidad de Yaguará, Huila con sus negocios y servicios locales. Encuentra todo lo que necesitas en un solo lugar.</p>
                <div class="social-links mt-3">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <h5>Explorar</h5>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>index.php?url=home/index">Inicio</a></li>
                    <li><a href="<?= BASE_URL ?>index.php?url=negocio/listado">Negocios</a></li>
                    <li><a href="<?= BASE_URL ?>index.php?url=negocio/crear">Registrar Negocio</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5>Categorías populares</h5>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>index.php?url=categoria/ver/restaurantes-comidas">Restaurantes</a></li>
                    <li><a href="<?= BASE_URL ?>index.php?url=categoria/ver/turismo-hospedaje">Turismo</a></li>
                    <li><a href="<?= BASE_URL ?>index.php?url=categoria/ver/servicios-tecnicos">Servicios Técnicos</a></li>
                    <li><a href="<?= BASE_URL ?>index.php?url=categoria/ver/salud-bienestar">Salud</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h5>Contacto</h5>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt me-2" style="color:var(--color-primary-light)"></i>Yaguará, Huila, Colombia</li>
                    <li class="mt-2"><i class="fas fa-envelope me-2" style="color:var(--color-primary-light)"></i>contacto@yaguara.gov.co</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. Todos los derechos reservados. v<?= APP_VERSION ?></p>
        </div>
    </div>
</footer>
