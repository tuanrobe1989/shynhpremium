<?php
/**
 * @package WordPress
 * @subpackage shynhpremium-dev-team
 * @since version 1.0
 */
global $home_id;
?><!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head() ?>
</head>

<body <?php body_class() ?>><span class="toppoint"></span>
<header class="header header__normal animate__animated animate__fadeIn">
    <div class="container">
        <a href="<?php bloginfo('home') ?>" title="<?php bloginfo('name') ?>" class="header__logo">
            <img src="<?php echo imageEncode('/images/icon-shynh-premium.png') ?>" width="180" height="150" alt="<?php bloginfo('name') ?>" title="<?php bloginfo('name') ?>"/>
        </a>
        <span class="header__menutab">
            <span></span>
        </span>
        <span class="header__search">
            <img src="<?php echo imageEncode('/images/icon-search.png') ?>" alt="" title=""/>
        </span>
        <?php 
            wp_nav_menu(
                array(
                    'menu'              =>  2,
                    'menu_class'        => 'header__menu',
                    'container_class'   =>  'header__menuround',
                )
            );
        ?>
    </div>
</header>