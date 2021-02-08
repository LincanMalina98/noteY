<?php


  class Sessions
  {

    public  static function setSession($key,$value)
    {
       $_SESSION[$key]  = $value;
    }

    public static function verifyIfSessionIsSet($key)
    {

      if(isset($_SESSION[$key])){
          return true;
      }else{
          return false;
      }

    }

    public static function unsetSession()
    {
      session_unset();
      session_destroy();
    }

  }
