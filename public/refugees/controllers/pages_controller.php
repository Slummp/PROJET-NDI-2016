<?php
  class PagesController {
    public function home() {
      
      $infoIP = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=d3538c354ba668e3937fa471bb1dfd0eb50a5df91bc625b706298622fcbc80ac&ip='.$_SERVER['REMOTE_ADDR'], FILE_USE_INCLUDE_PATH);
      $infoIP = explode(';', $infoIP);
      $latitude = $infoIP[8];
      $longitude = $infoIP[9]; 
      
      $myQuestions = Questions::getMyQuestions($_SESSION['user_id']);
      $nearQuestions = Questions::getLocatedQuestions($longitude, $latitude);
      $allQuestions = Questions::all();
      require_once('views/pages/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
    
 
  }
?>
