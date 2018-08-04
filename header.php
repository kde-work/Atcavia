<!DOCTYPE html>
<!--[if lt IE 8]>		<html class="no-js lt-ie9 lt-ie8" dir="ltr" lang="<?php echo __t( 'ru-RU', 'en-EN' ); ?>"> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" dir="ltr" lang="<?php echo __t( 'ru-RU', 'en-EN' ); ?>"> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" dir="ltr" lang="<?php echo __t( 'ru-RU', 'en-EN' ); ?>"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
</head>
<?php
$classes = array(__t( 'ru', 'en' ));
?>
<body <?php body_class($classes); ?>>

<div class="layout header">
    <div class="layout__box">
        <div class="header__left">
            <div class="header__hamburger hamburger hamburger--menu mobile" data-id="open"></div>
            <div class="header__logo"></div>
        </div>
        <div class="header__right">
            <div class="header__menu"><?php wp_nav_menu(
                array(
	                'container' => false,
	                'item_spacing' => 'discard',
                    'menu' => ___( 'Header Menu' )
                    )
                ); ?></div><div class="header__track track">
                <a class="header__track-link mobile" href="<?php echo get_the_permalink( 211 ); ?>"><?php echo __t( 'Трекинг AWB', 'AWB Tracking' ); ?></a>
                <form action="" class="header__track-form desktop">
                    <label for="header__track" class="track__label"><?php echo __t( 'Трекинг AWB:', 'AWB Tracking:' ); ?></label><input id="header__track" type="text" class="track__input input--track" placeholder="000-00000000" autocomplete="off"><input type="submit" class="track__submit" value="">
                </form>
            </div><div class="header__language language">
                <div class="language__item language__item--en <?php echo ( atc_is_en() )? 'language__item--active' : ''; ?>" data-id="en">
                    <div class="language__ico language__ico--en"></div>
                    <div class="language__title">en</div>
                </div><div class="language__item language__item--ru <?php echo ( atc_is_ru() )? 'language__item--active' : ''; ?>" data-id="ru">
                    <div class="language__ico language__ico--ru"></div>
                    <div class="language__title">ру</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="layout top-menu">
    <div class="layout__box top-menu__box">
        <div class="top-menu__hamburger hamburger hamburger--close mobile" data-id="close"></div>
        <div class="top-menu__menu"><?php wp_nav_menu(
		        array(
			        'container' => false,
			        'item_spacing' => 'discard',
                    'menu' => ___( 'Top Menu' )
		        )
	        ); ?></div>
        <div class="top-menu__search top-search">
            <div class="top-search__ico"></div>
        </div>
        <div class="top-menu__btn scroll-btn">
            <div class="btn btn--light-blue btn--medium btn--linked" data-linked="1" data-top="67"><?php
	            echo __t( 'Связаться&nbsp;с&nbsp;нами', 'Contact&nbsp;With&nbsp;Us' );
	            ?></div>
        </div>
    </div>
</div>
<div class="page-content-p">
    <div class="page-content">
