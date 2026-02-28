<?php
require_once __DIR__ . "/../structs/shop.class.php";
require_once __DIR__ . "/../structs/user.class.php";
require_once __DIR__ . "/../structs/promotion.class.php";
require_once __DIR__ . "/../structs/shopType.class.php";
require_once __DIR__ . "/../data/promotion.data.php";
require_once __DIR__ . "/../data/user.data.php";
require_once __DIR__ . "/../data/promoUse.data.php";

class PromotionContoller
{
    public static function registerPromotion(Promotion $promo)
    {
        try {
            $dateFrom = $promo->getDateFrom();
            $dateTo = $promo->getDateTo();

            if ($dateTo === null) {
                throw new Exception("La fecha de fin es obligatoria.");
            }

            if ($dateFrom === null) {
                throw new Exception("La fecha de inicio es obligatoria.");
            }

            $now = new DateTime();

            if ($dateTo < $now) {
                throw new Exception("La fecha de fin no puede ser anterior a la fecha actual.");
            }

            if ($dateTo < $dateFrom) {
                throw new Exception("La fecha de fin no puede ser anterior a la fecha de inicio.");
            }

            PromotionData::add($promo);
            return $promo;
        } catch (Exception $e) {
            throw new Exception("Error en el registro de la promocion. " . $e->getMessage());
        }
    }

    //Tiene dos filtros en capa logica no de datos. Se filtra por el tipo de comercio de la promoción y por si esta fue o no utilizado. Si alguno es null no se aplica. 
    //StatusUse puede ser = Usada o Pendiente. Se verifica con isUsed
    //Recibe el $promoName
    public static function getAllUsesByUser(User $user, ShopType|null $tipoLocal = null, string $statusUse = '', string|null $promoText = null)
    {
        $userPromoUses = [];
        $arrayFiltrado = [];
        $arrayFiltrado2 = [];

        try {
            //$user = $_SESSION['user']; //ROMPE LAS CAPAS NOOOO. LAUTARO

            $userPromoUses = PromoUseData::findAllByUser($user);

            if ($statusUse === 'Usada' || $statusUse === 'Pendiente') {
                if ($statusUse === 'Usada') {
                    $s = true;
                } elseif ($statusUse === 'Pendiente') {
                    $s = false;
                }
                $userPromoUses = array_filter(
                    $userPromoUses,
                    fn($promo) => $promo->isUsed() === $s
                );
            }
            if ($tipoLocal !== null && $tipoLocal->getId() !== 0) {
                $userPromoUses = array_filter(
                    $userPromoUses,
                    fn($promo) => $promo->getPromo()?->getShop()?->getShopType()?->getId() === $tipoLocal->getId()
                );
            }
            if ($promoText !== null && $promoText !== '') {
                $userPromoUses = array_filter(
                    $userPromoUses,
                    function ($promo) use ($promoText) {
                        $texto = (string) $promo->getPromo()?->getPromoText();
                        // stripos: Busca coincidencias sin importar mayúsculas/minúsculas
                        // !== false: Significa que encontró el texto en alguna posición
                        return stripos($texto, $promoText) !== false;

            });
            }
        } catch (Exception $e) {
            throw new Exception("Error al buscar las promociones usadas por el usuario " . $e->getMessage());
        }
        return $userPromoUses;
        //return $arrayFiltrado;
    }



    public static function registerPromoUseCode(PromoUse $use)
    {
        try {
            PromoUseData::add($use);
        } catch (Exception $e) {
            throw new Exception("Error en el registro del codigo de uso de la promocion" . $e->getMessage());
        }
        return $use;
    }
    public static function getOne(Promotion $promo)
    {
        try {
            $foundPromo = PromotionData::findById($promo);
        } catch (Exception $e) {
            throw new Exception("No se pudo encontrar la promocion. " . $e->getMessage());
        }
        return $foundPromo;
    }
    public static function getAllPending()
    {
        $pendingPromotions = [];
        try {
            $pendingPromotions = PromotionData::findPending();
        } catch (Exception $e) {
            throw new Exception("Error al buscar las promociones pendientes. " . $e->getMessage());
        }
        return $pendingPromotions;
    }

    //Si no recibe parametros funciona como un getAllPending
    //Recibe un Promotion con Nombre, un ShopType con ID, un UserCategory con Id.
    //Si no se filtra por Promotion, promoText = '', si no se filtra por categoria o tipo, id=0.
    public static function getAllPendingFilter(Promotion $promotion, ShopType $shopType, UserCategory $userCategory)
    {
        $pendingPromotions = [];
        try {
            $pendingPromotions = PromotionData::findPendingFilter($promotion, $shopType, $userCategory);
        } catch (Exception $e) {
            throw new Exception("Error al buscar las promociones pendientes filtrando por nombre comercio, tipo comercio y categoria de usuario. " . $e->getMessage());
        }
        return $pendingPromotions;
    }

    public static function getAllActiveByShop(Shop $shop): array
    {
        try {
            $promotions = PromotionData::findAllByShop($shop);

            $activePromotions = array_filter(
                $promotions,
                fn($promo) => $promo->getStatus() === PromoStatus_enum::Vigente
            );

            return array_values($activePromotions);
        } catch (Exception $e) {
            throw new Exception(
                "Error al buscar las promociones activas del local. " . $e->getMessage()
            );
        }
    }

    public static function getCountPromotionsByShop(Shop $shop): int
    {
        try {
            $cant = PromotionData::findCountRecordsFilterByShop($shop);

            return $cant;
        } catch (Exception $e) {
            throw new Exception(
                "Error al contar la cantidad de registros de las promociones filtradas por comercio " . $e->getMessage()
            );
        }
    }

    public static function getAllByShopPagination(Shop $shop, int|null $pagNumb = null, int $cantPag = 4): array
    {
        try {
            $promotions = PromotionData::findAllByShopPagination($shop, $pagNumb, $cantPag);

            return $promotions;
        } catch (Exception $e) {
            throw new Exception(
                "Error al buscar las promociones del local con paginación. " . $e->getMessage()
            );
        }
    }


    public static function getAllByShop(Shop $shop)
    {
        $activePromotions = [];
        try {
            $activePromotions = PromotionData::findAllByShop($shop);
        } catch (Exception $e) {
            throw new Exception("Error al buscar las promociones del local. " . $e->getMessage());
        }
        return $activePromotions;
    }
    public static function approvePromotion(Promotion $promo): void
    {
        try {
            PromotionData::approvePromotion($promo);
        } catch (Exception $e) {
            throw new Exception(
                "Error al aprobar la promoción. " . $e->getMessage()
            );
        }
    }
    public static function rejectPromotion(Promotion $promo): void
    {
        try {
            PromotionData::rejectPromotion($promo);
        } catch (Exception $e) {
            throw new Exception(
                "Error al rechazar la promoción. " . $e->getMessage()
            );
        }
    }
    public static function deletePromotion(Promotion $promo): void
    {
        try {
            PromotionData::softDeletePromotion($promo);
        } catch (Exception $e) {
            throw new Exception(
                "Error al eliminar la promoción. " . $e->getMessage()
            );
        }
    }

    public static function checkSingleUse(PromoUse $use)
    {
        try {
            $total = PromoUseData::checkSingleUse($use);
            if ($total === 0) {
                return true;
            } else
                return false;
        } catch (Exception $e) {
            throw new Exception(
                "Error verificar uso unico por usuario. " . $e->getMessage()
            );
        }
    }

    //LISTA LAS PROMOCIONES VIGENTES DE TODOS LOS NEGOCIOS Y CATEGORÍAS
    public static function getAll($limit = null)
    {
        $activePromotions = [];
        try {
            $activePromotions = PromotionData::findAll($limit);
        } catch (Exception $e) {
            throw new Exception("Error al buscar todas las promociones Vigentes. " . $e->getMessage());
        }
        return $activePromotions;
    }

    public static function usePromotionCode(string $code)
    {
        $promoUse = PromoUseData::findByCode($code);
        if (!$promoUse) throw new Exception("El código de promoción no es válido.");
        if ($promoUse->wasUsed()) throw new Exception("Este código ya ha sido utilizado.");

        $promo = $promoUse->getPromo();
        $today = new DateTimeImmutable('today');

        if ($promo->getStatus() !== PromoStatus_enum::Vigente) {
            throw new Exception("La promoción no se encuentra vigente o aprobada.");
        }
        if ($promo->getDateTo() < $today) {
            throw new Exception("La promoción ha vencido.");
        }
        $fullPromo = PromotionData::findById($promo);
        $dayOfWeek = strtolower($today->format('l'));
        $validDays = $fullPromo->getValidDays();

        if (!isset($validDays[$dayOfWeek]) || !$validDays[$dayOfWeek]) {
            throw new Exception("La promoción no es válida para el día de hoy.");
        }
        $owner = $_SESSION['user'];
        $promoUse->setOwner($owner);
        PromoUseData::markAsUsed($promoUse);
        $total = PromoUseData::countUsedByUser($promoUse->getUser());
        $user = UserData::findOne($promoUse->getUser());
        $idCategory = $user->getUserCategory();

        if ($total >= 25 and $idCategory != 3) {
            $user->getUserCategory()->setId(3);
            UserData::updateUser($user);
        } elseif ($total >= 10 and $idCategory = 1) {
            $user->getUserCategory()->setId(2);
            UserData::updateUser($user);
        }
        return true;
    }
}
