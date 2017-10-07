<?php

$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";

$ans= "no";

function test_input($data) {
	if(empty($data)){
		echo "no";
		die();
	}
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
  	return $data;
}

if($_SERVER["REQUEST_METHOD"]== "GET"){

	//Getting Values
	$uname=test_input($_GET["user"]);
	

	//Processing values

	$conn=new mysqli($servername, $username, $password, $dbname);
	if($conn->connect_error){
		echo "no";
		die();
	}

	$sql="SELECT uname FROM users WHERE uname='$uname'";

	//Executing sql query

	$result=$conn->query($sql);
	if($result->num_rows > 0){
		$ans="no";
	}
	else{
		echo "yes";
		die();
	}
}
echo $ans;
?>