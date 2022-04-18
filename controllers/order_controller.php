<?php

include './models/database.php';
include './models/order_model.php';
include '../models/language_model.php';
include './core/functions.php';



class OrderController  extends OrderHeadModel {



    // To return all users in DB
    public function getAllOrders($languageCode){
        
        $database = new Database();
        $conn = $database->getConnection();

        $query = " SELECT * FROM " .$this->table_name. ""
            ." LEFT JOIN ".$this->table_details_name." 
            ON ".$this->table_name.".order_id = ".$this->table_details_name.".oh_id 
            LEFT JOIN item ON order_details.item_id = item.item_id  
            LEFT JOIN item_ml ON item.item_id = item_ml.item_id
            INNER JOIN language ON language.language_id = item_ml.language_id 
            WHERE language.code = '".$languageCode."'";
            
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

        // To return one selected Order by OrderId and Language-Code
        public function getOrderById($orderId, $languageCode){
        
            $database = new Database();
            $conn = $database->getConnection();
    
            $query = " SELECT * FROM " .$this->table_name. ""
            ." LEFT JOIN ".$this->table_details_name." 
            ON ".$this->table_name.".order_id = ".$this->table_details_name.".oh_id 
            LEFT JOIN item ON order_details.item_id = item.item_id  
            LEFT JOIN item_ml ON item.item_id = item_ml.item_id
            INNER JOIN language ON language.language_id = item_ml.language_id 
            WHERE language.code = '".$languageCode."' AND order_head.order_id = ".$orderId."";

            $stmt = $conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }

      
        // To insert new Category
        public Function insertNewOrder($orderModel){

            $database = new Database();
            $conn = $database->getConnection();

            $restaurantId = $orderModel->restaurantId ;
            $userId = $orderModel->userId ;
            $address = $orderModel->address ;
            $phone = $orderModel->phone ;
            $deliveryTime = $orderModel->deliveryTime ;

            $orderDetails = $orderModel->orderDetails;

            
            
            $query = "INSERT INTO order_head ( restaurant_id, user_id, address, phone, delivery_time) 
                                                 VALUES (?,?,?,?,?)";

     
            $stmt = $conn->prepare($query);
            $stmt->execute([$restaurantId, $userId, $address, $phone, $deliveryTime ]);

            $oderHedId = $conn->lastInsertId();

           $functions = new CoreFunction();
           $eachDetailArray =   $functions->fromJson($orderDetails); 


        // Insert the Order-Details 
        foreach($eachDetailArray as $item){
            //echo '('.$item['itemId'].')';

            $itemId =  $item['itemId'];
            $itemCount =  $item['count'];
            $itemPrice = $item['itemPrice'];
            $mainItemId = $item['mainItemId'] != 'null' ? $item['mainItemId'] : null;
            $readyTime = $item['readyTime'] != 'null' ? $item['readyTime'] : null;

            $query = "INSERT INTO order_details (oh_id, item_id, item_count, price, maini_id, ready_time ) 
                                                VALUES (?,?,?,?,?,?)"; 
            $stmt = $conn->prepare($query);
            $stmt->execute([ $oderHedId ,$itemId , $itemCount, $itemPrice, $mainItemId, $readyTime]);

            }
            //print_r($orderDetails);
            return('One order Added: '. $orderDetails) ;
        }



        // To update current Category-Ml for exist Category by CategoryId  AND LanguageId
        public Function updateteOrderById($orderModel){

            $database = new Database();
            $conn = $database->getConnection();

            $ordeHedId = $orderModel->orderHeadId;
            $restaurantId = $orderModel->restaurantId ;
            $userId = $orderModel->userId ;
            $address = $orderModel->address ;
            $phone = $orderModel->phone ;
            $deliveryTime = $orderModel->deliveryTime ;

            $orderDetails = $orderModel->orderDetails;

            $query = "UPDATE order_head SET restaurant_id=?, user_id=?, address=?, phone=?, delivery_time =?  WHERE order_id =?  ";

            $stmt = $conn->prepare($query);
            $stmt->execute([$restaurantId, $userId, $address, $phone, $deliveryTime, $ordeHedId]);

            //Delete all details for this Order
            $query = "DELETE FROM order_details  WHERE oh_id =?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$ordeHedId]);

            //Insert the all new orderDetails 
            $functions = new CoreFunction();
            $eachDetailArray =   $functions->fromJson($orderDetails); 
            foreach($eachDetailArray as $item){
                //echo '('.$item['itemId'].')';
    
                $itemId =  $item['itemId'];
                $itemCount =  $item['count'];
                $itemPrice = $item['itemPrice'];
                $mainItemId = $item['mainItemId'] != 'null' ? $item['mainItemId'] : null;
                $readyTime = $item['readyTime'] != 'null' ? $item['readyTime'] : null;
    
                $query = "INSERT INTO order_details (oh_id, item_id, item_count, price, maini_id, ready_time ) 
                                                    VALUES (?,?,?,?,?,?)"; 
                $stmt = $conn->prepare($query);
                $stmt->execute([ $ordeHedId ,$itemId , $itemCount, $itemPrice, $mainItemId, $readyTime]);
                }
                //print_r($orderDetails);
                return('One order Updated: '. $orderDetails) ;
        }


        // To Delete current Category by userID
        public Function deleteOrderById($orderId){

            $database = new Database();
            $conn = $database->getConnection();

            $query = "DELETE FROM  order_head  WHERE order_id =?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$orderId]);
        }





     
    
    
}


?>