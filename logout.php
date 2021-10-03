<?php
require_once 'init.php';
$user = new user($database);
$user->logout();
redirect(URL_ADMIN);