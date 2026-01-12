<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Términos y Condiciones - PromoShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #eae8e0 !important;
        }
        .terms-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .text-orange {
            color: #CC6600 !important;
        }
        .terms-card h2 {
            margin-top: 30px;
        }
        .terms-card p {
            color: #444;
            line-height: 1.7;
        }
    </style>
</head>

<body>
<?php include "../components/header.php"; ?>
<?php include "../components/navBarByUserType.php"; ?>

<main class="container py-5">
    <div class="terms-card">
        <h1 class="display-4 font-weight-bold text-orange mb-4">
            Términos y Condiciones
        </h1>

        <p>
            Bienvenido a <strong>PromoShop</strong>. Al acceder y utilizar esta plataforma,
            usted acepta cumplir con los presentes Términos y Condiciones. Si no está de
            acuerdo con alguno de ellos, deberá abstenerse de utilizar el sistema.
        </p>

        <h2 class="h4 font-weight-bold">1. Objeto del servicio</h2>
        <p>
            PromoShop es una plataforma destinada a la publicación, gestión y utilización
            de promociones comerciales ofrecidas por locales adheridos. El sistema permite
            a los usuarios visualizar promociones vigentes y a los comercios administrar
            su contenido bajo las reglas establecidas.
        </p>

        <h2 class="h4 font-weight-bold">2. Uso adecuado</h2>
        <p>
            El usuario se compromete a utilizar la plataforma de manera responsable,
            lícita y conforme a la normativa vigente. Queda prohibido cualquier uso que
            pueda dañar, sobrecargar o afectar el correcto funcionamiento del sistema.
        </p>

        <h2 class="h4 font-weight-bold">3. Promociones</h2>
        <p>
            Las promociones publicadas son responsabilidad exclusiva del comercio que
            las ofrece. PromoShop no garantiza la disponibilidad, veracidad ni vigencia
            de las promociones, y no se responsabiliza por inconvenientes derivados de
            su uso.
        </p>

        <h2 class="h4 font-weight-bold">4. Vigencia y condiciones</h2>
        <p>
            Cada promoción posee fechas y días específicos de validez. Es responsabilidad
            del usuario verificar dichas condiciones antes de utilizar una promoción.
            Las promociones fuera de vigencia no podrán ser reclamadas.
        </p>

        <h2 class="h4 font-weight-bold">5. Suspensión del servicio</h2>
        <p>
            PromoShop se reserva el derecho de suspender temporal o definitivamente el
            acceso a la plataforma ante incumplimientos de estos términos, fallas técnicas
            o por razones de mantenimiento, sin necesidad de previo aviso.
        </p>

        <h2 class="h4 font-weight-bold">6. Modificaciones</h2>
        <p>
            Los presentes Términos y Condiciones podrán ser modificados en cualquier momento.
            Las modificaciones entrarán en vigencia a partir de su publicación en la
            plataforma. El uso continuado del sistema implica la aceptación de los cambios.
        </p>

        <h2 class="h4 font-weight-bold">7. Protección de datos</h2>
        <p>
            La información personal proporcionada por los usuarios será tratada de acuerdo
            con las políticas de privacidad vigentes, y utilizada únicamente para el
            correcto funcionamiento de la plataforma.
        </p>

        <h2 class="h4 font-weight-bold">8. Legislación aplicable</h2>
        <p>
            Estos Términos y Condiciones se rigen por las leyes de la República Argentina.
            Cualquier controversia será sometida a los tribunales competentes.
        </p>

        <hr class="my-4">

        <p class="text-muted">
            Última actualización: <?= date('d/m/Y') ?>
        </p>

        <div class="mt-4">
            <a href="javascript:history.back()" class="btn btn-light btn-lg">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</main>

<?php include "../components/footer.php"; ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>
