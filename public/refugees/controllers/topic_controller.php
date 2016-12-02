<?php
  class TopicController {
    public function read() {
      $questionInfo = Questions::find($_GET['code']);
      if(!count($questionInfo)) {
        header('location: /refugees/index.php');
      }
      
      if(count($_POST)) {
        $data = array(
          'answer' => $_POST['answer'],
          'user_id' => $_SESSION['user_id'],
          'question_id' => $questionInfo->id 
        );
        Topics::add($data);
        header('location: /refugees/index.php?controller=topic&action=read&code='.$_GET['code']);
      }
      $topics = Topics::getAnswerQuestions($questionInfo->id);
      require_once('views/topics/read.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>
