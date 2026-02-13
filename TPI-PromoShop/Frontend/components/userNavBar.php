<link rel="stylesheet" href="../assets/styles/navBar.css">
<div class="container-fluid nav-menu" id="navBarContainer" style="background-color: #006633;">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
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
                                href="#" data-target="#submenu-promociones">
                                Promociones
                                <span class="submenu-arrow ml-2">&#9662;</span>
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
                                href="#" data-target="#submenu-nosotros">
                                Sobre nosotros
                                <span class="submenu-arrow ml-2">&#9662;</span>
                            </a>
                            <div class="custom-submenu" id="submenu-nosotros">
                                <a class="dropdown-item" href="<?php echo frontendURL . '/quienesSomosPage.php'; ?>">Quiénes Somos</a>
                                <a class="dropdown-item" href="<?php echo frontendURL . '/infoGeneralPage.php'; ?>">Información General</a>
                                <a class="dropdown-item" href="<?php echo frontendURL . '/MVVPage.php'; ?>">Misión, Visión, Valores</a>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-submenu').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute('data-target'));

            // Cierra otros menús abiertos
            document.querySelectorAll('.custom-submenu').forEach(menu => {
                if (menu !== target) menu.classList.remove('show');
            });

            document.querySelectorAll('.toggle-submenu').forEach(link => {
                if (link !== this) link.classList.remove('active');
            });

            // Alterna el menú actual
            if (target) {
                target.classList.toggle('show');
                this.classList.toggle('active');
            }
        });
    });

    // Cierra el menú al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-item')) {
            document.querySelectorAll('.custom-submenu').forEach(menu => menu.classList.remove('show'));
            document.querySelectorAll('.toggle-submenu').forEach(link => link.classList.remove('active'));
        }
    });
</script>