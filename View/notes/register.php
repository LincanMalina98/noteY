<?php
  session_start();

  include_once ("../includes/files.php");
  include_once("../../Controller/Register.php");
  include_once ("../includes/layout/header.php");

  if(isset($_POST['register']))
  {
     $validate  = new Validate($_POST);
     $errors = $validate->validateRegisterFormData();
     $escapeChars = $validate->escapeHtmlChars();

     if(count($errors) == 0){

      $user = new Register($escapeChars);
      $user->register();

      unset($errors);
     }

  }


?>
<div class="container">
  <div class="row justify-content-md-center full-height centered-box">
    <div class="col-md-4">
      <?php

        if(isset($_SESSION['success'])){

          echo "<div class='alert alert-primary' role='alert' id='alert'>{$_SESSION['success']}</div>";
        }
        unset($_SESSION['success'])
      ?>
      <div class="box">
      <div class="title">
        <h3>Register</h3>
      </div>

          <form action="register.php" method="post">

            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" class="form-control"  placeholder="Enter your name" autofocus required>
              <?php if (isset($errors) && isset($errors['name'])) { ?>
                <p class="text-danger"><?php echo $errors["name"] ; ?></p>
              <?php } ?>
            </div>

            <div class="form-group mt-3">
              <label for="email">E-mail:</label>
              <input type="text" name="email" class="form-control" placeholder="Enter your email address" required>
              <?php if (isset($errors) && isset($errors['email'])) { ?>
                <p class="text-danger"><?php echo $errors["email"] ; ?></p>
              <?php } ?>
            </div>

            <div class="form-group mt-3">
              <label for="password">Password:</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
              <?php if (isset($errors) && isset($errors['password'])){ ?>
                <p class="text-danger"><?php echo $errors["password"] ; ?></p>
              <?php } ?>
            </div>

            <div class="form-group mt-3">
              <label for="confirm_password">Password confirmation:</label>
              <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
              <?php if (isset($errors) && isset($errors['confirm_password'])){ ?>
                <p class="text-danger"><?php echo $errors["confirm_password"] ; ?></p>
              <?php } ?>
            </div>

            <div class="link mt-3">
              <a href="login.php">Login</a>
            </div>

            <div class="linkf mt-3">
              <a href="#">Forgot password</a>
            </div>

            <div class="form-group">
              <button type="submit" name="register" class="btn button">Register</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
<?php include_once ("../includes/layout/footer.php")?>
