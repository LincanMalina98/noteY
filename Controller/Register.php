<?php

class Register extends Connection
{

  private $data;
  protected $con;

  public function __construct($data)
  {
    $this->data = $data;
    $this->con = $this->openConnection();

  }

  private function encryptPassword()
  {
    return $password = md5($this->data['password']);
  }

  public function register()
  {

    try {

        $sql = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->con->prepare($sql);

        $params = [
          'name' => $this->data['name'],
          'email' => $this->data['email'],
          'password' => $this->encryptPassword(),
        ];

        Sessions::setSession('success','Your are registered successfully!');

        $stmt->execute($params);

    }catch (PDOException $e){
      echo "Cannot insert data into the database" . $e->getMessage();
    }
  }


}

