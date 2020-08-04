<?php
class Product{
    private $db;
    const table                  = 'dong_product';
    const product_id             = 'product_id';
    const product_barcode        = 'product_barcode';
    const product_sku            = 'product_sku';
    const product_url            = 'product_url';
    const product_name           = 'product_name';
    const product_short_content  = 'product_short_content';
    const product_content        = 'product_content';
    const product_hashtag        = 'product_hashtag';
    const product_category       = 'product_category';
    const product_image          = 'product_image';
    const product_brand          = 'product_brand';
    const product_price          = 'product_price';
    const product_price_sale     = 'product_price_sale';
    const product_sale_percent   = 'product_sale_percent';
    const product_price_buy      = 'product_price_buy';
    const product_price_vat      = 'product_price_vat';
    const product_quantity       = 'product_quantity';
    const product_user           = 'product_user';
    const product_featured       = 'product_featured';
    const product_status         = 'product_status';
    const product_instock        = 'product_instock';
    const product_unit           = 'product_unit';
    const product_time           = 'product_time';
    const product_last_update    = 'product_last_update';

    public function __construct($db){
        $this->db = $db;
    }

    public function check_product($data){
        $database   = $this->db;
        $check      = $database->select('COUNT(*) AS count')->from(self::table)->where($data)->fetch_first();
        if($check['count'] > 0){
            return true;
        }
        return false;
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

    public function get_product($data, $select = '*'){
        if(!is_array($data)){
            return get_response_array(309, 'Data phải là 1 mảng array.');
        }
        $db     = $this->db;
        $data   = $db->select($select)->from(self::table)->where($data)->fetch_first();
        if(!$data){
            return false;
        }
        return $data;
    }

    function get_sale_percent($price, $price_sale){
        return 100 - floor(($price_sale/$price) * 100);
    }

    private function check_category($id){
        $database   = $this->db;
        $check      = $database->select('COUNT(*) AS count')->from('dong_meta')->where(['meta_id' => $id, 'meta_type' => 'product_category'])->fetch_first();
        if($check['count'] > 0){
            return true;
        }
        return false;
    }

    private function check_brand($id){
        $database   = $this->db;
        $check      = $database->select('COUNT(*) AS count')->from('dong_meta')->where(['meta_id' => $id, 'meta_type' => 'product_brand'])->fetch_first();
        if($check['count'] > 0){
            return true;
        }
        return false;
    }

    function get_unit($type = '', $data = ''){
        $content = [
            '1' => 'Chiếc',
            '2' => 'Cái',
            '3' => 'Kg',
            '4' => 'Lọ',
            '5' => 'Túi',
            '6' => 'Mét'
        ];
        switch ($type){
            case 'get_name':
                return $content[$data] ? $content[$data] : false;
                break;
            default:
                return $content;
                break;
        }
    }

    public function create_barcode(){
        return "888".time();
    }

    public function update_image($product_id, $image_url){
        $db             = $this->db;
        if(!validate_int($product_id)){
            return get_response_array(309, 'ID sản phẩm phải là dạng số.');
        }
        $check_product  = $this->check_product([self::product_id => $product_id]);
        if(!$check_product){
            return get_response_array(309, 'Sản phẩm không tồn tại.');
        }
        if(!file_exists(ABSPATH . $image_url)){
            return get_response_array(309, 'Tập tin không tồn tại.');
        }
        $action = $db->where(self::product_id, $product_id)->update(self::table, [self::product_image => $image_url]);
        if(!$action){
            return get_response_array(208, "Cập nhật ảnh sản phẩm không thành công.");
        }
        return ['response' => 200, 'message' => 'Cập nhật ảnh sản phẩm thành công'];
    }

    public function add(){
        $db = $this->db;
        global $me;

        // Kiểm tra nhập mã Barcode
        if($_REQUEST[self::product_barcode]){
            if(strlen($_REQUEST[self::product_barcode]) > 20){
                return get_response_array(309, 'Mã Barcode phải dưới 20 ký tự.');
            }
            if($this->check_product([self::product_barcode => $_REQUEST[self::product_barcode]])){
                return get_response_array(309, 'Mã Barcode đã tồn tại, vui lòng chọn lại.');
            }
        }

        // Kiểm tra nhập mã SKU
        if($_REQUEST[self::product_sku]){
            if(strlen($_REQUEST[self::product_sku]) > 50){
                return get_response_array(309, 'Mã SKU phải dưới 50 ký tự.');
            }
            if($this->check_product([self::product_sku=> $_REQUEST[self::product_sku]])){
                return get_response_array(309, 'Mã SKU đã tồn tại, vui lòng chọn lại.');
            }
        }

        // Kiểm tra tên sản phẩm
        if(!$_REQUEST[self::product_name]){
            return get_response_array(309, 'Bạn cần nhập tên sản phẩm.');
        }
        if($this->check_product([self::product_name=> $_REQUEST[self::product_name]])){
            return get_response_array(309, 'Tên sản phẩm đã tồn tại, vui lòng nhập lại.');
        }

        // Kiểm tra URL sản phẩm
        if(!$_REQUEST[self::product_url]){
            return get_response_array(309, 'Bạn cần nhập URL sản phẩm.');
        }
        if($this->check_product([self::product_url => $_REQUEST[self::product_url]])){
            return get_response_array(309, 'URL sản phẩm đã tồn tại, vui lòng nhập lại.');
        }

        // Kiểm tra chọn chuyên mục
        if(!$_REQUEST[self::product_category]){
            return get_response_array(309, 'Bạn cần chọn một danh mục sản phẩm.');
        }
        if(!$this->check_category($_REQUEST[self::product_category])){
            return get_response_array(309, 'Danh mục sản phẩm không đúng, vui lòng chọn lại.');
        }

        // Kiểm tra chọn Brand
        if($_REQUEST[self::product_brand] && !$this->check_brand($_REQUEST[self::product_brand])){
            return get_response_array(309, 'Brand không đúng, vui lòng chọn lại.');
        }

        // Kiểm tra giá
        if($_REQUEST[self::product_price]){
            if(!validate_int($_REQUEST[self::product_price])){
                return get_response_array(309, 'Giá sản phẩm phải là sạng số int.');
            }
            if($_REQUEST[self::product_price] < 0){
                return get_response_array(309, 'Giá sản phẩm không được nhỏ hơn 0.');
            }
        }else{
            $_REQUEST[self::product_price] = 0;
        }

        // Kiểm tra giá khuyến mại
        if($_REQUEST[self::product_price_sale]){
            if(!validate_int($_REQUEST[self::product_price_sale])){
                return get_response_array(309, 'Giá sản phẩm khuyến mại phải là sạng số int.');
            }
            if($_REQUEST[self::product_price_sale] < 0){
                return get_response_array(309, 'Giá khuyến mãi không được nhỏ hơn 0.');
            }
            if($_REQUEST[self::product_price_sale] >= $_REQUEST[self::product_price]){
                return get_response_array(309, 'Giá khuyến mại phải nhỏ hơn giá bán, vui lòng nhập lại.');
            }
        }else{
            $_REQUEST[self::product_price_sale] = 0;
        }

        // Kiểm tra giá nhập vào
        if($_REQUEST[self::product_price_buy]){
            if(!validate_int($_REQUEST[self::product_price_buy])){
                return get_response_array(309, 'Giá sản phẩm nhập vào phải là sạng số int.');
            }
            if($_REQUEST[self::product_price_buy] < 0){
                return get_response_array(309, 'Giá nhập vào không được nhỏ hơn 0.');
            }
        }else{
            $_REQUEST[self::product_price_buy] = 0;
        }

        // Kiểm tra giá bán đã bao gồm VAT chưa?
        if($_REQUEST[self::product_price_vat]){
            $_REQUEST[self::product_price_vat] = 'true';
        }

        // Kiểm tra xem có phải là sản phẩm nổi bật không?
        if($_REQUEST[self::product_featured]){
            $_REQUEST[self::product_featured] = 'true';
        }

        // Kiểm tra xem có phải là sản phẩm nổi bật không?
        if($_REQUEST[self::product_status]){
            $_REQUEST[self::product_status] = 'public';
        }else{
            $_REQUEST[self::product_status] = 'hide';
        }

        // Kiểm tra xem còn hàng trong kho không?
        if($_REQUEST[self::product_instock]){
            $_REQUEST[self::product_instock] = 'instock';
        }else{
            $_REQUEST[self::product_instock] = 'outofstock';
        }

        // Kiểm tra xem đơn vị tính là gì?
        if(!$_REQUEST[self::product_unit]){
            return get_response_array(309, 'Bạn cần chọn 1 đơn vị tính.');
        }
        if(!$this->get_unit('get_name', $_REQUEST[self::product_unit])){
            return get_response_array(309, 'Đơn vị tính không tồn tại, vui lòng xem lại.');
        }

        $data = [
            self::product_barcode        => $db->escape($_REQUEST[self::product_barcode]),
            self::product_sku            => $db->escape($_REQUEST[self::product_sku]),
            self::product_url            => $db->escape($_REQUEST[self::product_url]),
            self::product_name           => $db->escape($_REQUEST[self::product_name]),
            self::product_short_content  => $db->escape($_REQUEST[self::product_short_content]),
            self::product_content        => $db->escape($_REQUEST[self::product_content]),
            self::product_hashtag        => $db->escape($_REQUEST[self::product_hashtag]),
            self::product_category       => $db->escape($_REQUEST[self::product_category]),
            self::product_image          => get_config('no_image'),
            self::product_brand          => $db->escape($_REQUEST[self::product_brand]),
            self::product_price          => $db->escape($_REQUEST[self::product_price]),
            self::product_price_sale     => $db->escape($_REQUEST[self::product_price_sale]),
            self::product_sale_percent   => $this->get_sale_percent($_REQUEST[self::product_price], $_REQUEST[self::product_price_sale]),
            self::product_price_buy      => $db->escape($_REQUEST[self::product_price_buy]),
            self::product_price_vat      => $db->escape($_REQUEST[self::product_price_vat]),
            self::product_quantity       => 0,
            self::product_user           => $me['user_id'],
            self::product_featured       => $db->escape($_REQUEST[self::product_featured]),
            self::product_status         => $db->escape($_REQUEST[self::product_status]),
            self::product_instock        => $db->escape($_REQUEST[self::product_instock]),
            self::product_unit           => $db->escape($_REQUEST[self::product_unit]),
            self::product_time           => get_date_time()
        ];

        $action = $db->insert(self::table, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Thêm dữ liệu thành công', 'data' => $action];
    }

    public function update($product_id){
        $db             = $this->db;

        if(!validate_int($product_id)){
            return get_response_array(309, 'ID sản phẩm không đúng định dạng.');
        }

        $product  = $this->get_product([self::product_id => $product_id]);

        // Kiểm tra xem sản phẩm có tồn tại không?
        if(!$product){
            return get_response_array(309, 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra nhập mã Barcode
        if($_REQUEST[self::product_barcode]){
            if(strlen($_REQUEST[self::product_barcode]) > 20){
                return get_response_array(309, 'Mã Barcode phải dưới 20 ký tự.');
            }
            if($_REQUEST[self::product_barcode] != $product[self::product_barcode] && $this->check_product([self::product_barcode => $_REQUEST[self::product_barcode]])){
                return get_response_array(309, 'Mã Barcode đã tồn tại, vui lòng chọn lại.');
            }
        }

        // Kiểm tra nhập mã SKU
        if($_REQUEST[self::product_sku]){
            if(strlen($_REQUEST[self::product_sku]) > 50){
                return get_response_array(309, 'Mã SKU phải dưới 50 ký tự.');
            }
            if($_REQUEST[self::product_sku] != $product[self::product_sku] && $this->check_product([self::product_sku => $_REQUEST[self::product_sku]])){
                return get_response_array(309, 'Mã SKU đã tồn tại, vui lòng chọn lại.');
            }
        }

        // Kiểm tra tên sản phẩm
        if(!$_REQUEST[self::product_name]){
            return get_response_array(309, 'Bạn cần nhập tên sản phẩm.');
        }
        if($_REQUEST[self::product_name] != $product[self::product_name] && $this->check_product([self::product_name=> $_REQUEST[self::product_name]])){
            return get_response_array(309, 'Tên sản phẩm đã tồn tại, vui lòng nhập lại.');
        }

        // Kiểm tra URL sản phẩm
        if(!$_REQUEST[self::product_url]){
            return get_response_array(309, 'Bạn cần nhập URL sản phẩm.');
        }
        if($_REQUEST[self::product_url] != $product[self::product_url] && $this->check_product([self::product_url => $_REQUEST[self::product_url]])){
            return get_response_array(309, 'URL sản phẩm đã tồn tại, vui lòng nhập lại.');
        }

        // Kiểm tra chọn chuyên mục
        if(!$_REQUEST[self::product_category]){
            return get_response_array(309, 'Bạn cần chọn một danh mục sản phẩm.');
        }
        if(!$this->check_category($_REQUEST[self::product_category])){
            return get_response_array(309, 'Danh mục sản phẩm không đúng, vui lòng chọn lại.');
        }

        // Kiểm tra chọn Brand
        if($_REQUEST[self::product_brand] && !$this->check_brand($_REQUEST[self::product_brand])){
            return get_response_array(309, 'Brand không đúng, vui lòng chọn lại.');
        }

        // Kiểm tra giá
        if($_REQUEST[self::product_price]){
            if(!validate_int($_REQUEST[self::product_price])){
                return get_response_array(309, 'Giá sản phẩm phải là sạng số int.');
            }
            if($_REQUEST[self::product_price] < 0){
                return get_response_array(309, 'Giá sản phẩm không được nhỏ hơn 0.');
            }
        }else{
            $_REQUEST[self::product_price] = 0;
        }

        // Kiểm tra giá khuyến mại
        if($_REQUEST[self::product_price_sale]){
            if(!validate_int($_REQUEST[self::product_price_sale])){
                return get_response_array(309, 'Giá sản phẩm khuyến mại phải là sạng số int.');
            }
            if($_REQUEST[self::product_price_sale] < 0){
                return get_response_array(309, 'Giá khuyến mãi không được nhỏ hơn 0.');
            }
            if($_REQUEST[self::product_price_sale] >= $_REQUEST[self::product_price]){
                return get_response_array(309, 'Giá khuyến mại phải nhỏ hơn giá bán, vui lòng nhập lại.');
            }
        }else{
            $_REQUEST[self::product_price_sale] = 0;
        }

        // Kiểm tra giá nhập vào
        if($_REQUEST[self::product_price_buy]){
            if(!validate_int($_REQUEST[self::product_price_buy])){
                return get_response_array(309, 'Giá sản phẩm nhập vào phải là sạng số int.');
            }
            if($_REQUEST[self::product_price_buy] < 0){
                return get_response_array(309, 'Giá nhập vào không được nhỏ hơn 0.');
            }
        }else{
            $_REQUEST[self::product_price_buy] = 0;
        }

        // Kiểm tra giá bán đã bao gồm VAT chưa?
        if($_REQUEST[self::product_price_vat]){
            $_REQUEST[self::product_price_vat] = 'true';
        }

        // Kiểm tra xem có phải là sản phẩm nổi bật không?
        if($_REQUEST[self::product_featured]){
            $_REQUEST[self::product_featured] = 'true';
        }

        // Kiểm tra xem có phải là sản phẩm nổi bật không?
        if($_REQUEST[self::product_status]){
            $_REQUEST[self::product_status] = 'public';
        }else{
            $_REQUEST[self::product_status] = 'hide';
        }

        // Kiểm tra xem còn hàng trong kho không?
        if($_REQUEST[self::product_instock]){
            $_REQUEST[self::product_instock] = 'instock';
        }else{
            $_REQUEST[self::product_instock] = 'outofstock';
        }

        // Kiểm tra xem đơn vị tính là gì?
        if(!$_REQUEST[self::product_unit]){
            return get_response_array(309, 'Bạn cần chọn 1 đơn vị tính.');
        }
        if(!$this->get_unit('get_name', $_REQUEST[self::product_unit])){
            return get_response_array(309, 'Đơn vị tính không tồn tại, vui lòng xem lại.');
        }

        $data = [
            self::product_barcode        => $db->escape($_REQUEST[self::product_barcode]),
            self::product_sku            => $db->escape($_REQUEST[self::product_sku]),
            self::product_url            => $db->escape($_REQUEST[self::product_url]),
            self::product_name           => $db->escape($_REQUEST[self::product_name]),
            self::product_short_content  => $db->escape($_REQUEST[self::product_short_content]),
            self::product_content        => $db->escape($_REQUEST[self::product_content]),
            self::product_hashtag        => $db->escape($_REQUEST[self::product_hashtag]),
            self::product_category       => $db->escape($_REQUEST[self::product_category]),
            self::product_brand          => $db->escape($_REQUEST[self::product_brand]),
            self::product_price          => $db->escape($_REQUEST[self::product_price]),
            self::product_price_sale     => $db->escape($_REQUEST[self::product_price_sale]),
            self::product_sale_percent   => $this->get_sale_percent($_REQUEST[self::product_price], $_REQUEST[self::product_price_sale]),
            self::product_price_buy      => $db->escape($_REQUEST[self::product_price_buy]),
            self::product_price_vat      => $db->escape($_REQUEST[self::product_price_vat]),
            self::product_featured       => $db->escape($_REQUEST[self::product_featured]),
            self::product_status         => $db->escape($_REQUEST[self::product_status]),
            self::product_instock        => $db->escape($_REQUEST[self::product_instock]),
            self::product_unit           => $db->escape($_REQUEST[self::product_unit]),
            self::product_last_update   => get_date_time()
        ];

        $action = $db->where(self::product_id, $product_id)->update(self::table, $data);
        if(!$action){
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Cập nhật dữ liệu thành công'];
    }
}