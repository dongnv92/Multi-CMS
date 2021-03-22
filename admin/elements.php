<?php
$header['title']        = 'Các phần tử trong trang quản trị';
$header['css']          = [URL_ADMIN_ASSETS."plugins/prism/prism.css"];
$header['js']           = [URL_ADMIN_ASSETS."plugins/prism/prism.js"];
require_once 'admin-header.php';
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-bordered">
                <div class="card-inner border-bottom">
                    <div class="card-title-group">
                        <div class="card-title"><h6 class="title">Card</h6></div>
                    </div>
                </div>
                <div class="card-inner">
                    <?php
                    echo sanitize_string_code_sample('<div class="card card-bordered">
    <div class="card-inner border-bottom">
        <!-- Title -->
        <div class="card-title-group">
            <div class="card-title"><h6 class="title">Card</h6></div>
            <div class="card-tools">
                <a href="#" class="link">Xem tất cả</a>
            </div>
        </div>
        <!-- Title -->
    </div>
    <!-- Content -->
    <div class="card-inner">
        Hello
    </div>
    <!-- End Content -->
</div>');
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-bordered">
                <div class="card-inner border-bottom">
                    <!-- Title -->
                    <div class="card-title-group">
                        <div class="card-title"><h6 class="title">Ajax</h6></div>
                        <div class="card-tools">
                            <a href="#" class="link">Xem tất cả</a>
                        </div>
                    </div>
                    <!-- Title -->
                </div>
                <!-- Content -->
                <div class="card-inner">
                    <?php
                    echo sanitize_string_code_sample("var ajax = $.ajax({
    url         : '<?=URL_ADMIN_AJAX . \"login\"?>',
    method      : 'POST',
    dataType    : 'json',
    data        : $('form').serialize(),
    beforeSend  : function () {
        $('#submit_login').attr('disabled', true);
        $('#submit_login').html('Text Disable ...');
    }
});
ajax.done(function (data) {
    $('#id').attr('disabled', false);
    $('#id').html('Text Enable');
    alert(data.message);
});

ajax.fail(function( jqXHR, textStatus ) {
    $('#id').attr('disabled', false);
    $('#id').html('Text Enable');
    alert( \"Request failed: \" + textStatus );
});", 'javascript');
                ?>
                </div>
                <!-- End Content -->
            </div>
        </div>
        <!-- #END# Basic Examples -->
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <div class="row">
                        <div class="col-lg-6 text-left"><h2>Bảng demo</h2></div>
                    </div>
                </div>
                <div class="content table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th style="width: 20%" class="text-center align-middle">Nội Dung</th>
                            <th style="width: 20%" class="text-center align-middle">Giá</th>
                            <th style="width: 20%" class="text-center align-middle">Trạng Thái</th>
                            <th style="width: 20%" class="text-center align-middle">Ngày Thêm</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center align-middle">Hiii</td>
                            <td class="text-center align-middle">200₫</td>
                            <td class="text-center align-middle">Chờ Gửi</td>
                            <td class="text-center align-middle">10:40:35 09/06/2020</td>
                        </tr>
                        <tr>
                            <td class="text-center align-middle">HEllo</td>
                            <td class="text-center align-middle">200₫</td>
                            <td class="text-center align-middle">Hoàn Thành</td>
                            <td class="text-center align-middle">10:00:04 08/06/2020</td>
                        </tr>
                        <tr>
                            <td class="text-center align-middle">Dong</td>
                            <td class="text-center align-middle">200₫</td>
                            <td class="text-center align-middle">Hoàn Thành</td>
                            <td class="text-center align-middle">22:01:41 06/06/2020</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?=sanitize_string_code_sample('<div class="card">
    <div class="header">
        <div class="row">
            <div class="col-lg-6 text-left"><h2>Bảng demo</h2></div>
        </div>
    </div>
    <div class="content table-responsive">
        <table class="table table-hover mb-0">
            <thead>
            <tr>
                <th style="width: 20%" class="text-center align-middle">Nội Dung</th>
                <th style="width: 20%" class="text-center align-middle">Giá</th>
                <th style="width: 20%" class="text-center align-middle">Trạng Thái</th>
                <th style="width: 20%" class="text-center align-middle">Ngày Thêm</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center align-middle">Hiii</td>
                <td class="text-center align-middle">200₫</td>
                <td class="text-center align-middle">Chờ Gửi</td>
                <td class="text-center align-middle">10:40:35 09/06/2020</td>
            </tr>
            <tr>
                <td class="text-center align-middle">...</td>
                <td class="text-center align-middle">...</td>
                <td class="text-center align-middle">...</td>
                <td class="text-center align-middle">...</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>', 'html')?>
        </div>
    </div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Tạo và đóng Form trong Backend <small>Mã tạo nhanh Form trong admin</small></h2>
            </div>
            <div class="body">
                <p>Mở <code>Form</code> mới bằng 1 trong các cách sau. <small><code>$attribute</code> có thể là method, class, enctype, ...</small></p>
                <p><?=sanitize_string_code_sample('<?php echo formOpen($action, $attribute)?>', 'php')?>
                <p>Hoặc</p>
                <?=sanitize_string_code_sample('<?=formOpen($action, $attribute)?>', 'php')?>
                <p>Ví dụ:</p>
                <?=sanitize_string_code_sample('<?=formOpen(\'\', ["class" => "form-control", "enctype" => "true", "method" => "POST"])?>', 'php')?>
                <p>Đóng <code>Form</code> bằng cách sau.</p>
                <p><?=sanitize_string_code_sample('<?formClose()?>', 'php')?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Thẻ Input <small>Các thẻ Input</small></h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <?=formInputText('hello', ['error' => 'Đây là thông báo lỗi', 'placeholder' => 'Placeholder Text', 'label' => 'Đây là thẻ <code>input Text</code> mặc định'])?>
                        <?=sanitize_string_code_sample("<?=formInputText('name_input', ['error' => 'Đây là thông báo lỗi', 'placeholder' => 'Placeholder Text', 'label' => 'Đây là thẻ <code>input Text</code> mặc định', 'value' => ''])?>", 'php')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?=formInputPassword('hello', ['placeholder' => 'Input Password', 'label' => 'Đây là thẻ <code>input Password</code> mặc định'])?>
                        <?=sanitize_string_code_sample("<?=formInputPassword('name_input', ['placeholder' => 'Placeholder Password', 'label' => 'Đây là thẻ <code>input Password</code> mặc định', 'value' => ''])?>", 'php')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?=formInputTextarea('hello', ['placeholder' => 'Placeholder Textarea', 'label' => 'Đây là thẻ <code>textarea</code> mặc định', 'rows' => '5'])?>
                        <?=sanitize_string_code_sample("<?=formInputTextarea('hello', ['placeholder' => 'Placeholder Textarea', 'label' => 'Đây là thẻ <code>textarea</code> mặc định', 'rows' => '5'])?>", 'php')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?=formInputSelect('test', ['hanoi' => 'Hà Nội', 'danang' => 'Đà Nẵng', 'hcm' => 'Hồ Chí Minh'], ['data-live-search' => 'true', 'selected' => 'hcm', 'label' => 'Đây là thẻ <code>select</code> mặc định. Thêm Live Search với thuộc tính <code>data-live-search</code>'])?>
                        <?=sanitize_string_code_sample("<?=formInputSelect('test', ['hanoi' => 'Hà Nội', 'danang' => 'Đà Nẵng', 'hcm' => 'Hồ Chí Minh'], ['data-live-search' => 'true', 'selected' => 'hcm', 'label' => 'Đây là thẻ <code>select</code> mặc định'])?>", 'php')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?=formInputRadio('test', ['male' => 'Nam', 'female' => 'Nữ'], ['label' => 'Đây là thẻ <code>inputRadio</code>. Layout mặc định hoặc <code>inline</code>'])?>
                        <?=formInputRadio('test1', ['male1' => 'Nam', 'female1' => 'Nữ'], ['error' => 'Đây là thông báo lỗi', 'layout' => 'inline', 'label' => 'Đây là thẻ <code>inputRadio</code>. Layout mặc định hoặc <code>inline</code>'])?>
                        <?=sanitize_string_code_sample("<?=formInputRadio('test', ['male' => 'Nam', 'female' => 'Nữ'], ['label' => 'Đây là thẻ <code>inputRadio</code>. Layout mặc định hoặc <code>inline</code>'])?>", 'php')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?=formInputCheckbox('test_1', ['male_11' => 'Nam', 'female_11' => 'Nữ', 'all_11' => 'Tất cả'], ['label' => 'Đây là thẻ <code>inputCheckbox</code>. Layout mặc định hoặc <code>inline</code>'])?>
                        <?=formInputCheckbox('test_2', ['male_22' => 'Nam', 'female_22' => 'Nữ', 'all_22' => 'Tất cả'], ['layout' => 'inline', 'label' => 'Đây là thẻ <code>inputCheckbox</code>. Layout mặc định hoặc <code>inline</code>'])?>
                        <?=sanitize_string_code_sample("<?=formInputCheckbox('test_2', ['male_22' => 'Nam', 'female_22' => 'Nữ', 'all_22' => 'Tất cả'], ['layout' => 'inline', 'label' => 'Đây là thẻ <code>inputCheckbox</code>. Layout mặc định hoặc <code>inline</code>'])?>", 'php')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <p>Mặc định</p>
                        <?=formButton('BLUE')?>
                    </div>
                    <div class="col-lg-4 text-center">
                        <p>Màu RED <code>.btn  btn-raised bg-red waves-effect</code></p>
                        <?=formButton('RED', ['class' => 'btn  btn-raised bg-red waves-effect'])?>
                    </div>
                    <div class="col-lg-4 text-center">
                        <p>Màu PINK <code>.btn  btn-raised bg-pink waves-effect</code></p>
                        <?=formButton('PINK', ['disabled' => 'disabled', 'class' => 'btn  btn-raised bg-pink waves-effect'])?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <p>Màu PURPLE <code>.btn  btn-raised bg-purple waves-effect</code></p>
                        <?=formButton('PURPLE', ['class' => 'btn  btn-raised bg-purple waves-effect'])?>
                    </div>
                    <div class="col-lg-4 text-center">
                        <p>Màu DEEP PURPLE <code>.btn  btn-raised bg-deep-purple waves-effect</code></p>
                        <?=formButton('DEEP PURPLE', ['class' => 'btn  btn-raised bg-deep-purple waves-effect'])?>
                    </div>
                    <div class="col-lg-4 text-center">
                        <p>Màu INDIGO <code>.btn  btn-raised bg-indigo waves-effect</code></p>
                        <?=formButton('INDIGO', ['disabled' => 'disabled', 'class' => 'btn  btn-raised bg-indigo waves-effect'])?>
                    </div>
                    <div class="col-lg-12 text-center">
                        <?=sanitize_string_code_sample("<?=formButton('INDIGO', ['disabled' => 'disabled', 'class' => 'btn  btn-raised bg-indigo waves-effect'])?>", 'php')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'admin-footer.php';