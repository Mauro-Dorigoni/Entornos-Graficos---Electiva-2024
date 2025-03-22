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
    <title>Register Page</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/styles/registerPage.css">
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
                            alt="login form" class="img-fluid" style="max-width: 80%; height: auto;" />
                    </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <form action=<?php echo backendHTTPLayer."/register.http.php"?> method="post" onsubmit="return validatePasswords()">
                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Registro de Usuario</h5>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" id="form2Example17" class="form-control form-control-lg" name="email" required/>
                                    <label class="form-label" for="form2Example17">Direccion de email</label>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" id="form2Example27" class="form-control form-control-lg" name="pass" required/>
                                    <label class="form-label" for="form2Example27" >Contraseña</label>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" class="form-control form-control-lg" id="pass2" name="pass2" required/>
                                    <label class="form-label" for="pass2" >Repita su Contraseña</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p id="error-message" class="error-message">Las contraseñas no coinciden.</p>
                                    </div>
                                </div>

                                <div class="pt-1 mb-4">
                                    <button type="submit" class="btn btn-lg btn-block btn-outline-orange">Registrarse</button>
                                </div>
                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Ya tienes una cuenta? <a href=<?php echo frontendURL."/loginPage.php"?>
                                    style="color: #393f81;">Ingrese Aqui</a></p>
                                <a href="#!" class="small text-muted">Terminos de Uso.</a>
                                <a href="#!" class="small text-muted">Politica de Privacidad</a>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    <script>
        function validatePasswords() {
            var password = document.getElementById("form2Example27").value;
            var confirmPassword = document.getElementById("pass2").value;
            var errorMessage = document.getElementById("error-message");

            if (password !== confirmPassword) {
                errorMessage.style.display = "block";  // Muestra el mensaje de error
                return false;  // Previene el envío del formulario
            } else {
                errorMessage.style.display = "none";  // Oculta el mensaje de error
                return true;  // Permite el envío del formulario
            }
        }
    </script>
</body>
</html>