<?php
require_once 'init.php';

$kplus  = new Kplus($database);
$data   = $kplus->searchCode($_REQUEST['month']);

print_r($data);