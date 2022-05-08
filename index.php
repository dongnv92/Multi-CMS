<?php
require_once 'init.php';
$setting    = $database->select('setting_value')->from('dong_setting')->where('setting_key', 'logo')->fetch_first();
print_r($setting);
//require_once 'content/theme/'. CONFIG_THEME .'/index.php';