<?php
  session_start();
  include ("../../Controller/Sessions.php");

  if(isset($_POST['logout']))
  {
    Sessions::unsetSession();

    header("Location: login.php");
  }
