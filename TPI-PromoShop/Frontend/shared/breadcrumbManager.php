<?php

class BreadcrumbManager
{

    /**
     * Define el mapa del sitio: Hijos -> Padres
     */
    private static function getSiteMap()
    {
        return [
            // --- HOME / LANDINGS ---
            // Creo que por logica el index no va
            // 'index.php' => [
            //     'title' => 'Inicio',
            //     'parent' => '' // Raíz absoluta
            // ],

            // --- AUTENTICACIÓN ---
            'loginPage.php' => [
                'title' => 'Iniciar Sesión',
                'parent' => 'index.php'
            ],
            'registerPage.php' => [
                'title' => 'Registrarse',
                'parent' => 'index.php'
            ],
            'passwordRecoveryPage.php' => [
                'title' => 'Recuperar Contraseña',
                'parent' => 'loginPage.php'
            ],
            'passwordChangePage.php' => [ // Asumo que se accede desde el perfil
                'title' => 'Cambiar Contraseña',
                'parent' => 'myProfilePage.php'
            ],

            // --- PERFIL DE USUARIO ---
            'myProfilePage.php' => [
                'title' => 'Mi Perfil',
                'parent' => 'index.php'
            ],
            'myPromotionsPage.php' => [
                'title' => 'Mis Cupones',
                'parent' => 'index.php'
            ],

            // --- LOCALES (SHOPS) ---
            'shopsCardsPage.php' => [
                'title' => 'Listado Locales',
                'parent' => 'index.php'
            ],
            'shopDetailPage.php' => [
                'title' => 'Detalle del Local',
                'parent' => 'shopsCardsPage.php',
                // Lista blanca: Si viene de aquí, respetamos ese camino
                'allowed_parents' => [
                    'index.php',
                    'shopsCardsPage.php'
                ]
            ],
            'newLocalPage.php' => [
                'title' => 'Alta de Local',
                'parent' => 'index.php'
            ],
            'editShopPage.php' => [
                'title' => 'Editar Local',
                'parent' => 'shopDetailPage.php'
            ],

            //Creo que esta función se debería eliminar.... Lautaro. 
            'newShopGalleryPage.php' => [
                'title' => 'Alta de Galeria del Local',
                'parent' => 'index.php'
            ],

            'newShopTypePage.php' => [ // Gestión de categorías (Admin)
                'title' => 'Alta de Tipo',
                'parent' => 'index.php'
            ],

            // --- PROMOCIONES ---
            'allPromotionsPage.php' => [
                'title' => 'Todas las Promociones',
                'parent' => 'index.php'
            ],

            //promociones de un local owner
            'allShopPromotionsPage.php' => [
                'title' => 'Listado de Promociones',
                'parent' => 'index.php'
            ],

            'promoDetailPage.php' => [
                'title' => 'Detalle de Promoción',
                'parent' => 'allPromotionsPage.php', 
                'allowed_parents' => [
                    'index.php',
                    'shopDetailPage.php',
                    'allShopPromotionsPage.php',
                    'myPromotionsPage.php'
                ]
            ],

            'newPromotionPage.php' => [
                'title' => 'Alta de Promoción',
                'parent' => 'index.php'
            ],

            'promoManagementPage.php' => [ // Gestión de promos pendientes (ADMIN)
                'title' => 'Gestión de Promociones',
                'parent' => 'index.php'
            ],

            'promotionValidationPage.php' => [ // Validar cupón
                'title' => 'Validar Promoción',
                'parent' => 'index.php'
            ],

            // --- NOVEDADES (NEWS) ---
            'newsPage.php' => [
                'title' => 'Novedades',
                'parent' => 'index.php'
            ],
            'newsDetailPage.php' => [
                'title' => 'Leer Novedad',
                'parent' => 'newsPage.php'
            ],
            'newNewsPage.php' => [ // Crear noticia (Admin)
                'title' => 'Nueva Novedad',
                'parent' => 'index.php',
                'allowed_parents' => [
                    'index.php',
                    'newsPage.php'
                ]
            ],
            'editNewsPage.php' => [ // Editar noticia
                'title' => 'Editar Novedad',
                'parent' => 'newsPage.php'
            ],

            // --- REPORTES ---
            'adminReportPage.php' => [
                'title' => 'Reportes del Sistema',
                'parent' => 'index.php'
            ],
            'ownerReportPage.php' => [
                'title' => 'Mis Reportes',
                'parent' => 'index.php'
            ],

            // --- INFO Y LEGALES ---
            'infoGeneralPage.php' => [
                'title' => 'Información General',
                'parent' => 'index.php'
            ],

            'MVVPage.php' => [ // Misión Visión Valores
                'title' => 'Misión, Visión y Valores',
                'parent' => 'infoGeneralPage.php'
            ],
            'quienesSomosPage.php' => [
                'title' => 'Quiénes Somos',
                'parent' => 'infoGeneralPage.php'
            ],
            'privacyPage.php' => [
                'title' => 'Política de Privacidad',
                'parent' => 'index.php'
            ],
            'termsPage.php' => [
                'title' => 'Términos y Condiciones',
                'parent' => 'index.php'
            ],
            'siteMapPage.php' => [
                'title' => 'Mapa del Sitio',
                'parent' => 'index.php'
            ],
            'faqPage.php' => [
                'title' => 'Preguntas Frecuentes',
                'parent' => 'index.php'
            ]
        ];
    }

    /**
     * Genera el breadcrumb automáticamente basándose en el archivo actual
     * @param string|null $tituloOverride (Opcional) Para pisar el título genérico (ej: "Promo #45" en vez de "Detalle")
     */
    public static function render($tituloOverride = null)
    {
        // 1. Detectamos el archivo actual (ej: promoDetailPage.php)
        $currentFile = basename($_SERVER['PHP_SELF']);

        //en el index no mostramos el breadcrumb 
        if ($currentFile != 'index.php' && $currentFile !=  'infoGeneralPage.php' && $currentFile != 'MVVPage.php') {
            $map = self::getSiteMap();
            $breadcrumbs = [];

            // De dónde vengo (Referer)
            $refererFull = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            // Limpio el referer para quedarnos solo con el nombre del archivo (ej: "shopDetailPage.php")
            $refererFile = basename(parse_url($refererFull, PHP_URL_PATH));

            // 3. DECISIÓN DEL PADRE INMEDIATO
            $config = $map[$currentFile];
            $parent = $config['parent']; // Empezamos con el default

            // Si tiene padres alternativos permitidos Y el referer coincide con uno...
            if (isset($config['allowed_parents']) && in_array($refererFile, $config['allowed_parents'])) {
                $parent = $refererFile;
            }

            // 4. Construcción del Árbol (Backtracking)
            $breadcrumbs = [];

            // Agregamos la página actual primero
            $breadcrumbs[] = [
                'label' => $tituloOverride ? $tituloOverride : $config['title'],
                'url' => ''
            ];

            // Ahora vamos hacia atrás buscando a los abuelos
            // Nota: El $parent ya fue decidido arriba (o default o referer)
            while ($parent && isset($map[$parent])) {
                $parentConfig = $map[$parent];

                $breadcrumbs[] = [
                    'label' => $parentConfig['title'],
                    'url' => $parent
                ];

                // Saltamos al siguiente padre (el abuelo)
                // OJO: Aquí ya usamos siempre el 'parent' estático del mapa,
                // porque los abuelos no suelen cambiar dinámicamente.
                $parent = $parentConfig['parent'];

                // Romper si llegamos al root para evitar bucles infinitos
                if ($parent == 'index.php') break;
            }


            // Siempre agregamos Inicio al final (porque el array está al revés)
            $breadcrumbs[] = ['label' => 'Inicio', 'url' => 'index.php'];

            // 5. Invertimos el array para imprimirlo en orden correcto (Inicio > ... > Actual)
            $breadcrumbs = array_reverse($breadcrumbs);

            // 6. Renderizar HTML
            self::printHTML($breadcrumbs);
        }
    }

    private static function printHTML($steps)
    {
        echo '<nav  style="--bs-breadcrumb-divider: \' > \';"  aria-label="breadcrumb">';
        echo '<ol class="breadcrumb bg-transparent pt-2  mb-0 pl-md-5  pl-2">';

        foreach ($steps as $step) {
            if (empty($step['url'])) {
                // Página actual (Gris)
                echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($step['label']) . '</li>';
            } else {
                // Padre (Link Naranja)
                echo '<li class="breadcrumb-item"><a href="' . $step['url'] . '" class="text-orange">' . htmlspecialchars($step['label']) . '</a></li>';
            }
        }

        echo '</ol>';
        echo '</nav>';
    }
}
