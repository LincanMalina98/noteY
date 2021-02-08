<?php

  class Pagination extends Connection
  {

     use Records;

     private $results_per_page;
     private $number_of_results_from_db;
     private $number_of_pages_available;
     private $user_page_number;
     private $page_first_result;
     private $table_name;
     protected $con;

     public function __construct($results_per_page,$table_name)
     {
       $this->results_per_page = $results_per_page;
       $this->table_name = $table_name;
       $this->con = $this->openConnection();
     }


    private function availablePages(): int
    {

      return $this->number_of_pages_available = ceil($this->number_of_results_from_db / $this->results_per_page);

    }

    private function getUserPageNumber(): int
    {

      if(!isset($_GET['page'])){
        $this->user_page_number = 1;
      }else{
        $this->user_page_number = $_GET['page'];
      }

      return $this->user_page_number;
    }

    private function pageLimit(): int
    {

      $this->getUserPageNumber();

      return $this->page_first_result = ($this->user_page_number - 1) * $this->results_per_page;
    }


    public function getAllRecords(): array
    {
      $this->number_of_results_from_db = $this->GetAllRecordsNumber($this->con,$this->table_name,$_SESSION['id']);

      $this->pageLimit();

      return  $this->queryBuilder($this->con,"SELECT * FROM {$this->table_name} WHERE user_id = {$_SESSION['id']} LIMIT {$this->page_first_result},{$this->results_per_page}",null);
    }

    public function links(): void
    {
      $availablePages = $this->availablePages();

      if ($availablePages >= 2)
      {
        if ($this->user_page_number >= 2)
        {
          $prev = $this->user_page_number - 1;

          echo "<li class='page-item'><a class='page-link' href='index.php?page={$prev}'>Prev</a></li>";
        }

        for ($i = 1; $i <= $this->number_of_pages_available; $i++)
        {

          echo "<li class='page-item'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";

        }

        if ($this->user_page_number < $this->number_of_pages_available)
        {
          $next = $this->user_page_number + 1;
          echo "<li class='page-item'><a class='page-link' href='index.php?page={$next}'>Next</a></li>";
        }
      }
    }

  }
