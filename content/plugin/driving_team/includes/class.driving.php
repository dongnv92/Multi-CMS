<?php
class pDriving{
    private $carplan_date = 'carplan_date';
    private $carplan_licenseplates = 'carplan_licenseplates';
    private $carplan_area = 'carplan_area';
    private $carplan_note = 'carplan_note';
    private $carplan_user = 'carplan_user';
    private $carplan_time = 'carplan_time';

    private $table_oil = 'dong_car_oil';
    private $caroil_id = 'caroil_id';
    private $caroil_bsx = 'caroil_bsx';
    private $caroil_tx = 'caroil_tx';
    private $caroil_code = 'caroil_code';
    private $cariol_image = 'cariol_image';
    private $caroil_lit = 'caroil_lit';
    private $caroil_price = 'caroil_price';
    private $caroil_date = 'caroil_date';
    private $caroil_note = 'caroil_note';
    private $caroil_user = 'caroil_user';
    private $caroil_create = 'caroil_create';

    public function __construct(){
    }

    public function add_car_plan(){

    }

    public function get_caroil($caroil_id, $fields = '*'){
        global $database;
        if(!$this->check_caroil($caroil_id)){
            return false;
        }
        $data = $database->select($fields)->from($this->table_oil)->where($this->caroil_id, $caroil_id)->fetch_first();
        if(!$data){
            return false;
        }
        return $data;
    }

    public function update_image_oil($oil_id, $path_image){
        global $database;
        if(!$this->check_caroil($oil_id)){
            return get_response_array(309, 'Phiếu đổ dầu không tồn tại.');
        }
        $update = $database->where([$this->caroil_id => $oil_id])->update($this->table_oil, [$this->cariol_image => $path_image]);
        if($update){
            return get_response_array(200, 'Update ảnh thành công.');
        }else{
            return get_response_array(309, 'Update ảnh không thành công.');
        }
    }

    public function update_oil($caroil_id){
        global $database;

        $caroil = $this->get_caroil($caroil_id);
        if(!$caroil){
            return get_response_array(309, 'Phiếu này không tồn tại.');
        }
        if((time() - strtotime($caroil[$this->caroil_create])) > (60*60*24*2)){
            return get_response_array(309, 'Đã quá thời gian để chỉnh sửa.');
        }

        $caroil_date = $_REQUEST['caroil_date'];
        if(!$caroil_date){
            return get_response_array(309, 'Bạn cần nhập ngày đổ phiếu.');
        }
        $caroil_date = explode('-', $caroil_date);
        if(!checkdate($caroil_date[1], $caroil_date[2], $caroil_date[0])){
            return get_response_array(309, 'Ngày đổ dầu không đúng định dạng.');
        }

        if(!$_REQUEST['caroil_bsx'] || !$this->check_bks($_REQUEST['caroil_bsx'])){
            return get_response_array(309, 'Bạn cần nhập biển số xe.');
        }

        if(!$_REQUEST['caroil_tx'] ||  !$this->check_user($_REQUEST['caroil_tx'])){
            return get_response_array(309, 'Bạn cần chọn người đi đổ dầu.');
        }

        if(!$_REQUEST['caroil_lit']){
            return get_response_array(309, 'Bạn cần nhập số lít đầu đổ.');
        }

        $data = [
            'caroil_bsx'    => $_REQUEST['caroil_bsx'],
            'caroil_tx'     => $_REQUEST['caroil_tx'],
            'caroil_code'   => $_REQUEST['caroil_code'],
            'caroil_lit'    => $_REQUEST['caroil_lit'],
            'caroil_price'  => $_REQUEST['caroil_price'],
            'caroil_date'   => $_REQUEST['caroil_date'],
            'caroil_note'   => $_REQUEST['caroil_note']
        ];

        $action = $database->where([$this->caroil_id => $caroil_id])->update($this->table_oil, $data);

        if(!$action){
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        }
        return ['response'  => 200, 'message'   => 'Cập nhật liệu thành công', 'data' => $action];
    }

    public function add_oil(){
        global $me, $database;
        $caroil_date = $_REQUEST['caroil_date'];
        if(!$caroil_date){
            return get_response_array(309, 'Bạn cần nhập ngày đổ phiếu.');
        }
        $caroil_date = explode('-', $caroil_date);
        if(!checkdate($caroil_date[1], $caroil_date[2], $caroil_date[0])){
            return get_response_array(309, 'Ngày đổ dầu không đúng định dạng.');
        }

        if(!$_REQUEST['caroil_bsx'] || !$this->check_bks($_REQUEST['caroil_bsx'])){
            return get_response_array(309, 'Bạn cần nhập biển số xe.');
        }

        if(!$_REQUEST['caroil_tx'] ||  !$this->check_user($_REQUEST['caroil_tx'])){
            return get_response_array(309, 'Bạn cần chọn người đi đổ dầu.');
        }

        if(!$_REQUEST['caroil_lit']){
            return get_response_array(309, 'Bạn cần nhập số lít đầu đổ.');
        }

        $data = [
            'caroil_bsx'    => $_REQUEST['caroil_bsx'],
            'caroil_tx'     => $_REQUEST['caroil_tx'],
            'caroil_code'   => $_REQUEST['caroil_code'],
            'caroil_lit'    => $_REQUEST['caroil_lit'],
            'caroil_price'  => $_REQUEST['caroil_price'],
            'caroil_date'   => $_REQUEST['caroil_date'],
            'caroil_note'   => $_REQUEST['caroil_note'],
            'caroil_user'   => $me['user_id'],
            'caroil_create' => get_date_time()
        ];

        $action = $database->insert($this->table_oil, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }

        // Send Message to Telegram Group
        $car        = new meta($database, 'listcar_category');
        $get_car    = $car->get_meta($_REQUEST['caroil_bsx']);
        $tx         = new user($database);
        $get_tx     = $tx->get_user(['user_id' => $_REQUEST['caroil_tx']]);

        $telegram = new Telegram('citypost_notice');
        $telegram->set_chatid('-506790604');
        $message = "[Thông báo đổ dầu] Lái xe {$get_tx['user_name']} đổ {$_REQUEST['caroil_lit']} Lít dầu ngày {$_REQUEST['caroil_date']} xe {$get_car['data']['meta_name']}.\nNgười nhập: {$me['user_name']}";
        $telegram->sendMessage($message);
        return ['response'  => 200, 'message'   => 'Thêm dữ liệu thành công', 'data' => $action];
    }

    // Lấy danh sách tất cả
    public function get_all(){
        global $database;
        $param      = get_param_defaul();
        $page       = $param['page'];
        $limit      = $param['limit'];
        $offset     = $param['offset'];
        $where      = [];
        $pagination = [];

        if($_REQUEST['caroil_bsx'] && $this->check_bks($_REQUEST['caroil_bsx'])){
            $where['caroil_bsx'] = $_REQUEST['caroil_bsx'];
        }
        if($_REQUEST['caroil_tx'] && $this->check_user($_REQUEST['caroil_tx'])){
            $where['caroil_tx'] = $_REQUEST['caroil_tx'];
        }

        // Tính tổng data
        $database->select('COUNT(*) AS count_data')->from($this->table_oil);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [$this->caroil_note, $this->caroil_lit, $this->caroil_price]));
        }
        if($where){
            $database->where($where);
        }
        if(($_REQUEST['date_start'] && check_date($_REQUEST['date_start'], 'y-m-d')) && ($_REQUEST['date_end'] && check_date($_REQUEST['date_end'], 'y-m-d'))){
            $database->between($this->caroil_date, $_REQUEST['date_start'], $_REQUEST['date_end']);
        }

        $data_count                 = $database->fetch_first();
        $pagination['count']        = $data_count['count_data'];                    // Tổng số bản ghi
        $pagination['page_num']     = ceil($pagination['count'] / $limit);   // Tổng số trang
        $pagination['page_start']   = ($page - 1) * $limit;                        // Bắt đầu từ số bản ghi này

        // Nếu số trang hiện tại lớn hơn tổng số trang thì bào lỗi
        if(($page - 1) > $pagination['page_num'] || $offset > $pagination['count'])
            return get_response_array(311, 'Số trang không được lớn hơn số dữ liệu có.');

        // Hiển thị dữ liệu theo số liệu nhập vào
        $database->select('*')->from($this->table_oil);
        if($_REQUEST['search']){
            $database->where(get_query_search($_REQUEST['search'], [$this->caroil_note, $this->caroil_lit, $this->caroil_price]));
        }
        if($where){
            $database->where($where);
        }
        if(($_REQUEST['date_start'] && check_date($_REQUEST['date_start'], 'y-m-d')) && ($_REQUEST['date_end'] && check_date($_REQUEST['date_end'], 'y-m-d'))){
            $database->between($this->caroil_date, $_REQUEST['date_start'], $_REQUEST['date_end']);
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
            $database->order_by($this->caroil_id, 'DESC');
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

    public function delete_oilcar($oilcar_id){
        global $database;
        $caroil = $this->get_caroil($oilcar_id);
        if(!$caroil){
            return get_response_array(309, 'Phiếu này không tồn tại.');
        }
        if((time() - strtotime($caroil[$this->caroil_create])) > (60*60*24*2)){
            return get_response_array(309, 'Đã quá thời gian để chỉnh sửa.');
        }

        $delete = $database->delete($this->table_oil)->where($this->caroil_id, $oilcar_id)->execute();
        if(!$delete){
            return get_response_array(309, 'Xóa lịch sử dổ dầu không thành công.');
        }
        return get_response_array(200, 'Xóa lịch sử đổ dầu thành công.');
    }

    public function widget_index($content = ''){
        global $database;
        switch ($content){
            case 'oil_last':
                $database->select()->from($this->table_oil);
                $database->order_by($this->caroil_id, 'DESC');
                $database->limit(5);
                $data = $database->fetch();
                $html = '
                <div class="card card-bordered h-100">
                    <div class="card-inner border-bottom">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Danh sách đổ dầu mới nhất</h6>
                            </div>
                            <div class="card-tools">
                                <a href="'. URL_ADMIN .'/driving_team/oil/" class="link">Xem tất cả</a> | <a href="'. URL_ADMIN .'/driving_team/oil/add" class="link">Thêm mới</a> 
                            </div>
                        </div>
                    </div>
                    <div class="card-inner">
                        <div class="timeline">
                            <h6 class="timeline-head">Hiện tại: '. date('H:i:s d/m/Y') .'</h6>
                            <ul class="timeline-list">';
                            foreach ($data AS $row){
                                $car        = new meta($database, 'listcar_category');
                                $get_car    = $car->get_meta($row['caroil_bsx']);

                                $tx         = new user($database);
                                $get_tx     = $tx->get_user(['user_id' => $row['caroil_tx']]);
                                $html .= '<li class="timeline-item">
                                    <div class="timeline-status bg-primary is-outline"></div>
                                    <div class="timeline-date">'. date('d/m', strtotime($row[$this->caroil_date])) .' <em class="icon ni ni-alarm-alt"></em></div>
                                    <div class="timeline-data">
                                        <h6 class="timeline-title">Đổ dầu xe '. $get_car['data']['meta_name'] .'</h6>
                                        <div class="timeline-des">
                                            <p>Lái xe đổ dầu '. $get_tx['user_name'] .'.</p>
                                            <span class="time">Thêm lúc: '. view_date_time($row[$this->caroil_create]) .'</span>
                                        </div>
                                    </div>
                                </li>';
                            }
                            $html .= '</ul>
                        </div>
                    </div>
                </div><!-- .card -->';
            break;
        }

        return $html;
    }

    // Check Oil Car
    private function check_caroil($caroil_id){
        global $database;
        $count = $database->select('COUNT(*) AS count')->from($this->table_oil)->where($this->caroil_id, $caroil_id)->fetch_first();
        if($count['count'] > 0){
            return true;
        }
        return false;
    }

    // Check BKS
    private function check_bks($bks){
        global $database;
        $meta = new meta($database, 'listcar_category');
        if(!$meta->check_id($bks)){
            return false;
        }
        return true;
    }

    // Check User
    private function check_user($user_id){
        global $database;
        $user = new user($database);
        if(!$user->check_user($user_id, 'id')){
            return false;
        }
        return true;
    }
}

