<?php
    $header['title'] = $header['title'] ?? 'Mua Tài Khoản - Tài khoản xem ngoại hạng anh, cúp C1';
    $header['description'] = $header['description'] ?? 'Mua tài khoản xem ngoại hạng anh, cúp C1, tài khoản netflix giá rẻ, thanh toán tự động';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="<?=$header['description']?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#100DD1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags-->
    <!-- Title-->
    <title><?=$header['title']?></title>
    <!-- For Facebook -->
    <meta property="og:title" content="<?=$header['title']?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?=URL_HOME . "/content/assets/images/system/kplus.jpeg"?>" />
    <meta property="og:url" content="<?=get_current_url()?>" />
    <meta property="og:description" content="<?=$header['description']?>" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?=URL_HOME."/content/assets/images/system/favicon.ico"?>">
    <!-- Apple Touch Icon-->
<!--    <link rel="apple-touch-icon" href="<?/*=PATH_ASSET*/?>/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?/*=PATH_ASSET*/?>/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="<?/*=PATH_ASSET*/?>/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?/*=PATH_ASSET*/?>/img/icons/icon-180x180.png">-->
    <!-- CSS Libraries-->
    <link rel="stylesheet" href="<?=PATH_ASSET?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=PATH_ASSET?>/css/animate.css">
    <link rel="stylesheet" href="<?=PATH_ASSET?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=PATH_ASSET?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=PATH_ASSET?>/css/default/lineicons.min.css">
    <!-- Stylesheet-->
    <link rel="stylesheet" href="<?=PATH_ASSET?>/css/style.css">
    <?php foreach ($header['css'] AS $css){echo '<link rel="stylesheet" href="'. $css .'">'."\n";}?>
    <!-- Web App Manifest-->
    <link rel="manifest" href="<?=PATH_ASSET?>/manifest.json">
    <meta name="google-site-verification" content="ryDRg_K8KHSWMxoUYw05rvRoX5WIIzIjwMWmFSQOTJA" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0Y2W8Q3HWN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-0Y2W8Q3HWN');
    </script>
</head>
<body>
<!-- Preloader-->
<div class="preloader" id="preloader">
    <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Đang tải...</div>
    </div>
</div>
<!-- Header Area-->
<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper-->
        <div class="logo-wrapper"><a href="<?=URL_HOME?>">
            <img src="<?=get_config('logo')?>" style="max-height: 25px" alt="Logo"></a>
        </div>
        <!-- Search Form-->
        <div class="top-search-form">
            <form action="" method="">
                <input class="form-control" type="search" placeholder="Tìm kiếm">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler">
            <span></span><span></span><span></span>
        </div>
    </div>
</div>
<!-- Sidenav Black Overlay-->
<div class="sidenav-black-overlay"></div>
<!-- Side Nav Wrapper-->
<!--<div class="suha-sidenav-wrapper" id="sidenavWrapper">
    <div class="sidenav-profile">
        <div class="user-profile"><img src="<?/*=PATH_ASSET*/?>/img/bg-img/9.jpg" alt=""></div>
        <div class="user-info">
            <h6 class="user-name mb-0">Suha Jannat</h6>
            <p class="available-balance">Balance <span>$<span class="counter">523.98</span></span></p>
        </div>
    </div>
    <ul class="sidenav-nav ps-0">
        <li><a href="profile.html"><i class="lni lni-user"></i>My Profile</a></li>
        <li><a href="notifications.html"><i class="lni lni-alarm lni-tada-effect"></i>Notifications<span class="ms-3 badge badge-warning">3</span></a></li>
        <li class="suha-dropdown-menu"><a href="#"><i class="lni lni-cart"></i>Shop Pages</a>
            <ul>
                <li><a href="shop-grid.html">- Shop Grid</a></li>
                <li><a href="shop-list.html">- Shop List</a></li>
                <li><a href="single-product.html">- Product Details</a></li>
                <li><a href="featured-products.html">- Featured Products</a></li>
                <li><a href="flash-sale.html">- Flash Sale</a></li>
            </ul>
        </li>
        <li><a href="pages.html"><i class="lni lni-empty-file"></i>All Pages</a></li>
        <li class="suha-dropdown-menu"><a href="wishlist-grid.html"><i class="lni lni-heart"></i>My Wishlist</a>
            <ul>
                <li><a href="wishlist-grid.html">- Wishlist Grid</a></li>
                <li><a href="wishlist-list.html">- Wishlist List</a></li>
            </ul>
        </li>
        <?/*=$me ? '<li><a href="'. URL_ADMIN .'"><i class="lni lni-cog"></i>Admin</a></li>' : ''*/?>
        <li><a href="intro.html"><i class="lni lni-power-switch"></i>Sign Out</a></li>
    </ul>
    <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>
</div>
--><!-- PWA Install Alert-->
<!--<div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
    <div class="toast-body">
        <div class="content d-flex align-items-center mb-2"><img src="<?/*=PATH_ASSET*/?>/img/icons/icon-72x72.png" alt="">
            <h6 class="mb-0">Add to Home Screen</h6>
            <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
        </div><span class="mb-0 d-block">Add Suha on your mobile home screen. Click the<strong class="mx-1">"Add to Home Screen"</strong>button &amp; enjoy it like a regular app.</span>
    </div>
</div>
-->
<div class="page-content-wrapper">