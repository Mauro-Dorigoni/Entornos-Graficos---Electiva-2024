<?php
require_once "../shared/backendRoutes.dev.php";
require_once "../shared/frontendRoutes.dev.php";
include "../components/messageModal.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperacion de Cuenta</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/styles/passwordRecoveryPage.css">
</head>
<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem; background-color: #eae8e0">
                    <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-flex justify-content-center align-items-center" style="background-color: white; border-radius: 1rem 0 0 1rem;">
                        <img src="../assets/LogoPromoShopFondoBlanco.png"
                            alt="password recovery form" class="img-fluid" style="max-width: 80%; height: auto;" />
                    </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <form action=<?php echo backendHTTPLayer . '/recovery.http.php'; ?> method="post">
                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Recuperacion de Cuenta</h5>
                                <p>Parece que te has olvidado tu contraseña. No te preocupes, te ayudaremos a recuperar tu cuenta a traves de la direccion de email asociada con esta</p>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" id="form2Example17" class="form-control form-control-lg" id="email" name="email" required/>
                                    <label class="form-label" for="form2Example17">Direccion de email</label>
                                </div>
                                <div class="pt-1 mb-4">
                                    <button type="submit" class="btn btn-lg btn-block btn-outline-orange">Recuperar</button>
                                </div>
                                <a href=<?php echo frontendURL."/termsPage.php"?> class="small text-muted">Terminos de Uso.</a>
                                <a href=<?php echo frontendURL."/privacyPage.php"?> class="small text-muted">Politica de Privacidad</a>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</body>
</html>