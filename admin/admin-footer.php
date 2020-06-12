</div>
</section>
<!--End Content-->
<!-- Jquery Core Js -->
<script src="<?=URL_ADMIN?>/assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?=URL_ADMIN?>/assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?=URL_ADMIN?>/assets/bundles/mainscripts.bundle.js"></script>
<script src="<?=URL_ADMIN?>/assets/js/init.js"></script>
<?php
foreach ($header['js'] AS $js){
    echo '<script src="'. $js .'"></script>'."\n";
}
?>
<!--<script src="<?/*=_URL_CPANEL*/?>/assets/js/init.js"></script>
--></body>
</html>