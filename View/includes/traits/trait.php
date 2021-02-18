<?php

  trait Records
  {

    public function GetAllRecordsNumber($con, $table_name,$id)
    {

      $sql = "SELECT * FROM {$table_name} WHERE user_id=:id AND status = 2";
      $stmt = $con->prepare($sql);

      $params=[
        'id' => $id
      ];

      $stmt->execute($params);

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return count($result);

    }

    public function queryBuilder($con,$query,?array $params)
    {
      if(empty($params)) {
        $stmt = $con->query($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

      }else{

        $stmt = $con->prepare($query);

        $stmt->execute($params);
      }
    }

  }
