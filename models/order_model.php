<?php
class OrderHeadModel extends OrderDetails
{
    public $orderHeadId;
    public $restaurantId;
    public $userId;
    public $insertTime;
    public $address;
    public $phone;
    public $deliveryTime;
    //public $paymentTime;
    public $price;
    public $canceldTime;

    public $orderDetails ;

    public $table_name = "order_head";
    
}

class  OrderDetails
{
    public $orderDetailsId;
    public $orderHeadId;
    public $itemId;
    public $mainItemId;
    public $price;
    public $readyTime;

    public $table_details_name = "order_details";
  

    
}


?>