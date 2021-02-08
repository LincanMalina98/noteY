<?php
  session_start();

  include_once ("../includes/files.php");


  $access = new Notes(null);
  $isRouteValid = $access->isRouteValid($_GET['id']);

  if(isset($_GET['id']) && $isRouteValid === true) {
    $access->delete($_GET['id']);
  } else {
    header("Location: forbidden.php");
  }

