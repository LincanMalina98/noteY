<?php
  session_start();

  $title = 'View';
  include_once ("../includes/layout/header.php");
  include_once ("../includes/layout/nav.php");
  include_once ("../includes/files.php");

  $session = Sessions::verifyIfSessionIsSet('id');

  if(!$session)
  {
    header("Location: login.php");
  }


  if(isset($_GET['id'])) {

    $viewNote = new Notes(null);
    $note = $viewNote->selectNote($_GET['id']);
  }


  if(isset($_POST['submit']))
  {
    $updateNote = new Notes(null);
    $updateNote->updateFile();

  }


?>

<div class="content">
  <div class="container">
    <div class="row centered-box">
      <div class="col-md-6">
        <div><a href="../notes/index.php" class="font-weight-bold btn btn-custom-primary btn-sm">Back to notes</a></div>
      </div>
    </div>
    <div class='row centered-box mt-3'>
        <div class='col-md-3'>
          <div class="card mt-2">
            <h6 class="card-header" style="color: #8fafe7;">YOUR NOTE</h6>
            <div class="card-body">
              <h4 class="card-title"><?php {echo $note['title'] ; }?></h4>
              <p class="card-text"><?php {echo $note['description']; }?></p>
              <p class="card-text" style="color: #8fafe7;"><?php {echo $note['file']; }?></p>
              <p class="card-text text-end">Created at: <?php {echo $note['date'];}?></p>
              <?php if($note['file'] != null):?>
                <form action="view.php" method="post">
                  <input type="hidden" value="<?php echo $note['id']; ?>" name="id" />
                  <input type="hidden" value="<?php echo $note['file']; ?>" name="file" />
                 <button type="submit" name="submit" class="btn btn-sm btn-custom-danger">Delete file</button>
                </form>
                <a href="download.php?path=<?php echo $note['file'];?>" class="btn btn-sm btn-custom-edit">Download</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
    </div>
  </div>
  </div>
</div>

<?php include_once ("../includes/layout/footer.php")?>

