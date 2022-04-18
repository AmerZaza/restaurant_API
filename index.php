<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once 'models/database.php';
include_once 'models/user_model.php';

$database = new Database();

$conn = $database->getConnection(); 
//getConnection();
$query = "SELECT * FROM  user ";


$stmt = $conn->prepare($query);

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($results) ;
?>