<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");


include_once 'controllers/item_controller.php';
include_once 'controllers/language_controller.php';
include_once 'configuration.php';


if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($_POST['action'])){

        switch($_POST['action']){

            case 'select_all_items':
                selectAllItems();
                break;
            case 'select_item_id':
                selectItemById();
                break;
            case 'new_item':
                addNewItem();
                break;
            case 'add_item_ml':
                addItemMl();
                break;
            case 'update_item_ml':
                updateItemMl();
                break;
            case 'delete_by_id':
                deleteItem();
                break;
            default:
                http_response_code(502);
                echo json_encode(array("message"=> "Falsh Request"));
                break;

        }
    }

}

/*
**  To get all users in the System
*/
function selectAllItems(){
    $languageCode = $_POST['language'] != null ? $_POST['language'] : $mainLanguage;
    $itemObject = new ItemController();
    $response = $itemObject->getAllItems($languageCode);
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected users by userID from the System
*/
function selectItemById(){
    $itemId = $_POST['item_id'];
    $languageCode = $_POST['language'] != null ? $_POST['language'] : $mainLanguage;

    $itemObject = new ItemController();
    $response = $itemObject->getItemMlById($itemId , $languageCode);
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected category by ID
*/
function addNewItem(){
    $item = new ItemModel();

    $item->itemGroupId = $_POST['category_id'] ; 
    $item->isMain = $_POST['isMain'];
    $item->mainItemId = $_POST['mainItemId'];
    $item->fixed = $_POST['fixed'];
    $item->name = $_POST['name'];
    $item->description = $_POST['description'];
    $item->food_info = $_POST['food_info'];
    $item->price = $_POST['price'];

    $itemObject = new ItemController();
    $response = $itemObject->insertNewItem($item);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  To get selected category-Ml to current Category
*/
function addItemMl(){
    $item = new ItemModel();
    $languageController = new LanguageController();
    
    $item->itemId = $_POST['item_id'];
    $item->name = $_POST['name'];
    $item->description = $_POST['description'];
    $item->foodInfo = $_POST['food_info'];
    $item->languageId = $languageController->getLanguageCode($_POST['language_code']);
  
    $itemObject = new ItemController();
    $response = $itemObject->insertItemMl($item);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  o update selected Category_ML by ID AND Language ID
*/
function updateItemMl(){   

    $item = new ItemModel();
    $languageController = new LanguageController();
    
    $item->itemId = $_POST['item_id'];
    $item->name = $_POST['name'];
    $item->description = $_POST['description'];
    $item->foodInfo = $_POST['food_info'];
    $item->languageId = $languageController->getLanguageCode($_POST['language_code']);

    $itemObject = new ItemController();
    $response = $itemObject->updateteItemMl($item);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  o delete selected user by ID
*/
function deleteItem(){

    $item = new ItemModel();

    $itemId = $_POST['item_id'];
    $itemObject = new ItemController();

    if( count($itemObject->getItemById($itemId )) != 0){
        $response = $itemObject->deleteItemById($itemId);
        echo json_encode($response); 
    
        http_response_code(201); 
    }else{
        echo json_encode('Item id is not in the system.'); 
        http_response_code(404); 
    } 
}







?>  