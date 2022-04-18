<?php
class appointment
{
    public $appointmentId ;
    public $restaurantId ;
    public $time ;
    public $persons ;
    public $userId ;

    private $conn;
    private $table_name = "appointment";


    public function __construct($db){
        $this->conn = $db;
    }
    
}

?>