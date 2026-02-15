<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información General | Tu Shopping</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <style>
        /* Estilos consistentes con landingPageTest.php */
        body {
            background-color: #eae8e0 !important;
        }
        .btn-orange {
            background-color: #ff8c00 !important;
            color: white !important;
            border-color: #ff8c00 !important;
            font-weight: bold !important;
        }

        .cat-card {
            border: none;
            border-radius: 12px;
            background: white;
            transition: all 0.3s ease;
            height: 100%;
        }

        .cat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            border-bottom: 4px solid #ff8c00;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background-color: #fff3e0;
            color: #ff8c00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 15px auto;
        }

        .hero-info {
            height: 50vh;
            position: relative;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%), 
                        url('https://static.wixstatic.com/media/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .overlap-container {
            margin-top: -80px;
            position: relative;
            z-index: 10;
        }

        .text-orange {
            color: #ff8c00 !important;
        }
    </style>
</head>

<body>

    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <div class="hero-info">
        <div class="container">
            <h1 class="display-4 font-weight-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.6);">
                Información General
            </h1>
            <p class="lead" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">
                Todo lo que necesitas saber para tu visita.
            </p>
        </div>
    </div>

    <div class="container overlap-container mb-5">
        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                    <div class="icon-circle">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4 class="font-weight-bold">Horarios</h4>
                    <div class="text-muted small mt-2">
                        <p class="mb-1"><strong class="text-dark">Locales:</strong><br> Lunes a Domingos, 10:00 - 22:00 hs.</p>
                        <p class="mb-0"><strong class="text-dark">Gastronomía:</strong><br> Hasta las 00:00 hs.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                    <div class="icon-circle">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4 class="font-weight-bold">Ubicación</h4>
                    <div class="text-muted small mt-2">
                        <p class="mb-1">Av. Principal 1234, Rosario, Santa Fe.</p>
                        <p class="mb-0 font-italic text-orange">Estacionamiento gratuito para clientes.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                    <div class="icon-circle">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4 class="font-weight-bold">Contacto</h4>
                    <div class="text-muted small mt-2">
                        <p class="mb-1"><i class="fas fa-phone mr-1"></i> (0341) 455-XXXX</p>
                        <p class="mb-0"><i class="fas fa-envelope mr-1"></i> info@shopping.com</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include "../components/footer.php" ?>

</body>
</html>