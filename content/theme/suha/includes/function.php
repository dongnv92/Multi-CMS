<?php

if(!function_exists('create_url_category')) {
    function create_url_category($data, $option = 'url'){
        global $database;
        switch ($option){
            case 'url':
                $url = URL_CATEGORY . "/$data.html";
                break;
            default:
                $meta   = new meta($database, 'type_account_category');
                $meta   = $meta->get_meta($data);
                $url    = $meta['data']['meta_url'];
                $url    = URL_CATEGORY . "/$url.html";
                break;
        }
        return $url;
    }
}

if(!function_exists('create_url_product')) {
    function create_url_product($data, $option = 'url'){
        global $database;
        switch ($option){
            case 'url':
                $url = URL_PRODUCT . "/$data.html";
                break;
            default:
                $account    = new pAccount();
                $detail     = $account->get_account($data);
                if($detail){
                    $url = URL_PRODUCT . "/{$detail['account_url']}.html";
                }else{
                    $url = '';
                }
                break;
        }
        return $url;
    }
}

if(!function_exists('template_category')) {
    function template_category(){
        global $database;
        $meta = new meta($database, 'type_account_category');
        $data = $meta->get_all();
        $data = $data['data'];
        $text = '<div class="product-catagories-wrapper py-3"><div class="container"><div class="section-heading"><h6>Chuyên mục</h6></div><div class="product-catagory-wrap"><div class="row g-3">';
        foreach ($data AS $_data){
            $text .= '
            <div class="col-4">
                <div class="card catagory-card">
                    <div class="card-body">
                        <a class="text-danger" href="'. create_url_category($_data['meta_url'], 'url') .'">
                            <i class="lni lni-display text-success"></i>
                            <span>'. $_data['meta_name'] .'</span>
                        </a>
                    </div>
                </div>
            </div>';
        }
        $text .= '</div></div></div></div>';
        return $text;
    }
}

if(!function_exists('template_slides')){
    function template_slides(){
        $theme  = new Theme();
        $data   = $theme->get_all(['slides_status' => 'show']);
        $text = '<div class="container"><div class="pt-3"><div class="hero-slides owl-carousel">';
        foreach ($data AS $_data){
            $text .= '<!-- Single Hero Slide-->
            <div class="single-hero-slide" style="background-image: url('. URL_HOME .'/'. $_data['slides_image'] .')">
                <div class="slide-content h-100 d-flex align-items-center">
                    <div class="slide-text">
                        <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-duration="1000ms">'. $_data['slides_caption'] .'</h4>
                        <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-duration="1000ms">'. $_data['slides_content'] .'</p>
                        '. $_data['slides_link'] .'
                    </div>
                </div>
            </div>';
        }
        $text .= '</div></div></div>';
        return $text;
    }
}

if(!function_exists('template_account_detail')){
    function template_account_detail($data, $layout = '', $option = []){
        switch ($layout){
            case 'grid':
                $text = '
                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            '. ($option['badge'] ? '<span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>' : '') .'
                            <a class="wishlist-btn" href="#"><i class="lni lni-heart"></i></a>
                            <a class="product-thumbnail d-block" href="'. create_url_product($data['account_url']) .'">
                                <img class="mb-2" width="300px" height="300px" src="'. $data['images'][0] .'" alt="'. $data['account_title'] .'">
                            </a>
                            <a class="product-title d-block" href="'. create_url_product($data['account_url']) .'">'. convert_title($data['account_title'], $data) .'</a>
                            <p class="sale-price">'. convert_number_to_money(convert_price($data)) .'</p>
                            <div class="product-rating">
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                            </div>
                            <a class="btn btn-success btn-sm" href="'. (URL_CART . "?account={$data['account_id']}") .'"><i class="lni lni-cart"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Single Top Product Card-->';
                break;
            case 'list':
                $text = '
                <!-- Single Weekly Product Card-->
                <div class="col-12 col-md-6">
                    <div class="card weekly-product-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="product-thumbnail-side">
                                '. ($option['badge'] ? '<span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>' : '') .'
                                <a class="wishlist-btn" href="#"><i class="lni lni-heart"></i></a>
                                <a class="product-thumbnail d-block" href="'. create_url_product($data['account_url']) .'">
                                    <img  src="'. $data['images'][0] .'" width="300px" height="300px" alt="'. $data['account_title'] .'">
                                </a>
                            </div>
                            <div class="product-description">
                                <a class="product-title d-block" href="'. create_url_product($data['account_url']) .'">'. convert_title($data['account_title'], $data) .'</a>
                                <p class="sale-price"><i class="lni lni-dollar"></i>'. convert_number_to_money(convert_price($data)) .'</p>
                                <div class="product-rating">
                                    <i class="lni lni-star-filled"></i>'. ($data['account_package'] ? 'Gói '.$data['account_package'] : '') .'
                                </div>
                                '. ($data['account_status'] == 'instock' ? '<a class="btn btn-outline-success btn-sm" href="'. (URL_CART . "?account={$data['account_id']}") .'"><i class="me-1 lni lni-cart"></i>Mua Ngay</a>' : '<a class="btn btn-dark btn-sm" href="javascript:;"><i class="me-1 lni lni-cart"></i>Hết hàng</a>') .'
                            </div>
                        </div>
                    </div>
                </div>';
                break;
        }
        return $text;
    }
}

if(!function_exists('template_account')){
    function template_account($option = [], $number_item = 12, $layout = 'grid'){
        $account            = new pAccount();
        // Số lượng cần lấy
        $_REQUEST['limit']  = (validate_int($number_item) ? $number_item : 12);

        // Sắp xếp theo
        if($option['sort']){
            $_REQUEST['sort'] = $option['sort'];
        }
        // Kiểu layout
        $layout = ($layout == 'grid' ? $layout : 'list');

        // Lấy các sản phẩm hiển thị
        $_REQUEST['account_display'] = $option['account_display'] ? $option['account_display'] : '';

        // Lấy các sản phẩm vẫn còn hàng
        $_REQUEST['account_status'] = $option['account_status'] ? $option['account_status'] : '';

        // Lấy các sản phẩm cùng chuyên mục
        $_REQUEST['account_category'] = $option['account_category'] ? $option['account_category'] : '';

        // Lấy các sản phẩm nổi bật
        $_REQUEST['account_featured'] = $option['account_featured'] ? $option['account_featured'] : '';

        $data   = $account->get_all();
        $text   = '';
        foreach ($data['data'] AS $row){
            $badge = $row['account_featured'] == 'featured' ? 'Nổi bật' : '';
            $text .= template_account_detail($row, $layout, $badge);
        }
        return $text;
    }
}

if(!function_exists('account_caculator_date')){
    function account_caculator_date($end){
        $date1 = new DateTime(date('Y/m/d', time()));
        $date2 = new DateTime($end);
        $interval = $date1->diff($date2);
        $data = [
            'day'   => $interval->d,
            'month' => $interval->m,
            'year'  => $interval->y
        ];
        return $data;
    }
}

if(!function_exists('convert_title')){
    function convert_title($title, $data = []){
        if($data['account_expired'] && $data['account_price_type'] == 'change'){
            $date   = account_caculator_date($data['account_expired']);
            $title  = str_replace('{date_expired}', "({$date['month']} tháng, {$date['day']} ngày)", $title);
        }
        return $title;
    }
}

if(!function_exists('convert_price')){
    function convert_price($data = []){
        $price = $data['account_price'];
        if($data['account_price_type'] == 'change'){
            $date   = account_caculator_date($data['account_expired']);
            if($date['year'] > 0){
                $month = ($date['year']*12) + $date['month'];
                if($date['day'] >= 13 && $date['day'] < 25){
                    $month += 0.5;
                }
                if($date['day'] >= 25){
                    $month +=1;
                }
                $price = $month*$data['account_price'];
            }else{
                $month = $date['month'];
                if($date['day'] >= 13 && $date['day'] < 25){
                    $month += 0.5;
                }
                if($date['day'] >= 25){
                    $month +=1;
                }
                $price = $month*$data['account_price'];
            }
        }
        return $price;
    }
}
