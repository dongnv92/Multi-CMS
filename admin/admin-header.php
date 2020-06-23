<?php
$header = $header ? $header : ['title' => 'Trang quản trị'];
?>
<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Quản lý dữ liệu">
    <title><?=$header['title']?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?=URL_ADMIN_ASSETS?>images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>plugins/bootstrap/css/bootstrap.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>css/main.css">
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>plugins/bootstrap-select/css/bootstrap-select.css">
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>css/color_skins.css">
    <?php foreach ($header['css'] AS $css){echo '<link rel="stylesheet" href="'. $css .'">'."\n";}?>
</head>
<body class="theme-blush">
<!-- Hiệu ứng tải trang khi đang load -->
<?=admin_page_loader_start()?>

<!-- Thanh Search bar -->
<?=admin_header_search_bar()?>

<!-- Top Bar -->
<?=admin_top_bar()?>

<!-- Left Sidebar -->
<?=admin_left_side_bar()?>

<!-- Main Content -->
<section class="content home">
    <?=$header['breadcrumbs']?$header['breadcrumbs']:''?>
    <div class="container-fluid">