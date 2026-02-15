<?php
//Muestra los botontes de las acciones según el tipo de usuario para la pantalla shopDetailPage
function renderUserShopAction(Shop $shop)
{
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
        $userType = $_SESSION["userType"];

        if ($user != null && $userType === UserType_enum::Admin) {
?>
            <button type="button"
                class="btn mr-2"
                style="background-color:#CC6600; color:white; border:none;">
                <a href="editShopPage.php?id=<?= $shop->getId(); ?>"
                    aria-label="Editar local <?= htmlspecialchars($shop->getName()); ?>"
                    style="color:white; text-decoration:none;">
                    Editar
                </a>
            </button>
            <form action="<?php echo backendHTTPLayer . '/deleteShop.http.php'; ?>" method="post" class="mb-0">
                <input type="hidden" name="idShop" value="<?= $shop->getId() ?>">
                <button type="button" class="btn btn-secondary text-white" aria-label="Borrar local <?= htmlspecialchars($shop->getName()); ?>" onclick="confirmarBorrado(this)">
                    Borrar
                </button>

            </form>



        <?php
        }
        if ($user != null && $userType === UserType_enum::Owner) {
        ?>
        <button type="button"
            class="btn"
            style="background-color:#CC6600; color:white; border:none;">
            <a href="editShopPage.php?id=<?= $shop->getId(); ?>"
                aria-label="Editar local <?= htmlspecialchars($shop->getName()); ?>"
                style="color:white; text-decoration:none;">
                Editar
            </a>
        </button>

<?php
        }
    }
}




?>