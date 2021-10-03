<?php
header('Content-Type: application/json');

switch ($path[2]){
    case 'transaction_check':
        $momo       = new MomoAccount();
        $list_his   = $momo->getHistoryByPayment($_REQUEST['date_start'], $_REQUEST['date_end'], strtoupper($_REQUEST['comment']), $_REQUEST['money']);
        if($list_his['response'] != 200){
            echo encode_json($list_his);
            break;
        }
        $account        = new pAccount();
        $account->transaction_refresh();
        $transaction    = $account->get_transaction(['transaction_code' => $_REQUEST['code'], 'transaction_status' => 'wait']);
        if(!$transaction){
            echo encode_json(['response' => 309, 'message' => 'Giao dịch này đã hết hạn hoặc bị hủy']);
            break;
        }

        // Kiểm tra xem ID lịch sử giao dịch momo đã thanh toán cho đơn hàng nào chưa
        $check_momo = $account->get_transaction(['transaction_payment_id' => $list_his['data']['history_id']]);
        if($check_momo){
            echo encode_json(['response' => 309, 'message' => 'Giao dịch này đã được thanh toán cho đơn khác.']);
            break;
        }

        // Thay đổi trạng thái thành hết hàng
        $account->change_status_account($transaction['account_id'], 'outstock');

        //Update lại thông tin đơn hàng
        $data_trans = [
            'transaction_payment_info'      => $list_his['data']['history_tran_partner_id'],
            'transaction_payment_name'      => $list_his['data']['history_tran_partner_name'],
            'transaction_payment_network'   => 'momo',
            'transaction_payment_id'        => $list_his['data']['history_id'],
            'transaction_note'              => 'Giao dịch thành công',
            'transaction_status'            => 'success',
            'transaction_finish'            => get_date_time()
        ];
        $database->where(['transaction_id' => $transaction['transaction_id']])->update('dong_account_transaction', $data_trans);
        echo encode_json(['response' => 200, 'message' => 'Thanh toán thành công']);
        break;
    case 'transaction_refresh':
        $account = new pAccount();
        $account->transaction_refresh();
        echo encode_json(['response' => 200, 'message' => 'Đồng bộ dữ liệu thành công']);
        break;
    default:

        break;
}