<?php
require_once 'init.php';

require_once ABSPATH . 'includes/class/class.user.php';
$me = new user($database);
$access_token = 'MzNKeDNpTURwbnNDaVRkUnpjeUxaQT09';
if($me->check_user_by_access_token($access_token)){
    echo 'Ok';
}else{
    echo "Not Ok";
}