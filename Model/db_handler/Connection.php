<?php


  class Connection
  {

    private $server = "mysql:host=localhost;dbname=noteY";
    private $username = "root";
    private $password = "root";
    private $options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,);

    protected $con;

    public function openConnection()
    {
       try{

         $this->con = new PDO($this->server,$this->username,$this->password,$this->options);
         return $this->con;

       }catch(PDOException $e){
          echo "Connection to the database failed!" . $e->getMessage();
       }
    }

    public function closeConnection()
    {
      $this->con = null;
    }



  }
