                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
            <!-- footer @s -->
            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> &copy; 2021 Copy right <a href="#" target="_blank">Dong Nguyen</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
    </div>
<!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="<?=URL_ADMIN_ASSETS?>assets/js/bundle.js?ver=2.2.0"></script>
<script src="<?=URL_ADMIN_ASSETS?>assets/js/scripts.js?ver=2.2.0"></script>
<?php
foreach ($header['js'] AS $js){
    echo '<script src="'. $js .'"></script>'."\n";
}
?>
</body>
</html>
