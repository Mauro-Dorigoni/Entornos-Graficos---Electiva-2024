<?php
//Muestra los botontes de las acciones según el tipo de usuario para la pantalla shopDetailPage
function renderUserShopAction(Shop $shop)
{
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
        $userType = $_SESSION["userType"];

        if ($user != null && $userType === UserType_enum::Admin) {
?>
                <button type="button" class="btn btn-primary mr-2">
                    <a class="text-white" href="editShopPage.php?id=<?= $shop->getId(); ?>"
                        aria-label="Editar local <?= htmlspecialchars($shop->getName()); ?>">
                        Editar
                    </a></button>
                <form action="<?php echo backendHTTPLayer . '/deleteShop.http.php'; ?>" method="post" class="mb-0">
                    <input type="hidden" name="idShop" value="<?= $shop->getId() ?>">
                    <button type="submit" class="btn btn-secondary text-white" aria-label="Borrar local <?= htmlspecialchars($shop->getName()); ?>" onclick="return confirm('¿Estás seguro de querer borrar este local?');">
                        Borrar
                    </button>

                </form>



        <?php
        }
        if ($user != null && $userType === UserType_enum::Owner) {
        ?>

            <button type="button" class="btn btn-primary">
                <a class="text-white" href="editShopPage.php?id=<?= $shop->getId(); ?>"
                    aria-label="Editar local <?= htmlspecialchars($shop->getName()); ?>">
                    Editar
                </a></button>

<?php
        }
    }
}




?>