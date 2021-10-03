<?php
class MomoAccount{
    private $table_account      = 'dong_momo_account';
    private $table_history      = 'dong_momo_history';
    private $table_account_rows = [
        'account_id'                => 'account_id',
        'account_user'              => 'account_user',
        'account_phone'             => 'account_phone',
        'account_password'          => 'account_password',
        'account_name'              => 'account_name',
        'account_imei'              => 'account_imei',
        'account_aaid'              => 'account_aaid',
        'account_token'             => 'account_token',
        'account_ohash'             => 'account_ohash',
        'account_secureid'          => 'account_secureid',
        'account_rkey'              => 'account_rkey',
        'account_rowcardId'         => 'account_rowcardId',
        'account_authorization'     => 'account_authorization',
        'account_agent_id'          => 'account_agent_id',
        'account_setupkey_decrypt'  => 'account_setupkey_decrypt',
        'account_setupkey'          => 'account_setupkey',
        'account_sessionkey'        => 'account_sessionkey',
        'account_rsa_public_key'    => 'account_rsa_public_key',
        'account_balance'           => 'account_balance',
        'account_last_update'       => 'account_last_update',
        'account_status'            => 'account_status',
        'account_device'            => 'account_device',
        'account_hardware'          => 'account_hardware',
        'account_facture'           => 'account_facture',
        'account_model_id'          => 'account_model_id',
        'account_create'            => 'account_create'
    ];
    private $table_history_rows = [
        'history_id'                => 'history_id',
        'history_tran_phone'        => 'history_tran_phone',
        'history_tran_id'           => 'history_tran_id',
        'history_tran_action'       => 'history_tran_action',
        'history_tran_partner_id'   => 'history_tran_partner_id',
        'history_tran_partner_name' => 'history_tran_partner_name',
        'history_tran_amount'       => 'history_tran_amount',
        'history_tran_desc'         => 'history_tran_desc',
        'history_tran_comment'      => 'history_tran_comment',
        'history_tran_status'       => 'history_tran_status',
        'history_tran_time'         => 'history_tran_time',
        'history_status'            => 'history_status',
        'history_user'              => 'history_user',
        'history_create'            => 'history_create'
    ];

    public function __construct(){
    }

    // Lấy danh sách tài khoản của mình tạo
    public function getListAccount(){
        global $database, $me;
        $where = [$this->table_account_rows['account_user'] => $me['user_id']];
        if(in_array($_REQUEST['account_status'], ['active', 'inactive'])){
            $where[$this->table_account_rows['account_status']] = $_REQUEST['account_status'];
        }
        $database->select()->from($this->table_account);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [$this->table_account_rows['account_phone']]));
        }
        $database->where($where);
        $data = $database->fetch();
        if(!$data){
            return false;
        }
        return $data;
    }

    // Xóa tài khoản
    public function deleteAccount($account_id){
        global $database;
        $check = $database->select('COUNT(*) AS count')->from($this->table_account)->where($this->table_account_rows['account_id'], $account_id)->fetch_first();
        if($check['count'] == 0){
            return get_response_array(204, 'Tài khoản không tồn tại');
        }
        $action = $database->delete()->from($this->table_account)->where($this->table_account_rows['account_id'], $account_id)->limit(1)->execute();
        if(!$action){
            return get_response_array(309, 'Lỗi không xóa được.');
        }
        return get_response_array(200, 'Xóa tài khoản thành công.');
    }

    // Hiển thị trạng thái
    function viewStatus($status){
        $text = '';
        switch ($status){
            case 'active':
                $text .= '<span class="label label-lg label-light-success label-inline">Hoạt động</span>';
                break;
            case 'inactive':
                $text .= '<span class="label label-lg label-light-danger label-inline">Không hoạt động</span>';
                break;
        }
        return $text;
    }

    // Kiểm tra tính hợp lệ số điện thoại
    function checkPhoneNumber($phone){
        $phone = str_replace([' ', '-', ' -', '- ', ' - ', '.'], '', $phone);
        if (!preg_match('/^0[0-9]{9}$/', $phone)) return false;
        $carriers_number = [
            '096' => 'Viettel',
            '097' => 'Viettel',
            '098' => 'Viettel',
            '032' => 'Viettel',
            '033' => 'Viettel',
            '034' => 'Viettel',
            '035' => 'Viettel',
            '036' => 'Viettel',
            '037' => 'Viettel',
            '038' => 'Viettel',
            '039' => 'Viettel',
            '090' => 'Mobifone',
            '093' => 'Mobifone',
            '070' => 'Mobifone',
            '071' => 'Mobifone',
            '072' => 'Mobifone',
            '076' => 'Mobifone',
            '078' => 'Mobifone',
            '091' => 'Vinaphone',
            '094' => 'Vinaphone',
            '083' => 'Vinaphone',
            '084' => 'Vinaphone',
            '085' => 'Vinaphone',
            '087' => 'Vinaphone',
            '089' => 'Vinaphone',
            '099' => 'Gmobile',
            '092' => 'Vietnamobile',
            '056' => 'Vietnamobile',
            '058' => 'Vietnamobile',
            '095'  => 'SFone'
        ];
        if(!array_key_exists(substr($phone, 0, 3), $carriers_number)) return false;
        return [
            'phone_number'  => $phone,
            'carriers'      => $carriers_number[substr($phone, 0, 3)]
        ];
    }

    // Kiểm tra xem User ID và Phone có hợp lệ không
    public function checkPhoneByUserId($phone, $user_id){
        global $database;
        $data = $database->select($this->table_account_rows['account_user'])->from($this->table_account)->where($this->table_account_rows['account_phone'], $phone)->fetch_first();
        if(!$data || $data[$this->table_account_rows['account_user']] != $user_id){
            return false;
        }
        return true;
    }

    // Đồng bộ giao dịch từ Momo vào Database
    public function syncHistory($momo_history, $user_id){
        global $database;
        if(!is_array($momo_history)){
            return false;
        }
        foreach ($momo_history AS $history){
            if(!$this->checkTran($history['tranId'])){
                $history_tran_time = substr($history['finishTime'], 0, 10);
                $history_tran_time = date('Y-m-d H:i:s', $history_tran_time);
                $data_add = [
                    $this->table_history_rows['history_tran_phone']         => $history['user'],
                    $this->table_history_rows['history_tran_id']            => $history['tranId'],
                    $this->table_history_rows['history_tran_action']        => ($history['io'] == 1 ? 'receive' : 'send'),
                    $this->table_history_rows['history_tran_partner_id']    => $history['partnerId'],
                    $this->table_history_rows['history_tran_partner_name']  => $history['partnerName'],
                    $this->table_history_rows['history_tran_amount']        => $history['amount'],
                    $this->table_history_rows['history_tran_desc']          => $history['desc'],
                    $this->table_history_rows['history_tran_comment']       => $history['comment'],
                    $this->table_history_rows['history_tran_status']        => $history['status'],
                    $this->table_history_rows['history_tran_time']          => $history_tran_time,
                    $this->table_history_rows['history_status']             => $this->processTranComment($history['comment']),
                    $this->table_history_rows['history_user']               => $user_id,
                    $this->table_history_rows['history_create']             => date('Y-m-d H:i:s', time())
                ];
                $database->insert($this->table_history, $data_add);
            }
        }
        return true;
    }

    // Kiểm tra xem mã giao dịch đã có chưa?
    private function checkTran($tran_id){
        global $database;
        $check = $database->select('COUNT(*) AS count')->from($this->table_history)->where([$this->table_history_rows['history_tran_id'] => $tran_id])->fetch_first();
        if($check['count'] > 0){
            return true;
        }
        return false;
    }

    // Function xử lý comment khi khách gửi tiền
    private function processTranComment($comment){
        switch ($comment){
            default:
                $status = 'done';
                break;
        }
        return $status;
    }

    // Lấy danh sách lịch sử giao dịch qua phone
    public function getHistoryByPhone($phone, $limit = 50){
        global $database;
        if(!validate_int($limit) || $limit < 1 || $limit > 1000){
            $limit = 50;
        }
        $where = [$this->table_history_rows['history_tran_phone'] => $phone];
        $database->select()->from($this->table_history);
        $database->where($where);
        $database->order_by($this->table_history_rows['history_id'], 'DESC');
        $database->limit($limit);
        $data = $database->fetch();
        return $data;
    }

    // Lấy toàn bộ lịch sử giao dịch của User
    public function getHistoryByUser(){
        global $database, $me;

        if(!$me){
            return false;
        }

        $param      = get_param_defaul();
        $page       = $param['page'];
        $limit      = $param['limit'];
        $offset     = $param['offset'];
        $where      = [$this->table_history_rows['history_user'] => $me['user_id']];
        $pagination = [];

        // Lọc theo số điện thoại
        if($_REQUEST[$this->table_history_rows['history_tran_phone']]){
            $where[$this->table_history_rows['history_tran_phone']] = $_REQUEST[$this->table_history_rows['history_tran_phone']];
        }

        // Lọc theo kiểu giao dịch
        if($_REQUEST[$this->table_history_rows['history_tran_action']]){
            $where[$this->table_history_rows['history_tran_action']] = $_REQUEST[$this->table_history_rows['history_tran_action']];
        }

        // Tính tổng data
        $database->select('COUNT(*) AS count_data')->from($this->table_history);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [
                $this->table_history_rows['history_tran_id'],
                $this->table_history_rows['history_tran_partner_id'],
                $this->table_history_rows['history_tran_partner_name'],
                $this->table_history_rows['history_tran_amount'],
                $this->table_history_rows['history_tran_comment']
            ]));
        }
        if($where){
            $database->where($where);
        }

        if($_REQUEST['time_start'] && $_REQUEST['time_end'] && validateDate($_REQUEST['time_start'], 'd-m-Y') && validateDate($_REQUEST['time_end'], 'd-m-Y')){
            $database->between($this->table_history_rows['history_tran_time'], date('Y-m-d 00:00:00', strtotime($_REQUEST['time_start'])), date('Y-m-d 23:59:59', strtotime($_REQUEST['time_end'])));
        }

        $data_count                 = $database->fetch_first();
        $pagination['count']        = $data_count['count_data'];                    // Tổng số bản ghi
        $pagination['page_num']     = ceil($pagination['count'] / $limit);   // Tổng số trang
        $pagination['page_start']   = ($page - 1) * $limit;                        // Bắt đầu từ số bản ghi này

        // Nếu số trang hiện tại lớn hơn tổng số trang thì bào lỗi
        if(($page - 1) > $pagination['page_num'] || $offset > $pagination['count'])
            return get_response_array(311, 'Số trang không được lớn hơn số dữ liệu có.');

        // Hiển thị dữ liệu theo số liệu nhập vào
        $database->select('*')->from($this->table_history);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [
                $this->table_history_rows['history_tran_id'],
                $this->table_history_rows['history_tran_partner_id'],
                $this->table_history_rows['history_tran_partner_name'],
                $this->table_history_rows['history_tran_amount'],
                $this->table_history_rows['history_tran_comment']
            ]));
        }
        if($where){
            $database->where($where);
        }

        if($_REQUEST['time_start'] && $_REQUEST['time_end'] && validateDate($_REQUEST['time_start'], 'd-m-Y') && validateDate($_REQUEST['time_end'], 'd-m-Y')){
            $database->between($this->table_history_rows['history_tran_time'], date('Y-m-d 00:00:00', strtotime($_REQUEST['time_start'])), date('Y-m-d 23:59:59', strtotime($_REQUEST['time_end'])));
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
            $database->order_by($this->table_history_rows['history_id'], 'DESC');
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

    // Lấy lịch sử giao dịch cho thanh toán tự động
    public function getHistoryByPayment($date_start, $date_end, $content, $money = ''){
        global $database;
        if(!validateDate($date_start, 'Y-m-d H:i:s') || !validateDate($date_end, 'Y-m-d H:i:s')){
            return get_response_array(309, 'Thời gian không hợp lệ');
        }
        $where = [
            $this->table_history_rows['history_tran_comment']   => $content,
            $this->table_history_rows['history_tran_status']    => '999',
            $this->table_history_rows['history_tran_action']    => 'receive'
        ];
        if($money && validate_int($money) && $money > 0){
            $where[$this->table_history_rows['history_tran_amount']] = $money;
        }
        $database->select()->from($this->table_history);
        $database->where($where);
        $database->between($this->table_history_rows['history_tran_time'], $date_start, $date_end);
        $database->order_by($this->table_history_rows['history_id'], 'DESC');
        $data = $database->fetch_first();
        if(!$data){
            return ['response' => '309', 'message' => 'Chưa có thanh toán nào', 'data' => $_REQUEST];
        }
        return [
            'response'  => 200,
            'message'   => 'Lấy dữ liệu thành công.',
            'data'      => $data
        ];
    }

    // Lấy danh sách số điện thoại theo user
    public function getListPhoneByUser(){
        global $database, $me;
        if(!$me){
            return false;
        }
        $data = [];
        $lists = $database->select($this->table_account_rows['account_phone'])->from($this->table_account)->where($this->table_account_rows['account_user'], $me['user_id'])->fetch();
        foreach ($lists AS $list){
            $data[] = $list[$this->table_account_rows['account_phone']];
        }
        return $data;
    }

    // Lấy thông tin tài khoản
    public function getAccount($phone){
        global $database;
        $data = $database->select("{$this->table_account_rows['account_balance']}, {$this->table_account_rows['account_last_update']}, {$this->table_account_rows['account_status']}")->from($this->table_account)->where($this->table_account_rows['account_phone'], $phone)->fetch_first();
        return $data;
    }
}