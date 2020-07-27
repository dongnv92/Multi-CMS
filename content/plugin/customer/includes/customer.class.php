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

    private function check_customer($where){
        $db = $this->db;
        $where[self::customer_type] = $this->type;
        $check = $db->select('COUNT(*) AS count')->from(self::table)->where($where)->fetch_first();
        if($check['count'] > 0){
            return true;
        }
        return false;
    }

    public function get_customer($where, $select = '*'){
        $db                         = $this->db;
        $where[self::customer_type] = $this->type;
        $data                       = $db->select($select)->from(self::table)->where($where)->fetch_first();
        if(!$data){
            return false;
        }
        return ['response' => 200, 'data' => $data];
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
        }else{
            if(strlen($_REQUEST[self::customer_code]) > 20){
                return get_response_array(309, 'Mã code phải dưới 20 ký tự.');
            }
            if($this->check_customer([self::customer_code => $_REQUEST[self::customer_code]])){
                return get_response_array(309, 'Mã code đã tồn tại, vui lòng chọn mã khác.');
            }
        }

        // Kiểm tra tên khách hàng / đối tác
        if(!$_REQUEST[self::customer_name]){
            return get_response_array(309, 'Cần nhập tên khách hàng / đối tác.');
        }

        // Kiểm tra email
        if($_REQUEST[self::customer_email] && !validate_email($_REQUEST[self::customer_email])){
            return get_response_array(309, 'Email không đúng định dạng.');
        }

        if(!$_REQUEST[self::customer_status]){
            $_REQUEST[self::customer_status] = 'active';
        }

        $data_add = [
            self::customer_type     => $this->type,
            self::customer_code     => $db->escape($_REQUEST[self::customer_code]),
            self::customer_name     => $db->escape($_REQUEST[self::customer_name]),
            self::customer_phone    => $db->escape($_REQUEST[self::customer_phone]),
            self::customer_address  => $db->escape($_REQUEST[self::customer_address]),
            self::customer_email    => $db->escape($_REQUEST[self::customer_email]),
            self::customer_user     => $me['user_id'],
            self::customer_status   => $db->escape($_REQUEST[self::customer_status]),
            self::customer_time     => get_date_time()
        ];

        $data_add = $db->insert(self::table, $data_add);
        if(!$data_add){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return get_response_array(200, "Thêm dữ liệu mới thành công.");
    }

    public function update($customer_id){
        $db         = $this->db;
        $customer   = $this->get_customer([self::customer_id => $customer_id, self::customer_type => $this->type]);

        if(!$this->check_customer([self::customer_id => $customer_id, self::customer_type => $this->type])){
            return get_response_array(309, 'Dữ liệu không tồn tại.');
        }

        // Kiểu khách hàng, đối tác
        if(!$_REQUEST[self::customer_type] || !in_array($_REQUEST[self::customer_type], self::customer_type_value)){
            return get_response_array(309, 'Kiểu dữ liệu {type} không đúng định dạng.');
        }

        // Nếu không có mã thì gọi hàm tạo
        if(!$_REQUEST[self::customer_code]){
            $_REQUEST[self::customer_code] = $this->create_code();
        }else{
            if(strlen($_REQUEST[self::customer_code]) > 20){
                return get_response_array(309, 'Mã code phải dưới 20 ký tự.');
            }
            if($this->check_customer([self::customer_code => $_REQUEST[self::customer_code]])){
                return get_response_array(309, 'Mã code đã tồn tại, vui lòng chọn mã khác.');
            }
        }

        // Kiểm tra tên khách hàng / đối tác
        if(!$_REQUEST[self::customer_name]){
            return get_response_array(309, 'Cần nhập tên khách hàng / đối tác.');
        }

        // Kiểm tra email
        if($_REQUEST[self::customer_email] && !validate_email($_REQUEST[self::customer_email])){
            return get_response_array(309, 'Email không đúng định dạng.');
        }

        if(!$_REQUEST[self::customer_status]){
            $_REQUEST[self::customer_status] = 'active';
        }

        $data_add = [
            self::customer_type     => $this->type,
            self::customer_code     => $db->escape($_REQUEST[self::customer_code]),
            self::customer_name     => $db->escape($_REQUEST[self::customer_name]),
            self::customer_phone    => $db->escape($_REQUEST[self::customer_phone]),
            self::customer_address  => $db->escape($_REQUEST[self::customer_address]),
            self::customer_email    => $db->escape($_REQUEST[self::customer_email]),
            self::customer_user     => $me['user_id'],
            self::customer_status   => $db->escape($_REQUEST[self::customer_status]),
            self::customer_time     => get_date_time()
        ];

        $data_add = $db->insert(self::table, $data_add);
        if(!$data_add){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return get_response_array(200, "Thêm dữ liệu mới thành công.");
    }
}