<?php
class Media{
    private $db;
    const table             = 'dong_files';         // Tên bảng
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

    public function add($file_type, $file_attackment){
        $db = $this->db;
        global $me;

        // Kiểm tra file_type có hợp lệ không?
        if(!in_array($file_type, self::file_type_allow)){
            return get_response_array(309, 'Từ khoá tập tin không hợp lệ.');
        }

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