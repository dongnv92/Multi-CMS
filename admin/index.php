<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';

if(!$me){
    redirect(URL_LOGIN);
}

require_once 'admin-header.php';

require_once 'admin-footer.php';