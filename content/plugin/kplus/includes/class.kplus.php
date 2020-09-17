<?php
class Kplus{
    private $db;
    const table         = 'dong_kplus';
    const kplus_id      = 'kplus_id';
    const kplus_code    = 'kplus_code';
    const kplus_expired = 'kplus_expired';
    const kplus_name    = 'kplus_name';
    const kplus_status  = 'kplus_status'; // unregistered|registered
    const kplus_note    = 'kplus_note';
    const kplus_time    = 'kplus_time';
    const kplus_status_value        = ['unregistered', 'registered', 'wait']; // unregistered|registered
    const kplus_register_at         = 'kplus_register_at';      // Đăng ký lúc
    const kplus_register_by         = 'kplus_register_by';      // Người đăng ký
    const kplus_register_by_defaule = '823657709';              // ID chát của tôi
    const kplus_register_payment    = 'kplus_register_payment'; // Tình trạng thanh toán

    public function __construct($database){
        $this->db = $database;
    }

    private function validateCode($code){
        if(strlen($code) == 12 && validate_int($code)){
            return true;
        }
        return false;
    }

    public function getData($code){
        $db     = $this->db;
        $data   = $db->select()->from(self::table)->where(self::kplus_code, $code)->fetch_first();
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

    // dd/mm/yyyy VD 24/02/1992
    private function checkDate($date){
        if(strlen(trim($date)) != 10){
            return false;
        }
        $date = explode('/',$date);
        if(!checkdate($date[1], $date[0], $date[2])){
            return false;
        }
        return true;
    }

    // Lấy danh sách tất cả sản phẩm
    public function get_all(){
        $db         = $this->db;
        $param      = get_param_defaul();
        $page       = $param['page'];
        $limit      = $param['limit'];
        $offset     = $param['offset'];
        $where      = [];
        $pagination = [];
        $where[self::kplus_status] = 'unregistered';

        // Lọc trạng thái
        if(in_array($_REQUEST[self::kplus_status], self::kplus_status_value)){
            $where[self::kplus_status] = $_REQUEST[self::kplus_status];
        }

        // Tính tổng data
        $db->select('COUNT(*) AS count_data')->from(self::table);
        if($_REQUEST['search']){
            $db->where(get_query_search($_REQUEST['search'], [
                self::kplus_code,
                self::kplus_expired,
                self::kplus_name,
                self::kplus_note
            ]));
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
            $db->where(get_query_search($_REQUEST['search'], [
                self::kplus_code,
                self::kplus_expired,
                self::kplus_name,
                self::kplus_note
            ]));
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
            $db->order_by(self::kplus_expired, 'asc');
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

    // Check Code. Nếu code đã được sử dụng hoặc lỗi thì trả về false
    public function checkCodeAvailable($code){
        $db = $this->db;
        if(!$this->validateCode($code)){
            return false;
        }
        $count = $db->select('COUNT(*) AS count')->from(self::table)->where(self::kplus_code, $code)->fetch_first();
        if($count['count'] > 0){
            return false;
        }
        return true;
    }

    public function adds(){
        $content    = $_REQUEST['content'];
        if(!validate_isset($content)){
            return get_response_array(309, 'Chưa có nội dung.');
        }
        if(!validate_isset($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Bạn cần nhập ngày hết hạn.');
        }
        $content = explode("\n", $content);
        $success = 0;
        $error   = 0;

        foreach ($content AS $_content){
            $_content_new = str_replace([' ', '-'], '', $_content);
            $_content_new = explode('/', $_content_new);
            $_REQUEST['kplus_code']     = $_content_new[0];
            $action = $this->add();
            if($action['response'] == 200){
                $success+=1;
            }else{
                $error+=1;
            }
        }

        return get_response_array(200, "Thêm thành công $success mã. Lỗi $error mã.");
    }

    public function add(){
        $db = $this->db;
        $_REQUEST[self::kplus_code] = str_replace(' ', '', $_REQUEST[self::kplus_code]);

        if(!$this->validateCode($_REQUEST[self::kplus_code])){
            return get_response_array(309, 'Mã thẻ trống hoặc sai định dạng.');
        }
        if(!$this->checkCodeAvailable($_REQUEST[self::kplus_code])){
            return get_response_array(309, 'Mã thẻ đã được sử dụng.');
        }
        if(!validate_isset($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Bạn cần nhập ngày hết hạn.');
        }
        if(!$this->checkDate($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Ngày hết hạn không hợp lệ.');
        }
        $kplus_expired = explode('/', $_REQUEST[self::kplus_expired]);

        $data = [
            self::kplus_code        => $db->escape($_REQUEST[self::kplus_code]),
            self::kplus_expired     => $db->escape($kplus_expired[2].'-'.$kplus_expired[1].'-'.$kplus_expired[0]),
            self::kplus_name        => $db->escape($_REQUEST[self::kplus_name]),
            self::kplus_status      => 'unregistered',
            self::kplus_time        => get_date_time()
        ];

        $action = $db->insert(self::table, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Thêm dữ liệu thành công', 'data' => $action];
    }

    public function update($kplus_code){
        $db = $this->db;
        $_REQUEST[self::kplus_code] = str_replace(' ', '', $_REQUEST[self::kplus_code]);

        if(!$this->validateCode($_REQUEST[self::kplus_code])){
            return get_response_array(309, 'Mã thẻ trống hoặc sai định dạng.');
        }
        if($kplus_code != $_REQUEST[self::kplus_code] && !$this->checkCodeAvailable($_REQUEST[self::kplus_code])){
            return get_response_array(309, 'Mã thẻ đã được sử dụng.');
        }

        if(!validate_isset($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Bạn cần nhập ngày hết hạn.');
        }
        if(!$this->checkDate($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Ngày hết hạn không hợp lệ.');
        }
        $kplus_expired = explode('/', $_REQUEST[self::kplus_expired]);

        $data = [
            self::kplus_code        => $db->escape($_REQUEST[self::kplus_code]),
            self::kplus_expired     => $db->escape($kplus_expired[2].'-'.$kplus_expired[1].'-'.$kplus_expired[0]),
            self::kplus_name        => $db->escape($_REQUEST[self::kplus_name])
        ];

        $action = $db->where(self::kplus_code, $kplus_code)->update(self::table, $data);
        if(!$action){
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Cập nhật dữ liệu thành công'];
    }

    public function updateStatus($kplus_code, $status = 'registered'){
        $db = $this->db;
        $check = $this->getData($kplus_code);
        if(!$check){
            return get_response_array(309, 'Mã thẻ không tồn tại.');
        }
        if(!in_array($status, self::kplus_status_value)){
            return get_response_array(309, 'Trạng thái không đúng định dạng. '.$status);
        }
        $data = [
            self::kplus_status              => $db->escape($status),
            self::kplus_register_at         => get_date_time(),
            self::kplus_register_by         => self::kplus_register_by_defaule,
            self::kplus_register_payment    => 'paid'
        ];

        $action = $db->where(self::kplus_code, $kplus_code)->update(self::table, $data);
        if(!$action){
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Cập nhật dữ liệu thành công'];
    }

    public function delete($kplus_code){
        $db = $this->db;
        $check = $this->getData($kplus_code);
        if(!$check){
            return get_response_array(309, 'Mã thẻ không tồn tại.');
        }
        $action = $db->delete()->from(self::table)->where(self::kplus_code, $kplus_code)->limit(1)->execute();
        if(!$action){
            return get_response_array(309, 'Lỗi không xóa được.');
        }
        return get_response_array(200, 'Xóa thẻ thành công.');
    }

    private function getCodeByDate($date){
        $db = $this->db;
        $check_date = explode('-', $date);
        if(!checkdate($check_date[1], $check_date[2], $check_date[0])){
            return false;
        }
        $data = $db->select()->from(self::table)->where([self::kplus_status => 'unregistered', self::kplus_expired => $date])->fetch_first();
        if(!$data){
            return false;
        }
        return $data;
    }

    // Check xem ngày này có mã nào không?
    // Date định dạng Y-m-d
    public function checkCodeDate($date){
        $db = $this->db;
        $check_date = explode('-', $date);
        if(!checkdate($check_date[1], $check_date[2], $check_date[0])){
            return false;
        }
        $check = $db->select('COUNT(*) AS count')->from(self::table)->where([self::kplus_status => 'unregistered', self::kplus_expired => $date])->fetch_first();
        if($check['count'] > 0){
            return true;
        }
        return false;
    }

    private function searchCodeDate($date){
        // Lặp từ -8 ngày đến +8 ngày
        for ($i=-8; $i<=8; $i++){
            $newdate    = strtotime(($i >= 0 ? '+' : '')."$i days", strtotime($date));
            $newdate    = date('Y-m-d', $newdate);
            if($this->checkCodeDate($newdate)){
                return $newdate;
                break;
            }
        }

        // Lặp từ 9 đến 90 ngày
        for ($i=9; $i<=90; $i++){
            $newdate    = strtotime("+$i days", strtotime($date));
            $newdate    = date('Y-m-d', $newdate);
            if($this->checkCodeDate($newdate)){
                return $newdate;
                break;
            }
        }

        // Lặp Từ -9 đến -90
        for ($i=-9; $i>=-90; $i--){
            $newdate    = strtotime("$i days", strtotime($date));
            $newdate    = date('Y-m-d', $newdate);
            if($this->checkCodeDate($newdate)){
                return $newdate;
                break;
            }
        }
        return false;
    }

    // Nhập số tháng cần đăng ký và tìm 1 mã phù hợp nhất
    function searchCode($month){
        if(!in_array($month, [3,4,5,6,7,8,9,10,11,12])){
            return false;
        }
        $today      = date('Y-m-d', time());
        $newdate    = strtotime("+$month month", strtotime($today));
        $newdate    = date('Y-m-d', $newdate);
        // Nếu ngày này có mã thẻ thì trả về ngày hợp lệ
        if($this->checkCodeDate($newdate)){
            $data = $this->getCodeByDate($newdate);
            if($data){
                return $data;
            }
        }
        $search_date = $this->searchCodeDate($newdate);
        if($search_date){
            $data = $this->getCodeByDate($search_date);
            if($data){
                return $data;
            }
        }
        return false;
    }

    // Update trạng thái sau khi tìm được mã thẻ
    public function updateSearchCode($kplus_code, $chat_id = self::kplus_register_by_defaule){
        $db     = $this->db;
        $count  = $db->select('COUNT(*) AS count')->from(self::table)->where([self::kplus_code => $kplus_code, self::kplus_status => 'unregistered'])->fetch_first();
        if($count == 0){
            return false;
        }
        $data = [
            self::kplus_status              => $db->escape('wait'),
            self::kplus_register_at         => get_date_time(),
            self::kplus_register_by         => $chat_id,
            self::kplus_register_payment    => 'unpaid'
        ];

        $action = $db->where(self::kplus_code, $kplus_code)->update(self::table, $data);
        if(!$action){
            return false;
        }
        return true;
    }
}