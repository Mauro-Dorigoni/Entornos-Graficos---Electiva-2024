<?php
require_once __DIR__ . "/../shared/BD.data.dev.php";
require_once __DIR__ . "/../structs/promoUse.class.php";
require_once __DIR__ . "/../structs/promotion.class.php";
require_once __DIR__ . "/../shared/promoStatus.enum.php";

class PromoUseData
{
    public static function findByCode(string $code): ?PromoUse
    {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) throw new Exception("Error de conexión: " . $conn->connect_error);

            $stmt = $conn->prepare("SELECT pu.id, pu.uniqueCode, pu.wasUsed, pu.idUser, p.id as promo_id, p.promoText, p.dateFrom, p.dateTo, p.status, vpd.monday, vpd.tuesday, vpd.wednesday, vpd.thursday, vpd.friday, vpd.saturday, vpd.sunday
                                    FROM promouse pu 
                                    INNER JOIN promotion p ON pu.idPromo = p.id 
                                    INNER JOIN validpromoday vpd ON p.id = vpd.idPromotion
                                    WHERE pu.uniqueCode = ? AND p.dateDeleted IS NULL");
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $promo = new Promotion();
                $promo->setId((int)$row['promo_id']);
                $promo->setPromoText($row['promoText']);
                $promo->setDateFrom(new DateTimeImmutable($row['dateFrom']));
                $promo->setDateTo(new DateTimeImmutable($row['dateTo']));
                $promo->setStatus(PromoStatus_enum::from($row['status']));
                $promo->setValidDays([
                    'monday'    => (bool)$row['monday'],
                    'tuesday'   => (bool)$row['tuesday'],
                    'wednesday' => (bool)$row['wednesday'],
                    'thursday'  => (bool)$row['thursday'],
                    'friday'    => (bool)$row['friday'],
                    'saturday'  => (bool)$row['saturday'],
                    'sunday'    => (bool)$row['sunday'],
                ]);

                $use = new PromoUse();
                $use->setId((int)$row['id']);
                $use->setUniqueCode($row['uniqueCode']);
                $use->setWasUsed((bool)$row['wasUsed']);
                $use->setPromo($promo);
                $user = new User();
                $user->setId((int)$row['idUser']);
                $use->setUser($user);
                return $use;
            }
            return null;
        } catch (Throwable $e) {
            throw $e;
        } finally {
            if (isset($conn)) $conn->close();
        }
    }

    public static function findAllByUser(User $user): array
    {
        $results = [];
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT pu.id, pu.uniqueCode, pu.wasUsed, pu.useDate, pu.idUser, pu.idOwner, 
                                            p.id AS promo_id, p.promoText, p.dateFrom, p.dateTo, p.status, p.imageUUID,
                                            vpd.monday, vpd.tuesday, vpd.wednesday, vpd.thursday, vpd.friday, vpd.saturday, vpd.sunday,
                                            s.id as shopId, s.name as shopName,
                                            st.id as shopTypeId, st.type as shopTypeName
                                            FROM promouse pu
                                            INNER JOIN promotion p ON pu.idPromo = p.id
                                            INNER JOIN shop s ON s.id = p.idShop
                                            INNER JOIN validpromoday vpd ON p.id = vpd.idPromotion
                                            INNER JOIN shoptype st ON s.idShopType = st.id 
                                            INNER JOIN usercategory u ON u.id = p.idUserCategory
                                            WHERE pu.idUser = ?
                                            AND p.dateDeleted IS NULL
                                            ORDER BY pu.id DESC");
            $userId = $user->getId();
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $promo = new Promotion();
                $promo->setId((int) $row['promo_id']);
                $promo->setPromoText($row['promoText']);
                $promo->setImageUUID($row['imageUUID']);
                $promo->setDateFrom(new DateTimeImmutable($row['dateFrom']));
                $promo->setDateTo(new DateTimeImmutable($row['dateTo']));
                $promo->setStatus(PromoStatus_enum::from($row['status']));
                $promo->setValidDays([
                    'monday'    => (bool) $row['monday'],
                    'tuesday'   => (bool) $row['tuesday'],
                    'wednesday' => (bool) $row['wednesday'],
                    'thursday'  => (bool) $row['thursday'],
                    'friday'    => (bool) $row['friday'],
                    'saturday'  => (bool) $row['saturday'],
                    'sunday'    => (bool) $row['sunday'],
                ]);

                $shop = new Shop();
                $shop->setId((int)$row['shopId']);
                $shop->setName($row['shopName']);

                $shopType = new ShopType();
                $shopType->setId($row['shopTypeId']);
                $shopType->setType($row['shopTypeName']);

                $shop->setShopType($shopType);


                $promo->setShop($shop);
                $use = new PromoUse();
                $use->setId((int) $row['id']);
                $use->setUniqueCode($row['uniqueCode']);
                $use->setWasUsed(
                    $row['wasUsed'] !== null ? (bool) $row['wasUsed'] : null
                );
                $use->setPromo($promo);
                if ($row['useDate'] !== null) {
                    $use->setUseDate(new DateTimeImmutable($row['useDate']));
                }
                $user = new User();
                $user->setId((int) $row['idUser']);
                $use->setUser($user);
                if ($row['idOwner'] !== null) {
                    $owner = new User();
                    $owner->setId((int) $row['idOwner']);
                    $use->setOwner($owner);
                }
                $results[] = $use;
            }
            return $results;
        } catch (Throwable $e) {
            throw $e;
        } finally {
            if (isset($conn)) {
                $conn->close();
            }
        }
    }


    public static function add(PromoUse $use)
    {
        $conn = new mysqli(servername, username, password, dbName);
        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }
        $conn->begin_transaction();
        try {
            $stmtUse = $conn->prepare("INSERT INTO promouse (uniqueCode, idPromo, idUser) values (?,?,?)");
            if (!$stmtUse) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
            $uniqueCode = $use->getUniqueCode();
            $idPromo = $use->getPromo()->getId();
            $idUser = $use->getUser()->getid();
            $stmtUse->bind_param("sii", $uniqueCode, $idPromo, $idUser);
            if (!$stmtUse->execute()) {
                throw new Exception("Error al intentar insertar el pedido de promocion" . $stmtUse->error);
            }
            $conn->commit();
        } catch (Throwable $e) {
            $conn->rollback();
            throw $e;
        } finally {
            $conn->close();
        }
    }

    public static function markAsUsed(PromoUse $use): void
    {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            $stmt = $conn->prepare("UPDATE promouse SET wasUsed = 1, useDate = NOW(), idOwner = ? WHERE id = ?");
            $id = $use->getId();
            $owner = $use->getOwner()->getId();
            $stmt->bind_param("ii", $owner, $id);
            $stmt->execute();
            $stmt->close();
        } finally {
            if (isset($conn)) $conn->close();
        }
    }

    public static function countUsedByUser(User $user): int
    {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) throw new Exception("Error de conexión: " . $conn->connect_error);

            $userId = $user->getId();
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM promouse WHERE idUser = ? AND wasUsed = 1");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            return (int)$row['total'];
        } finally {
            if (isset($conn)) $conn->close();
        }
    }

    public static function checkSingleUse(PromoUse $use): int
    {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) throw new Exception("Error de conexión: " . $conn->connect_error);

            $userId = $use->getUser()->getId();
            $promoId = $use->getPromo()->getId();
            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM promouse WHERE idUser = ? AND idPromo = ?");
            $stmt->bind_param("ii", $userId, $promoId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            return (int)$row['total'];
        } finally {
            if (isset($conn)) $conn->close();
        }
    }
}
