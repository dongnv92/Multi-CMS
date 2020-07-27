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
    const customer_last_update      = 'customer_last_update';

    const customer_type_value       = ['customer', 'partner'];
    const customer_status_value     = ['active', 'not_active'];

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

    public function delete($id){
        $db     = $this->db;
        if(!$this->check_customer([self::customer_id => $id, self::customer_type => $this->type])){
            return get_response_array(309, 'Dữ liệu không tồn tại hoặc đã bị xóa khỏi hệ thống.');
        }
        $delete = $db->delete()->from(self::table)->where([self::customer_id => $id, self::customer_type => $this->type])->limit(1)->execute();
        if(!$delete){
            return get_response_array(208, 'Xóa dữ liệu không thành công!');
        }
        return get_response_array(200, 'Xóa dữ liệu thành công!');
    }

    // Lấy danh sách tất cả thành viên
    public function get_all(){
        $db         = $this->db;
        $param      = get_param_defaul();
        $page       = $param['page'];
        $limit      = $param['limit'];
        $offset     = $param['offset'];
        $where      = [];
        $pagination = [];

        // Tính tổng data
        $db->select('COUNT(*) AS count_data')->from(self::table);
        if($_REQUEST['search']){
            $db->where(get_query_search($_REQUEST['search'], [self::customer_code, self::customer_name, self::customer_phone, self::customer_address, self::customer_email]));
        }
        if($where){
            $db->where($where);
        }
        $data_count                 = $db->fetch_first();
        $pagination['count']        = $data_count['count_data'];                    // Tổng số bản ghi
        $pagination['page_num']     = ceil($pagination['count'] / $limit);   // Tổng số trang
        $pagination['page_start']   = ($page - 1) * $limit;                        // Bắt đầu từ số bản ghi này

        // Nếu số trang hiện tại lớn hơn tổng số trang thì bào lỗi
        if(($page - 1) > $pagination['page_num'] || $offset > $pagination['count'])
            return get_response_array(311, 'Số trang không được lớn hơn số dữ liệu có.');

        // Hiển thị dữ liệu theo số liệu nhập vào
        $db->select('*')->from(self::table);
        if($_REQUEST['search']){
            $db->where(get_query_search($_REQUEST['search'], [self::customer_code, self::customer_name, self::customer_phone, self::customer_address, self::customer_email]));
        }
        if($where){
            $db->where($where);
        }
        $db->limit($limit, ($page > 1 ? $pagination['page_start'] : $offset));
        if($_REQUEST['sort']){
            $sort = explode('.',$_REQUEST['sort']);
            if(count($sort) == 1){
                $db->order_by($sort[0]);
            }else if(count($sort) == 2 && in_array($sort[1], ['asc', 'ASC', 'desc', 'DESC'])){
                $db->order_by($sort[0], $sort[1]);
            }
        }else{
            $db->order_by(self::customer_id, 'desc');
        }
        $data = $db->fetch();
        $response = [
            'response'  => 200,
            'paging'    => [
                'count_data'    => $pagination['count'],
                'page'          => $pagination['page_num'],
                'page_current'  => $page,
                'limit'         => $limit,
                'offset'        => $page > 1 ? $pagination['page_start'] : $offset
            ],
            'data'      => $data
        ];
        return $response;
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

        if(!in_array($_REQUEST[self::customer_status], self::customer_status_value)){
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

        // Check xem $customer_id có tồn tịa hay không?
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
            if($customer[self::customer_code] != $_REQUEST[self::customer_code] && $this->check_customer([self::customer_code => $_REQUEST[self::customer_code]])){
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

        if(!in_array($_REQUEST[self::customer_status], self::customer_status_value)){
            $_REQUEST[self::customer_status] = 'not_active';
        }

        $data = [
            self::customer_type         => $this->type,
            self::customer_code         => $db->escape($_REQUEST[self::customer_code]),
            self::customer_name         => $db->escape($_REQUEST[self::customer_name]),
            self::customer_phone        => $db->escape($_REQUEST[self::customer_phone]),
            self::customer_address      => $db->escape($_REQUEST[self::customer_address]),
            self::customer_email        => $db->escape($_REQUEST[self::customer_email]),
            self::customer_status       => $db->escape($_REQUEST[self::customer_status]),
            self::customer_last_update  => get_date_time()
        ];

        $action = $db->where(self::customer_id, $customer_id)->update(self::table, $data);
        if(!$action){
            return get_response_array(208, "Cập nhật không thành công.");
        }
        return get_response_array(200, "Cập nhật thành công.");
    }
}