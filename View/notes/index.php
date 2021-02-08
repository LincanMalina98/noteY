<?php
  session_start();

  $title = 'Notes';

  include_once ("../includes/files.php");
  include ("../../Controller/Pagination.php");
  include_once ("../includes/layout/header.php");
  include_once ("../includes/layout/nav.php");

  $session = Sessions::verifyIfSessionIsSet('id');

  if(!$session)
  {
    header("Location: login.php");
  }

  $paginator = new Pagination(4,'notes');
  $notes = $paginator->getAllRecords();

  $results = count($notes);

?>
 <?php if($results == 0):?>
  <div class='content'>
    <div class='container'>
       <div class='row centered-box'>
           <div class='col-md-6 text-center'>
            <p><strong>No available notes,please create one!</strong></p>
            <a href='create.php' class='btn btn-custom-primary btn-md'>Create note</a>
            </div>
       </div>
    </div>
  </div>
  <?php else:?>
<div class='content'>
  <div class='container'>
    <div class='row centered-box mt-3'>
      <?php
        if(isset($_SESSION['create'])) {
          echo "<div class='alert alert-primary' role='alert' id='alert-create'>{$_SESSION['create']}</div>";
        }
        unset($_SESSION['create']);

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
        <a href='create.php ' class='btn btn-custom-primary btn-md'>Create note</a>
      </div>
      <div class="col-md-4">
        <form action="search.php" method="post">
          <div class="input-group">
            <input type="text" name="data" class="form-control rounded" placeholder="Search" />
            <button type="submit" name="search" class="btn btn-custom-primary">search</button>
          </div>
        </form>
    </div>
    <div class='row centered-box mt-3'>
       <?php foreach($notes as $note):?>
        <div class='col-md-3'>
        <div class="card mt-2">
          <h6 class="card-header" style="color: #8fafe7;">YOUR NOTE</h6>
          <div class="card-body">
            <h4 class="card-title"><?php {echo $note['title'] ; }?></h4>
            <p class="card-text"><?php {echo substr($note['description'],0,100); }?></p>
            <p class="card-text text-end">Created at: <?php {echo $note['date'];}?></p>
            <a href="update.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-custom-edit">Edit</a>
            <a href="delete.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-custom-danger">Delete</a>
          </div>
        </div>
        </div>
        <?php endforeach;?>
    </div>
    </div>
    <div class="mt-3">
      <ul class="pagination justify-content-center">
        <?php $paginator->links(); ?>
      </ul>
    </div>
</div>
  <?php endif; ?>

<?php include_once ("../includes/layout/footer.php")?>
