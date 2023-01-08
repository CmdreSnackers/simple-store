<?php

require 'config.php';
require 'includes/functions.php';
require 'includes/class-orders.php';



//make sure the get[] is availible
if(isset($_GET['billplz'])) {


    $string = 'billplzid' . $_GET['billplz']['id'] . '|billplzpaid_at' . $_GET['billplz']['paid_at'] . '|billplzpaid' . $_GET['billplz']['paid'];

    //create a signature to compare with one by billplz
    $signature = hash_hmac('sha256', $string, BILLPLZ_X_SIGNATURE);

    //verify signature
    if($signature === $_GET['billplz']['x_signature']) {

        //get order status
        //shorthand if statement
        $status = $_GET['billplz']['paid'] === 'true' ? 'completed' : 'failed';

        //update order status
        $orders = new Orders();
        $orders->updateOrder(
            $_GET['billplz']['id'], // billplz id as transaction_id
            $status
        );

        //redirect user back to order page
        header('Location: /orders');
        exit;

    } else {
        echo 'Invalid Signature';
    }

} else {
    echo 'No Data Found';
}
