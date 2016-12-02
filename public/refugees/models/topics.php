<?php
  class Topics {
    const TOPICS = 'refugees_answers';
    
    public $id;
    public $user_id;
    public $question_id;
    public $date_post;
    public $answer;


    public function __construct($data) {
      $this->id      = $data['id'];
      $this->user_id  = $data['user_id'];
      $this->question_id = $data['question_id'];
      $this->date_post = $data['date_post'];
      $this->answer = $data['answer'];
    }
    
    public static function getAnswerQuestions($questionId) {
      $list = [];
      $db = Db::getInstance();
      $sql = 'SELECT * FROM '.self::TOPICS.
             ' WHERE question_id = :question_id
             ORDER BY date_post DESC';
      $req = $db->prepare($sql);
      $req->execute(array('question_id' => intval($questionId)));

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $list[] = new Topics($post);
      }

      return $list;
    }
    
    public function add($data) {
      $sql = 'INSERT INTO '.self::TOPICS.' (user_id, question_id, answer) VALUES (?,?,?)';
      $db = Db::getInstance();
      $req = $db->prepare($sql);
      try {
        $req->execute(
         array(
          $data['user_id'],
          $data['question_id'],
          $data['answer']
          )
        );
       } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
      }
        
      return $db->lastInsertId();
    }
  }
?>
