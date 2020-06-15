<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';

$menu = get_menu_header_structure();
echo get_menu_header($menu);