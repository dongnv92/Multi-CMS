<?php
require_once 'init.php';
$logout = new user($database);
$logout->logout();
redirect(URL_ADMIN);