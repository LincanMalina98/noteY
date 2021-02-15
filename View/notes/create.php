<?php
  session_start();

  $title = 'Create';


  include_once ("../includes/layout/header.php");
  include_once ("../includes/layout/nav.php");
  include_once ("../includes/files.php");

  $session = Sessions::verifyIfSessionIsSet('id');

  if(!$session)
  {
    header("Location: login.php");
  }

  if(isset($_POST['submit']))
  {
    $validate = new Validate(
        array(
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'file' => $_FILES['file']['name']
        ),
    );

    $errors = $validate->validateNotesData();
    $escapedChars = $validate->escapeHtmlChars();

    if(count($errors) == 0){

      $note = new Notes($escapedChars);
      $note->insertFormData();

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
        <form action="create.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title"><strong>Title:</strong></label>
            <input type="text" name="title" placeholder="Title" class="form-control form-control-sm">
            <?php if (isset($errors) && isset($errors['title'])) { ?>
              <p class="text-danger"><?php echo $errors["title"] ; ?></p>
            <?php } ?>
          </div>
          <div class="form-group mt-3">
            <label for="title" ><strong>Note:</strong></label>
            <textarea name="description" id="textarea" cols="30" rows="10" class="form-control form-control-sm" placeholder="Enter your thoughts..."></textarea>
            <?php if (isset($errors) && isset($errors['description'])) { ?>
              <p class="text-danger"><?php echo $errors["description"] ; ?></p>
            <?php } ?>
          </div>
          <div class="form-group mt-3">
            <label for="file" ><strong>File:</strong></label>
            <input type="file" name="file" class="custom-file-input form-control" >
            <?php if (isset($errors) && isset($errors['file'])) { ?>
              <p class="text-danger"><?php echo $errors["file"] ; ?></p>
            <?php } ?>
          </div>
          <div class="form-group mt-3">
            <button  type="submit" name="submit" class="btn btn-sm btn-custom-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once ("../includes/layout/footer.php")?>

