<?php
class PaymentMethod
{
    public $paymentId ;
    public $restaurantId ;
    public $paypal ;
    public $master ;
    public $visa ;
    public $giro ;

    private $conn;
    private $table_name = "payment_method";
  
  
    public function __construct($db){
        $this->conn = $db;
    }
    
}

?>