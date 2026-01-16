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
            $stmtValidDays = $conn->prepare("INSERT INTO validpromoday (idPromotion, monday, tuesday, wednesday, thursday, friday, saturday, sunday) VALUES (?,?,?,?,?,?,?,?)");
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
            throw $e;
        }finally{
            $conn->close();
        }
    }

    public static function findById(Promotion $promo): ?Promotion{
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare(
                "SELECT 
                    p.id AS promo_id, p.promoText, p.dateFrom, p.dateTo, p.imageUUID, p.status, p.motivoRechazo,
                    ucat.id AS usercat_id, ucat.categoryType,
                    s.id AS shop_id, s.name AS shop_name, s.location, s.description AS shop_description, s.openinghours,
                    st.id AS shoptype_id, st.type AS shoptype_type, st.description AS shoptype_description,
                    v.monday, v.tuesday, v.wednesday, v.thursday, v.friday, v.saturday, v.sunday,
                    a.id AS admin_id, a.email AS admin_email
                FROM promotion p
                INNER JOIN validpromoday v ON v.idPromotion = p.id
                INNER JOIN shop s ON s.id = p.idShop
                INNER JOIN shoptype st ON st.id = s.idShopType
                INNER JOIN usercategory ucat ON ucat.id = p.idUserCategory
                LEFT JOIN user a ON a.id = p.idAdmin
                WHERE p.id = ? AND p.dateDeleted IS NULL AND s.dateDeleted IS NULL AND ucat.dateDeleted IS NULL AND st.dateDeleted IS NULL");
            if (!$stmt) {
                throw new Exception($conn->error);
            }
            $id = (int)$promo->getId();
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            $category = new UserCategory();
            $category->setId((int)$row['usercat_id']);
            $category->setCategoryType($row['categoryType']);
            $shopType = new ShopType();
            $shopType->setId((int)$row['shoptype_id']);
            $shopType->setType($row['shoptype_type']);
            $shopType->setDescription($row['shoptype_description']);
            $shop = new Shop();
            $shop->setId((int)$row['shop_id']);
            $shop->setName($row['shop_name']);
            $shop->setLocation($row['location']);
            $shop->setDescription($row['shop_description']);
            $shop->setOpeningHours($row['openinghours']);
            $shop->setShopType($shopType);
            $promo = new Promotion();
            $promo->setId((int)$row['promo_id']);
            $promo->setPromoText($row['promoText']);
            $promo->setDateFrom(new DateTimeImmutable($row['dateFrom']));
            $promo->setDateTo(new DateTimeImmutable($row['dateTo']));
            $promo->setImageUUID($row['imageUUID']);
            $promo->setStatus(PromoStatus_enum::from($row['status']));
            $promo->setMotivoRechazo($row['motivoRechazo']);
            $promo->setShop($shop);
            $promo->setUserCategory($category);
            $promo->setValidDays([
                'monday'    => (bool)$row['monday'],
                'tuesday'   => (bool)$row['tuesday'],
                'wednesday' => (bool)$row['wednesday'],
                'thursday'  => (bool)$row['thursday'],
                'friday'    => (bool)$row['friday'],
                'saturday'  => (bool)$row['saturday'],
                'sunday'    => (bool)$row['sunday'],
            ]);
            if ($row['admin_id'] !== null) {
                $admin = new User();
                $admin->setId((int)$row['admin_id']);
                $admin->setEmail($row['admin_email']);
                $promo->setAdmin($admin);
            }
            $stmt->close();
            return $promo;
        } catch (Exception $e) {
            throw new Exception("Error al obtener la promoción por ID: " . $e->getMessage());
        } finally {
            if (isset($conn)) {
                $conn->close();
            }
        }
    }

    public static function findPending(): array{
    $pendingPromos = [];
    try {
        $conn = new mysqli(servername, username, password, dbName);
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
        $result = $conn->query("SELECT p.id AS promo_id, p.promoText, p.dateFrom, p.dateTo, p.imageUUID, p.status,
                u.id AS usercat_id, u.categoryType,
                s.id AS shop_id,s.name AS shop_name, s.location, s.description AS shop_description, s.openinghours,
                st.id AS shoptype_id, st.type AS shoptype_type, st.description AS shoptype_description,
                v.monday, v.tuesday,v.wednesday, v.thursday, v.friday, v.saturday, v.sunday
            FROM promotion p
            INNER JOIN validpromoday v ON v.idPromotion = p.id
            INNER JOIN shop s ON s.id = p.idShop
            INNER JOIN shoptype st ON st.id = s.idShopType
            INNER JOIN usercategory u ON u.id = p.idUserCategory
            WHERE p.status = 'Pendiente' AND p.dateDeleted IS NULL AND s.dateDeleted IS NULL AND u.dateDeleted IS NULL AND st.dateDeleted IS NULL");
        if (!$result) {
            throw new Exception($conn->error);
        }
        while ($row = $result->fetch_assoc()) {
            $category = new UserCategory();
            $category->setId((int)$row['usercat_id']);
            $category->setCategoryType($row['categoryType']);
            $shopType = new ShopType();
            $shopType->setId((int)$row['shoptype_id']);
            $shopType->setType($row['shoptype_type']);
            $shopType->setDescription($row['shoptype_description']);
            $shop = new Shop();
            $shop->setId((int)$row['shop_id']);
            $shop->setName($row['shop_name']);
            $shop->setLocation($row['location']);
            $shop->setDescription($row['shop_description']);
            $shop->setOpeningHours($row['openinghours']);
            $shop->setShopType($shopType);
            $promo = new Promotion();
            $promo->setId((int)$row['promo_id']);
            $promo->setPromoText($row['promoText']);
            $promo->setDateFrom(new DateTimeImmutable($row['dateFrom']));
            $promo->setDateTo( new DateTimeImmutable($row['dateTo']));
            $promo->setImageUUID($row['imageUUID']);
            $promo->setStatus(PromoStatus_enum::from($row['status']));
            $promo->setShop($shop);
            $promo->setUserCategory($category);
            $promo->setValidDays([
                'monday'    => (bool)$row['monday'],
                'tuesday'   => (bool)$row['tuesday'],
                'wednesday' => (bool)$row['wednesday'],
                'thursday'  => (bool)$row['thursday'],
                'friday'    => (bool)$row['friday'],
                'saturday'  => (bool)$row['saturday'],
                'sunday'    => (bool)$row['sunday'],
            ]);
            $pendingPromos[] = $promo;
        }
    } catch (Exception $e) {
        throw new Exception(
            "Error al obtener las promociones pendientes de revisión: " . $e->getMessage()
        );
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
    return $pendingPromos;
    }

    public static function findAllByShop(Shop $shop): array{
    $activePromos = [];
    try {
        $conn = new mysqli(servername, username, password, dbName);
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT p.id AS promo_id, p.promoText, p.dateFrom, p.dateTo, p.imageUUID, p.status, p.motivoRechazo,
                u.id AS usercat_id, u.categoryType,
                s.id AS shop_id, s.name AS shop_name, s.location, s.description AS shop_description, s.openinghours,
                st.id AS shoptype_id, st.type AS shoptype_type, st.description AS shoptype_description,
                v.monday, v.tuesday, v.wednesday, v.thursday, v.friday, v.saturday, v.sunday
            FROM promotion p
            INNER JOIN validpromoday v ON v.idPromotion = p.id
            INNER JOIN shop s ON s.id = p.idShop
            INNER JOIN shoptype st ON st.id = s.idShopType
            INNER JOIN usercategory u ON u.id = p.idUserCategory
            WHERE p.idShop = ? AND p.dateDeleted IS NULL AND s.dateDeleted IS NULL AND u.dateDeleted IS NULL AND st.dateDeleted IS NULL");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $shopId = $shop->getId();
        $stmt->bind_param("i", $shopId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $category = new UserCategory();
            $category->setId((int)$row['usercat_id']);
            $category->setCategoryType($row['categoryType']);
            $shopType = new ShopType();
            $shopType->setId((int)$row['shoptype_id']);
            $shopType->setType($row['shoptype_type']);
            $shopType->setDescription($row['shoptype_description']);
            $shopObj = new Shop();
            $shopObj->setId((int)$row['shop_id']);
            $shopObj->setName($row['shop_name']);
            $shopObj->setLocation($row['location']);
            $shopObj->setDescription($row['shop_description']);
            $shopObj->setOpeningHours($row['openinghours']);
            $shopObj->setShopType($shopType);
            $promo = new Promotion();
            $promo->setId((int)$row['promo_id']);
            $promo->setPromoText($row['promoText']);
            $promo->setDateFrom(new DateTimeImmutable($row['dateFrom']));
            $promo->setDateTo(new DateTimeImmutable($row['dateTo']));
            $promo->setImageUUID($row['imageUUID']);
            $promo->setStatus(PromoStatus_enum::from($row['status']));
            $promo->setMotivoRechazo($row['motivoRechazo']);
            $promo->setShop($shopObj);
            $promo->setUserCategory($category);
            $promo->setValidDays([
                'monday'    => (bool)$row['monday'],
                'tuesday'   => (bool)$row['tuesday'],
                'wednesday' => (bool)$row['wednesday'],
                'thursday'  => (bool)$row['thursday'],
                'friday'    => (bool)$row['friday'],
                'saturday'  => (bool)$row['saturday'],
                'sunday'    => (bool)$row['sunday'],
            ]);
            $activePromos[] = $promo;
        }
        $stmt->close();
    } catch (Exception $e) {
        throw new Exception(
            "Error al obtener las promociones vigentes del local: " . $e->getMessage()
        );
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
    return $activePromos;
}
    public static function rejectPromotion(Promotion $promo): void {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare(" UPDATE promotion
                                            SET status = ?, idAdmin = ?, motivoRechazo = ?
                                            WHERE id = ? AND dateDeleted IS NULL");
            if (!$stmt) {
                throw new Exception($conn->error);
            }
            $status = PromoStatus_enum::Rechazada->value;
            $adminId = $promo->getAdmin()->getId();
            $promoId = $promo->getId();
            $motivoRechazo = $promo->getMotivoRechazo();
            $stmt->bind_param("sisi",$status,$adminId, $motivoRechazo, $promoId);
            $stmt->execute();
            if ($stmt->affected_rows === 0) {
                throw new Exception("No se pudo rechazar la promoción o ya fue modificada.");
            }
            $stmt->close();
            $promo->setStatus(PromoStatus_enum::Rechazada);
        } catch (Exception $e) {
            throw new Exception(
                "Error al rechazar la promoción: " . $e->getMessage());
        } finally {
            if (isset($conn)) {
                $conn->close();
            }
        }
    }

    public static function approvePromotion(Promotion $promo): void {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $today = new DateTimeImmutable('today');
            $dateTo = $promo->getDateTo();
            if (!$dateTo instanceof DateTimeInterface && $dateTo != null) { //ver por si no funciona
                $dateTo = new DateTimeImmutable($dateTo);
            }
            $newStatus = null;
            if ($dateTo > $today) {
                $newStatus = PromoStatus_enum::Vigente;
            }
            if ($newStatus !== null) {
                $stmt = $conn->prepare("UPDATE promotion
                                                SET status = ?, idAdmin = ?
                                                WHERE id = ? AND dateDeleted IS NULL");
                if (!$stmt) {
                    throw new Exception($conn->error);
                }
                $statusValue = $newStatus->value;
                $adminId = $promo->getAdmin()->getId();
                $promoId = $promo->getId();
                $stmt->bind_param("sii", $statusValue, $adminId, $promoId);
            } else {
                $stmt = $conn->prepare("UPDATE promotion
                                                SET idAdmin = ?
                                                WHERE id = ? AND dateDeleted IS NULL");
                if (!$stmt) {
                    throw new Exception($conn->error);
                }
                $adminId = $promo->getAdmin()->getId();
                $promoId = $promo->getId();
                $stmt->bind_param("ii",$adminId,$promoId);
            }
            $stmt->execute();
            if ($stmt->affected_rows === 0) {
                throw new Exception("No se pudo aprobar la promoción o ya fue modificada.");
            }
            $stmt->close();
            if ($newStatus !== null) {
                $promo->setStatus($newStatus);
            }
        } catch (Exception $e) {
            throw new Exception(
                "Error al aprobar la promoción: " . $e->getMessage());
        } finally {
            if (isset($conn)) {
                $conn->close();
            }
        }
}

public static function softDeletePromotion(Promotion $promo): void
{
    try {
        $conn = new mysqli(servername, username, password, dbName);
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("UPDATE promotion
                                        SET dateDeleted = ?
                                        WHERE id = ? AND dateDeleted IS NULL");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $today = (new DateTimeImmutable('today'))->format('Y-m-d');
        $promoId = $promo->getId();
        $stmt->bind_param("si",$today,$promoId);
        $stmt->execute();
        if ($stmt->affected_rows === 0) {
            throw new Exception("La promoción no existe o ya fue eliminada.");
        }
        $stmt->close();
        $promo->setDateDeleted(new DateTimeImmutable('today'));
    } catch (Exception $e) {
        throw new Exception(
            "Error al eliminar lógicamente la promoción: " . $e->getMessage());
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}

}
?>