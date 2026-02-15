<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misión, Visión y Valores | Tu Shopping</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <style>
        /* Reutilizamos los estilos de la Landing para mantener consistencia */
        body {
            background-color: #eae8e0 !important;
        }
        .text-orange { color: #ff8c00 !important; }
        
        /* BANNER */
        .hero-section {
            height: 50vh;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%), 
                        url('https://static.wixstatic.com/media/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* TARJETAS */
        .cat-card {
            border: none;
            border-radius: 12px;
            background: white;
            transition: all 0.3s ease;
            height: 100%;
        }

        .cat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
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
            margin: 0 auto 20px auto;
        }

        .overlap-container {
            margin-top: -100px;
            position: relative;
            z-index: 10;
        }

        ul.values-list {
            list-style: none;
            padding: 0;
        }

        ul.values-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }

        ul.values-list li::before {
            content: "\f00c"; /* Check icon de FontAwesome */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: #ff8c00;
        }
    </style>
</head>

<body>

    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <div class="hero-section text-center text-white">
        <div class="container">
            <h1 class="display-4 font-weight-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.6);">
                Nuestra Identidad
            </h1>
            <p class="lead" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">
                Conoce el compromiso que nos impulsa cada día.
            </p>
        </div>
    </div>

    <div class="container overlap-container pb-5">
        <div class="row">
            
            <div class="col-md-4 mb-4">
                <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                    <div class="icon-circle">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="font-weight-bold">Misión</h3>
                    <p class="text-muted">
                        Brindar una experiencia de compra integral y segura, ofreciendo la mejor variedad de marcas y servicios para satisfacer las necesidades de nuestros visitantes.
                    </p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                    <div class="icon-circle">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="font-weight-bold">Visión</h3>
                    <p class="text-muted">
                        Ser reconocidos como el complejo comercial y de ocio más innovador del país, destacándonos por nuestra hospitalidad y compromiso con la comunidad.
                    </p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                    <div class="icon-circle">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="font-weight-bold">Valores</h3>
                    <ul class="text-left text-muted values-list">
                        <li>Integridad en nuestras acciones.</li>
                        <li>Excelencia en el servicio.</li>
                        <li>Innovación constante.</li>
                        <li>Responsabilidad Social.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <?php include "../components/footer.php" ?>

</body>
</html>