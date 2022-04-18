<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, x-requested-with");


include_once 'controllers/appointment_controller.php';
//include_once 'controllers/language_controller.php';
include_once 'configuration.php';


if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($_POST['action'])){

        switch($_POST['action']){

            case 'select_all_appointments':
                selectAllAppointments();
                break;
            case 'select_appointment_id':
                selectAppointmentById();
                break;
            case 'new_appointment':
                addNewAppointment();
                break;
            case 'update_appointment_by_id':
                updateAppointmentById();
                break;
            case 'delete_appointment_id':
                deleteAppointment();
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
function selectAllAppointments(){
    $appointmentObject = new AppointmentController();
    $response = $appointmentObject->getAllAppointments();
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To get selected Order by orderID from the System
*/
function selectAppointmentById(){
    $AppointmentId = $_POST['appointment_id'];

    $appointmentObject = new AppointmentController();
    $response = $appointmentObject->getAppointmentById($AppointmentId);
    echo json_encode($response);

    http_response_code(200);
}

/*
**  To Insert order 
*/
function addNewAppointment(){
    
    $appointment = new AppointmentModel();

    //$appointment->appointmentId = $_POST['appointment_id'] ; 
    $appointment->restaurantId = $_POST['restaurant_id'];
    $appointment->dateTime = $_POST['date_time'];
    $appointment->persons = $_POST['persons'];
    $appointment->userId = $_POST['user_id'];


    $appointmentObject = new AppointmentController();
    $response = $appointmentObject->insertNewAppointment($appointment);
    echo json_encode($response);  
    
    http_response_code(201);
}

/*
**  o update selected Order by orderHead ID 
*/
function updateAppointmentById(){   
    
    $appointment = new AppointmentModel();

    $appointment->appointmentId = $_POST['appointment_id'] ; 
    $appointment->restaurantId = $_POST['restaurant_id'];
    $appointment->dateTime = $_POST['date_time'];
    $appointment->persons = $_POST['persons'];
    $appointment->userId = $_POST['user_id'];


    $appointmentObject = new AppointmentController();
    $response = $appointmentObject->updateteAppointmentById($appointment);
    echo json_encode($response);  
    
    http_response_code(201);
}

/*
**  o delete selected user by ID
*/
function deleteAppointment(){

    $appointmentId = $_POST['appointment_id'];

    $appointmentObject = new AppointmentController();
    $response = $appointmentObject->deleteAppointmentId($appointmentId);

    if($response){
        echo json_encode($response); 
        http_response_code(201); 
    }else{
        echo json_encode('Appointment id is not in the system.'); 
        http_response_code(404); 
    }
      
}


?>  