<?php
//get route from global
$path = $_SERVER["REQUEST_URI"];
//remove / from start and end
$path = trim($path, '/');
//remove all url ? parameters
$path = parse_url($path, PHP_URL_PATH);


switch ($path) {
  case 'login':
    require "pages/login.php";
    break;
  case 'signup':
    require "pages/signup.php";
    break;
  case 'cart':
    require "pages/cart.php";
    break;
  case 'orders':
    require "pages/orders.php";
    break;
  case 'logout':
    require "pages/logout.php";
    break;
  case 'checkout':
    require "pages/checkout.php";
    break;
  default:
    require "pages/home.php";
    break;
}


