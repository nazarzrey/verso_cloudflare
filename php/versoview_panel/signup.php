<?php

	$HostName = "localhost";
	$DatabaseName = "versoview";
	$HostUser = "root";
	$HostPass = "NazarApp";

	$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
	$json = file_get_contents('php://input');
	$obj = json_decode($json,true);
	$email = $obj['email'];
	$username = $obj['username'];
	$nohp = $obj['nohp'];
	$password = hash('sha512', $obj['password']);
	$confirmpassword = $obj['confirmpassword'];
	
	$sql = "INSERT INTO login (email, user_name, password, nohp)
			VALUES ('$email', '$username', '$password', '$nohp')";

	if (mysqli_query($con, $sql)) {
	    $SuccessLoginMsg = 'Data Matched';
		$SuccessLoginJson = json_encode($SuccessLoginMsg);
		echo $SuccessLoginJson ;
	} else {
	    $InvalidMSG = 'Invalid Username or Password Please Try Again' ;
		$InvalidMSGJSon = json_encode($InvalidMSG);
		echo $InvalidMSGJSon ;
	}
	// echo json_encode(hash('sha512', $password));

	mysqli_close($con);
?>