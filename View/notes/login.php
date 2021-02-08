<?php
  session_start();
  $title = 'Login';

include_once ("../includes/files.php");
  include("../../Controller/Login.php");
include_once ("../includes/layout/header.php");

  if(isset($_SESSION['id'])){
    header('location:index.php');
    exit();
  }

  $message = '';

  if(isset($_POST['submit']))
  {
      $user = new Login($_POST);
      $message = $user->login();
  }
?>

<div class="container">
  <div class="row justify-content-md-center full-height centered-box">
    <div class="col-md-4">
     <p class="text-danger"><?php echo $message; ?></p>
      <div class="box">
        <div class="title">
          <h3>Login</h3>
        </div>
        <form action="login.php" method="post">
          <div class="form-group mt-3">
            <label for="email">E-mail:</label>
            <input type="text" name="email" class="form-control" placeholder="Enter your email address">
          </div>

          <div class="form-group mt-3">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password">
          </div>

          <div class="link mt-3">
            <a href="register.php">Register</a>
          </div>

          <div class="linkf mt-3">
            <a href="#">Forgot password</a>
          </div>

          <div class="form-group">
            <button type="submit" name="submit" class="btn button">Login</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include_once ("../includes/layout/footer.php")?>
