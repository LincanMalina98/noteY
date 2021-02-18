<?php

  class Notes extends Connection
  {
    use Records;

    private $data;
    private $fileName;
    protected $con;

    public function __construct(?array $data)
    {
      $this->data = $data;
      $this->con = $this->openConnection();
    }

    private function fileHandle()
    {

        $targetFilePath = "../uploads/" . $_FILES['file']['name'];
        $ext = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $this->fileName = basename($_FILES['file']['name'], "." . $ext);

      return $ext;
    }

    public function selectAllFavoriteNotes()
    {
      $sql = "SELECT * FROM notes WHERE user_id=:id AND status=:status";
      $stmt = $this->con->prepare($sql);

      $params=[
        'id'=>$_SESSION['id'],
        'status' => FAV
      ];

      $stmt->execute($params);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertFormData()
    {
      $ext = $this->fileHandle();

      $actualname = $this->fileName . $_SESSION['id']."." .$ext;

      try {
        $params = [
          'user_id' => $_SESSION['id'],
          'title' => $this->data['title'],
          'description' => $this->data['description'],
          'date' => date('Y-m-d H:i:s'),
          'file'=>$actualname,
          'status' => NFAV
        ];

        $this->queryBuilder($this->con,"INSERT INTO notes(user_id ,title, description, date,file,status)VALUES(:user_id,:title, :description, :date,:file,:status)",$params);

        if(!file_exists("../uploads/{$actualname}"))
        {
          move_uploaded_file($_FILES['file']['tmp_name'],"../uploads/{$actualname}");
        }

        Sessions::setSession('create','Your note was successfully created!');

        header("Location: index.php");

      }catch (PDOException $e){
        echo "Cannot insert data into the database" . $e->getMessage();
      }
    }


    public function selectNote($id)
    {
      $stmt = $this->con->query( "SELECT * FROM notes WHERE id = {$id}");

      $stmt->execute();

      return $stmt->fetch();
    }

    public function updateFile()
    {
      $filename = $_POST['file'];

      $params=[
        'id'=>$_POST['id'],
        'file' => NULL
      ];

      $this->queryBuilder($this->con,"UPDATE notes SET file=:file WHERE id=:id",$params);

      Sessions::setSession('delete_file','Your file was successfully deleted!');


      if(file_exists("../uploads/{$filename}") === true)
      {
        unlink("../uploads/{$filename}");
      }

      header("Location: index.php");
    }

    public function update()
    {

      $result = $this->selectNote($_POST['id']);
      $ext = $this->fileHandle();

      $actualname = $this->fileName . $_SESSION['id']."." .$ext;

      if($result['file'] === NULL || empty($result['file'])) {
        $params = [
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'id' => $_POST['id'],
          'file' => $actualname
        ];
        $this->queryBuilder($this->con, "UPDATE notes SET title=:title, description=:description ,file=:file WHERE id=:id", $params);

        if(!file_exists("../uploads/{$actualname}"))
        {
          move_uploaded_file($_FILES['file']['tmp_name'],"../uploads/{$actualname}");
        }

        Sessions::setSession('update', 'Your note was successfully updated!');

        header("Location: index.php");
      }else{
        $params = [
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'id' => $_POST['id'],
        ];
        $this->queryBuilder($this->con, "UPDATE notes SET title=:title, description=:description WHERE id=:id", $params);

        Sessions::setSession('update', 'Your note was successfully updated!');

        header("Location: index.php");
      }


    }

    public function setNoteStatus($status,$id)
    {
      $params=[
        'id'=>$id,
        'status' => $status
      ];

      $this->queryBuilder($this->con,"UPDATE notes SET status=:status WHERE id=:id",$params);

    }

    public function delete($id)
    {

      $record = $this->selectNote($id);

      $params = [
        'id' => $id,
      ];

     $this->queryBuilder($this->con,"DELETE FROM notes WHERE id =:id ",$params);

     Sessions::setSession('delete','Your note was successfully deleted!');

      if(file_exists("../uploads/{$record['file']}") === true)
      {
        unlink("../uploads/{$record['file']}");
      }

      header("Location: index.php");
    }

    public function search($search_input_data)
    {
      return $this->queryBuilder($this->con,"SELECT * FROM notes WHERE title LIKE '%{$search_input_data}%' AND user_id = {$_SESSION['id']}",null);
    }


    public function isRouteValid($id)
    {
      $sql = "SELECT user_id FROM notes WHERE id=:id";
      $stmt = $this->con->prepare($sql);

      $params = [
        'id' => $id,
      ];

      $stmt->execute($params);

      $results = $stmt->fetch(PDO::FETCH_ASSOC);


      if ( $_SESSION["id"] === $results["user_id"]) {
        return true;
      }

      return false;
    }
  }
