</div>
</section>
<!--End Content-->
<!-- Jquery Core Js -->
<script src="<?=URL_ADMIN_ASSETS?>bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?=URL_ADMIN_ASSETS?>bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?=URL_ADMIN_ASSETS?>bundles/mainscripts.bundle.js"></script>
<?php
foreach ($header['js'] AS $js){
    echo '<script src="'. $js .'"></script>'."\n";
}
?>
</body>
</html>