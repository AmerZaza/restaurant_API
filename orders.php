<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");


include_once 'controllers/order_controller.php';
include_once 'controllers/language_controller.php';
include_once 'configuration.php';


if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($_POST['action'])){

        switch($_POST['action']){

            case 'select_all_orders':
                selectAllOrders();
                break;
            case 'select_order_id':
                selectOrderById();
                break;
            case 'new_order':
                addNewOrder();
                break;
            case 'update_order_by_id':
                updateOrderById();
                break;
            case 'delete_by_id':
                deleteOrder();
                break;
            default:
                http_response_code(502);
                echo json_encode(array("message"=> "Falsh Request"));
                break;

        }
    }

}

/*
**  To get all orders in the System
*/
function selectAllOrders(){
    $languageCode = $_POST['language'] != null ? $_POST['language'] : $mainLanguage;
    $orderObject = new OrderController();
    $response = $orderObject->getAllOrders($languageCode);
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected Order by orderID from the System
*/
function selectOrderById(){
    $orderId = $_POST['order_id'];
    $languageCode = $_POST['language'] != null ? $_POST['language'] : $mainLanguage;

    $orderObject = new OrderController();
    $response = $orderObject->getOrderById($orderId , $languageCode);
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To Insert order 
*/
function addNewOrder(){
    
    $order = new OrderHeadModel();

    $order->restaurantId = $_POST['restaurant_id'] ; 
    $order->userId = $_POST['user_id'];
    $order->address = $_POST['address'];
    $order->phone = $_POST['phone'];
    $order->deliveryTime = $_POST['delevery_time'];

    $order->orderDetails = $_POST['order-details'];

    $orderObject = new OrderController();
    $response = $orderObject->insertNewOrder($order);
    echo json_encode($response);  
    
    http_response_code(201);
}

/*
**  o update selected Order by orderHead ID 
*/
function updateOrderById(){   
    
    $order = new OrderHeadModel();

    $order->orderHeadId = $_POST['order_head_id'];
    $order->restaurantId = $_POST['restaurant_id'] ; 
    $order->userId = $_POST['user_id'];
    $order->address = $_POST['address'];
    $order->phone = $_POST['phone'];
    $order->deliveryTime = $_POST['delevery_time'];

    $order->orderDetails = $_POST['order-details'];

    $orderObject = new OrderController();
    $response = $orderObject->updateteOrderById($order);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  o delete selected user by ID
*/
function deleteOrder(){

    $order = new OrderHeadModel();
    global $mainLanguage;

    $orderId = $_POST['order_head_id'];
    $orderObject = new OrderController();

    $response = $orderObject->deleteOrderById($orderId);
    if($response){
        echo json_encode($response); 
        http_response_code(201); 
    }else{
        echo json_encode('Order id is not in the system.'); 
        http_response_code(404); 
    }
    

    /*
    if( count($orderObject->getOrderById($orderId , $mainLanguage) ) != 0){
        $response = $orderObject->deleteOrderById($orderId);
        echo json_encode($response); 
    
        http_response_code(201); 
    }else{
        echo json_encode('Order id is not in the system.'); 
        http_response_code(404); 
    } 
    */
    
}







?>  