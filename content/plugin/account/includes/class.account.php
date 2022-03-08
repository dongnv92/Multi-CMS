<?php
class pAccount{
    private $table      = 'dong_account';
    private $table_tran = 'dong_account_transaction';
    private $table_rows = [
        'account_id'            => 'account_id',
        'account_title'         => 'account_title',
        'account_url'           => 'account_url',
        'account_login'         => 'account_login',
        'account_password'      => 'account_password',
        'account_expired'       => 'account_expired',
        'account_category'      => 'account_category',
        'account_package'       => 'account_package',
        'account_price'         => 'account_price',
        'account_price_type'    => 'account_price_type',
        'account_content'       => 'account_content',
        'account_featured'      => 'account_featured',
        'account_display'       => 'account_display',
        'account_view'          => 'account_view',
        'account_status'        => 'account_status',
        'account_user'          => 'account_user',
        'account_create'        => 'account_create'
    ];

    public function __construct(){
    }

    public function transaction_viewstatus($status){
        $text = '';
        switch ($status){
            case 'success':
                $text .= '<span class="label label-square label-success label-inline mr-2">THÀNH CÔNG</span>';
                break;
            case 'wait':
                $text .= '<span class="label label-square label-warning label-inline mr-2">CHỜ THANH TOÁN</span>';
                break;
            case 'false':
                $text .= '<span class="label label-square label-danger label-inline mr-2">THẤT BẠI</span>';
                break;
        }
        return $text;
    }

    public function transaction_getall(){
        global $database, $me;

        $param      = get_param_defaul();
        $page       = (($_REQUEST['page'] && validate_int($_REQUEST['page'])) ? $_REQUEST['page'] : $param['page']);
        $limit      = (($_REQUEST['limit'] && validate_int($_REQUEST['limit'])) ? $_REQUEST['limit'] : $param['limit']);
        $offset     = (($_REQUEST['offset'] && validate_int($_REQUEST['offset'])) ? $_REQUEST['offset'] : $param['offset']);
        $where      = [];
        $pagination = [];


        // Tính tổng data
        $database->select('COUNT(*) AS count_data')->from($this->table_tran);
        if($_REQUEST['search']){
            $data_search = get_query_search($_REQUEST['search'], [
                'transaction_code',
                'transaction_name',
                'transaction_phone',
                'transaction_coupon',
                'transaction_payment_method',
                'transaction_payment_info',
                'transaction_payment_name',
                'transaction_payment_network',
                'transaction_payment_content',
                'transaction_payment_id',
                'transaction_note'
            ]);
            $database->where($data_search);
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
        $database->select('*')->from($this->table_tran);
        if($_REQUEST['search']){
            $data_search = get_query_search($_REQUEST['search'], [
                'transaction_code',
                'transaction_name',
                'transaction_phone',
                'transaction_coupon',
                'transaction_payment_method',
                'transaction_payment_info',
                'transaction_payment_name',
                'transaction_payment_network',
                'transaction_payment_content',
                'transaction_payment_id',
                'transaction_note'
            ]);
            $database->where($data_search);
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
            $database->order_by('transaction_id', 'DESC');
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

    public function change_status_account($account_id, $status){
        global $database;
        if(!in_array($status, ['instock', 'wait_payment', 'outstock'])){
            return false;
        }
        $check = $this->check_account([$this->table_rows['account_id'] => $account_id]);
        if(!$check){
            return false;
        }
        $update = $database->where([$this->table_rows['account_id'] => $account_id])->update($this->table, [$this->table_rows['account_status'] => $status]);
        if(!$update){
            return false;
        }
        return true;
    }
    
    // Làm mới giao dịch
    public function transaction_refresh(){
        global $database;
        // Lấy danh sách các giao dịch đang chờ thanh toán
        $data_wait = $database->select()->from($this->table_tran)->where(['transaction_status' => 'wait'])->fetch();
        if(!$data_wait){
            return false;
        }
        foreach ($data_wait AS $_data_wait){
            // Nếu quá thời gian thanh toán thì update là fail
            if(time() > $_data_wait['transaction_deadline']){
                $database->where(['transaction_id' => $_data_wait['transaction_id']])->update($this->table_tran, ['transaction_status' => 'false', 'transaction_note' => 'Hết thời gian, thanh toán không thành công']);
                $this->change_status_account($_data_wait['transaction_account'], 'instock');
            }
        }
        return true;
    }

    // Thêm 1 transaction mới
    public function transaction_add(){
        global $database, $me, $user;
        $account_amout = ($_REQUEST['accoun_amout'] && validate_int($_REQUEST['accoun_amout']) ? $_REQUEST['accoun_amout'] : 1);
        if(!in_array($_REQUEST['account_method'], ['momo', 'card'])){
            return get_response_array(309, 'Phương thức thanh toán không hợp lệ');
        }
        $database->select('transaction_id, transaction_status, transaction_deadline')->from($this->table_tran);
        $database->where(['transaction_account' => $_REQUEST['account_id']]);
        $database->order_by('transaction_id', 'DESC');
        $check = $database->fetch_first();
        if($check['transaction_status'] == 'wait'){
            return ['response'  => 200, 'message'   => 'Lấy dữ liệu thành công', 'id' => $check['transaction_id'], 'time' => gmdate('i:s', ($check['transaction_deadline'] - time()))];
        }
        if($check['transaction_status'] == 'done'){
            return ['response'  => 309, 'message'   => 'Sản phẩm này đã hoàn thành thanh toán'];
        }

        // Check Account
        $check_account = $database->select('COUNT(*) AS count')->from($this->table)->where([$this->table_rows['account_id'] => $_REQUEST['account_id'], $this->table_rows['account_status'] => 'instock'])->fetch_first();
        if($check_account['count'] == 0){
            return ['response'  => 309, 'message'   => 'Sản phẩm không hợp lệ'];
        }

        $time = time() + 600;
        $data = [
            'transaction_account'           => $_REQUEST['account_id'],
            'transaction_amount'            => $account_amout,
            'transaction_name'              => $database->escape($_SESSION['account']['account_name']),
            'transaction_phone'             => $database->escape($_SESSION['account']['account_phone']),
            'transaction_price'             => $database->escape($_REQUEST['account_price']),
            'transaction_coupon'            => $database->escape($_REQUEST['account_coupon']),
            'transaction_discount_money'    => '',
            'transaction_total_money'       => $database->escape(($_REQUEST['account_price'] * $account_amout)),
            'transaction_payment_method'    => $database->escape($_REQUEST['account_method']),
            'transaction_payment_info'      => '',
            'transaction_payment_name'      => '',
            'transaction_payment_network'   => '',
            'transaction_note'              => 'Đang chờ thanh toán',
            'transaction_user'              => ($me ? $me['user_id'] : ''),
            'transaction_status'            => 'wait',
            'transaction_deadline'          => $time,
            'transaction_create'            => get_date_time(),
            'transaction_finish'            => ''
        ];
        $action = $database->insert($this->table_tran, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }

        // Update trạng thái sản phẩm thành đang chờ thanh toán
        $this->change_status_account($_REQUEST['account_id'], 'wait_payment');

        // Update lại cú pháp ...
        $payment_content    = "PAY $action";
        $transaction_code   = $user->encodeText($payment_content);

        $data_update = [
            'transaction_code'              => $database->escape($transaction_code),
            'transaction_payment_content'   => "$payment_content",
        ];
        $database->where(['transaction_id' => $action])->update($this->table_tran, $data_update);
        return [
            'response'  => 200,
            'message'   => 'Thêm dữ liệu thành công',
            'code'      => $transaction_code,
            'id'        => $action,
            'time'      => gmdate('i:s', $time - time())
        ];
    }

    // Lấy thông tin 1 giao dịch
    public function get_transaction(array $where){
        global $database;
        $data = $database->from($this->table_tran)->where($where)->fetch_first();
        if(!$data){
            return false;
        }
        return $data;
    }

    public function caculatorDate($end){
        $date1 = new DateTime(date('Y/m/d', time()));
        $date2 = new DateTime($end);
        $interval = $date1->diff($date2);
        return $interval->m . " Tháng, " . $interval->d . " Ngày";
    }

    // Lấy danh sách tài khoản
    public function get_all($list = 'all'){
        global $database, $me;

        $param      = get_param_defaul();
        $page       = (($_REQUEST['page'] && validate_int($_REQUEST['page'])) ? $_REQUEST['page'] : $param['page']);
        $limit      = (($_REQUEST['limit'] && validate_int($_REQUEST['limit'])) ? $_REQUEST['limit'] : $param['limit']);
        $offset     = (($_REQUEST['offset'] && validate_int($_REQUEST['offset'])) ? $_REQUEST['offset'] : $param['offset']);
        $where      = [];

        $pagination = [];

        // Lọc theo User hoặc all
        if($list == 'user'){
            $where[$this->table_rows['account_user']] = $me['user_id'];
        }
        // Lọc theo chuyên mục
        if($_REQUEST[$this->table_rows['account_category']] && validate_int($_REQUEST[$this->table_rows['account_category']])){
            $where[$this->table_rows['account_category']] = $_REQUEST[$this->table_rows['account_category']];
        }
        // Lọc theo trạng thái
        if($_REQUEST[$this->table_rows['account_status']] && in_array($_REQUEST[$this->table_rows['account_status']], ['instock', 'outstock'])){
            $where[$this->table_rows['account_status']] = $_REQUEST[$this->table_rows['account_status']];
        }
        // Lọc theo hiển thị
        if($_REQUEST[$this->table_rows['account_display']] && in_array($_REQUEST[$this->table_rows['account_display']], ['show', 'hide'])){
            $where[$this->table_rows['account_display']] = $_REQUEST[$this->table_rows['account_display']];
        }
        // Lọc theo nổi bật
        if($_REQUEST[$this->table_rows['account_featured']] && in_array($_REQUEST[$this->table_rows['account_featured']], ['featured', 'not_featured'])){
            $where[$this->table_rows['account_featured']] = $_REQUEST[$this->table_rows['account_featured']];
        }
        // Lọc theo kiểu tính giá
        if($_REQUEST[$this->table_rows['account_price_type']] && in_array($_REQUEST[$this->table_rows['account_price_type']], ['fixed', 'change'])){
            $where[$this->table_rows['account_price_type']] = $_REQUEST[$this->table_rows['account_price_type']];
        }


        // Tính tổng data
        $database->select('COUNT(*) AS count_data')->from($this->table);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [
                $this->table_rows['account_title'],
                $this->table_rows['account_login'],
                $this->table_rows['account_password'],
                $this->table_rows['account_expired'],
                $this->table_rows['account_content']
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
        $database->select('*')->from($this->table);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [
                $this->table_rows['account_title'],
                $this->table_rows['account_login'],
                $this->table_rows['account_password'],
                $this->table_rows['account_expired'],
                $this->table_rows['account_content']
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
            $database->order_by($this->table_rows['account_id'], 'DESC');
        }
        $data = $database->fetch();

        foreach ($data AS &$_data){
            $media = new Media($database);
            $files = $media->get_list_data('account', $_data[$this->table_rows['account_id']]);
            foreach ($files AS $file){
                $_data['images'][] = URL_HOME . '/' . $file['file_path'];
            }
        }

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

    // Lấy thông tin 1 tài khoản
    public function get_account($account_id){
        global $database;
        if(!$this->check_account([$this->table_rows['account_id'] => $account_id])){
            return false;
        }
        $data   = $database->from($this->table)->where([$this->table_rows['account_id'] => $account_id])->fetch_first();
        $media  = new Media($database);
        $files  = $media->get_list_data('account', $data[$this->table_rows['account_id']]);
        foreach ($files AS $file){
            $data['images'][] = URL_HOME . '/' . $file['file_path'];
        }
        return $data;
    }

    // Lấy thông tin 1 tài khoản theo URL
    public function get_account_by_url($account_url){
        global $database;
        if(!$this->check_account([$this->table_rows['account_url'] => $account_url])){
            return false;
        }
        $data = $database->from($this->table)->where([$this->table_rows['account_url'] => $account_url])->fetch_first();

        $media = new Media($database);
        $files = $media->get_list_data('account', $data[$this->table_rows['account_id']]);
        foreach ($files AS $file){
            $data['images'][] = URL_HOME . '/' . $file['file_path'];
        }

        return $data;
    }

    // Kiểm tra dữ liệu theo điều kiện có tồn tại không
    public function check_account($where){
        global $database;
        $data = $database->select('COUNT(*) AS count')->from($this->table)->where($where)->fetch_first();
        if($data['count'] > 0){
            return true;
        }
        return false;
    }

    // Thêm tài khoản
    public function add($action = 'add'){
        global $database, $me;
        if(!$_REQUEST['account_title']){
            return get_response_array(309, 'Bạn cần nhập tiêu đề tài khoản');
        }
        if(strlen($_REQUEST['account_title']) < 5 || strlen($_REQUEST['account_title']) > 500){
            return get_response_array(309, 'Tiêu đề từ 5-500 ký tự');
        }
        if(!$_REQUEST['account_login']){
            return get_response_array(309, 'Bạn cần nhập tên đăng nhập.');
        }
        if(strlen($_REQUEST['account_login']) < 4 || strlen($_REQUEST['account_login']) > 50){
            return get_response_array(309, 'Tên đăng nhập từ 4-50 ký tự');
        }
        if(!$_REQUEST['account_password']){
            return get_response_array(309, 'Bạn cần nhập mật khẩu tài khoản.');
        }
        if(strlen($_REQUEST['account_password']) < 4 || strlen($_REQUEST['account_password']) > 50){
            return get_response_array(309, 'Mật khẩu từ 5-50 ký tự');
        }
        if(strlen($_REQUEST['account_package']) < 4 || strlen($_REQUEST['account_package']) > 50){
            return get_response_array(309, 'Gói tài khoản từ 5-50 ký tự');
        }
        if(!$_REQUEST['account_price']){
            return get_response_array(309, 'Bạn cần nhập giá tài khoản này');
        }
        if(!validate_int($_REQUEST['account_price'])){
            return get_response_array(309, 'Giá tài khoản phải là dạng số');
        }
        if($_REQUEST['account_price'] < 100 || $_REQUEST['account_price'] > 1000000){
            return get_response_array(309, 'Giá từ 100đ đến 1.000.000đ');
        }
        if(!$_REQUEST['account_price_type']){
            return get_response_array(309, 'Bạn cần nhập kiểu tính giá');
        }
        if(!in_array($_REQUEST['account_price_type'], ['fixed', 'change'])){
            return get_response_array(309, 'Kiểu tính giá không hợp lệ');
        }
        if($_REQUEST['account_expired'] && !validateDate($_REQUEST['account_expired'], 'd-m-Y')){
            return get_response_array(309, 'Ngày hết hạn không hợp lệ');
        }
        if(!$_REQUEST['account_url']){
            $_REQUEST['account_url'] = sanitize_title($_REQUEST['account_title']).'-'.random_string('5');
        }
        if(!$_REQUEST['account_url'] || $this->check_account([$this->table_rows['account_url'] => $_REQUEST['account_url']])){
            return get_response_array(309, 'URL chưa có hoặc đã tồn tại.');
        }
        if($this->check_account([$this->table_rows['account_category'] => $_REQUEST['account_category'], $this->table_rows['account_login'] => $_REQUEST['account_login']])){
            return get_response_array(309, 'Tài khoản đã tồn tại.');
        }

        if(!$_REQUEST['account_status']){
            $_REQUEST['account_status'] = 'outstock';
        }else{
            $_REQUEST['account_status'] = 'instock';
        }

        if($action == 'prepare'){
            return get_response_array(200, 'Success');
        }
        $data = [
            $this->table_rows['account_title']      => $database->escape($_REQUEST[$this->table_rows['account_title']]),
            $this->table_rows['account_url']        => $database->escape($_REQUEST[$this->table_rows['account_url']]),
            $this->table_rows['account_login']      => $database->escape($_REQUEST[$this->table_rows['account_login']]),
            $this->table_rows['account_password']   => $database->escape($_REQUEST[$this->table_rows['account_password']]),
            $this->table_rows['account_expired']    => ($_REQUEST['account_expired'] ? date('Y-m-d', strtotime($_REQUEST['account_expired'])) : ''),
            $this->table_rows['account_category']   => $database->escape($_REQUEST[$this->table_rows['account_category']]),
            $this->table_rows['account_package']    => $database->escape($_REQUEST[$this->table_rows['account_package']]),
            $this->table_rows['account_price']      => $database->escape($_REQUEST[$this->table_rows['account_price']]),
            $this->table_rows['account_price_type'] => $database->escape($_REQUEST[$this->table_rows['account_price_type']]),
            $this->table_rows['account_content']    => $database->escape($_REQUEST[$this->table_rows['account_content']]),
            $this->table_rows['account_featured']   => $database->escape($_REQUEST[$this->table_rows['account_featured']] ? 'featured' : 'not_featured'),
            $this->table_rows['account_display']    => $database->escape($_REQUEST[$this->table_rows['account_display']] ? 'show' : 'hide'),
            $this->table_rows['account_status']     => $database->escape($_REQUEST['account_status']),
            $this->table_rows['account_view']       => 0,
            $this->table_rows['account_user']       => $me['user_id'],
            $this->table_rows['account_create']     => get_date_time(),
        ];
        $action = $database->insert($this->table, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response'  => 200, 'message'   => 'Thêm dữ liệu thành công', 'id' => $action];
    }

    // Cập nhật tài khoản
    public function update($account_id){
        global $database;

        if(!validate_int($account_id)){
            return get_response_array(309, 'ID tài khoản không đúng định dạng.');
        }
        $check  = $this->check_account([$this->table_rows['account_id'] => $account_id]);
        // Kiểm tra xem sản phẩm có tồn tại không?
        if(!$check){
            return get_response_array(309, 'Tài khoản không tồn tại.');
        }
        $account = $this->get_account($account_id);

        if(!$_REQUEST['account_title']){
            return get_response_array(309, 'Bạn cần nhập tiêu đề tài khoản');
        }
        if(strlen($_REQUEST['account_title']) < 5 || strlen($_REQUEST['account_title']) > 500){
            return get_response_array(309, 'Tiêu đề từ 5-500 ký tự');
        }
        if(!$_REQUEST['account_login']){
            return get_response_array(309, 'Bạn cần nhập tên đăng nhập.');
        }
        if(strlen($_REQUEST['account_login']) < 4 || strlen($_REQUEST['account_login']) > 50){
            return get_response_array(309, 'Tên đăng nhập từ 4-50 ký tự');
        }
        if(!$_REQUEST['account_password']){
            return get_response_array(309, 'Bạn cần nhập mật khẩu tài khoản.');
        }
        if(strlen($_REQUEST['account_password']) < 4 || strlen($_REQUEST['account_password']) > 50){
            return get_response_array(309, 'Mật khẩu từ 5-50 ký tự');
        }
        if(strlen($_REQUEST['account_package']) < 4 || strlen($_REQUEST['account_package']) > 50){
            return get_response_array(309, 'Gói tài khoản từ 5-50 ký tự');
        }
        if(!$_REQUEST['account_price']){
            return get_response_array(309, 'Bạn cần nhập giá tài khoản này');
        }
        if(!validate_int($_REQUEST['account_price'])){
            return get_response_array(309, 'Giá tài khoản phải là dạng số');
        }
        if($_REQUEST['account_price'] < 100 || $_REQUEST['account_price'] > 1000000){
            return get_response_array(309, 'Giá từ 100đ đến 1.000.000đ');
        }
        if(!$_REQUEST['account_price_type']){
            return get_response_array(309, 'Bạn cần nhập kiểu tính giá');
        }
        if(!in_array($_REQUEST['account_price_type'], ['fixed', 'change'])){
            return get_response_array(309, 'Kiểu tính giá không hợp lệ');
        }
        if($_REQUEST['account_expired'] && !validateDate($_REQUEST['account_expired'], 'd-m-Y')){
            return get_response_array(309, 'Ngày hết hạn không hợp lệ');
        }
        if(!$_REQUEST['account_url']){
            $_REQUEST['account_url'] = sanitize_title($_REQUEST['account_title']).'-'.random_string('5');
        }
        if(($_REQUEST['account_url'] != $account[$this->table_rows['account_url']]) && $this->check_account([$this->table_rows['account_url'] => $_REQUEST['account_url']])){
            return get_response_array(309, 'URL chưa có hoặc đã tồn tại.');
        }
        if(($_REQUEST[$this->table_rows['account_login']] != $account[$this->table_rows['account_login']]) && $this->check_account([$this->table_rows['account_category'] => $_REQUEST['account_category'], $this->table_rows['account_login'] => $_REQUEST['account_login']])){
            return get_response_array(309, 'Tài khoản đã tồn tại.');
        }

        if(!$_REQUEST['account_status']){
            $_REQUEST['account_status'] = 'outstock';
        }else{
            $_REQUEST['account_status'] = 'instock';
        }

        $data = [
            $this->table_rows['account_title']      => $database->escape($_REQUEST[$this->table_rows['account_title']]),
            $this->table_rows['account_url']        => $database->escape($_REQUEST[$this->table_rows['account_url']]),
            $this->table_rows['account_login']      => $database->escape($_REQUEST[$this->table_rows['account_login']]),
            $this->table_rows['account_password']   => $database->escape($_REQUEST[$this->table_rows['account_password']]),
            $this->table_rows['account_expired']    => ($_REQUEST['account_expired'] ? date('Y-m-d', strtotime($_REQUEST['account_expired'])) : ''),
            $this->table_rows['account_category']   => $database->escape($_REQUEST[$this->table_rows['account_category']]),
            $this->table_rows['account_package']    => $database->escape($_REQUEST[$this->table_rows['account_package']]),
            $this->table_rows['account_price']      => $database->escape($_REQUEST[$this->table_rows['account_price']]),
            $this->table_rows['account_price_type'] => $database->escape($_REQUEST[$this->table_rows['account_price_type']]),
            $this->table_rows['account_content']    => $database->escape($_REQUEST[$this->table_rows['account_content']]),
            $this->table_rows['account_featured']   => $database->escape($_REQUEST[$this->table_rows['account_featured']] ? 'featured' : 'not_featured'),
            $this->table_rows['account_display']    => $database->escape($_REQUEST[$this->table_rows['account_display']] ? 'show' : 'hide'),
            $this->table_rows['account_status']     => $database->escape($_REQUEST['account_status'])
        ];
        $action = $database->where([$this->table_rows['account_id'] => $account_id])->update($this->table, $data);
        if(!$action){
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        }
        return ['response'  => 200, 'message'   => 'Cập nhật dữ liệu thành công', 'id' => $action];
    }

    // Xóa 1 tài khoản
    public function delete($account_id){
        global $database, $me;
        if(!validate_int($account_id)){
            return get_response_array(309, 'ID tài khoản không đúng định dạng.');
        }
        $check  = $this->check_account([$this->table_rows['account_id'] => $account_id, $this->table_rows['account_user'] => $me['user_id']]);
        // Kiểm tra xem sản phẩm có tồn tại không?
        if(!$check){
            return get_response_array(309, 'Tài khoản không tồn tại.');
        }
        $delete = $database->delete()->from($this->table)->where($this->table_rows['account_id'], $account_id)->limit(1)->execute();
        if(!$delete){
            return get_response_array(309, 'Xoá sản phẩm không thành công.');
        }
        $media      = new Media($database);
        $media_list = $media->get_list_data('account', $account_id);
        if($media_list){
            foreach ($media_list AS $_media_list){
                $media->delete_file('account', $_media_list['file_id']);
            }
        }
        return get_response_array(200, 'Xoá tài khoản thành công.');
    }
}