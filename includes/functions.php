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

?>




