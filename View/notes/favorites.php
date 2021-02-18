<?php
  session_start();

  $title = 'Notes';

  include_once ("../includes/files.php");
  include_once ("../includes/layout/header.php");
  include_once ("../includes/layout/nav.php");

  $session = Sessions::verifyIfSessionIsSet('id');

  if(!$session)
  {
    header("Location: login.php");
  }

  if(isset($_POST['submit']))
  {
    $fav_status = new Notes(null);
    $fav_status->setNoteStatus(NFAV,$_POST['id']);
  }

$favorite_note = new Notes(null);
$favorite_notes = $favorite_note->selectAllFavoriteNotes();

?>

<div class='content'>
  <div class='container'>
    <div class='row centered-box mt-3'>
      <div class='col-md-6'>
        <a href='index.php ' class='btn btn-custom-primary btn-md'>Back to note</a>
      </div>
    </div>
    <div class='row centered-box mt-3'>
      <?php foreach($favorite_notes as $favorite_note):?>
        <div class='col-md-3'>
          <div class="card mt-2">
            <h6 class="card-header" style="color: #8fafe7;">YOUR NOTE</h6>
            <span class="text-end">
            <form action="favorites.php" method="post">
              <input type="hidden" name="id" value="<?php echo $favorite_note['id']; ?>"/>
              <button type="submit" name="submit" class="btn btn-sm btn-light material-icons" style="color: #f5db02;">grade</button>
            </form>
          </span>
            <div class="card-body">
              <h4 class="card-title"><?php {echo $favorite_note['title'] ; }?></h4>
              <p class="card-text"><?php {echo substr( $favorite_note['description'],0,100); if(strlen($favorite_note['description']) > 100){echo "...";}}?></>
              <p class="card-text text-end">Created at: <?php {echo $favorite_note['date'];}?></p>
              <a href="update.php?id=<?php echo $favorite_note['id']; ?>" class="btn btn-sm btn-custom-edit">Edit</a>
              <a href="delete.php?id=<?php echo $favorite_note['id']; ?>" class="btn btn-sm btn-custom-danger">Delete</a>
              <a href="view.php?id=<?php echo $favorite_note['id']; ?>" class="btn btn-sm btn-custom-view">View</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php include_once ("../includes/layout/footer.php")?>
