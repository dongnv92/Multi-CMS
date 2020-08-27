<?php
class Cart {
    Private $db;
    public function __construct($dababase){
        $this->db = $dababase;
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    private function checkItem(array $array, $key, $value){
        $num = array_search($value, array_column($array, $key));
        if(is_numeric($num)){
            return true;
        }else{
            return false;
        }
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

        // Kiểm tra giá sản phẩm có hợp lệ không
        if(validate_isset($_REQUEST['cart_price'])){
            if(!validate_int($_REQUEST['cart_price']) || $_REQUEST['cart_price'] < 0){
                return get_response_array(309, 'Chưa có giá hoặc giá sản phẩm không chính xác.');
            }
        }

        // Kiểm tra giá được giảm nếu có có hợp lệ không
        if(validate_isset($_REQUEST['cart_price_sale'])){
            if(!validate_int($_REQUEST['cart_price_sale']) || $_REQUEST['cart_price_sale'] < 0){
                return get_response_array(309, 'Giá sản phẩm khuyến mại không chính xác.');
            }
            if($_REQUEST['cart_price_sale'] >= $_REQUEST['cart_price']){
                return get_response_array(309, 'Giá sản phẩm khuyến mại phải nhỏ hơn giá niêm yết.');
            }
        }

        // Kiểm tra số lượng sản phẩm xem có chính xác không
        if(validate_isset($_REQUEST['cart_amount'])){
            if(!validate_int($_REQUEST['cart_amount']) || $_REQUEST['cart_amount'] < 0){
                return get_response_array(309, 'Số lượng sản phẩm không chính xác.');
            }
        }

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa?
        if(!$this->checkItem($_SESSION['cart']['products'], 'product_id', $_REQUEST['cart_product'])){
            // Thêm mới sản phẩm vào giỏ hàng nếu sản phẩm này chưa có trong giỏ hàng.
            $data = [
                'product_id'            => $product['product_id'],
                'product_name'          => $product['product_name'],
                'product_price'         => $product['product_price'],
                'product_price_sale'    => $product['product_price_sale'],
                'product_price_sell'    => $product['product_price_sale'] ? $product['product_price_sale'] : $product['product_price'],
                'product_difference'    => $product['product_price_sale'] ? ($product['product_price'] - $product['product_price_sale']) : 0,
                'product_amount'        => $product['cart_amount'] ? $product['cart_amount'] : 1
            ];
            $_SESSION['cart']['products'][] = $data;
        }else{
            foreach ($_SESSION['cart']['products'] AS &$products){
                if($products['product_id'] == $_REQUEST['cart_product']){
                    if($_REQUEST['cart_amount']){
                        $products['cart_amount'] = $_REQUEST['cart_amount'];
                    }

                    if(in_array($_REQUEST['cart_amount_change'], ['plus'])){
                        $products['cart_amount'] = $products['cart_amount'] + 1;
                    }

                    if(in_array($_REQUEST['cart_amount_change'], ['minus']) && $products['cart_amount'] > 2){
                        $products['cart_amount'] = $products['cart_amount'] - 1;
                    }
                }
            }
        }
        return ['response' => 200, 'message' => 'Thêm sản phẩm vào giỏ hàng thành công'];
    }
}