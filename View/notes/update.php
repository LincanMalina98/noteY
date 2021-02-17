<?php
  session_start();
  $title = 'Edit';
  include_once ("../includes/files.php");
  include_once ("../includes/layout/header.php");
  include_once ("../includes/layout/nav.php");

  $session = Sessions::verifyIfSessionIsSet('id');

  if(!$session)
  {
    header("Location: login.php");
  }

  $access = new Notes(null);
  $verify =  $access->isRouteValid($_GET['id']);

//  if($verify == false)
//  {
//    header("Location: forbidden.php");
//  }

  if(isset($_GET['id']))
  {

    $user_note = new Notes(NULL);
    $result = $user_note->selectNote($_GET['id']);

  }


  if(isset($_POST['submit']))
  {

    if($result['file'] !== null)
    {
      $validate = new Validate(
        array(
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'file' => $_FILES['file']['name']
        )
      );

      $errors = $validate->validateNotesData();
      $escapedChars = $validate->escapeHtmlChars();


      if (count($errors) == 0) {

        $edit_note = new Notes($escapedChars);
        $edit_note->update();

      }
    }else{

      $edit_note = new Notes($_POST);
      $edit_note->update();
    }

  }

?>

<div class="content">
  <div class="container">
    <div class="row centered-box">
      <div class="col-md-6">
        <div><a href="../notes/index.php" class="font-weight-bold btn btn-custom-primary btn-sm">Back to notes</a></div>
      </div>
    </div>
    <div class="row centered-box mt-3">
      <div class="col-md-6">
        <form action="update.php" method="post" enctype="multipart/form-data">
          <input type="hidden" value="<?php echo $result['id']; ?>" name="id" />
          <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" placeholder="Title" class="form-control form-control-sm" value="<?php echo $result['title']; ?>">
            <?php if (isset($errors) && isset($errors['title'])) { ?>
              <p class="text-danger"><?php echo $errors["title"] ; ?></p>
            <?php } ?>
          </div>
          <div class="form-group mt-3">
            <label for="title">Note:</label>
            <textarea name="description" id="note" cols="30" rows="10" class="form-control form-control-sm" placeholder="Enter your thoughts..."><?php echo $result['description'];?></textarea>
            <?php if (isset($errors) && isset($errors['description'])) { ?>
              <p class="text-danger"><?php echo $errors["description"] ; ?></p>
            <?php } ?>
          </div>
          <?php if($result['file'] === null || empty($result['file'])): ?>
          <div class="form-group mt-3">
            <label for="file" ><strong>File:</strong></label>
            <input type="file" name = "file" class="custom-file-input form-control">
            <?php if (isset($errors) && isset($errors['file'])) { ?>
              <p class="text-danger"><?php echo $errors["file"] ; ?></p>
            <?php } ?>
          </div>
          <?php endif; ?>
          <div class="form-group mt-3">
            <button  type="submit" name="submit" class="btn btn-sm btn-custom-primary">Edit</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php include_once ("../includes/layout/footer.php")?>


