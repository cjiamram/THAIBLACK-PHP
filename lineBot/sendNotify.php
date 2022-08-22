<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Bangkok");

	$sToken = "vy2QVhVs0xapg7Efu5V7P1qYKb31NZh5kDNGyRT78OI";
	
	$data = json_decode(file_get_contents("php://input"));
	
	$sMessage =isset($data->message)?$data->message:"Trsnsfer Slip";

	
	$chOne = curl_init(); 
	// curl_setopt($cv, CURLOPT_URL, “https://covid19.th-stat.com/api/open/today");
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	/*
	“{\r\n\r\n \”to\”: \”$id\”,\r\n\r\n \”messages\”: [{\r\n\r\n \”type\”: \”text\”,\r\n\r\n \”text\”: \”$msg\”\r\n\r\n }]\r\n\r\n}”,
	*/
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		$result_ = json_decode($result, true); 
		echo "status : ".$result_['status']; 
		echo "message : ". $result_['message'];
	} 
	curl_close( $chOne );   
?>