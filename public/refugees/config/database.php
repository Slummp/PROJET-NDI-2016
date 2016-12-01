<?php
  class Db {
    
	private $user = 'root';
	private $pass = 'root';
	private $db = 'ndi';
	
	private static $instance = NULL;
    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance = new PDO('mysql:host=localhost;dbname='.$this->db, $this->db->user, $this->db->pass, $pdo_options);
      }
      return self::$instance;
    }
  }
?>
