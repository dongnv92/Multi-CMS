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

    public function cart_detail(){
        $data = [];
        $data['product_total']      = 0;
        $data['total_money']        = 0; // Tổng tiền giá niêm yết
        $data['money_difference']   = 0; // Tổng tiền được khuyến mãi
        $data['total_sell']         = 0; // Tổng tiền thực phải trả

        foreach ($_SESSION['cart']['products'] AS $product){
            $data['product_total']      += $product['product_amount'];
            $data['total_money']        += ($product['product_amount'] * $product['product_price']);
            $data['money_difference']   += ($product['product_difference'] * $product['product_amount']);
            $data['total_sell']         += ($product['product_price_sell'] * $product['product_amount']);
        }

        if($_SESSION['cart']['ship'] > 0){

        }
    }

    public function update(){
        if(count($_SESSION['cart']['products']) < 1){
            return get_response_array(309, 'Giỏ hàng đang trống.');
        }
        if($_REQUEST['ship'] && validate_int($_REQUEST['ship'])){
            $_SESSION['cart']['ship'] = $_REQUEST['ship'];
        }

        if($_REQUEST['sale'] && validate_int($_REQUEST['sale'])){
            $_SESSION['cart']['sale'] = $_REQUEST['sale'];
        }

        if($_REQUEST['message'] && validate_int($_REQUEST['message'])){
            $_SESSION['cart']['message'] = $_REQUEST['message'];
        }
        return get_response_array(200, 'Update giỏ hàng thành công.');
    }

    public function delete($product_id){
        // Kiểm tra id sản phẩm
        if(!validate_isset($product_id) || !validate_int($product_id) || $product_id < 0){
            return get_response_array(309, 'ID sản phẩm không chính xác.');
        }
        $product = new Product($this->db);
        $product = $product->get_product(['product_id' => $product_id]);

        if(!$product){
            return get_response_array(309, 'Sản phẩm không tồn tại.');
        }

        // Delete Product in Cart
        foreach ($_SESSION['cart']['products'] AS $key => $value){
            if($value['product_id'] == $product['product_id']){
                unset($_SESSION['cart']['products'][$key]);
            }
        }
        return get_response_array(200, 'Xoá sản phẩm trong giỏ hàng thành công.');
    }

    public function set_empty(){
        unset($_SESSION['cart']);
        return get_response_array(200, 'Làm trống giỏ hàng thành công.');
    }

    public function add($product_id){
        // Kiểm tra id sản phẩm
        if(!validate_isset($product_id) || !validate_int($product_id) || $product_id < 0){
            return get_response_array(309, 'ID sản phẩm không chính xác.');
        }

        $product = new Product($this->db);
        $product = $product->get_product(['product_id' => $product_id]);

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
        if(!$this->checkItem($_SESSION['cart']['products'], 'product_id', $product_id)){
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
                if($products['product_id'] == $product_id){
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