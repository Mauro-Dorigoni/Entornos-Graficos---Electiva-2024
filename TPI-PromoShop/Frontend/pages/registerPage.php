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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                            alt="register form" class="img-fluid" style="max-width: 80%; height: auto;" />
                    </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <form action=<?php echo backendHTTPLayer."/register.http.php"?> method="post" onsubmit="return validatePasswords()">
                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Registro de Usuario</h5>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" id="form2Example17" class="form-control form-control-lg" name="email" required/>
                                    <label class="form-label" for="form2Example17">Direccion de email</label>
                                </div>
                                <div class="form-group">

                                            <div class="input-group">
                                                <input
                                                    type="password"
                                                    id="pass"
                                                    name="pass"
                                                    class="form-control form-control-lg"
                                                    pattern="(?=.*[!@#$%^&*(),.?{}|<>]).{8,}"
                                                    title="La contraseña debe tener al menos 8 caracteres y un carácter especial."
                                                    required
                                                />

                                                <div class="input-group-append">
                                                    <button 
                                                        class="btn btn-outline-secondary toggle-password"
                                                        type="button"
                                                        data-target="pass">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <label for="pass">Contraseña</label>
                                        </div>

                               <div class="form-group">

                                            <div class="input-group">
                                                <input
                                                    type="password"
                                                    id="pass2"
                                                    name="pass2"
                                                    class="form-control form-control-lg"
                                                    pattern="(?=.*[!@#$%^&*(),.?{}|<>]).{8,}"
                                                    title="La contraseña debe tener al menos 8 caracteres y un carácter especial."
                                                    required
                                                />

                                                <div class="input-group-append">
                                                    <button 
                                                        class="btn btn-outline-secondary toggle-password"
                                                        type="button"
                                                        data-target="pass2">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <label for="pass2">Repita su Contraseña</label>
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
    <script>
        function validatePasswords() {
            const password = document.getElementById("pass").value;
            const confirmPassword = document.getElementById("pass2").value;
            const errorMessage = document.getElementById("error-message");

            // Regex: mínimo 8 caracteres y al menos 1 caracter especial
            const regex = /^(?=.*[!@#$%^&*(),.?{}|<>]).{8,}$/;

            // Validar formato
            if (!regex.test(password)) {
                errorMessage.innerText = "La contraseña debe tener al menos 8 caracteres y un carácter especial.";
                errorMessage.style.display = "block";
                return false;
            }

            // Validar coincidencia
            if (password !== confirmPassword) {
                errorMessage.innerText = "Las contraseñas no coinciden.";
                errorMessage.style.display = "block";
                return false;
            }

            errorMessage.style.display = "none";
            return true;
        }

        document.addEventListener("DOMContentLoaded", function () {
        const toggles = document.querySelectorAll(".toggle-password");

        toggles.forEach(toggle => {
            toggle.addEventListener("click", function () {
                const targetId = this.getAttribute("data-target");
                const input = document.getElementById(targetId);
                const icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                }
            });
        });
    });
    </script>
</body>
</html>