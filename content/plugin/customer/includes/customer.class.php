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
        return 'CUS'.time();
    }

    public function add(){
        $db = $this->db;
        global $me;

        // Kiểu khách hàng, đối tác
        if(!$_REQUEST[self::customer_type] || !in_array($_REQUEST[self::customer_type], self::customer_type_value)){
            return get_response_array(309, 'Kiểu dữ liệu {type} không đúng định dạng.');
        }

        // Nếu không có mã thì gọi hàm tạo
        if(!$_REQUEST[self::customer_code]){
            $_REQUEST[self::customer_code] = $this->create_code();
        }

        // Kiểm tra tên khách hàng / đối tác
        if(!$_REQUEST[self::customer_name]){
            return get_response_array(309, 'Cần nhập tên khách hàng / đối tác.');
        }

        // Kiểm tra email
        if($_REQUEST[self::customer_email] && !validate_email($_REQUEST[self::customer_email])){
            return get_response_array(309, 'Email không đúng định dạng.');
        }

    }
}