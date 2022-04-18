<?php
require_once ABSPATH . 'content/theme/suha/init.php';
switch ($path[0]){
    case 'test.html':
        $array_1 = ['mot' => ['hai' => true, 'ba' => true, 'bon' => true], 'nam' => ['sau' => false, 'bay' => true, 'tam' => true]];
        $array_2 = ['mot' => ['hai' => false, 'ba' => false, 'bon' => false], 'nam' => ['sau' => true, 'bay' => false, 'tam' => false]];
        $array = [];

        foreach ($array_1 AS $_key_1 => $_value_1){
            foreach ($_value_1 AS $_key_2 => $_value_2){
                $array[$_key_1][$_key_2] = (($_value_2 == true || $array_2[$_key_1][$_key_2]) ? true : false);
            }
        }
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        Break;
    case 'bomb.html':
        ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Lấy mã Chát ID Bot Telegram</title>
    <!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="icon" href="https://muataikhoan.net/content/assets/images/system/favicon.ico">
<meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body class="bg-light">

<div class="container">
  <main>
  <div class="py-5 text-center">
      <h2>LẤY MÃ ID CHÁT CHO BOT TELEGRAM</h2>
      <p class="lead">Để tạo Bot đầu tiên chát với <a href="https://t.me/BotFather" target="_blank">@BotFather</a>, chát với lệnh <span class="text-danger">/newbot</span>, Sau đó bạn đặt tên và user name cho bot. Sau khi hoàn thành bot sẽ gửi cho bạn thông tin token của bot bạn mới tạo. Để nhận thông báo từ BOT, bạn hãy chát 1 vài câu với BOT bạn mới tạo và nhập mã TOKEN bạn mới nhận ở trên vào đây, nhập xong hệ thống sẽ gửi về các mã ID chát của BOT</p>
    </div>
    <div class="row g-5">
        <div class="col-12">
            <div class="input-group">
            <input type="text" id="token" class="form-control" placeholder="Nhập mã TOKEN BOT vào đây. VD: 5841867436:AAHuZIqThrurQgZNeZTf5HEpKhbXQ7qxK1U">
            <button type="submit" class="btn btn-primary" id="click">LẤY MÃ CHAT ID</button>
          </div>
    </div>

    <div class="py-5 text-center">

  <p class="lead" id="result"></p>
</div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2022 DONG NGUYEN</p>
    <ul class="list-inline">
    </ul>
  </footer>
</div>
    <script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  <script language="JavaScript">
    $(document).ready(function () {
        $('#click').on('click', function (){
            let token = $('#token').val();
            if(!token){
                $('#result').html('Vui lòng nhập mã TOKEN');
                return false;
            }

                let btnText     = $(this).text();
                let id          = '#' + $(this).attr('id');
                let textLoading = ' VUI LÒNG CHỜ ... ';
                let urlLoad     = '<?=URL_API . "telegram/bomb"?>';

                var ajax = $.ajax({
                    url         : urlLoad,
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {'token' : token},
                    beforeSend  : function () {
                        $(id).attr('disabled', true);
                        $(id).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>'+ textLoading +'</span>');
                    }
                });
                ajax.done(function (data) {
                    setTimeout(function (){

                            $(id).attr('disabled', false);
                            $(id).html(btnText);
                            $('#result').html(data.message);

                    }, 500)
                });
                ajax.fail(function( jqXHR, textStatus ) {
                    $(id).attr('disabled', false);
                    $(id).html(btnText);
                    toastr.error(jqXHR.responseText);
                });
        });
    });
</script>
  </body>
</html>

        <?php
        break;
    case 'payment':
        switch ($path[1]){
            default:
                $transaction_code   = str_replace('.html', '', $path[1]);
                $account            = new pAccount();
                $transaction        = $account->get_transaction(['transaction_code' => $transaction_code]);
                // Check nếu mã giao dịch không tồn tại
                if(!$transaction){
                    $header['title'] = 'Đơn hàng';
                    require_once 'header.php';
                    ?>
                    <div class="container">
                        <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
                            <div class="offline-text text-center">
                                <h5>Nội dung không tồn tại</h5>
                                <p>Đơn hàng không tông tại hoặc đã bị xóa, vui lòng kiểm tra lại đường dẫn.</p><a class="btn btn-outline-danger" href="<?=URL_HOME?>">Trang chủ</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    require_once 'footer.php';
                    break;
                }

                switch ($transaction['transaction_payment_method']){
                    case 'momo':
                        $qrcode = new QRCode('2|99|0966624292|NGUYEN VAN DONG|0|0|0|'.$transaction['transaction_total_money']);
                        $qrcode->setConfig([
                            'bgColor' => '#FFFFFF',
                            'body' => 'diamond',
                            'bodyColor' => '#0277bd',
                            'brf1' => [],
                            'brf2' => [],
                            'brf3' => [],
                            'erf1' => [],
                            'erf2' => [],
                            'erf3' => [],
                            'eye' => 'frame12',
                            'eye1Color' => '#000000',
                            'eye2Color' => '#000000',
                            'eye3Color' => '#000000',
                            'eyeBall' => 'ball14',
                            'eyeBall1Color' => '#000000',
                            'eyeBall2Color' => '#000000',
                            'eyeBall3Color' => '#000000',
                            'gradientColor1' => '#0277bd',
                            'gradientColor2' => '#000000',
                            'gradientOnEyes' => 'true',
                            'gradientType' => 'linear',
                        ]);
                        $qrcode->setSize(500);
                        $image     = $qrcode->create();
                        $header['js']       = [
                            URL_JS . "account/payment?account={$transaction['transaction_code']}"
                        ];
                        $header['title'] = 'Chi tiết đơn hàng';
                        require_once 'header.php';
                        ?>
                        <div class="checkout-wrapper-area py-3 text-center">
                            <div class="credit-card-info-wrapper">
                                <h5 class="text-danger">Quét Mã Để Thanh Toán</h5>
                                <!--<img class="d-block mb-4" src="<?/*=$image*/?>" alt="">-->
                                <img class="d-block mb-4" src="<?=$image?>" alt="Quét Mã Để Thanh Toán">
                                <p>
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1"/>
                                            <path d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z" fill="#000000"/>
                                        </g>
                                    </svg> Sử dụng App <strong class="text-danger">MOMO</strong> để quét mã QRcode, kiểm tra lại thông tin bên dưới và nhập đúng nội dung.<br>
                                    Sau khi quét mã thanh toán xong hãy đợi 30 giây, hệ thống sẽ tự hiện thông tin tài khoản cho bạn, nếu hệ thống không hiện hãy làm mới trang hoặc <a href="">Bấm vào đây</a>
                                </p>
                            </div>
                        </div>
                        <div class="my-order-wrapper pt-3">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <!-- Single Order Status-->
                                    <div class="single-order-status active">
                                        <div class="order-icon shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                                                <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="order-text">
                                            <h6>Đơn Hàng</h6><span><?=$transaction['transaction_code']?> (<?=date('H:i:s d/m/Y', strtotime($transaction['transaction_create']))?>)</span>
                                        </div>
                                        <div class="order-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Single Order Status-->
                                    <div class="single-order-status active">
                                        <div class="order-icon shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M14.4862 18L12.7975 21.0566C12.5304 21.54 11.922 21.7153 11.4386 21.4483C11.2977 21.3704 11.1777 21.2597 11.0887 21.1255L9.01653 18H5C3.34315 18 2 16.6569 2 15V6C2 4.34315 3.34315 3 5 3H19C20.6569 3 22 4.34315 22 6V15C22 16.6569 20.6569 18 19 18H14.4862Z" fill="black"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7H15C15.5523 7 16 7.44772 16 8C16 8.55228 15.5523 9 15 9H6C5.44772 9 5 8.55228 5 8C5 7.44772 5.44772 7 6 7ZM6 11H11C11.5523 11 12 11.4477 12 12C12 12.5523 11.5523 13 11 13H6C5.44772 13 5 12.5523 5 12C5 11.4477 5.44772 11 6 11Z" fill="black"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="order-text">
                                            <h6>Thông Tin Chuyển Khoản</h6>
                                            <span>ĐIỆN THOẠI: <strong class="text-danger">0966624292 (Nguyễn Văn Đông)</strong></span>
                                            <span>SỐ TIỀN: <strong class="text-danger"><?=convert_number_to_money($transaction['transaction_total_money'])?></strong></span>
                                            <span>NỘI DUNG: <strong class="text-danger"><?=$transaction['transaction_payment_content']?></strong></span>
                                        </div>
                                        <div class="order-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Single Order Status-->
                                    <div class="single-order-status active">
                                        <div class="order-icon shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z" fill="#000000"/>
                                                    <path d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z" fill="#000000" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="order-text">
                                            <h6>Trạng thái đơn hàng</h6>
                                            <span>
                                                <?php
                                                switch ($transaction['transaction_status']){
                                                    case 'false':
                                                        echo '<strong class="text-danger">Đơn hàng đã bị hủy</strong>';
                                                        break;
                                                    case 'wait':
                                                        echo 'Thời hạn thanh toán: <strong class="text-success countdown">'. gmdate("i:s", ($transaction['transaction_deadline'] - time())) .'</strong>';
                                                        break;
                                                    case 'success':
                                                        echo '<strong class="text-success">Đơn Hàng Đã Hoàn Thành</strong>';
                                                        break;
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <div class="order-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <?php
                                        if($transaction['transaction_status'] == 'success'){
                                        $account_info = $account->get_account($transaction['transaction_account']);
                                    ?>
                                    <div class="single-order-status active">
                                        <div class="order-icon shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="order-text">
                                            <h6>THÔNG TIN TÀI KHOẢN</h6>
                                            <span>Tên Đăng Nhập: <strong class="text-danger"><?=$account_info['account_login']?></strong></span>
                                            <span>Mật Khẩu: <strong class="text-danger"><?=$account_info['account_password']?></strong></span>
                                        </div>
                                        <div class="order-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <?php }else{?>
                                    <div class="single-order-status active">
                                        <div class="order-icon shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="order-text">
                                            <h6>THÔNG TIN TÀI KHOẢN</h6>
                                            <span>Tên Đăng Nhập: <strong class="text-danger">Thanh toán để xem</strong></span>
                                            <span>Mật Khẩu: <strong class="text-danger">Thanh toán để xem</strong></span>
                                        </div>
                                        <div class="order-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php
                        require_once 'footer.php';
                        break;
                }
                break;
        }
        break;
    case 'settings.html':
        $header['title'] = 'Cài đặt';
        require_once 'header.php';
        ?>
        <div class="container">
            <!-- Settings Wrapper-->
            <div class="settings-wrapper py-3">
                <!-- Single Setting Card-->
                <div class="card settings-card">
                    <div class="card-body">
                        <!-- Single Settings-->
                        <div class="single-settings d-flex align-items-center justify-content-between">
                            <div class="title"><i class="lni lni-night"></i><span>Night Mode</span></div>
                            <div class="data-content">
                                <div class="toggle-button-cover">
                                    <div class="button r">
                                        <input class="checkbox" id="darkSwitch" type="checkbox">
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    case 'payment-momo.html':
        $product_id = ($_REQUEST['account'] ? $_REQUEST['account'] : ($_SESSION['account']['account_id'] ? $_SESSION['account']['account_id'] : ''));
        $account    = new pAccount();
        $product    = $account->get_account($product_id);
        if(!$product){
            redirect(URL_HOME);
            exit();
        }
        if(!in_array($product['account_status'], ['instock', 'wait_payment'])){
            redirect(create_url_product($product['account_url']));
            exit();
        }

        $_REQUEST['account_id']     = $product['account_id'];
        $_REQUEST['account_amout']  = ($_SESSION['account']['amount'] && validate_int($_SESSION['account']['amount']) ? $_SESSION['account']['amount'] : 1);
        $_REQUEST['account_price']  = convert_price($product);
        $_REQUEST['account_coupon'] = ($_SESSION['account']['coupon'] ? $_SESSION['account']['coupon'] : '');
        $_REQUEST['account_method'] = 'momo';
        $transaction = $account->transaction_add();

        if($transaction['response'] != 200){
            redirect(create_url_product($product['account_url']));
            exit();
        }
        redirect(URL_PAYMENT . "/{$transaction['code']}.html");
        exit();

        /*$qrcode = new QRCode('2|99|0962778307|NGUYEN VAN QUAN|0|0|0|'.convert_price($product));
        $qrcode->setConfig([
            'bgColor' => '#FFFFFF',
            'body' => 'diamond',
            'bodyColor' => '#0277bd',
            'brf1' => [],
            'brf2' => [],
            'brf3' => [],
            'erf1' => [],
            'erf2' => [],
            'erf3' => [],
            'eye' => 'frame12',
            'eye1Color' => '#000000',
            'eye2Color' => '#000000',
            'eye3Color' => '#000000',
            'eyeBall' => 'ball14',
            'eyeBall1Color' => '#000000',
            'eyeBall2Color' => '#000000',
            'eyeBall3Color' => '#000000',
            'gradientColor1' => '#0277bd',
            'gradientColor2' => '#000000',
            'gradientOnEyes' => 'true',
            'gradientType' => 'linear',
        ]);
        $qrcode->setSize(500);
        $image     = $qrcode->create();*/

        $header['js']       = [
            URL_JS . "account/payment"
        ];
        $header['title'] = 'Thanh toán qua ví điện tử MOMO';
        require_once 'header.php';
        ?>
        <div class="container">
            <div class="checkout-wrapper-area py-3 text-center">
                <div class="credit-card-info-wrapper">
                    <h5 class="text-danger">Quét Mã Để Thanh Toán</h5>
                    <!--<img class="d-block mb-4" src="<?/*=$image*/?>" alt="">-->
                    <img class="d-block mb-4" src="https://api.qrcode-monkey.com/tmp/682c0bd8acd487267304e4c7d6ba9a8b.png" alt="">
                    <p>
                        <i class="lni lni-frame-expand"></i> Sử dụng App <strong class="text-danger">MOMO</strong> để quét mã QRcode, kiểm tra lại thông tin bên dưới và nhập đúng nội dung.<br />
                        Số điện thoại nhận: <strong class="text-danger">0962778307 (Nguyễn Văn Quân)</strong><br />
                        Số tiền: <strong class="text-danger"><?=convert_number_to_money(convert_price($product))?></strong><br />
                        Nội dung: <strong class="text-danger">BUY <?=$transaction['id']?></strong><br />
                        Thời hạn thanh toán: <strong class="countdown text-danger"><?=$transaction['time']?></strong>
                    </p>
                    <hr />
                </div>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    case 'checkout-payment.html':
        $product_id = ($_REQUEST['account'] ? $_REQUEST['account'] : ($_SESSION['account']['account_id'] ? $_SESSION['account']['account_id'] : ''));
        $account    = new pAccount();
        $product    = $account->get_account($product_id);
        if(!$product){
            redirect(URL_HOME);
            exit();
        }
        if($product['account_status'] != 'instock'){
            $header['title'] = 'Giỏ hàng';
            require_once 'header.php';
            ?>
            <div class="container">
                <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
                    <div class="offline-text text-center">
                        <h5>Hết hàng</h5>
                        <p>Tài khoản này đã được mua hoặc đã bị xóa, vui lòng kiểm tra lại.</p><a class="btn btn-outline-danger" href="<?=URL_PRODUCT . "/index.html"?>">Xem Tài Khoản</a>
                    </div>
                </div>
            </div>
            <?php
            require_once 'footer.php';
            break;
        }
        $header['title'] = 'Chọn phương thức thanh toán';
        require_once 'header.php';
        ?>
        <div class="container">
            <!-- Checkout Wrapper-->
            <div class="checkout-wrapper-area py-3">
                <!-- Choose Payment Method-->
                <div class="choose-payment-method">
                    <h6 class="mb-3 text-center">Chọn một phương thức thanh toán</h6>
                    <div class="row justify-content-center g-3">
                        <!--MOMO-->
                        <div class="col-6 col-md-5">
                            <div class="single-payment-method">
                                <a class="paypal active" href="<?=URL_PAYMENT_MOMO?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-wallet2 mb-2 text-dark" viewBox="0 0 16 16">
                                        <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                                    </svg>
                                    <h6>VÍ MOMO</h6>
                                </a>
                            </div>
                        </div>
                        <!--MOMO-->
                        <div class="col-6 col-md-5">
                            <div class="single-payment-method">
                                <a class="credit-card" href="javascript:;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-credit-card-2-front mb-2 text-dark" viewBox="0 0 16 16">
                                        <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"/>
                                        <path d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                    <h6>THẺ ĐIỆN THOẠI <small class="text-warning">(Đang tích hợp)</small></h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    case 'checkout.html':
        $product_id = ($_REQUEST['account'] ? $_REQUEST['account'] : ($_SESSION['account']['account_id'] ? $_SESSION['account']['account_id'] : ''));
        $account    = new pAccount();
        $product    = $account->get_account($product_id);
        if(!$product){
            redirect(URL_HOME);
            exit();
        }
        if($product['account_status'] != 'instock'){
            $header['title'] = 'Giỏ hàng';
            require_once 'header.php';
            ?>
            <div class="container">
                <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
                    <div class="offline-text text-center">
                        <h5>Hết hàng</h5>
                        <p>Tài khoản này đã được mua hoặc đã bị xóa, vui lòng kiểm tra lại.</p><a class="btn btn-outline-danger" href="<?=URL_PRODUCT . "/index.html"?>">Xem Tài Khoản</a>
                    </div>
                </div>
            </div>
            <?php
            require_once 'footer.php';
            break;
        }

        $header['title'] = 'Xác nhận và thanh toán';
        require_once 'header.php';
        ?>
        <div class="container">
            <!--begin::cart item-->
            <div class="cart-wrapper-area py-3">
                <div class="cart-table card mb-3">
                    <div class="table-responsive card-body">
                        <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th scope="row"><a class="remove-product" href="#"><i class="lni lni-close"></i></a></th>
                                <td><img src="<?=$product['images'][0]?>" width="300px" height="300px" alt=""></td>
                                <td><a href="<?=create_url_product($product['account_url'])?>"><?=convert_title($product['account_title'], $product)?><span><?=convert_number_to_money(convert_price($product))?> × 1</span></a></td>
                                <td>
                                    <div class="quantity">
                                        <input class="qty-text" type="text" value="1">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::cart item-->
            <div class="checkout-wrapper-area py-3">
                <!-- Billing Address-->
                <div class="billing-information-card mb-3">
                    <div class="card billing-information-title-card bg-danger">
                        <div class="card-body">
                            <h6 class="text-center mb-0 text-white">THÔNG TIN BẢO HÀNH</h6>
                        </div>
                    </div>
                    <div class="card user-data-card">
                        <div class="card-body">
                            <div class="single-profile-data d-flex align-items-center justify-content-between">
                                <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Họ và Tên</span></div>
                                <div class="data-content"><?=($_SESSION['account']['account_name'] ? $_SESSION['account']['account_name'] : '---')?></div>
                            </div>
                            <div class="single-profile-data d-flex align-items-center justify-content-between">
                                <div class="title d-flex align-items-center"><i class="lni lni-phone"></i><span>Điện thoại</span></div>
                                <div class="data-content"><?=($_SESSION['account']['account_phone'] ? $_SESSION['account']['account_phone'] : '---')?></div>
                            </div>
                            <!-- Edit Address-->
                            <a class="btn btn-danger w-100" href="<?=URL_CART . "?account={$_SESSION['account']['account_id']}"?>">Thay đổi thông tin</a>
                        </div>
                    </div>
                </div>
                <!-- Billing Address-->
                <!--begin::checkout-->
                <div class="card cart-amount-area">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <h5 class="total-price mb-0"><?=convert_number_to_money(convert_price($product))?></h5><a href="<?=URL_CHECKOUT_PAYMENT?>" class="btn btn-danger">THANH TOÁN</a>
                    </div>
                </div>
                <!--end::checkout-->
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    case 'cart.html':
        $product_id = ($_REQUEST['account'] ? $_REQUEST['account'] : ($_SESSION['account']['account_id'] ? $_SESSION['account']['account_id'] : ''));
        $account    = new pAccount();
        $product    = $account->get_account($product_id);
        if(!$product){
            $header['title'] = 'Giỏ hàng';
            require_once 'header.php';
            ?>
            <div class="container">
                <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
                    <div class="offline-text text-center">
                        <h5>Giỏ hàng trống</h5>
                        <p>Giỏ hàng đang trống, hãy chọn 1 sản phẩm bạn cần mua và thanh toán.</p><a class="btn btn-outline-danger" href="<?=URL_PRODUCT . "/index.html"?>">Xem Tài Khoản</a>
                    </div>
                </div>
            </div>
            <?php
            require_once 'footer.php';
            break;
        }

        if($product['account_status'] != 'instock'){
            $header['title'] = 'Giỏ hàng';
            require_once 'header.php';
            ?>
            <div class="container">
                <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
                    <div class="offline-text text-center">
                        <h5>Hết hàng</h5>
                        <p>Tài khoản này đã được mua hoặc đã bị xóa, vui lòng kiểm tra lại.</p><a class="btn btn-outline-danger" href="<?=URL_PRODUCT . "/index.html"?>">Xem Tài Khoản</a>
                    </div>
                </div>
            </div>
            <?php
            require_once 'footer.php';
            break;
        }

        $_SESSION['account']['account_id']          = $_REQUEST['account'];
        if($_REQUEST['submit'] && $product){
            $_SESSION['account']['account_name']    = ($_REQUEST['account_name']    ? $_REQUEST['account_name']     : '');
            $_SESSION['account']['account_phone']   = ($_REQUEST['account_phone']   ? $_REQUEST['account_phone']    : '');
            redirect(URL_CHECKOUT);
        }
        $header['title'] = 'Giỏ hàng';
        require_once 'header.php';
        ?>
        <div class="container">
            <!--begin::cart item-->
            <div class="cart-wrapper-area py-3">
                <div class="cart-table card mb-3">
                    <div class="table-responsive card-body">
                        <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th scope="row"><a class="remove-product" href="#"><i class="lni lni-close"></i></a></th>
                                <td><img src="<?=$product['images'][0]?>" width="300px" height="300px" alt=""></td>
                                <td><a href="<?=create_url_product($product['account_url'])?>"><?=convert_title($product['account_title'], $product)?><span><?=convert_number_to_money(convert_price($product))?> × 1</span></a></td>
                                <td>
                                    <div class="quantity">
                                        <input class="qty-text" type="text" value="1">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::cart item-->
            <!--begin::info-->
            <form action="" method="post">
            <div class="card user-data-card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="text-danger">
                            <i>- Nhập chính xác thông tin để chúng tôi xác thực thông tin trong trường hợp bảo hành.<br />- Trường hợp không nhập thông tin, chúng tôi từ chối bảo hành với tài khoản này.</i>
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="title mb-2"><i class="lni lni-user"></i><span>Họ và Tên</span></div>
                        <input class="form-control" name="account_name" placeholder="Nhập họ và tên" type="text" value="<?=($_SESSION['account']['account_name'] ? $_SESSION['account']['account_name'] : '')?>">
                    </div>
                    <div class="mb-3">
                        <div class="title mb-2"><i class="lni lni-phone"></i><span>Số điện thoại</span></div>
                        <input class="form-control" name="account_phone" type="text" placeholder="Nhập số điện thoại" value="<?=($_SESSION['account']['account_phone'] ? $_SESSION['account']['account_phone'] : '')?>">
                    </div>
                </div>
            </div>
            <!--end::info-->
            <!--begin::checkout-->
            <div class="card cart-amount-area">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h5 class="total-price mb-0"><?=convert_number_to_money(convert_price($product))?></h5><button type="submit" name="submit" value="submit" class="btn btn-danger">XÁC NHẬN THÔNG TIN</button>
                </div>
            </div>
            </form>
            <!--end::checkout-->
        </div>
        <?php
        require_once 'footer.php';
        break;
    case 'category':
        switch ($path[1]){
            default:
                $meta   = new meta($database, 'type_account_category');
                $meta   = $meta->get_meta_by_slug($path[1]);
                if($meta['response'] == 200){
                    $header['title'] = $meta['data']['meta_name'].' - Chuyên Mục';
                }
                $option = [
                    'account_category'  => $meta['data']['meta_id'],
                    'account_status'    => 'instock'
                ];
                require_once 'header.php';
                echo template_category();
                ?>
                <!--Begin:: Tài khoản mới nhất -->
                <div class="top-products-area clearfix py-3">
                    <div class="container">
                        <div class="section-heading d-flex align-items-center justify-content-between">
                            <h6><?=$meta['data']['meta_name']?></h6>
                        </div>
                        <div class="row g-3">
                            <?=template_account($option, '', 'list')?>
                        </div>
                    </div>
                </div>
                <!--End:: Tài khoản mới nhất -->
                <?php
                require_once 'footer.php';
                break;
        }
        break;
    case 'product':
        switch ($path[1]){
            case 'index.html':
                $option = [];
                $header['title'] = 'Tấ cả sản phẩm';

                if($_REQUEST['category'] && validate_int($_REQUEST['category'])){
                    $option['account_category'] = $_REQUEST['category'];
                    $meta   = new meta($database, 'type_account_category');
                    $title  = $meta->get_meta($_REQUEST['category']);
                    if($title['response'] == 200){
                        $header['title'] = $title['data']['meta_name'].' - Chuyên Mục';
                    }
                }
                require_once 'header.php';
                echo template_category();
                ?>
                <!--Begin:: Tài khoản mới nhất -->
                <div class="top-products-area clearfix py-3">
                    <div class="container">
                        <div class="section-heading d-flex align-items-center justify-content-between">
                            <h6>Tất cả sản phẩm</h6>
                        </div>
                        <div class="row g-3">
                            <?=template_account($option, '', 'list')?>
                        </div>
                    </div>
                </div>
                <!--End:: Tài khoản mới nhất -->
                <?php
                require_once 'footer.php';
                break;
            default:
                $account    = new pAccount();
                $product    = $account->get_account_by_url(str_replace('.html', '', $path[1]));
                $meta       = new meta($database, 'type_account_category');
                $meta       = $meta->get_meta($product['account_category']);

                $header['title'] = convert_title($product['account_title'], $product);
                require_once 'header.php';
                ?>
                <!-- Product Slides-->
                <div class="product-slides owl-carousel">
                    <?php foreach ($product['images'] AS $product_image){?>
                    <div class="single-product-slide" style="background-image: url('<?=$product_image?>')"></div>
                    <?php }?>
                </div>
                <div class="product-description pb-3">
                <!-- Product Title & Meta Data-->
                <div class="product-title-meta-data bg-white mb-3 py-3">
                    <div class="container d-flex justify-content-between">
                        <div class="p-title-price">
                            <h6 class="mb-1"><?=convert_title($product['account_title'], $product)?></h6>
                            <p class="sale-price mb-0"><?=convert_number_to_money(convert_price($product))?></p>
                        </div>
                        <div class="p-wishlist-share"><a href="wishlist-grid.html"><i class="lni lni-heart"></i></a></div>
                    </div>
                    <!-- Ratings-->
                    <div class="product-ratings">
                        <div class="container d-flex align-items-center justify-content-between">
                            <div class="ratings">
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <span class="ps-1">3 đánh giá</span>
                            </div>
                            <div class="total-result-of-ratings">
                                <?php if($product['account_status'] == 'instock'){?>
                                    <a href="<?=URL_CART . "?account={$product['account_id']}"?>" class="btn btn-danger btn-block">Mua Ngay</a>
                                <?php }else{?>
                                    <a href="javascript:;" class="btn btn-dark btn-block">Hết Hàng</a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button Buy-->
                <div class="cart-form-wrapper bg-white mb-3 py-3">
                    <div class="container">
                        <div class="profile-wrapper-area py-3">
                            <div class="card user-data-card">
                                <div class="card-body">
                                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                                        <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Chuyên mục</span></div>
                                        <div class="data-content"><strong><a href="<?=create_url_category($meta['data']['meta_url'], 'url')?>"><?=$meta['data']['meta_name']?></a></strong></div>
                                    </div>
                                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                                        <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Ngày hết hạn</span></div>
                                        <div class="data-content"><strong><?=($product['account_expired'] ? date('d-m-Y', strtotime($product['account_expired'])) : '---')?></strong></div>
                                    </div>
                                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                                        <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Gói tài khoản</span></div>
                                        <div class="data-content"><strong><?=$product['account_package']?></strong></div>
                                    </div>
                                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                                        <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Trạng thái</span></div>
                                        <div class="data-content"><strong><?=($product['account_status'] == 'instock' ? 'Còn hàng' : 'Hết hàng')?></strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Content-->
                <div class="p-specification bg-white mb-3 py-3">
                    <div class="container">
                        <h6>Nội dung</h6>
                        <?=$product['account_content']?>
                    </div>
                </div>
                <!--Begin:: Cùng chuyên mục -->
                <div class="top-products-area clearfix py-3">
                    <div class="container">
                        <div class="section-heading d-flex align-items-center justify-content-between">
                            <h6>Cùng chuyên mục</h6>
                        </div>
                        <div class="row g-3">
                            <?=template_account(['account_category' => $meta['data']['meta_id']], '4', 'list')?>
                        </div>
                    </div>
                </div>
                <?php
                require_once 'footer.php';
                break;
        }
        break;
    default:
        $header['title'] = 'Trang chủ - Tài khoản xem phim, bóng đá giá rẻ';
        require_once 'header.php';
        echo template_slides();
        echo template_category();
        ?>
        <!--Begin:: Tài khoản mới nhất -->
        <div class="top-products-area clearfix py-3">
            <div class="container">
                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Tài khoản mới nhất</h6><a class="btn btn-danger btn-sm" href="<?=URL_HOME . "/product/index.html"?>">Xem tất cả</a>
                </div>
                <div class="row g-3">
                    <?=template_account([
                        'account_display'   => 'show',
                        'account_status'    => 'instock'
                    ], 6, 'grid')?>
                </div>
            </div>
        </div>
        <!--End:: Tài khoản mới nhất -->
        <!--Begin:: Tài khoản HOT -->
        <div class="top-products-area clearfix py-3">
            <div class="container">
                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Tài khoản nổi bật</h6><a class="btn btn-danger btn-sm" href="<?=URL_HOME . "/product/index.html"?>">Xem tất cả</a>
                </div>
                <div class="row g-3">
                    <?=template_account([
                        'account_display'   => 'show',
                        'account_status'    => 'instock',
                        'account_featured'  => 'featured'
                    ], 6, 'list')?>
                </div>
            </div>
        </div>
        <!--End:: Tài khoản mới HOT -->
        <?php
        require_once 'footer.php';
        break;
}
