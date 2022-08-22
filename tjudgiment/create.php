<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tjudgiment.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tjudgiment($db);
$data = json_decode(file_get_contents("php://input"));
$obj->userCode = $data->userCode;
$obj->judgimentGrade = $data->judgimentGrade;
$obj->averageWeight = $data->averageWeight;
$obj->description = $data->description;
$obj->createDate = $data->createDate;
$obj->cowCode = $data->cowCode;
if($obj->create()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>