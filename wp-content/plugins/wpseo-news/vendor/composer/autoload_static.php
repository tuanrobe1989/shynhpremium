<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3a9c372df5d1beaa93769135da770d43
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'WPSEO_News' => __DIR__ . '/../..' . '/classes/wpseo-news.php',
        'WPSEO_News_Admin_Page' => __DIR__ . '/../..' . '/classes/admin-page.php',
        'WPSEO_News_Editor_Changes_Alert' => __DIR__ . '/../..' . '/classes/integrations/editor-changes-alert.php',
        'WPSEO_News_Excludable_Taxonomies' => __DIR__ . '/../..' . '/classes/excludable-taxonomies.php',
        'WPSEO_News_Googlebot_News_Presenter' => __DIR__ . '/../..' . '/classes/googlebot-news-presenter.php',
        'WPSEO_News_Head' => __DIR__ . '/../..' . '/classes/head.php',
        'WPSEO_News_Javascript_Strings' => __DIR__ . '/../..' . '/classes/javascript-strings.php',
        'WPSEO_News_Meta_Box' => __DIR__ . '/../..' . '/classes/meta-box.php',
        'WPSEO_News_Option' => __DIR__ . '/../..' . '/classes/option.php',
        'WPSEO_News_Product' => __DIR__ . '/../..' . '/classes/product.php',
        'WPSEO_News_Schema' => __DIR__ . '/../..' . '/classes/schema.php',
        'WPSEO_News_Settings_Genre_Removal_Alert' => __DIR__ . '/../..' . '/classes/integrations/settings-genre-removal-alert.php',
        'WPSEO_News_Sitemap' => __DIR__ . '/../..' . '/classes/sitemap.php',
        'WPSEO_News_Sitemap_Images' => __DIR__ . '/../..' . '/classes/sitemap-images.php',
        'WPSEO_News_Sitemap_Item' => __DIR__ . '/../..' . '/classes/sitemap-item.php',
        'WPSEO_News_Upgrade_Manager' => __DIR__ . '/../..' . '/classes/upgrade-manager.php',
        'Yoast_I18n_WordPressOrg_v3' => __DIR__ . '/..' . '/yoast/i18n-module/src/i18n-wordpressorg-v3.php',
        'Yoast_I18n_v3' => __DIR__ . '/..' . '/yoast/i18n-module/src/i18n-v3.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit3a9c372df5d1beaa93769135da770d43::$classMap;

        }, null, ClassLoader::class);
    }
}
