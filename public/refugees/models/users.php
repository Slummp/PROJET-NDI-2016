<?php
  class Users {
    const SESSION = 'session';
    const USERS = 'users';
    
    public $type;
    public $id;
    
     public function __construct($data) {
      $this->id   = $data['id'];
      $this->type  = $data['type'];
    }
    
    public function add($type) {
      $sql = "INSERT INTO ".self::USERS." (type) VALUES (?)";
      $db = Db::getInstance();
      $req = $db->prepare($sql);
      try {
        $req->execute(
          array(
            $type
          ) 
        );
       } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
      }
        
      return $db->lastInsertId();
    }
    
    public function addSession($user_id, $user_key) {
      $sql = "INSERT INTO ".self::SESSION." (id,id_user) VALUES (?,?)";
      $db = Db::getInstance();
      $req = $db->prepare($sql);
      try {
        $req->execute(
          array(
            $user_key, $user_id
          ) 
        );
       } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
      }
        
      return $db->lastInsertId();
    }
    
    public function updateSession($userkey) {
      $sql = "UPDATE ".self::SESSION." SET timestamp = '".date('Y-m-d H:i:s')."' WHERE id = ?";
      $db = Db::getInstance();
      $req = $db->prepare($sql);
      try {
        $req->execute(
          array(
            $userkey
          ) 
        );
       } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
      }
     
    }
    
    public static function find($userkey) {
      $db = Db::getInstance();
      $sql = 'SELECT * FROM '.self::SESSION.
             ' WHERE id = :userkey';
      $req = $db->prepare($sql);
      $req->execute(array('userkey' => $userkey));


      $res = $req->fetch();
      if(isset($res['id_user']))
        return $res['id_user'];
      else 
        return false;
    }
  }
?>
