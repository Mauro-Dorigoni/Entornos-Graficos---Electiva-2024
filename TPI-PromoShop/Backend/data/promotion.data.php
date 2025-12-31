<?php
require_once __DIR__."/../shared/BD.data.dev.php";
require_once __DIR__."/../structs/shop.class.php";
require_once __DIR__."/../structs/promotion.class.php";
require_once __DIR__."/../structs/userCategory.class.php";
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../shared/promoStatus.enum.php";

class PromotionData {
    public static function add (Promotion $promo){
        $conn = new mysqli(servername, username, password, dbName);
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
        $conn->begin_transaction();
        try{
            $stmtPromo = $conn->prepare("INSERT INTO promotion (promoText, status, imageUUID, dateFrom, dateTo, idUserCategory, idShop) values (?,?,?,?,?,?,?)");
            if (!$stmtPromo) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
            $promoText = $promo->getPromoText();
            $status = PromoStatus_enum::Pendiente->value;
            $imageUUID = $promo->getImageUUID();
            $dateFrom = $promo->getDateFromMysql();
            $dateTo = $promo->getDateToMysql(); 
            $idUserCategory = $promo->getUserCategory()->getId();
            $idShop = $promo->getShop()->getId();

            $stmtPromo->bind_param("sssssss",$promoText,$status,$imageUUID,$dateFrom,$dateTo,$idUserCategory,$idShop);
            if (!$stmtPromo->execute()) {
                throw new Exception("Error al intentar agregar la promocion: " . $stmtPromo->error);
            }
            $generatedId = $stmtPromo->insert_id;
            if ($generatedId <= 0) {
                throw new Exception("No se pudo obtener el ID generado");
            }
            $promo->setId($generatedId);
            $stmtPromo->close();
            $stmtValidDays = $conn->prepare("INSERT INTO validpromoday (idPromotion, monday, tuesday, wednesday, thursday, friday, saturday, sunday) VALUES (?,?,?,?,?,?,?,?");
            $idPromotion = $promo->getId();
            $monday = $promo->getValidDays()[0];
            $tuesday = $promo->getValidDays()[1];
            $wednesday = $promo->getValidDays()[2];
            $thursday = $promo->getValidDays()[3];
            $friday = $promo->getValidDays()[4];
            $saturday = $promo->getValidDays()[5];
            $sunday = $promo->getValidDays()[6];
            $stmtValidDays->bind_param("iiiiiiii", $idPromotion,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday);
            if (!$stmtValidDays->execute()) {
                throw new Exception("Error al intentar agregar los dias de validez: " . $stmtPromo->error);
            }
            $stmtValidDays->close();
            $conn->commit();
        }catch (Throwable $e){
            $conn->rollback();
        }finally{
            $conn->close();
        }
    }
}
?>