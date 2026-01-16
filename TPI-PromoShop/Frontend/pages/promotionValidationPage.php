<?php
require_once "../shared/authFunctions.php/owner.auth.function.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once "../shared/backendRoutes.dev.php";
include "../components/messageModal.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Beneficio - Fisherton Plaza</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Base inspirada en newsDetailPage.php */
        body { background-color: #eae8e0; min-height: 100vh; }
        .text-orange { color: #CC6600 !important; }
        
        /* Contenedor principal estilizado */
        .validator-card { 
            background: white; 
            border-radius: 20px; 
            border: none; 
            max-width: 550px; 
            margin: 0 auto; 
            overflow: hidden;
        }

        .header-accent {
            background-color: #CC6600;
            height: 8px;
            width: 100%;
        }

        /* Estilo del Input moderno sin la palabra "Código" al lado */
        .promo-input-container {
            position: relative;
            margin-bottom: 35px;
        }

        .promo-input-container i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #CC6600;
            font-size: 1.2rem;
            z-index: 10;
        }

        .input-custom {
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 15px 15px 15px 55px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            transition: all 0.3s ease;
            width: 100%;
            letter-spacing: 2px;
            text-align: center;
        }

        .input-custom:focus {
            border-color: #CC6600;
            box-shadow: 0 0 15px rgba(204, 102, 0, 0.1);
            outline: none;
        }

        #btn-outline-orange {
            color: white;
            background-color: #CC6600;
        }

        #btn-outline-orange:hover {
            background-color:rgb(148, 75, 1);
            color: white;
        }

        .info-section { padding: 50px 40px; }
        
        .back-link {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        .back-link:hover { color: #CC6600; text-decoration: none; }
    </style>
</head>
<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <main class="container py-5">
        <div class="card validator-card shadow-lg">
            <div class="header-accent"></div>
            <div class="info-section text-center">
                
                <div class="mb-4">
                    <i class="fas fa-ticket-alt fa-3x text-orange"></i>
                </div>

                <h2 class="font-weight-bold mb-2">Canje de Promoción</h2>
                <p class="text-muted mb-5">Ingresa el código alfanumérico para validar tu beneficio.</p>

                <form action="<?php echo backendHTTPLayer . '/registerPromoUse.http.php'; ?>" method="POST">
                    
                    <div class="promo-input-container">
                        <i class="fas fa-key"></i>
                        <input type="text" 
                               name="uniqueCode" 
                               class="input-custom" 
                               placeholder="EJ: PROMO-12345" 
                               maxlength="15"
                               required>
                    </div>

                    <div class="pt-1 mb-4">
                        <button type="submit" class="btn btn-lg btn-block btn-outline-orange" id="btn-outline-orange">Validar Beneficio</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>