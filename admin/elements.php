<?php
$header['title']        = 'Các phần tử trong trang quản trị';
$header['css']          = [URL_ADMIN_ASSETS."plugins/prism/prism.css"];
$header['js']           = [URL_ADMIN_ASSETS."plugins/prism/prism.js"];
require_once 'admin-header.php';
?>
    <div class="components-preview wide-md mx-auto">
        <div class="nk-block nk-block-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Mẫu Card</h4>
                    <p>Mẫu Card.</p>
                </div>
            </div>
            <div class="code-block">
                <h6 class="overline-title title">Code Mẫu</h6>
                <button class="btn btn-sm clipboard-init" title="Copy to clipboard" data-clipboard-target="#cardTT" data-clip-success="Đã Copy nội dung" data-clip-text="Copy"><span class="clipboard-text">Copy</span></button>
                <pre class="prettyprint lang-html" id="cardTT">
                    <?php
                echo sanitize_string_code_sample('<div class="card card-bordered">
        <div class="card-inner border-bottom">
            <!-- Title -->
            <div class="card-title-group">
                <div class="card-title"><h6 class="title">Tiêu đề</h6></div>
                <div class="card-tools">
                    <a href="#" class="link">Xem tất cả</a>
                </div>
            </div>
            <!-- Title -->
        </div>
        <!-- Content -->
        <div class="card-inner">
            Nội dung
        </div>
        <!-- End Content -->
    </div>');
                    ?>
                </pre>
            </div><!-- .code-block -->
        </div>
<!-- -------------------------------------------------------------------------------- -->
        <div class="nk-block nk-block-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Mẫu Ajax</h4>
                    <p>Mẫu gửi một request Ajax.</p>
                </div>
            </div>
            <div class="code-block">
                <h6 class="overline-title title">Code Mẫu</h6>
                <button class="btn btn-sm clipboard-init" title="Copy to clipboard" data-clipboard-target="#ex_ajax" data-clip-success="Đã Copy nội dung" data-clip-text="Copy"><span class="clipboard-text">Copy</span></button>
                <pre class="prettyprint lang-js" id="ex_ajax">
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
});");
                    ?>
                </pre>
            </div><!-- .code-block -->
        </div>
<!-- -------------------------------------------------------------------------------- -->
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Mẫu Bảng</h4>
                <p>Mẫu bảng data.</p>
            </div>
        </div>
        <div class="code-block">
            <h6 class="overline-title title">Code Mẫu</h6>
            <button class="btn btn-sm clipboard-init" title="Copy to clipboard" data-clipboard-target="#ex_table" data-clip-success="Đã Copy nội dung" data-clip-text="Copy"><span class="clipboard-text">Copy</span></button>
            <pre class="prettyprint lang-js" id="ex_table">
                <?php
                echo sanitize_string_code_sample('<div class="nk-block">
            <div class="card card-bordered card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner position-relative card-tools-toggle">
                        <div class="card-title-group">
                            <div class="card-tools">
                                <div class="form-inline flex-nowrap gx-3">
                                    <?=formInputText(\'search\', [\'label\' => \'Tìm kiếm\', \'value\' => \'Hihiii\'])?>
                                    <div class="form-wrap w-150px">
                                        <select class="form-select form-select-sm" data-search="off" data-placeholder="Bulk Action">
                                            <option value="">Bulk Action</option>
                                            <option value="email">Send Email</option>
                                            <option value="group">Change Group</option>
                                            <option value="suspend">Suspend User</option>
                                            <option value="delete">Delete User</option>
                                        </select>
                                    </div>
                                    <div class="btn-wrap">
                                        <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Apply</button></span>
                                        <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                                    </div>
                                </div><!-- .form-inline -->
                            </div><!-- .card-tools -->
                            <div class="card-tools mr-n1">
                                <ul class="btn-toolbar gx-1">
                                    <li class="btn-toolbar-sep"></li><!-- li -->
                                    <li>
                                        <div class="toggle-wrap">
                                            <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                            <div class="toggle-content" data-content="cardTools">
                                                <ul class="btn-toolbar gx-1">
                                                    <li class="toggle-close">
                                                        <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                    </li><!-- li -->
                                                    <li>
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                <em class="icon ni ni-setting"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                <ul class="link-check">
                                                                    <li><span>Show</span></li>
                                                                    <li class="active"><a href="#">10</a></li>
                                                                    <li><a href="#">20</a></li>
                                                                    <li><a href="#">50</a></li>
                                                                </ul>
                                                                <ul class="link-check">
                                                                    <li><span>Order</span></li>
                                                                    <li class="active"><a href="#">DESC</a></li>
                                                                    <li><a href="#">ASC</a></li>
                                                                </ul>
                                                            </div>
                                                        </div><!-- .dropdown -->
                                                    </li><!-- li -->
                                                </ul><!-- .btn-toolbar -->
                                            </div><!-- .toggle-content -->
                                        </div><!-- .toggle-wrap -->
                                    </li><!-- li -->
                                </ul><!-- .btn-toolbar -->
                            </div><!-- .card-tools -->
                        </div><!-- .card-title-group -->
                    </div><!-- .card-inner -->
                    <div class="card-inner p-0">
                        <table class="table table-tranx table-hover">
                            <thead>
                            <tr class="tb-tnx-head">
                                <th class="tb-tnx-id"><span class="">#</span></th>
                                <th class="tb-tnx-info">
                                            <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                <span>Bill For</span>
                                            </span>
                                    <span class="tb-tnx-date d-md-inline-block d-none">
                                                <span class="d-md-none">Date</span>
                                                <span class="d-none d-md-block">
                                                    <span>Issue Date</span>
                                                    <span>Due Date</span>
                                                </span>
                                            </span>
                                </th>
                                <th class="tb-tnx-amount is-alt">
                                    <span class="tb-tnx-total">Total</span>
                                    <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                                </th>
                                <th class="tb-tnx-action">
                                    <span>&nbsp;</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="tb-tnx-item">
                                <td class="tb-tnx-id">
                                    <a href="#"><span>4947</span></a>
                                </td>
                                <td class="tb-tnx-info">
                                    <div class="tb-tnx-desc">
                                        <span class="title">Enterprize Year Subscrition</span>
                                    </div>
                                    <div class="tb-tnx-date">
                                        <span class="date">10-05-2019</span>
                                        <span class="date">10-13-2019</span>
                                    </div>
                                </td>
                                <td class="tb-tnx-amount is-alt">
                                    <div class="tb-tnx-total">
                                        <span class="amount">$599.00</span>
                                    </div>
                                    <div class="tb-tnx-status">
                                        <span class="badge badge-dot badge-warning">Due</span>
                                    </div>
                                </td>
                                <td class="tb-tnx-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li><a href="#">View</a></li>
                                                <li><a href="#">Edit</a></li>
                                                <li><a href="#">Remove</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- .card-inner-group -->
            </div><!-- .card -->
        </div><!-- .nk-block -->');
                ?>
            </pre>
        </div><!-- .code-block -->
    </div>
        <!-- #END# Basic Examples -->

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