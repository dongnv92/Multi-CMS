<?php
class Customer{
    private $type, $db;
    const table             = 'dong_customer';
    const customer_id       = 'customer_id';
    const customer_type     = 'customer_type';
    const customer_code     = 'customer_code';
    const customer_name     = 'customer_name';
    const customer_phone    = 'customer_phone';
    const customer_address  = 'customer_address';
    const customer_email    = 'customer_email';
    const customer_user     = 'customer_user';
    const customer_status   = 'customer_status';
    const customer_time     = 'customer_time';

    const customer_type_value   = ['customer', 'partner'];

    public function __construct($database, $type){
        $this->db   = $database;
        $this->type = $type;
    }

    private function create_code(){

    }

    public function add(){
        $db = $this->db;
        global $me;

        if(!$_REQUEST['customer_type'] || !in_array($_REQUEST['customer_type'], self::customer_type_value)){
            return get_response_array(309, 'Kiểu dữ liệu {type} không đúng định dạng.');
        }

    }
}