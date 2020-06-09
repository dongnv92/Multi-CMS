<?php
require_once '../init.php';
$header['title']        = 'Các phần tử trong trang quản trị';
$header['breadcrumbs']  = admin_breadcrumbs('Phần tử HTML', 'Các phần tử trong trang quản trị', 'Phần tử HTML',[URL_ADMIN."/elements.php" => 'Phần tử HTML']);
$header['css']          = [URL_ADMIN."/assets/plugins/prism/prism.css"];
$header['js']           = [URL_ADMIN."/assets/plugins/prism/prism.js"];
require_once 'admin-header.php';
?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>Mã html Card <small>Mã html Card khi thêm mới</small></h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#">Action Link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                        <?php
                        echo sanitize_string_code_sample('<div class="card">
    <div class="header">
        <h2>Tiêu đề <small>Mô tả tiêu đề</small></h2>
        <ul class="header-dropdown m-r--5">
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="#">Action Link</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="body">
        Nội dung Card        
    </div>
</div>');
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- #END# Basic Examples -->
        <div class="col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>Thêm bảng html</h2>
                </div>
                <div class="body">
                    Nội dung Card
                </div>
            </div>
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
                        <?=formInputText('hello', ['placeholder' => 'Placeholder Text', 'label' => 'Đây là thẻ <code>input Text</code> mặc định'])?>
                        <?=sanitize_string_code_sample("<?=formInputText('name_input', ['placeholder' => 'Placeholder Text', 'label' => 'Đây là thẻ <code>input Text</code> mặc định', 'value' => ''])?>", 'php')?>
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
                        <?=formInputRadio('test1', ['male1' => 'Nam', 'female1' => 'Nữ'], ['layout' => 'inline', 'label' => 'Đây là thẻ <code>inputRadio</code>. Layout mặc định hoặc <code>inline</code>'])?>
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
                    <div class="col-lg-12">
                        <?=formButton('BLUE')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'admin-footer.php';