<?php

include './models/database.php';
include './models/user_model.php';


class UserController extends UserModel{



    // To return all users in DB
    public function getAllUsers(){
        
        $database = new Database();
        $conn = $database->getConnection();

        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

        // To return one user by userID
        public function getUser($userId){
        
            $database = new Database();
            $conn = $database->getConnection();
    
            $query = "SELECT * FROM  ".$this->table_name." WHERE user_id = " .$userId;
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }

        // To insert new user
        public Function insertUser($userModel){

            $database = new Database();
            $conn = $database->getConnection();

            $firstName =  $userModel->firstName;
            $lastName = $userModel->lastName;
            $userName = $userModel->userName;
            $password = $userModel->password;
            $email = $userModel->email;
            $token = $userModel->token;

            $query = "INSERT INTO ".$this->table_name." (u_name,first_name,last_name,u_email,token,u_password) VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$userName, $firstName, $lastName, $email, $token,$password]);

        }

        // To update current user by userID
        public Function updatetUser($userModel , $userId){

            $database = new Database();
            $conn = $database->getConnection();

            $firstName =  $userModel->firstName;
            $lastName = $userModel->lastName;
            $userName = $userModel->userName;
            $password = $userModel->password;
            $email = $userModel->email;
            $token = $userModel->token;

            $query = "UPDATE ".$this->table_name." SET u_name =?,first_name =?,last_name =?,u_email =?,token =?,u_password =? WHERE user_id =?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$userName, $firstName, $lastName, $email, $token,$password,  $userId]);
        }


        // To Delete current user by userID
        public Function deleteUser($userId){

            $database = new Database();
            $conn = $database->getConnection();

            $query = "DELETE FROM ".$this->table_name."  WHERE user_id =?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$userId]);
        }





     
    
    
}










?>