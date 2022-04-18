<?php
class Restaurant
{
    public $restaurantId ;
    public $name ;
    public $address ;
    public $capacity ;
    public $visitTime ; 
    public $email ;
    public $phone ;

    private $conn;
    private $table_name = "restaurant";
  
  
    public function __construct($db){
        $this->conn = $db;
    }
    
}

class RestaurantMl 
{
    public $restaurantMlId ;
    public $restaurantId ;
    public $languageId ;
    public $about ;
    public $imprint ;
    public $policy ;

    private $conn;
    private $table_name = "restaurant_ml";
  
  
    public function __construct($db){
        $this->conn = $db;
    }
    
}

class OpenTime 
{
    public $openTimeId ;
    public $restaurantId ;
    public $openDay ;
    public $oFrom ;
    public $oTo ;

    private $conn;
    private $table_name = "open_time";
  
  
    public function __construct($db){
        $this->conn = $db;
    }
    
}

class RestaurantSocial
{
    public $restaurantSocialId ;
    public $restaurantId ;
    public $youtube ;
    public $faceboock ;
    public $instegram ;
    public $twitter ;

    private $conn;
    private $table_name = "resturant_social";
  
  
    public function __construct($db){
        $this->conn = $db;
    }
    
}


?>