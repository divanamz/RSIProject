<?php
  class Model {
    protected $dbconn; 

    public function __construct() {
      $host = 'localhost';
      $dbuser = 'root';
      $dbpass = '';
      $dbname = 'rsidb';
      $dbport = '3306';
  
      $this->dbconn = new mysqli("localhost", "root", "", "rsidb", "3306");
      
      if ($this->dbconn->connect_errno) { 
        die('Database connection failure');
      }
      
    }

    public function getDbConnection() {
      return $this->dbconn;
    }

    

    
}
  