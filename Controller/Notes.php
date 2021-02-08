<?php

  class Notes extends Connection
  {
    use Records;

    private $data;
    protected $con;

    public function __construct(?array $data)
    {
      $this->data = $data;
      $this->con = $this->openConnection();
    }

    public function insertFormData()
    {

      try {
        $params = [
          'user_id' => $_SESSION['id'],
          'title' => $this->data['title'],
          'description' => $this->data['description'],
          'date' => date('Y-m-d H:i:s'),
        ];

        $this->queryBuilder($this->con,"INSERT INTO notes(user_id ,title, description, date)VALUES(:user_id,:title, :description, :date)",$params);

        Sessions::setSession('create','Your note was successfully created!');

        header("Location: index.php");

      }catch (PDOException $e){
        echo "Cannot insert data into the database" . $e->getMessage();
      }
    }


//    public function selectAllNotes()
//    {
//     return  $this->queryBuilder($this->con,"SELECT * FROM notes WHERE user_id = {$_SESSION['id']}",null);
//
//    }

    public function selectNote($id)
    {
      $stmt = $this->con->query( "SELECT * FROM notes WHERE id = {$id}");

      $stmt->execute();

      return $stmt->fetch();
    }

    public function update()
    {
      $params=[
        'title' => $_POST['title'],
        'description' =>$_POST['description'],
        'id'=>$_POST['id']
      ];
      $this->queryBuilder($this->con,"UPDATE notes SET title=:title, description=:description WHERE id=:id",$params);

      Sessions::setSession('update','Your note was successfully updated!');

      header("Location: index.php");
    }

    public function delete($id)
    {
      $params = [
        'id' => $id,
      ];

     $this->queryBuilder($this->con,"DELETE FROM notes WHERE id =:id ",$params);

     Sessions::setSession('delete','Your note was successfully deleted!');

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
