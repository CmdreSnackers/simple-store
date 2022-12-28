<?php
$path = $_SERVER["REQUEST_URI"];
// var_dump($_SERVER["REQUEST_URI"]);
switch ($path) {
  case '/login':
    require "pages/login.php";
    break;
  case '/signup[':
    require "pages/signup.php";
    break;
  case '/cart':
    require "pages/cart.php";
    break;
  case '/orders':
    require "pages/orders.php";
    break;
  case '/logout':
    require "pages/logout.php";
    break;
  default:
    require "pages/home.php";
    break;
}


