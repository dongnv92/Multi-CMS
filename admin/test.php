<?php
$attribute = ['hello' => 'Hiiii', 'Hai' => 'Hai Hai'];
$form_attribute = '';

foreach ($attribute AS $key => $value){
    switch ($key){
        case 'label':
            $label .= $value ? "<label>$value</label>" : '';
            break;
        case 'div_class_parent' :
        case 'div_class_child'  :
            $form_attribute .= '';
            break;
        default:
            $form_attribute .= ' '. $key .'="'. $value .'" ';
            break;
    }
}

echo "$form_attribute";