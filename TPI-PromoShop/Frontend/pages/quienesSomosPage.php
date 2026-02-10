<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quiénes Somos - Tu Shopping</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos heredados de newsDetailPage.php */
        body { background-color: #eae8e0 !important; min-height: 100vh; }
        .text-orange { color: #CC6600 !important; }
        
        .detail-card { 
            background: white; 
            border-radius: 15px; 
            overflow: hidden; 
            border: none; 
            margin-top: 50px;
        }
        
        .img-container { 
            height: 100%; 
            min-height: 500px; 
            background-color: #f8f9fa; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        
        /* Imagen optimizada para el contenedor lateral */
        .about-img { width: 100%; height: 100%; object-fit: cover; }
        .info-section { padding: 40px; }
        
        #btn-orange {
            color: white !important;
            background-color: #CC6600 !important;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        #btn-orange:hover {
            background-color: #a35200 !important;
        }

        .contact-info i {
            width: 25px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <main class="container py-5">
        <div class="card detail-card shadow-lg">
            <div class="row no-gutters"> 
                <div class="col-md-5">
                    <div class="img-container">
                        <img src="https://static.wixstatic.com/media/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png/v1/fill/w_1920,h_1080,al_c/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png" 
                             class="about-img" alt="Pasillos del Shopping Center">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="info-section">
                        <h1 class="text-orange font-weight-bold display-4">Quiénes Somos</h1>
                        <hr class="mb-4" style="border-top: 2px solid #CC6600; opacity: 0.3;">

                        <div class="description-box mb-4">
                            <p class="text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                                Somos el centro comercial líder de la región, fundado con la visión de crear un espacio único donde las compras, la cultura y el entretenimiento se encuentran. Desde nuestra inauguración, hemos trabajado para ser el punto de referencia de las familias.
                            </p>
                            <p class="text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                                Nuestro equipo está conformado por profesionales apasionados por el servicio al cliente y la gestión de experiencias memorables.
                            </p>
                        </div>

                        <div class="mt-5">
                            <h5 class="text-dark font-weight-bold"></i> Nuestra Trayectoria</h5>
                            <p class="text-secondary">
                                Más de una década brindando los mejores servicios, marcas internacionales y eventos culturales para toda la comunidad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>