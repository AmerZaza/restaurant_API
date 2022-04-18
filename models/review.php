<?php
class Review
{
    public $reviewId ;
    public $userId ;
    public $restaurantId ;
    public $review ;
    public $commitment ;

    private $conn;
    private $table_name = "review";
  
  
    public function __construct($db){
        $this->conn = $db;
    }
    
}


?>