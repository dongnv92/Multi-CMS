<?php
class Cart extends Product {
    Private $db;
    public function __construct($dababase){
        $this->db = $dababase;
    }

    public function add(){
        // Kiểm tra id sản phẩm
        if(!validate_isset($_REQUEST['cart_product']) || !validate_int($_REQUEST['cart_product']) || $_REQUEST['cart_product'] < 0){
            return get_response_array(309, 'ID sản phẩm không chính xác.');
        }
        $product = new Product($this->db);
        $product = $product->get_product(['product_id' => $_REQUEST['cart_product']]);
        if(!$product){
            return get_response_array(309, 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra giá có hợp lệ không
        if(!validate_isset($_REQUEST['cart_price']) || !validate_int($_REQUEST['cart_price']) || $_REQUEST['cart_price'] < 0){
            return get_response_array(309, 'Chưa có giá hoặc giá sản phẩm không chính xác.');
        }

        // Kiểm tra giá được giảm nếu có có hợp lệ không
        if($_REQUEST['cart_price_sale']){
            if(!validate_int($_REQUEST['cart_price_sale']) || $_REQUEST['cart_price_sale'] < 0){
                return get_response_array(309, 'Giá sản phẩm khuyến mại không chính xác.');
            }
            if($_REQUEST['cart_price_sale'] >= $_REQUEST['cart_price']){
                return get_response_array(309, 'Giá sản phẩm khuyến mại phải nhỏ hơn giá niêm yết.');
            }
        }

        // Kiểm tra số lượng sản phẩm xem có chính xác không
        if($_REQUEST['cart_amount']){
            if(!validate_int($_REQUEST['cart_amount']) || $_REQUEST['cart_amount'] < 0){
                return get_response_array(309, 'Số lượng sản phẩm không chính xác.');
            }
        }

        return $product;
    }
}