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

        // Kiểm tra URL sản phẩm
        if(!$_REQUEST[self::product_url]){
            return get_response_array(309, 'Bạn cần nhập URL sản phẩm.');
        }
        if($this->check_product([self::product_url => $_REQUEST[self::product_url]])){
            return get_response_array(309, 'URL sản phẩm đã tồn tại, vui lòng nhập lại.');
        }

        // Kiểm tra tên sản phẩm
        if(!$_REQUEST[self::product_name]){
            return get_response_array(309, 'Bạn cần nhập tên sản phẩm.');
        }
        if($this->check_product([self::product_name=> $_REQUEST[self::product_name]])){
            return get_response_array(309, 'Tên sản phẩm đã tồn tại, vui lòng nhập lại.');
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
            $_REQUEST[self::product_featured] = 'instock';
        }else{
            $_REQUEST[self::product_featured] = 'outofstock';
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
            self::product_sale_percent   => $db->escape($_REQUEST[self::product_price_sale] ? (floor(($_REQUEST[self::product_price_sale] / $_REQUEST[self::product_price])) * 100) : 0),
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
}