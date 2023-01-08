<?php

function connecttodb()
{
    return new PDO (
        'mysql:host=devkinsta_db;dbname=simple_store',
        'root',
        'WSC2rkMYbGqpj0v7'
);
}

function islogged()
{
    // if user logged in, return true
    // if user not logged in, return false
    return isset($_SESSION['user']);
}
function logout()
{
    // delete session data
    unset($_SESSION['user']);
}

function callAPI( $api_url = '', $method = 'GET', $formdata = [], $headers = [] ) {

    // init curl
    $curl = curl_init();

    // assign it to curl props
    $curl_props = [
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FAILONERROR => true,
        CURLOPT_CUSTOMREQUEST => $method
    ];

    // if $formdata is not empty, then we'll add in a new key called "CURLOPT_POSTFIELDS"
    if ( !empty( $formdata ) ) {
        $curl_props[ CURLOPT_POSTFIELDS ] = json_encode( $formdata );
    }

    // if $headers is not empty, then we'll add in a new key called "CURLOPT_HTTPHEADER"
    if ( !empty( $headers ) ) {
        $curl_props[ CURLOPT_HTTPHEADER ] = $headers;
    }

    // setup curl
    curl_setopt_array( $curl, $curl_props );

    // execute curl
    $response = curl_exec( $curl );

    // catch error
    $error = curl_error( $curl );

    // close curl
    curl_close( $curl );

    if ( $error )
        return 'API not working';

    return json_decode( $response );
}

?>




