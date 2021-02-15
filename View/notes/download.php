<?php

  session_start();

  if(isset($_GET['path']))
  {

    $filename = $_GET['path'];

    $file = "../uploads/" . $filename;

    if (file_exists($file)) {
      header('Content-Description: File Transfer');
      header('Content-Type:'.filetype($filename));
      header("Cache-Control: no-cache, must-revalidate");
      header("Expires: 0");
      header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
      header('Content-Length: ' . filesize($filename));
      header('Pragma: public');

      flush();

      readfile($file);

    } else
      {
      echo "File does not exist.";
      }
  }else
    {
    echo "Filename is not defined.";
     }

?>

