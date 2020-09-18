<?php
require_once 'init.php';

$kplus  = new Kplus($database);
$data   = $kplus->getListChatid();

print_r($data);
