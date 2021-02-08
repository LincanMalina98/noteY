<?php


  class Validate
  {
    private $data;
    private $errors = [];

    private static $fields = array('name','email','password','confirm_password');

    public function __construct($data)
    {
      $this->data = $data;
    }

    public function validateRegisterFormData()
    {

      foreach (self::$fields as $field){

        if(!array_key_exists($field,$this->data)){
          die("$field do not exist!");
        }
      }

      $this->validateName();
      $this->validateEmail();
      $this->validatePassword();
      $this->validateConfirmPassword();

      return $this->errors;

    }

    public function validateNotesData()
    {

      $this->filedIsEmpty();

      return $this->errors;
    }

    private function filedIsEmpty()
    {
      foreach ($this->data as $key => $value){
          if(empty($value)){
            $this->addError($key, "{$key} filed cannot be empty!");
          }
      }

    }

    public function escapeHtmlChars()
    {
      $trimmedValue = array();

       foreach ($this->data as $key => $value){

           $trimmedValue[$key] = htmlspecialchars(trim($value));
       }

       return $trimmedValue;
    }

    private function validateName()
    {
      if(empty($this->data['name'])){
        $this->addError('name','Name filed cannot be empty!');
      }else if(strlen($this->data['name']) > 30){
        $this->addError('name','Name cannot be longer than 30 characters.');
      }

    }

    private function validateEmail()
    {

      if(empty($this->data['email']))
      {
        $this->addError('email','Email cannot be empty');
      }elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)){
        $this->addError('email','This is not a valid email address');
      }

    }

    private function validatePassword()
    {
      if(empty($this->data['password']))
      {
        $this->addError('password','Password cannot be empty');
      }
    }

    private function validateConfirmPassword()
    {

      if(empty($this->data['confirm_password']))
      {
        $this->addError('confirm_password','Password cannot be empty');
      }elseif ($this->data['confirm_password'] != $this->data['password']){
        $this->addError('confirm_password','Password and confirm password do not correspond!');
      }
    }

    private function addError($key,$value)
    {
      $this->errors[$key] = $value;
    }

  }
