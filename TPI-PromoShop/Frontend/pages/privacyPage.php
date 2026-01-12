<?php
// Página pública
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Política de Privacidad - PromoShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #eae8e0 !important;
        }
        .privacy-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .text-orange {
            color: #CC6600 !important;
        }
        .privacy-card h2 {
            margin-top: 30px;
        }
        .privacy-card p {
            color: #444;
            line-height: 1.7;
        }
    </style>
</head>

<body>
<?php include "../components/header.php"; ?>
<?php include "../components/navBarByUserType.php"; ?>

<main class="container py-5">
    <div class="privacy-card">
        <h1 class="display-4 font-weight-bold text-orange mb-4">
            Política de Privacidad
        </h1>

        <p>
            En <strong>PromoShop</strong> valoramos y protegemos la privacidad de nuestros
            usuarios. La presente Política de Privacidad describe cómo recopilamos,
            utilizamos y protegemos la información personal proporcionada al utilizar
            nuestra plataforma.
        </p>

        <h2 class="h4 font-weight-bold">1. Información recopilada</h2>
        <p>
            PromoShop puede recopilar información personal como nombre, correo electrónico,
            datos del comercio y otra información necesaria para el correcto funcionamiento
            del sistema. Asimismo, se podrán recopilar datos técnicos relacionados con el
            uso de la plataforma.
        </p>

        <h2 class="h4 font-weight-bold">2. Uso de la información</h2>
        <p>
            La información recopilada se utiliza exclusivamente para la gestión de
            promociones, la administración de usuarios, la mejora del servicio y la
            comunicación relacionada con el funcionamiento de la plataforma.
        </p>

        <h2 class="h4 font-weight-bold">3. Confidencialidad</h2>
        <p>
            PromoShop se compromete a mantener la confidencialidad de los datos personales
            y a no cederlos a terceros, salvo obligación legal o consentimiento expreso del
            usuario.
        </p>

        <h2 class="h4 font-weight-bold">4. Almacenamiento y seguridad</h2>
        <p>
            Los datos personales son almacenados en sistemas seguros y protegidos mediante
            medidas técnicas y organizativas razonables, destinadas a prevenir accesos no
            autorizados, pérdidas o alteraciones de la información.
        </p>

        <h2 class="h4 font-weight-bold">5. Cookies y tecnologías similares</h2>
        <p>
            La plataforma puede utilizar cookies u otras tecnologías similares para mejorar
            la experiencia del usuario. Estas herramientas no recopilan información personal
            sensible y pueden ser deshabilitadas desde el navegador.
        </p>

        <h2 class="h4 font-weight-bold">6. Derechos del usuario</h2>
        <p>
            El usuario podrá acceder, rectificar o solicitar la eliminación de sus datos
            personales en cualquier momento, conforme a la legislación vigente en materia
            de protección de datos.
        </p>

        <h2 class="h4 font-weight-bold">7. Modificaciones de la política</h2>
        <p>
            PromoShop se reserva el derecho de modificar la presente Política de Privacidad
            en cualquier momento. Las modificaciones entrarán en vigencia a partir de su
            publicación en la plataforma.
        </p>

        <h2 class="h4 font-weight-bold">8. Legislación aplicable</h2>
        <p>
            Esta Política de Privacidad se rige por las leyes de la República Argentina.
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
