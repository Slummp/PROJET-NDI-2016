<?php
  class Questions {
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly
    public $id;
    public $user_id;
    public $question_code;
    public $question_title;
    public $longitude;
    public $latitude;
    public $type; //0 => private , 1=> 50km , 2 => public
    public $date_post;
    public $question_content;

    const QUESTIONS = 'refugees_questions';
    public function __construct($data) {
      $this->id      = $data['id'];
      $this->user_id  = $data['user_id'];
      $this->question_code = $data['question_code'];
      $this->question_title = $data['question_title'];
      $this->longitude = $data['longitude'];
      $this->latitude = $data['latitude'];
      $this->type = $data['type'];
      $this->date_post = $data['date_post'];
      $this->question_content = $data['question_content'];
    }
    
    public static function getMyQuestions($user_id) {
      $list = [];
      $db = Db::getInstance();
      $sql = 'SELECT * FROM '.self::QUESTIONS.
             ' WHERE user_id = :user_id
              ORDER BY id DESC';
      $req = $db->prepare($sql);
      $req->execute(array('user_id' => intval($user_id)));

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $list[] = new Questions($post);
      }

      return $list;
    }
    
    
    public static function getLocatedQuestions($longitude, $latitude, $km=50) {
      $list = [];
      $db = Db::getInstance();
      $subquery = '
        SELECT *, 
          ( 6371 * acos( cos( radians(:latitude) ) * 
            cos( radians(latitude) ) * 
            cos( radians( longitude ) 
            - radians(:longitude) ) 
            + sin( radians(:latitude) ) 
            * sin( radians( latitude ) ) ) )
        AS distance
        
        FROM '.self::QUESTIONS.'
        WHERE type = 1';
    
      $sql = "SELECT * FROM (".$subquery.") AS t WHERE distance <= 50";
      
      $req = $db->prepare($sql);
      $req->execute(
        array(
          'latitude' => $latitude,
          'longitude' => $longitude,
          'km' => $km
        )
      );
      
      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $list[] = new Questions($post);
      }

      return $list;
    }
    
    
    public function addThemeQuestion($idQuestion,$idTheme) {
      $sql = 'INSERT INTO questions_themes (question_id, theme_id) VALUES (?,?)';
      $db = Db::getInstance();
      $req = $db->prepare($sql);
      try {
        $req->execute(
          array(
            $idQuestion,
            $idTheme
          )
        );
      } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
      }
    }
    public function add($data) {
      $sql = 'INSERT INTO '.self::QUESTIONS.' (user_id, question_code, question_title, longitude, latitude, type, question_content) VALUES (?,?,?,?,?,?,?)';
      $db = Db::getInstance();
      $req = $db->prepare($sql);
      try {
        $req->execute(
         array(
          $data['user_id'],
          $data['question_code'],
          $data['question_title'],
          $data['longitude'],
          $data['latitude'],
          $data['type'],
          $data['question_content']
        )
        );
       } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
      }
        
      return $db->lastInsertId();
    }
    
    
    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM '.self::QUESTIONS.' WHERE type = 2 ORDER BY id DESC');

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $list[] = new Questions($post);
      }

      return $list;
    }

    public static function find($code) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $req = $db->prepare('SELECT * FROM '.self::QUESTIONS.' WHERE question_code = :code ORDER BY id DESC');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('code' => $code));
      $data = $req->fetch();
      if($data) {
        return new Questions($data);
      }
      else {
        return array();
      }
    }
    
    public function getThemes() {
      $themes = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM themes ORDER BY theme ASC');

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
        $themes[$post['id']] = $post['theme'];
      }

      return $themes;
    }
  }
?>
