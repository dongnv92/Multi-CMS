<?php
error_reporting(0);
require_once 'class.php';

switch ($_REQUEST['act']){
    case 'get_list_feed':
        $facebook   = new facebook();
        $data       = $facebook->getListFeed($_REQUEST['id'], 100);
        $data       = json_decode($data, true);
        echo '<table class="table table-hover">';
        foreach ($data['data'] AS $_data){
            if($_data['message']){
                echo '<tr><td><a href="'.$_data['permalink_url'].'" target="_blank">'. $facebook->text_truncate($_data['message'], 20) .'</a></td></tr>';
            }

            $comment    = $facebook->getListComments($_data['id'], 500);
            $comment    = json_decode($comment, true);
            foreach ($comment['data'] AS $_comment){
                $phone = $facebook->checkPhone($_comment['message']);
                if($phone){
                    echo '<tr><td>'. $phone .'</td></tr>';
                }
            }
        }
        echo '</table>';
        break;
}