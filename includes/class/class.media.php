<?php
class Media{
    private $db;
    const table             = 'dong_files';         // Tên bảng
    const file_id           = 'file_id';            // ID tập tin
    const file_type         = 'file_type';          // Từ khoá tập tin
    const file_path         = 'file_path';          // Đường đẫn đến file
    const file_name         = 'file_name';          // Tên File
    const file_extension    = 'file_extension';     // Định dạng File
    const file_size         = 'file_size';          // Kích thước file
    const file_attackment   = 'file_attackment';    // Nguồn chính xác của tập tin
    const file_download     = 'file_download';      // Lượt Download
    const file_user         = 'file_user';          // ID người tải file lên
    const file_time         = 'file_time';          // Thời gian upload file

    const file_type_allow   = ['product'];          // Từ khoá tập tin

    public function __construct($database){
        $this->db = $database;
    }

    public function get_list_data($file_type, $file_attackment){
        $db     = $this->db;
        $data   = $db->select()->from(self::table)->where([self::file_type => $file_type, self::file_attackment => $file_attackment])->fetch();
        if(!$data){
            return false;
        }
        return $data;
    }

    public function delete_file($file_type, $file_id){
        $db     = $this->db;
        $file   = $db->from(self::table)->where([self::file_type => $file_type, self::file_id => $file_id])->fetch_first();
        if(!$file){
            return get_response_array(309, 'Id tập tin không tồn tại');
        }
        $path = ABSPATH . $file[self::file_path];
        if(file_exists($path)){
            if(unlink($path)){
                $delete = $db->delete()->from(self::table)->where(self::file_id, $file_id)->limit(1)->execute();
                if($delete){
                    return get_response_array(200, 'Xóa tập tin thành công.');
                }
                return get_response_array(309, 'Xóa tập tin không thành công.');
            }
            return get_response_array(309, 'Xóa tập tin không thành công.');
        }
        return get_response_array(309, 'Xóa tập tin không thành công.');
    }

    public function add($file_type, $file_attackment){
        $db = $this->db;
        global $me;

        if(!$_REQUEST[self::file_path]){
            return get_response_array(309, 'Chưa có đường dẫn file.');
        }

        if(!$_REQUEST[self::file_name]){
            return get_response_array(309, 'Chưa có tên file.');
        }

        if(!$_REQUEST[self::file_extension]){
            return get_response_array(309, 'Chưa có định dạng file.');
        }

        if(!$_REQUEST[self::file_size]){
            return get_response_array(309, 'Chưa kích thước file.');
        }

        $data = [
            self::file_type         => $db->escape($file_type),
            self::file_path         => $db->escape($_REQUEST[self::file_path]),
            self::file_name         => $db->escape($_REQUEST[self::file_name]),
            self::file_extension    => $db->escape($_REQUEST[self::file_extension]),
            self::file_size         => $db->escape($_REQUEST[self::file_size]),
            self::file_attackment   => $db->escape($file_attackment),
            self::file_download     => 0,
            self::file_user         => $me['user_id'],
            self::file_time         => get_date_time()
        ];
        $action = $db->insert(self::table, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Thêm dữ liệu thành công'];
    }
}