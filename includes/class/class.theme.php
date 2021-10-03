<?php
class Theme{
    private $table_slide        = 'dong_theme_slides';
    private $table_slide_rows   = [
        'slides_id'         => 'slides_id',
        'slides_caption'    => 'slides_caption',
        'slides_content'    => 'slides_content',
        'slides_link'       => 'slides_link',
        'slides_image'      => 'slides_image',
        'slides_user'       => 'slides_user',
        'slides_status'     => 'slides_status',
        'slides_create'     => 'slides_create'
    ];

    public function __construct(){
    }

    public function get_all($where = []){
        global $database;
        $database->from($this->table_slide);
        if(count($where)){
            $database->where($where);
        }
        $data = $database->fetch();
        return $data;
    }

    // Kiểm tra Slides có tồn tại không
    private function check_slides($slides_id){
        global $database;
        if(!validate_int($slides_id)){
            return false;
        }
        $check = $database->select('COUNT(*) AS count')->from($this->table_slide)->where($this->table_slide_rows['slides_id'], $slides_id)->fetch_first();
        if($check['count'] > 0){
            return true;
        }
        return false;
    }

    // Lấy thông tin 1 Slides
    public function get_slides($slides_id){
        global $database;
        if(!$this->check_slides($slides_id)){
            return get_response_array(309, 'Mã Slides không hợp lệ.');
        }
        $data = $database->from($this->table_slide)->where($this->table_slide_rows['slides_id'], $slides_id)->fetch_first();
        return $data;
    }

    // Thêm mới Slides
    public function add_slides(){
        global $database, $me;
        if(!$_REQUEST['slides_caption']){
            return get_response_array(309, 'Bạn cần nhập tiêu đề Slide');
        }
        if(!$_REQUEST['slides_content']){
            return get_response_array(309, 'Bạn cần nhập nội dung Slide');
        }
        if(!$_REQUEST['slides_link']){
            return get_response_array(309, 'Bạn cần nhập link Button');
        }
        if(!$_REQUEST['slides_image']){
            return get_response_array(309, 'Bạn cần chọn file ảnh');
        }
        $data = [
            $this->table_slide_rows['slides_caption']   => $database->escape($_REQUEST[$this->table_slide_rows['slides_caption']]),
            $this->table_slide_rows['slides_content']   => $database->escape($_REQUEST[$this->table_slide_rows['slides_content']]),
            $this->table_slide_rows['slides_link']      => $database->escape($_REQUEST[$this->table_slide_rows['slides_link']]),
            $this->table_slide_rows['slides_image']     => $database->escape($_REQUEST[$this->table_slide_rows['slides_image']]),
            $this->table_slide_rows['slides_status']    => 'show',
            $this->table_slide_rows['slides_user']      => $database->escape($me['user_id']),
            $this->table_slide_rows['slides_create']    => get_date_time()
        ];
        $action = $database->insert($this->table_slide, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response'  => 200, 'message'   => 'Thêm dữ liệu thành công', 'id' => $action];
    }

    // Update Slides
    public function update_slides($slides_id){
        global $database;
        if(!$this->check_slides($slides_id)){
            return get_response_array(309, 'Mã Slides không hợp lệ.');
        }
        if(!$_REQUEST['slides_caption']){
            return get_response_array(309, 'Bạn cần nhập tiêu đề Slide');
        }
        if(!$_REQUEST['slides_content']){
            return get_response_array(309, 'Bạn cần nhập nội dung Slide');
        }
        if(!$_REQUEST['slides_link']){
            return get_response_array(309, 'Bạn cần nhập link Button');
        }

        $data = [
            $this->table_slide_rows['slides_caption']   => $database->escape($_REQUEST[$this->table_slide_rows['slides_caption']]),
            $this->table_slide_rows['slides_content']   => $database->escape($_REQUEST[$this->table_slide_rows['slides_content']]),
            $this->table_slide_rows['slides_link']      => $database->escape($_REQUEST[$this->table_slide_rows['slides_link']])
        ];

        if($_REQUEST['slides_image']){
            $data[$this->table_slide_rows['slides_image']] = $_REQUEST['slides_image'];
        }

        $action = $database->where([$this->table_slide_rows['slides_id'] => $slides_id])->update($this->table_slide, $data);
        if(!$action){
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        }
        return ['response'  => 200, 'message'   => 'Cập nhật dữ liệu thành công', 'id' => $action];
    }

    // Update Status Slide
    public function update_status_slides($slides_id, $status = 'show'){
        global $database;
        if(!$this->check_slides($slides_id)){
            return get_response_array(309, 'Mã Slides không hợp lệ.');
        }
        if(!in_array($status, ['show', 'hide'])){
            return get_response_array(309, 'Status không hợp lệ.');
        }
        $data   = [$this->table_slide_rows['slides_status']   => $status];
        $action = $database->where([$this->table_slide_rows['slides_id'] => $slides_id])->update($this->table_slide, $data);
        if(!$action){
            return get_response_array(208, "Cập nhật trạng thái không thành công.");
        }
        return ['response'  => 200, 'message'   => 'Cập nhật trạng thái thành công', 'id' => $action];
    }

    // Xóa Slide
    public function delete_slides($slides_id){
        global $database;
        if(!$this->check_slides($slides_id)){
            return get_response_array(309, 'Mã Slides không hợp lệ.');
        }
        $slide  = $this->get_slides($slides_id);
        $file   = $slide[$this->table_slide_rows['slides_image']];
        $delete = $database->delete()->from($this->table_slide)->where($this->table_slide_rows['slides_id'], $slides_id)->limit(1)->execute();
        if(!$delete){
            return get_response_array(309, 'Xoá Slides không thành công.');
        }

        // Xóa file
        if(file_exists(ABSPATH . $file)){
            unlink(ABSPATH . $file);
        }
        return get_response_array(200, 'Xoá Slide thành công.');
    }
}