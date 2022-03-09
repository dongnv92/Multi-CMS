<?php
$account    = new MomoAccount();
$data       = $account->get_data_widget();
?>
<div class="card card-custom gutter-b">
    <div class="card-body">
        <!--begin: Items-->
        <div class="d-flex align-items-center flex-wrap">
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm"><a href="<?=URL_ADMIN."/momo"?>">TÀI KHOẢN MOMO</a></span>
                    <span class="font-weight-bolder font-size-h5"><?=$data['count_account_active']?> Tài Khoản</span>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">CHUYỂN TIỀN</span>
                    <a href="<?=URL_ADMIN."/momo/send"?>" class="text-primary font-weight-bolder">CHUYỂN</a>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column text-dark-75">
                    <span class="font-weight-bolder font-size-sm">TÀI LIỆU API</span>
                    <a href="<?=URL_ADMIN."/momo/api"?>" class="text-primary font-weight-bolder">XEM</a>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column flex-lg-fill">
                    <span class="text-dark-75 font-weight-bolder font-size-sm">THÊM TÀI KHOẢN</span>
                    <a href="<?=URL_ADMIN."/momo/add"?>" class="text-primary font-weight-bolder">THÊM</a>
                </div>
            </div>
            <!--end: Item-->
            <!--begin: Item-->
            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                <span class="mr-4">
                    <i class="flaticon-chat-1 icon-2x text-muted font-weight-bold"></i>
                </span>
                <div class="d-flex flex-column">
                    <span class="text-dark-75 font-weight-bolder font-size-sm">LỊCH SỬ GIAO DỊCH</span>
                    <a href="<?=URL_ADMIN."/momo/history"?>" class="text-primary font-weight-bolder">XEM</a>
                </div>
            </div>
            <!--end: Item-->
        </div>
    </div>
</div>