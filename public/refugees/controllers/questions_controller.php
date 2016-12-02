<?php
  class QuestionsController {
    public function add() {
      $themes = Questions::getThemes();
      if(count($_POST)) {
        $infoIP = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=d3538c354ba668e3937fa471bb1dfd0eb50a5df91bc625b706298622fcbc80ac&ip='.$_SERVER['REMOTE_ADDR'], FILE_USE_INCLUDE_PATH);
        $infoIP = explode(';', $infoIP);
        $latitude = $infoIP[8];
        $longitude = $infoIP[9];  
        
        $data = $_POST;
        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;
        $data['user_id'] = $_SESSION['user_id'];
        $data['question_code'] = $this->generateRandomString();
        $idQuestion = Questions::add($data);

        foreach($_POST['themes'] as $key => $value) {
          echo $key;
          Questions::addThemeQuestion($idQuestion, $key);
        }
        header('location: /refugees/index.php?controller=topic&action=read&code='.$data['question_code']);
        
      }
      require_once('views/questions/add.php');
    }
    
    public function access() {
      
      if(count($_POST)) {
        $result = Questions::find($_POST['code']);
        if(count($result)) {
          header('location: /refugees/index.php?controller=topic&action=read&code='.$_POST['code']);
        }
        else {
          header('location: /refugees/index.php');
        }
      }
      else {
        require_once('views/questions/access.php');
      }
    }
    
    public function error() {
      require_once('views/pages/error.php');
    }
    
    private function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
  }
?>
