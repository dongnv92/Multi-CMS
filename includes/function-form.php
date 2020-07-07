<?php

/*
 * Mở from nhanh bằng PHP
 * $action: Là đường dẫn form khi Submit
 * $attribute : Là các thuộc tính của thẻ form.
 * VD: formOpen('', ['class' => 'form-control', 'method' => 'POST', ...])
 * */
function formOpen($action = "", $attribute = ['']){
    $form_attribute = '';
    // Thiết lập các giá trị mặc định
    foreach ($attribute AS $key => $value){
        switch ($key){
            case 'enctype':
                $form_attribute .= 'enctype="multipart/form-data"';
                break;
            default:
                $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
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

function formError($text){
    return '<label class="error">'. $text .'</label>';
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
            $error              = '';
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'error':
                        $error .= formError($value);
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
                '. ($error ? $error : '') .'
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
            $error              = '';
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'error':
                        $error .= formError($value);
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
                '. ($error ? $error : '') .'
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
            $error              = '';
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'error':
                        $error .= formError($value);
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
                '. ($error ? $error : '') .'
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
    $error              = '';
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
                    case 'error':
                        $error .= formError($value);
                        break;
                    case 'layout'       :
                    case 'value'        :
                    case 'selected'     :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }

            $content .= $label.'<select '. $form_attribute .' name="'. $name .'">';
            foreach ($data AS $value => $text){
                $content .= '<option '. ($value == $attribute['selected'] ? 'selected' : '') .' value="'. $value .'">'. $text .'</option>';
            }
            $content .= '</select>'. ($error ? $error : '');
            break;
    }
    return $content;
}

/* Thẻ Radio trong From
 * $name: là tag name trong thẻ
 * $data: Là dữ liệu data option dạng array. Ex' $data = ['hanoi' => 'Hà Nội', 'danang' => 'Đà Nẵng', ....]
 * $attribute: Là mảng gồm các attribute trong thẻ.
 *  - 1 số key không có trong meta attribute có thể dùng làm file cài đặt
 *      - layout            : Là giao diện thẻ select
 *      - class             : Mặc định "form-control"
 *      - id                : Mặc định "_$name"
 *      - ...               : ...
 * */
function formInputRadio($name, $data, $attribute = []){
    $content            = '';
    $form_attribute     = '';
    $label              = '';
    $div_class_parent   = '';
    $layout             = $attribute['layout'];
    $error              = '';
    switch ($layout){
        case 'inline':
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'custom-control-input';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            $div_class_parent   = $attribute['div_class_parent']    ? $attribute['div_class_parent']    : "form-group";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'error':
                        $error .= formError($value);
                        break;
                    case 'div_class_parent' :
                    case 'layout'  :
                    case 'value'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }
            $content .= $label.'<div class="'. $div_class_parent .'">';
            foreach ($data AS $value => $text){
                $content .= '<div class="custom-control custom-radio custom-control-inline"><input type="radio" name="'. $name .'" value="'. $value .'" id="_'. $value .'" '. $form_attribute .'><label class="custom-control-label" for="_'. $value .'">'. $text .'</label></div>';
            }
            $content .= ($error ? $error : '').'</div>';
            break;
        default:
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'custom-control-input';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            $div_class_parent   = $attribute['div_class_parent']    ? $attribute['div_class_parent']    : "form-group";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'error':
                        $error .= formError($value);
                        break;
                    case 'div_class_parent' :
                    case 'layout'  :
                    case 'value'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }
            $content .= $label.'<div class="'. $div_class_parent .'">';
            foreach ($data AS $value => $text){
                $content .= '<div class="custom-control custom-radio"><input type="radio" name="'. $name .'" value="'. $value .'" id="_'. $value .'" '. $form_attribute .'><label class="custom-control-label" for="_'. $value .'">'. $text .'</label></div>';
            }
            $content .= ($error ? $error : '').'</div>';
            break;
    }
    return $content;
}

/* Thẻ Checkbox trong From
 * $name: là tag name trong thẻ
 * $data: Là dữ liệu data option dạng array. Ex' $data = ['hanoi' => 'Hà Nội', 'danang' => 'Đà Nẵng', ....]
 * $attribute: Là mảng gồm các attribute trong thẻ.
 *  - 1 số key không có trong meta attribute có thể dùng làm file cài đặt
 *      - layout            : Là giao diện thẻ select
 *      - class             : Mặc định "form-control"
 *      - id                : Mặc định "_$name"
 *      - ...               : ...
 * */
function formInputCheckbox($name, $data, $attribute = []){
    $content            = '';
    $form_attribute     = '';
    $label              = '';
    $div_class_parent   = '';
    $layout             = $attribute['layout'];
    $error              = '';
    switch ($layout){
        case 'inline':
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'form-check-input';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            $div_class_parent   = $attribute['div_class_parent']    ? $attribute['div_class_parent']    : "form-group";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'error':
                        $error .= formError($value);
                        break;
                    case 'div_class_parent' :
                    case 'layout'  :
                    case 'value'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }
            $content .= $label.'<div class="'. $div_class_parent .'">';
            foreach ($data AS $value => $text){
                $content .= '<div class="form-check form-check-inline"><input type="checkbox" name="'. $name .'" value="'. $value .'" id="_'. $value .'" '. $form_attribute .'><label class="form-check-label" for="_'. $value .'">'. $text .'</label></div>';
            }
            $content .= ($error ? $error : '').'</div>';
            break;
        default:
            // Thiết lập các giá trị mặc định
            $attribute['class'] = $attribute['class']               ? $attribute['class']               : 'form-check-input';
            $attribute['id']    = $attribute['id']                  ? $attribute['id']                  : "_$name";
            $div_class_parent   = $attribute['div_class_parent']    ? $attribute['div_class_parent']    : "form-group";
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'label':
                        $label .= $value ? "<label>$value</label>" : '';
                        break;
                    case 'error':
                        $error .= formError($value);
                        break;
                    case 'div_class_parent' :
                    case 'layout'  :
                    case 'value'  :
                        $form_attribute .= '';
                        break;
                    default:
                        $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                        break;
                }
            }
            $content .= $label.'<div class="'. $div_class_parent .'">';
            foreach ($data AS $value => $text){
                $content .= '<div class="form-check"><input type="checkbox" name="'. $name .'" value="'. $value .'" id="_'. $value .'" '. $form_attribute .'><label class="form-check-label" for="_'. $value .'">'. $text .'</label></div>';
            }
            $content .= ($error ? $error : '').'</div>';
            break;
    }
    return $content;
}

function formButton($text, $attribute = []){
    $content            = '';
    $form_attribute     = '';
    $attribute['class'] = $attribute['class']   ? $attribute['class']   : 'btn btn-raised bg-blue waves-effect';
    $attribute['type']  = $attribute['type']    ? $attribute['type']    : 'button';
    foreach ($attribute AS $key => $value){
        switch ($key){
            default:
                $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
                break;
        }
    }
    $content .= '<button '. $form_attribute .'>'. $text .'</button>';
    return $content;
}