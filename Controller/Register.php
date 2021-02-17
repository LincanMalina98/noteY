<?php

class Register extends Connection
{

  use Records;

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
        $params = [
          'name' => $this->data['name'],
          'email' => $this->data['email'],
          'password' => $this->encryptPassword(),
        ];

        $this->queryBuilder($this->con , "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)",$params);

        Sessions::setSession('success','Your are registered successfully!');

    }catch (PDOException $e){
      echo "Cannot insert data into the database" . $e->getMessage();
    }
  }


}

