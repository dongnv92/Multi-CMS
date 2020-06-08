<?php

/*
 * Mở from nhanh bằng PHP
 * $action: Là đường dẫn form khi Submit
 * $attribute : Là các thuộc tính của thẻ form.
 * VD: formOpen('', ['class' => 'form-control', 'method' => 'POST', ...])
 * */
function formOpen($action = "", $attribute = ['']){
    $form_attribute = '';
    foreach ($attribute AS $key => $value){
        switch ($key){
            case 'method':
                $form_attribute .= (in_array($value, ['post', 'POST', 'get', 'GET']) && $value) ? ' method="'. $value .'" ' : '';
                break;
            case 'class':
                $form_attribute .= $value ? ' class="'. $value .'" ' : ' class="form-control" ';
                break;
            case 'enctype':
                $form_attribute .= $value ? ' enctype="enctype="multipart/form-data" ' : '';
                break;
            default:
                $form_attribute .= " $key = $value\"\" ";
                break;
        }
    }
    return '<form action="'. $action .'" '. $form_attribute .'>';
}

/*
 * Kết thúc 1 Form
 * VD: formClose()
 * */
function formClose(){
    return '</form>';
}

/* Thẻ Input trong From
 * $name: là tag name trong thẻ
 * $attribute: Là mảng gồm các attribute trong thẻ.
 *  - 1 số key không có trong meta attribute có thể dùng làm file cài đặt
 *      - layout            : Là giao diện thẻ input
 *      - class             : Mặc định "form-control"
 *      - id                : Mặc định "_$name"
 *      - div_class_parent  : Thẻ class ở ngoài cùng
 *      - div_class_child   : Thẻ class ở trong
 *      - ...               : ...
 * */
function formInputText($name, $attribute = ['']){
    $content            = '';
    $form_attribute     = '';
    $label              = '';
    $div_class_parent   = '';
    $div_class_child    = '';
    $layout             = $attribute['layout'];
    switch ($layout){
        default:
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'form-control';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            $div_class_parent   = $attribute['div_class_parent']    ? $attribute['div_class_parent']    : "form-group";
            $div_class_child    = $attribute['div_class_child']     ? $attribute['div_class_child']     : "form-line";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'div_class_parent' :
                    case 'div_class_child'  :
                    case 'layout'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }
            $content .= $label.'
            <div class="'. $div_class_parent .'">
                <div class="'. $div_class_child .'">
                    <input type="text" name="'. $name .'" '. $form_attribute .'>
                </div>
            </div>';
            break;
    }
    return $content;
}

/* Thẻ Input trong From
 * $name: là tag name trong thẻ
 * $attribute: Là mảng gồm các attribute trong thẻ.
 *  - 1 số key không có trong meta attribute có thể dùng làm file cài đặt
 *      - layout            : Là giao diện thẻ input
 *      - class             : Mặc định "form-control"
 *      - id                : Mặc định "_$name"
 *      - div_class_parent  : Thẻ class ở ngoài cùng
 *      - div_class_child   : Thẻ class ở trong
 *      - ...               : ...
 * */
function formInputPassword($name, $attribute = ['']){
    $content            = '';
    $form_attribute     = '';
    $label              = '';
    $div_class_parent   = '';
    $div_class_child    = '';
    $layout             = $attribute['layout'];
    switch ($layout){
        default:
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'form-control';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            $div_class_parent   = $attribute['div_class_parent']    ? $attribute['div_class_parent']    : "form-group";
            $div_class_child    = $attribute['div_class_child']     ? $attribute['div_class_child']     : "form-line";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'div_class_parent' :
                    case 'div_class_child'  :
                    case 'layout'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }
            $content .= $label.'
            <div class="'. $div_class_parent .'">
                <div class="'. $div_class_child .'">
                    <input type="password" name="'. $name .'" '. $form_attribute .'>
                </div>
            </div>';
            break;
    }
    return $content;
}

/* Thẻ TextArea trong From
 * $name: là tag name trong thẻ
 * $attribute: Là mảng gồm các attribute trong thẻ.
 *  - 1 số key không có trong meta attribute có thể dùng làm file cài đặt
 *      - layout            : Là giao diện thẻ Textarea
 *      - class             : Mặc định "form-control"
 *      - id                : Mặc định "_$name"
 *      - div_class_parent  : Thẻ class ở ngoài cùng
 *      - div_class_child   : Thẻ class ở trong
 *      - ...               : ...
 * */

function formInputTextarea($name, $attribute = []){
    $content            = '';
    $form_attribute     = '';
    $label              = '';
    $div_class_parent   = '';
    $div_class_child    = '';
    $layout             = $attribute['layout'];
    switch ($layout){
        default:
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'form-control no-resize';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            $div_class_parent   = $attribute['div_class_parent']    ? $attribute['div_class_parent']    : "form-group";
            $div_class_child    = $attribute['div_class_child']     ? $attribute['div_class_child']     : "form-line";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'div_class_parent' :
                    case 'div_class_child'  :
                    case 'layout'  :
                    case 'value'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }
            $content .= $label.'
            <div class="'. $div_class_parent .'">
                <div class="'. $div_class_child .'">
                    <textarea name="'. $name .'" '. $form_attribute .'>'. ($attribute['value'] ? $attribute['value'] : '') .'</textarea>
                </div>
            </div>';
            break;
    }
    return $content;
}

/* Thẻ Select trong From
 * $name: là tag name trong thẻ
 * $data: Là dữ liệu data option dạng array. Ex' $data = ['hanoi' => 'Hà Nội', 'danang' => 'Đà Nẵng', ....]
 * $attribute: Là mảng gồm các attribute trong thẻ.
 *  - 1 số key không có trong meta attribute có thể dùng làm file cài đặt
 *      - layout            : Là giao diện thẻ select
 *      - class             : Mặc định "form-control"
 *      - id                : Mặc định "_$name"
 *      - ...               : ...
 * */
function formInputSelect($name, $data = [], $attribute = []){
    $content            = '';
    $form_attribute     = '';
    $label              = '';
    $layout             = $attribute['layout'];
    switch ($layout){
        default:
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'form-control show-tick';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'layout'  :
                    case 'value'  :
                    case 'selected'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }

            $content .= $label.'<select '. $form_attribute .'>';
            foreach ($data AS $value => $text){
                $content .= '<option '. ($value == $attribute['selected'] ? 'selected' : '') .' value="'. $value .'">'. $text .'</option>';
            }
            $content .= '</select>';
            break;
    }
    return $content;
}