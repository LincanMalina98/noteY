<?php
  session_start();

  $title = 'Search';

  include_once ("../includes/files.php");
  include ("../../Controller/Pagination.php");
  include_once ("../includes/layout/header.php");
  include_once ("../includes/layout/nav.php");

  $session = Sessions::verifyIfSessionIsSet('id');

  if(!$session)
  {
    header("Location: login.php");
  }

  if(isset($_POST['search']))
  {
    $data = htmlspecialchars($_POST['data']);

    $note = new Notes(null);
    $results = $note->search($data);
  }

?>
<div class='content'>
  <div class='container'>
    <div class='row centered-box mt-3'>
      <?php
        if(isset($_SESSION['update'])) {
          echo "<div class='alert alert-primary' role='alert' id='alert-update'>{$_SESSION['update']}</div>";
        }

        unset($_SESSION['update']);

        if(isset($_SESSION['delete'])) {
          echo "<div class='alert alert-primary' role='alert' id='alert-delete'>{$_SESSION['delete']}</div>";
        }

        unset($_SESSION['delete']);
      ?>
      <div class='col-md-6'>
        <a href='index.php' class='btn btn-custom-primary btn-md'>Back to index</a>
      </div>
      <div class='row centered-box mt-3'>
        <?php if(!empty($data)):foreach($results as $result):?>
          <div class='col-md-3'>
            <div class="card mt-2">
              <h6 class="card-header" style="color: #8fafe7">YOUR NOTE</h6>
              <div class="card-body">
                <h4 class="card-title"><?php {echo $result['title'] ; }?></h4>
                <p class="card-text"><?php {echo substr($result['description'],0,100); }?></p>
                <p class="card-text text-end">Created at: <?php {echo $result['date'];}?></p>
                <a href="update.php?id=<?php echo $result['id']; ?>" class="btn btn-sm btn-custom-edit">Edit</a>
                <a href="delete.php?id=<?php echo $result['id']; ?>" class="btn btn-sm btn-custom-danger">Delete</a>
              </div>
            </div>
          </div>
        <?php endforeach; endif;?>
      </div>
    </div>
  </div>
  <?php include_once ("../includes/layout/footer.php")?>
