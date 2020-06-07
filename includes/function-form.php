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
 *
 * */
function formInputText($name, $layout = '',$attribute = ['']){
    $content            = '';
    $form_attribute     = '';
    $label              = '';
    $div_class_parent   = '';
    $div_class_child    = '';
    switch ($layout){
        default:
            foreach ($attribute AS $key => $value){
                switch ($key){
                    case 'class'            : $form_attribute .= $value ? ' class="'. $value .'" ' : ' class="form-control" '   ;   break;
                    case 'id'               : $form_attribute .= $value ? ' id="'. $value .'" ' : '_'.$name                     ;   break;
                    case 'label'            : $label .= $value ? "<label>$value</label>" : ''                                   ;   break;
                    case 'div_class_parent' : $div_class_parent .= $value ? $value : 'form-group'                               ;   break;
                    case 'div_class_child'  : $div_class_child .= $value ? $value : 'form-line'                                 ;   break;
                    default: $form_attribute .= !$value ? " $key " : ' '. $key .'="'. $value .'" ';
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
