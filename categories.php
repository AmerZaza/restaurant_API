<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");


include_once 'controllers/category_controller.php';
include_once 'controllers/language_controller.php';
include_once 'configuration.php';


$categoryObject = new CategoryController();

//$allCategories = $categoryObject->getAllCategories();
//print_r($allCategories);

//$categoryById = $categoryObject->getCategory('1');
//print_r($categoryById);

//$catModel = new CategoryModel();
//$catModel->itemCategoryName = 'Nudeln';
//$catModel->languageId = '1';
//$catModel->disable ='1'  ;
//$catModel->itemCategoryDescription = 'All nuddeln'  ;
//print_r($categoryObject->insertCategory($catModel));

//$catModel = new CategoryModel();
//$catModel->categoryId = '19' ;
//$catModel->itemCategoryName = 'Nüdeln';
//$catModel->languageId = '2';
//$catModel->itemCategoryDescription = 'Alle Nüdeln'  ;
//print_r($categoryObject->insertCategoryMl($catModel));


//$catModel = new CategoryModel();
//$catModel->categoryId = '19';
//$catModel->itemCategoryName = 'NudelnX';
//$catModel->itemCategoryDescription = 'XXXXXXX DE';
//$catModel->languageId = '2';
//print_r($categoryObject->updateteCategoryMl($catModel ));

//$catModel = new CategoryModel();
//print_r($categoryObject->deleteCategory(17));




if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($_POST['action'])){

        switch($_POST['action']){

            case 'select_all_categories':
                selectAllCategories();
                break;
            case 'select_category_id':
                selectCategoryById();
                break;
            case 'new_category':
                addNewCategory();
                break;
            case 'add_category_ml':
                addCategoryMl();
                break;
            case 'update_category_ml':
                updateCategoryMl();
                break;
            case 'delete_by_id':
                deleteCategoryById();
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
function selectAllCategories(){
    $languageCode = $_POST['language'] != null ? $_POST['language'] : $mainLanguage;
    $categoryObject = new CategoryController();
    $response = $categoryObject->getAllCategories($languageCode);
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected users by userID from the System
*/
function selectCategoryById(){
    $categoryId = $_POST['category_id'];
    $languageCode = $_POST['language'] != null ? $_POST['language'] : $mainLanguage;

    $categoryObject = new CategoryController();
    $response = $categoryObject->getCategory($categoryId , $languageCode);
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected category by ID
*/
function addNewCategory(){
    $category = new CategoryModel();
    
    $category->itemCategoryName = $_POST['name'];
    $category->itemCategoryDescription = $_POST['description'];

    $categoryObject = new CategoryController();
    $response = $categoryObject->insertCategory($category);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  To get selected category-Ml to current Category
*/
function addCategoryMl(){
    $category = new CategoryModel();
    $languageController = new LanguageController();
    
    $category->categoryId = $_POST['category_id'];
    $category->languageId = $languageController->getLanguageCode($_POST['language_code']);
    $category->itemCategoryName = $_POST['name'];
    $category->itemCategoryDescription = $_POST['description'];

    $categoryObject = new CategoryController();
    $response = $categoryObject->insertCategoryMl($category);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  o update selected Category_ML by ID AND Language ID
*/
function updateCategoryMl(){   

    $category = new CategoryModel();
    $languageController = new LanguageController();
    
    $category->categoryId = $_POST['category_id'];
    $category->languageId = $languageController->getLanguageCode($_POST['language_code']);
    $category->itemCategoryName = $_POST['name'];
    $category->itemCategoryDescription = $_POST['description'];

    $categoryObject = new CategoryController();
    $response = $categoryObject->updateteCategoryMl($category);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  o delete selected user by ID
*/
function deleteCategoryById(){

    $category = new CategoryModel();

    $categoryId = $_POST['category_id'];
    $categoryObject = new CategoryController();
    if( count($categoryObject->getCategory($categoryId )) != 0){
        $response = $categoryObject->deleteCategory($categoryId);
        echo json_encode($response); 
    
        http_response_code(201); 
    }else{
        echo json_encode('Category id is not in the system.'); 
        http_response_code(404); 
    } 
}

function getLanguageCode($languageCode){
    $laguageId = '1';

    if($languageCode == 'en'){
        $laguageId = '1';
    }elseif($languageCode == 'de'){
        $laguageId = '2';
    }

    return $laguageId ;
    
}









?>  