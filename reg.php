<?php

$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";

function test_input($data) {
	if(empty($data)){
		header('Location: /softablitz/todo/index.php?ref=s&fill=true');
		die();
	}
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
  	return $data;
}

if($_SERVER["REQUEST_METHOD"]== "POST"){

	//Getting Values
	$name=test_input($_POST["regname"]);
	$user=test_input($_POST["reguser"]);
	$email=test_input($_POST["regemail"]);
	$pass=test_input($_POST["regpass"]);
	$cnfpass=test_input($_POST["cnfregpass"]);

	if($pass!=$cnfpass){
		header('Location: /softablitz/todo/index.php?ref=s&fill=true');
		die();
	}

	//Processing values

	$conn=mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		echo "<script type='text/javascript'>alert('connection_aborted');</script>";
		die();
	}

	//username check

	$sql="SELECT uname FROM users WHERE uname='".$user."'";

	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0){
		header('Location: /softablitz/todo/index.php?ref=s&fill=true');
		die();
	}

	$sql= "INSERT INTO users (name,uname,email,password) VALUES ('$name', '$user', '$email', '$pass')";

	//Executing sql query

	if(mysqli_query($conn, $sql)){
		setcookie("username",$user,time()+(86400 * 365), "/");
		setcookie("accname",$name,time()+(86400 * 365), "/");
		$sql="INSERT INTO dps (username,dp) VALUES ('$user', 0)" ;
		mysqli_query($conn,$sql);
		setcookie("dp","false",time()+(86400 * 365), "/");
		header('Location: /softablitz/todo/dashboard.php');
	}
	else{
		echo "<script type='text/javascript'>alert('Cannot reach server');</script>";
		die();
	}
}
else{
	header('Location: /softablitz/todo/index.php?ref=s&fill=true');
	die();
}

?>