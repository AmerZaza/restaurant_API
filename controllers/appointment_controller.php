<?php

include './models/database.php';
include './models/appointment_model.php';
//include '../models/language_model.php';
//include './core/functions.php';



class AppointmentController  extends AppointmentModel {


    // To return all Appointments in  DB
    public function getAllAppointments(){
        
        $database = new Database();
        $conn = $database->getConnection();

        $query = "SELECT * FROM  appointment
                  LEFT JOIN restaurant 
                  ON appointment.restaurant_id = restaurant.restaurant_id 
                  LEFT JOIN user
                  ON user.user_id = appointment.user_id
                  ";
            
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

        // To return one selected Appointment by Id 
        public function getAppointmentById($AppointmentId){
        
            $database = new Database();
            $conn = $database->getConnection();
    
            $query = "SELECT * FROM  appointment
            LEFT JOIN restaurant 
            ON appointment.restaurant_id = restaurant.restaurant_id 
            LEFT JOIN user
            ON user.user_id = appointment.user_id
            WHERE appointment_id = {$AppointmentId}";

            $stmt = $conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }

      
        // To insert new Appointment
        public Function insertNewAppointment($appointment){

            $database = new Database();
            $conn = $database->getConnection();

            //$appointmentId = $appointment->appointmentId ;
            $restaurantId = $appointment->restaurantId ;
            $dateTime = $appointment->dateTime ;
            $persons = $appointment->persons ;
            $userId = $appointment->userId ;
            
            
            $query = "INSERT INTO appointment ( restaurant_id, date_time, persons, user_id) 
                                                 VALUES (?,?,?,?)";

            $stmt = $conn->prepare($query);
            $stmt->execute([$restaurantId, $dateTime, $persons, $userId ]);

            return('One Appointment Added') ;
        }



        // To update current Appointmentry by AppointmentId
        public Function updateteAppointmentById($appointment){

            $database = new Database();
            $conn = $database->getConnection();

            $appointmentId = $appointment->appointmentId ;
            $restaurantId = $appointment->restaurantId ;
            $dateTime = $appointment->dateTime ;
            $persons = $appointment->persons ;
            $userId = $appointment->userId ;

            $query = "UPDATE appointment SET restaurant_id=?, date_time=?, persons=?, user_id=?  WHERE appointment_id =? ";

            $stmt = $conn->prepare($query);
            $stmt->execute([$restaurantId, $dateTime, $persons, $userId, $appointmentId]);

             return('One Appoitment Updated') ;
        }


        // To Delete current Appointment by AppointmentID
        public Function deleteAppointmentId($appointmentId){

            $database = new Database();
            $conn = $database->getConnection();

            $query = "DELETE FROM  appointment  WHERE appointment_id =?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$appointmentId]);
        }





     
    
    
}


?>