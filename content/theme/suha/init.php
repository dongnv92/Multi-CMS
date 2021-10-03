<?php
const PATH_ASSET    = URL_HOME . '/' . PATH_THEME . '/' . CONFIG_THEME . '/assets';
const URL_CATEGORY  = URL_HOME . '/category';
const URL_PRODUCT   = URL_HOME . '/product';
const URL_CART      = URL_HOME . '/cart.html';
const URL_CHECKOUT  = URL_HOME . '/checkout.html';
const URL_CHECKOUT_PAYMENT  = URL_HOME . '/checkout-payment.html';
const URL_PAYMENT_MOMO      = URL_HOME . '/payment-momo.html';
const URL_PAYMENT           = URL_HOME . '/payment';
require_once(ABSPATH . '/content/theme/suha/includes/function.php');
$account = new pAccount();
$account->transaction_refresh();