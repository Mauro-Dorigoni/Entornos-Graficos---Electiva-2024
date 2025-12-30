
<link rel="stylesheet" href="../assets/styles/navBar.css">
<div class="container-fluid nav-menu"  id="navBarContainer" style="background-color: #006633;">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item position-relative">
                            <a class="nav-link px-4 toggle-submenu d-flex justify-content-between align-items-center" 
                                href="#" data-target="#submenu-locales">
                                Local 
                                <span class="submenu-arrow ml-2">&#9662;</span>
                            </a>
                            <div class="custom-submenu" id="submenu-locales">
                                <a class="dropdown-item" href="<?php echo frontendURL.'/landingPageOwner.php'; ?>">Mi local</a>
                                <!-- YO LO MANDARÍA A LA PAGINA PRINCIPAL GENERICA. Y EN MI LOCAL LA VISTA DE SU LOCAL -->
                                <a class="dropdown-item" href="<?php echo frontendURL.'/newShopGalleryPage.php'; ?>">Alta de Galeria</a>
                            </div>
                            </li>
                        <li class="nav-item">
                            <a class="nav-link px-4" href="">Placeholder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-4" href="">Placeholder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-4" href="">Placeholder</a>
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

        document.querySelectorAll('.custom-submenu').forEach(menu => {
            if (menu !== target) menu.classList.remove('show');
        });

        document.querySelectorAll('.toggle-submenu').forEach(link => {
            if (link !== this) link.classList.remove('active');
        });

        if (target) {
            target.classList.toggle('show');
            this.classList.toggle('active');
        }
    });
});


document.addEventListener('click', function(e) {
    if (!e.target.closest('.nav-item')) {
        document.querySelectorAll('.custom-submenu').forEach(menu => menu.classList.remove('show'));
        document.querySelectorAll('.toggle-submenu').forEach(link => link.classList.remove('active'));
    }
});
</script>