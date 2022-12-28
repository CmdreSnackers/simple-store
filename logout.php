<?php
session_start();

require 'includes/functions.php';
// make sure user is logged in
if(islogged()) {
    // delete the user session data
    logout();
    // redirect user back to login
    header('Location: //login');
    exit;
} else {
    header('Location: //login');
    exit;
}