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
                return $content[$data];
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

    }
}