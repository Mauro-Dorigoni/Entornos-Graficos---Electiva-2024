<?php
//Muestra los botontes de las acciones según el tipo de usuario para la pantalla shopDetailPage
function renderUserShopAction(Shop $shop){
    if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    $userType = $_SESSION["userType"];

        if($user != null && $userType===UserType_enum::Admin){
            ?>
        
            <button type="button" class="btn btn-primary">
             <a class="text-white" href="editShopPage.php?id=<?= $shop->getId(); ?>" 
                                   aria-label="Editar local <?= htmlspecialchars($shop->getName()); ?>">
                                   Editar
                                </a></button>
            <button type="button" class="btn btn-secondary">Borrar</button>
            
            <?php
        }
        if($user != null && $userType===UserType_enum::Owner){
            ?>
        
            <button type="button" class="btn btn-primary">
             <a href="editShopPage.php?id=<?= $shop->getId(); ?>" 
                                   aria-label="Editar local <?= htmlspecialchars($shop->getName()); ?>">
                                   Editar
                                </a></button>
            
            <?php
        }
    }
  
    
}




?>
