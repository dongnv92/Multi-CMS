<?php
$header = $header ? $header : ['title' => 'Trang quản trị'];
?>
<!DOCTYPE html>
<html lang="vn" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="DONG NGUYEN">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=URL_HOME."/content/assets/images/system/favicon.png"?>">
    <!-- Page Title  -->
    <title><?=$header['title']?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>assets/css/dashlite.css?ver=2.2.0">
    <link id="skin-default" rel="stylesheet" href="<?=URL_ADMIN_ASSETS?>assets/css/theme.css?ver=2.2.0">
    <link rel="stylesheet" type="text/css" href="<?=URL_ADMIN_ASSETS?>assets/css/libs/bootstrap-icons.css">
    <?php foreach ($header['css'] AS $css){echo '<link rel="stylesheet" href="'. $css .'">'."\n";}?>
</head>
<body class="nk-body bg-lighter npc-general has-sidebar ">
<!-- Root -->
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <?=admin_left_side_bar()?>
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <?=admin_main_header()?>
            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
