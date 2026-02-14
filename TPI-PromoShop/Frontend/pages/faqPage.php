<?php
// Incluimos lo básico (Sesión, Rutas, etc)
// Si usas el BreadcrumbManager nuevo, inclúyelo aquí
require_once __DIR__ . "/../shared/BreadcrumbManager.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes - PromoShop</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #eae8e0 !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .text-orange {
            color: #CC6600 !important;
        }

        .bg-orange {
            background-color: #CC6600 !important;
        }

        /* --- ESTILOS DEL ACORDEÓN --- */
        .faq-card {
            border: none;
            border-bottom: 1px solid #e0e0e0;
            background: white;
            margin-bottom: 8px;
            border-radius: 8px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .faq-header {
            padding: 0;
            background-color: #fff;
            border-bottom: none;
        }

        .faq-btn {
            width: 100%;
            text-align: left;
            color: #333;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 1.25rem 1.5rem;
            text-decoration: none !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .faq-btn:hover {
            color: #CC6600;
            background-color: #fff8f0;
        }

        /* Cuando está abierto */
        .faq-btn[aria-expanded="true"] {
            color: #CC6600;
            background-color: #fff3e0;
        }

        /* La respuesta */
        .card-body {
            padding: 1.5rem;
            color: #555;
            line-height: 1.6;
            background-color: #fff;
        }

        /* Animación de la flecha */
        .faq-icon {
            transition: transform 0.3s ease;
            font-size: 0.9rem;
            color: #999;
        }

        .faq-btn[aria-expanded="true"] .faq-icon {
            transform: rotate(180deg);
            color: #CC6600;
        }

        /* Sección de Contacto al final */
        .contact-box {
            background-color: #343a40;
            color: white;
            border-radius: 10px;
            padding: 3rem;
            text-align: center;
            margin-top: 3rem;
        }
    </style>
</head>

<body>

    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php"; ?>



    <main class="container py-4">


        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="text-center mb-5">
                    <h1 class="display-4 font-weight-bold">Preguntas Frecuentes</h1>
                    <p class="lead text-muted">Resolvemos tus dudas sobre cómo aprovechar al máximo PromoShop.</p>
                </div>

                <h3 class="text-orange mb-3"><i class="fas fa-user-circle mr-2"></i> Para Usuarios</h3>

                <div class="accordion" id="accordionUsers">

                    <div class="card faq-card">
                        <div class="card-header faq-header" id="headingOne">
                            <button class="btn btn-link faq-btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span>¿Cómo canjeo un cupón de descuento?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionUsers">
                            <div class="card-body">
                                Es muy sencillo. Solo tienes que buscar la promoción que te guste, hacer clic en ella y presionar el botón <strong>"Obtener Código"</strong>. Recibirás un código único alfanumérico. Preséntalo en el local correspondiente (mostrando la pantalla de tu celular) para que te apliquen el descuento.
                            </div>
                        </div>
                    </div>

                    <div class="card faq-card">
                        <div class="card-header faq-header" id="headingTwo">
                            <button class="btn btn-link faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>¿Tiene algún costo usar PromoShop?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionUsers">
                            <div class="card-body">
                                ¡No! Para los usuarios, PromoShop es <strong>totalmente gratuito</strong>. Puedes buscar, descargar y utilizar todos los cupones que quieras sin pagar ninguna comisión.
                            </div>
                        </div>
                    </div>

                    <div class="card faq-card">
                        <div class="card-header faq-header" id="headingThree">
                            <button class="btn btn-link faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span>¿Qué hago si un local no me acepta el cupón?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionUsers">
                            <div class="card-body">
                                Todos los comercios adheridos tienen la obligación de aceptar los cupones vigentes. Si tienes un problema, verifica que la fecha de la promoción sea válida y que cumplas las condiciones (días de la semana). Si el problema persiste, por favor contáctanos mediante el formulario de soporte reportando el local.
                            </div>
                        </div>
                    </div>

                    <div class="card faq-card">
                        <div class="card-header faq-header" id="headingFour">
                            <button class="btn btn-link faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span>¿Puedo cancelar un cupón que ya descargué?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionUsers">
                            <div class="card-body">
                                Los cupones no se "cancelan", simplemente caducan si no los usas. Si descargaste un código y decides no ir al local, no pasa nada, el código vencerá automáticamente en la fecha estipulada.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="my-5"></div>

                <h3 class="text-orange mb-3"><i class="fas fa-store mr-2"></i> Para Dueños de Locales</h3>

                <div class="accordion" id="accordionOwners">

                    <div class="card faq-card">
                        <div class="card-header faq-header" id="headingFive">
                            <button class="btn btn-link faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <span>¿Cómo publico una promoción?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionOwners">
                            <div class="card-body">
                                Debes tener una cuenta de tipo "Dueño". Ingresa a tu panel, ve a la sección <strong>"Mis Promociones"</strong> y haz clic en "Nueva Promoción". Completa los datos (título, descuento, días válidos, imagen) y envíala. Un administrador revisará la publicación y la aprobará a la brevedad.
                            </div>
                        </div>
                    </div>

                    <div class="card faq-card">
                        <div class="card-header faq-header" id="headingSix">
                            <button class="btn btn-link faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <span>¿Cómo valido el cupón de un cliente?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                        </div>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionOwners">
                            <div class="card-body">
                                Cuando un cliente llegue a tu local, te mostrará un código. Ingresa a tu panel en la sección <strong>"Validar Cupón"</strong>, escribe el código y el sistema te dirá si es válido y a qué descuento corresponde. Al validarlo, quedará marcado como "Usado" para evitar fraudes.
                            </div>
                        </div>
                    </div>

                    <div class="card faq-card">
                        <div class="card-header faq-header" id="headingSeven">
                            <button class="btn btn-link faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                <span>¿Puedo editar una promoción activa?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </button>
                        </div>
                        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionOwners">
                            <div class="card-body">
                                Por seguridad y transparencia hacia los usuarios, las promociones activas no se pueden modificar sustancialmente (como el porcentaje de descuento). Si cometiste un error, te recomendamos eliminar la promoción y crear una nueva.
                            </div>
                        </div>
                    </div>

                </div>

                <div class="contact-box shadow">
                    <h3 class="font-weight-bold">¿No encontraste lo que buscabas?</h3>
                    <p class="mb-4 text-light">Nuestro equipo de soporte está disponible para ayudarte con cualquier problema técnico o duda comercial.</p>
                    <a href="#" class="btn btn-lg font-weight-bold text-white" style="background-color: #CC6600; border: none; padding: 10px 30px;" data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="fas fa-envelope mr-2"></i> Contactar Soporte
                    </a>
                </div>

            </div>
        </div>
    </main>

    <?php include "../components/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>