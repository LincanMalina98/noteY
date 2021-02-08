<?php
  session_start();

  $title = 'Access forbidden';

  include_once ("../includes/layout/header.php");

?>
<div class='content'>
  <div class='container'>
    <div class='row centered-box mt-3'>
      <div class='col-md-6'>
        <h1>Access forbidden!!
             403</h1>
      </div>
    </div>
  </div>
</div>

  <?php include_once ("../includes/layout/footer.php")?>
