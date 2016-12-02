<?php
  session_start();

  require_once('config/database.php');

  require_once('models/users.php');
  if(isset($_SESSION['userkey'])) {
    setcookie("user_session", $_SESSION['userkey'], time() + (10 * 365 * 24 * 60 * 60));
    Users::updateSession($_SESSION['userkey']);
  }
  if(!isset($_COOKIE['user_session'])) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 128; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    setcookie("user_session", $randomString, time() + (10 * 365 * 24 * 60 * 60));
    $_SESSION['userkey'] = $randomString;
    $user_id = Users::add(0);
    Users::addSession($user_id,$randomString);
  }
  
  require_once('models/questions.php');
  require_once('models/topics.php');
  
  $_SESSION['user_id'] = Users::find($_SESSION['userkey']);

  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
  } else {
    $controller = 'pages';
    $action     = 'home';
  }

  require_once('views/layout.php');
?>
