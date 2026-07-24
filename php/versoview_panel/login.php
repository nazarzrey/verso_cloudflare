<?php

	$HostName = "localhost";
	$DatabaseName = "versoview";
	$HostUser = "root";
	$HostPass = "NazarApp";

	$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
	$json = file_get_contents('php://input');
	$obj = json_decode($json,true);
	$email = $obj['email'];
	$password = hash('sha512', hash('sha256', $obj['password']));
	$sql="select user_name,email,nohp from login where (email = '$email' OR nohp = '$email') and password = '$password' LIMIT 1";
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if(isset($row)){
		$data[] = $row;
		$SuccessLoginJson = json_encode($data);
		echo $SuccessLoginJson ;
	}
	else{
		$InvalidMSG = 'Invalid Username or Password Please Try Again' ;
		$InvalidMSGJSon = json_encode($InvalidMSG);
		echo $InvalidMSGJSon ;
	}
	
	mysqli_close($con);
?>