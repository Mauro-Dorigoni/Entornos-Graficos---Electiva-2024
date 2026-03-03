<link rel="stylesheet" href="../assets/styles/navBar.css">
<div class="container-fluid nav-menu" id="navBarContainer" style="background-color: #006633;">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-dark p-0" aria-label="Navegación principal">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar menú principal">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link px-4" href="<?php echo frontendURL . '/index.php'; ?>">Inicio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link px-4" href="<?php echo frontendURL . '/shopsCardsPage.php'; ?>">Locales</a>
                        </li>

                        <li class="nav-item position-relative">
                            <a class="nav-link px-4 toggle-submenu d-flex justify-content-between align-items-center"
                                href="#"
                                role="button"
                                aria-expanded="false"
                                aria-controls="submenu-promociones"
                                data-target="#submenu-promociones">
                                Promociones
                                <span class="submenu-arrow ml-2" aria-hidden="true">&#9662;</span>
                            </a>
                            <div class="custom-submenu" id="submenu-promociones">
                                <a class="dropdown-item" href="<?php echo frontendURL . '/myPromotionsPage.php'; ?>">Mis Promociones</a>
                                <a class="dropdown-item" href="<?php echo frontendURL . '/allPromotionsPage.php'; ?>">Todas las Promos</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link px-4" href="<?php echo frontendURL . '/newsPage.php'; ?>">Novedades</a>
                        </li>

                        <li class="nav-item position-relative">
                            <a class="nav-link px-4 toggle-submenu d-flex justify-content-between align-items-center"
                                href="#"
                                role="button"
                                aria-expanded="false"
                                aria-controls="submenu-nosotros"
                                data-target="#submenu-nosotros">
                                Sobre nosotros
                                <span class="submenu-arrow ml-2" aria-hidden="true">&#9662;</span>
                            </a>
                            <div class="custom-submenu" id="submenu-nosotros">
                                <a class="dropdown-item" href="<?php echo frontendURL . '/infoGeneralPage.php'; ?>">Información General</a>
                                <a class="dropdown-item" href="<?php echo frontendURL . '/quienesSomosPage.php'; ?>">Quiénes Somos</a>
                                <a class="dropdown-item" href="<?php echo frontendURL . '/MVVPage.php'; ?>">Misión, Visión, Valores</a>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

<div>
    <?php BreadcrumbManager::render(); ?>
</div>

<script>
    // Función centralizada para cerrar todo y reiniciar los atributos ARIA
    function closeAllSubmenus() {
        document.querySelectorAll('.custom-submenu').forEach(menu => menu.classList.remove('show'));
        document.querySelectorAll('.toggle-submenu').forEach(link => {
            link.classList.remove('active');
            link.setAttribute('aria-expanded', 'false'); // Avisa al lector que se cerró
        });
    }

    document.querySelectorAll('.toggle-submenu').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute('data-target'));

            // 1. Cierra otros menús abiertos y actualiza sus estados
            document.querySelectorAll('.custom-submenu').forEach(menu => {
                if (menu !== target) {
                    menu.classList.remove('show');
                    // Buscamos quién controlaba este menú para decirle que ahora está cerrado
                    const btnCerrar = document.querySelector(`[data-target="#${menu.id}"]`);
                    if (btnCerrar) btnCerrar.setAttribute('aria-expanded', 'false');
                }
            });

            document.querySelectorAll('.toggle-submenu').forEach(link => {
                if (link !== this) link.classList.remove('active');
            });

            // 2. Alterna el menú actual y sincroniza el aria-expanded
            if (target) {
                const isNowOpen = target.classList.toggle('show');
                this.classList.toggle('active');

                // Si isNowOpen es true, le decimos al lector que está expandido
                this.setAttribute('aria-expanded', isNowOpen ? 'true' : 'false');
            }
        });
    });

    // Cierra el menú al hacer clic fuera (Ratón)
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-item')) {
            closeAllSubmenus();
        }
    });

    // NUEVO: Cierra el menú con la tecla Escape (Teclado)
    // Esto es un requisito de Nivel A en las normas de usabilidad WCAG.
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllSubmenus();
        }
    });
</script>