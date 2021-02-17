<?php

  class Login extends Connection
  {

    private $data;
    private $records;
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

    private function selectUserCredential()
    {

      $sql = "SELECT * FROM users WHERE email =:email AND password=:password LIMIT 1";
      $stmt = $this->con->prepare($sql);

      $params = [
        'email' => $this->data['email'],
        'password' => $this->encryptPassword()
      ];

      $stmt->execute($params);

      return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function login()
    {
       $errors = '';

       $this->records = $this->selectUserCredential();

        if ($this->data['email'] === $this->records['email'] && md5($this->data['password']) === $this->records['password']) {

          Sessions::setSession('id',$this->records['id']);

          header("Location: index.php");
        } else {
          $errors = "Email address or password are wrong,please try again!";
        }
      return $errors;
    }

  }
