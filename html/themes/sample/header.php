<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- 共通CSS読み込み -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/css/reset.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/common.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/css/common.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/print.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/css/print.css'); ?>" media="print" />

    <!-- 共通JS読み込み -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.9.1.min.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/js/jquery-1.9.1.min.js'); ?>" type="text/javascript" charset="UTF-8"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/animation.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/js/animation.js'); ?>" type="text/javascript" charset="UTF-8"></script>
    <!-- OGP -->
    <meta property="og:locale" content="ja_JP" />

    <!-- Google Tag Manager -->

    <!-- End Google Tag Manager -->

    <?php if (is_home() && is_front_page()) : ?>
    <?php endif;?>

    <?php
    /*
         if (is_singular('news')) : ?>
    <?php endif;
     */
    ?>


    <!--[if lte IE 8 ]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/js/html5shiv.min.js'); ?>"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/js/selectivizr-min.js'); ?>"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/js/respond.min.js'); ?>"></script>
    <![endif]-->


    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
    <?php wp_head(); ?>
</head>

<body id="top">

    <header>
        <h1>
            <a href="/" class="hover">
                <img src="<?php echo get_template_directory_uri(); ?>/img/pc/common/logo_header.png?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/img/pc/common/logo_header.png'); ?>" alt="" class="pclogo" srcset="<?php echo get_template_directory_uri(); ?>/img/pc/common/retina/logo_header@2x.png?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/wp/wp-content/themes/sample/img/pc/common/retina/logo_header@2x.png'); ?>">
            </a>
        </h1>

        <!-- SP ハンバーガーメニュー -->
        <div class="spMenu spClass">
            <span></span>
            <span></span>
            <span></span>
            <p class="offText">MENU</p>
            <p class="onText">CLOSE</p>
        </div>

        <!-- グローバルナビゲーション -->
        <ul class="nav">
            <!-- TOP -->
            <li class="list">
                <a href="/">
                    <b>TOP</b>
                    <p>トップページ</p>
                </a>
            </li>
        </ul>
    </header>
