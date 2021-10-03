</div>
<!-- Internet Connection Status-->
<div class="internet-connection-status" id="internetStatus"></div>
<!-- Footer Nav-->
<div class="footer-nav-area" id="footerNav">
    <div class="container h-100 px-0">
        <div class="suha-footer-nav h-100">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li class="active"><a href="<?=URL_HOME?>"><i class="lni lni-home"></i>Trang chủ</a></li>
                <?=($me ? '<li><a href="'. URL_ADMIN .'"><i class="lni lni-display-alt"></i>Quản trị</a></li>' : '')?>
                <li><a href="<?=URL_CART?>"><i class="lni lni-shopping-basket"></i>Giỏ Hàng</a></li>
                <li><a href="<?=URL_HOME . "/settings.html"?>"><i class="lni lni-cog"></i>Cài đặt</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- All JavaScript Files-->
<script src="<?=PATH_ASSET?>/js/bootstrap.bundle.min.js"></script>
<script src="<?=PATH_ASSET?>/js/jquery.min.js"></script>
<script src="<?=PATH_ASSET?>/js/waypoints.min.js"></script>
<script src="<?=PATH_ASSET?>/js/jquery.easing.min.js"></script>
<script src="<?=PATH_ASSET?>/js/owl.carousel.min.js"></script>
<script src="<?=PATH_ASSET?>/js/jquery.counterup.min.js"></script>
<script src="<?=PATH_ASSET?>/js/jquery.countdown.min.js"></script>
<script src="<?=PATH_ASSET?>/js/default/jquery.passwordstrength.js"></script>
<script src="<?=PATH_ASSET?>/js/default/dark-mode-switch.js"></script>
<script src="<?=PATH_ASSET?>/js/default/no-internet.js"></script>
<script src="<?=PATH_ASSET?>/js/default/active.js"></script>
<script src="<?=PATH_ASSET?>/js/pwa.js"></script>
<?php
foreach ($header['js'] AS $js){
    echo '<script src="'. $js .'"></script>'."\n";
}
?>
</body>
</html>
