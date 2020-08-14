<?php
function encryptDecrypt($data, $key, $mode = 'ENCRYPT'){
    if (strlen($key) < 32) {
        $key = str_pad($key, 32, 'x');
    }
    $key = substr($key, 0, 32);
    $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    if ($mode === 'ENCRYPT') {
        return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));
    }
    else {
        return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}


