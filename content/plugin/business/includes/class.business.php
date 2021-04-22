<?php
class pBusiness{
    private $table_report           = 'dong_business_report';
    private $report_id              = 'report_id';
    private $report_company_name    = 'report_company_name';
    private $report_company_address = 'report_company_address';
    private $report_company_email   = 'report_company_email';
    private $report_contact_phone   = 'report_contact_phone';
    private $report_contact_name    = 'report_contact_name';
    private $report_shipping_needs  = 'report_shipping_needs';
    private $report_using_company   = 'report_using_company';
    private $report_customer_need   = 'report_customer_need';
    private $report_approach        = 'report_approach';
    private $report_feedback        = 'report_feedback';
    private $report_customer_type   = 'report_customer_type';
    private $report_note            = 'report_note';
    private $report_user            = 'report_user';
    private $report_time            = 'report_time';

    public function __construct(){
    }

    public function getMyReport(){
        global $database, $me;

        $param      = get_param_defaul();
        $page       = $param['page'];
        $limit      = $param['limit'];
        $offset     = $param['offset'];
        $where      = [];
        $where[$this->report_user] = $me['user_id'];
        $pagination = [];

        // Tính tổng data
        $database->select('COUNT(*) AS count_data')->from($this->table_report);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [
                $this->report_company_name,
                $this->report_company_address,
                $this->report_company_email,
                $this->report_contact_phone,
                $this->report_contact_name,
                $this->report_using_company,
                $this->report_feedback,
                $this->report_note
            ]));
        }
        if($where){
            $database->where($where);
        }
        $data_count                 = $database->fetch_first();
        $pagination['count']        = $data_count['count_data'];                    // Tổng số bản ghi
        $pagination['page_num']     = ceil($pagination['count'] / $limit);   // Tổng số trang
        $pagination['page_start']   = ($page - 1) * $limit;                        // Bắt đầu từ số bản ghi này

        // Nếu số trang hiện tại lớn hơn tổng số trang thì bào lỗi
        if(($page - 1) > $pagination['page_num'] || $offset > $pagination['count'])
            return get_response_array(311, 'Số trang không được lớn hơn số dữ liệu có.');

        // Hiển thị dữ liệu theo số liệu nhập vào
        $database->select('*')->from($this->table_report);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [
                $this->report_company_name,
                $this->report_company_address,
                $this->report_company_email,
                $this->report_contact_phone,
                $this->report_contact_name,
                $this->report_using_company,
                $this->report_feedback,
                $this->report_note
            ]));
        }
        if($where){
            $database->where($where);
        }
        $database->limit($limit, ($page > 1 ? $pagination['page_start'] : $offset));
        if($_REQUEST['sort']){
            $sort = explode('.',$_REQUEST['sort']);
            if(count($sort) == 1){
                $database->order_by($sort[0]);
            }else if(count($sort) == 2 && in_array($sort[1], ['asc', 'ASC', 'desc', 'DESC'])){
                $database->order_by($sort[0], $sort[1]);
            }
        }else{
            $database->order_by($this->report_id, 'desc');
        }
        $data = $database->fetch();
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

    public function listCustomerNeedOption($default_option = '', $type = ''){
        $list = [];
        if(is_array($default_option) && count($default_option)){
            $list['0'] = $default_option[0];
        }
        $list['vehicle']        = 'Bộ';
        $list['fly']            = 'Bay';
        $list['vehicle_fly']    = 'Bộ, Bay';
        $list['other']          = 'Khác';
        return !$type ? $list : $list[$type];
    }

    public function listApproachOption($default_option = ''){
        $list = [];
        if(is_array($default_option) && count($default_option)){
            $list['0'] = $default_option[0];
        }
        $list['direct']         = 'Gặp trực tiếp';
        $list['telesale']       = 'Telssale';
        $list['other']          = 'Khác';
        return $list;
    }

    public function listCustomerTypeOption($default_option = ''){
        $list = [];
        if(is_array($default_option) && count($default_option)){
            $list['0'] = $default_option[0];
        }
        $list['old']    = 'Khách hàng cũ';
        $list['new']    = 'Khách hàng mới';
        $list['other']  = 'Khác';
        return $list;
    }

    public function add(){
        global $database, $me;

        if(!$_REQUEST[$this->report_company_name]){
            return get_response_array(309, 'Bạn cần nhập tên công ty liên hệ.');
        }

        if(!$_REQUEST[$this->report_contact_phone]){
            return get_response_array(309, 'Bạn cần nhập số điện thoại của Khách Hàng.');
        }

        $data = [
            $this->report_company_name => $database->escape($_REQUEST[$this->report_company_name]),
            $this->report_company_address => $database->escape($_REQUEST[$this->report_company_address]),
            $this->report_company_email => $database->escape($_REQUEST[$this->report_company_email]),
            $this->report_contact_phone => $database->escape($_REQUEST[$this->report_contact_phone]),
            $this->report_contact_name => $database->escape($_REQUEST[$this->report_contact_name]),
            $this->report_shipping_needs => $database->escape($_REQUEST[$this->report_shipping_needs]),
            $this->report_using_company => $database->escape($_REQUEST[$this->report_using_company]),
            $this->report_customer_need => $database->escape($_REQUEST[$this->report_customer_need]),
            $this->report_approach => $database->escape($_REQUEST[$this->report_approach]),
            $this->report_feedback => $database->escape($_REQUEST[$this->report_feedback]),
            $this->report_customer_type => $database->escape($_REQUEST[$this->report_customer_type]),
            $this->report_note => $database->escape($_REQUEST[$this->report_note]),
            $this->report_user => $me['user_id'],
            $this->report_time => get_date_time(),
        ];
        $action = $database->insert($this->table_report, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Thêm dữ liệu thành công', 'data' => $action];
    }
}