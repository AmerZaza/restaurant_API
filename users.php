<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");


//echo 'Hi from Users view';

include_once 'controllers/user_controller.php';


$userObject = new UserController();

//$allUsers = $userObject->getAllUsers();
//print_r($allUsers);

//$userById = $userObject->getUser(1);
//print_r($userById);

//$umodel = new UserModel();
//$umodel->userName = 'mz';
//$umodel->email = 'mz@gmail.com';
//$umodel->password = 'Fadi@@';
//print_r($userObject->insertUser($umodel));


//$umodel = new UserModel();
//$umodel->userName = 'Fadi';
//$umodel->email = 'Fadi@gmail.com';
//$umodel->password = 'Fadi@@XXa2zX';
//print_r($userObject->updatetUser($umodel , 5));

//$umodel = new UserModel();
//print_r($userObject->deleteUser(12));





if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($_POST['action'])){

        switch($_POST['action']){

            case 'select_all_users':
                selectUsers();
                break;
            case 'select_user_id':
                selectUserById();
                break;
            case 'regist_user':
                registNewUser();
                break;
            case 'update_by_id':
                updateUserById();
                break;
            case 'delete_by_id':
                deleteUserById();
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
function selectUsers(){
    $userObject = new UserController();
    $response = $userObject->getAllUsers();
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected users by userID from the System
*/
function selectUserById(){
    $userId = $_POST['user_id'];

    $userObject = new UserController();
    $response = $userObject->getUser($userId );
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected user by ID
*/
function registNewUser(){
    $user = new  UserModel();
    
    $user->firstName = $_POST['first_name'];
    $user->lastName = $_POST['last_name'];
    $user->userName = $_POST['user_name'];
    $user->password = $_POST['password'];
    $user->email = $_POST['email'];
    $user->token = gererateToken(30); // $_POST['token'];

    $userObject = new UserController();
    $response = $userObject->insertUser($user);
    echo json_encode($response);   
    
    http_response_code(201);
}

/*
**  o update selected user by ID
*/
function updateUserById(){

    $user = new  UserModel();

    $userId = $_POST['user_id'];
    $userObject = new UserController();
    if( count($userObject->getUser($userId )) != 0){
        $user->firstName = $_POST['first_name'];
        $user->lastName = $_POST['last_name'];
        $user->userName = $_POST['user_name'];
        $user->password = $_POST['password'];
        $user->email = $_POST['email'];
        $response = $userObject->updatetUser($user, $userId);
        echo json_encode($response); 
    
        http_response_code(201); 
    }else{
        echo json_encode('User id is not in the system.'); 
        http_response_code(404); 
    }
}

/*
**  o delete selected user by ID
*/
function deleteUserById(){

    $user = new  UserModel();

    $userId = $_POST['user_id'];
    $userObject = new UserController();
    if( count($userObject->getUser($userId )) != 0){
        $response = $userObject->deleteUser($userId);
        echo json_encode($response); 
    
        http_response_code(201); 
    }else{
        echo json_encode('User id is not in the system.'); 
        http_response_code(404); 
    } 
}

/*
** Generate user Token
*/
function gererateToken($n ){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
} 



?>  