<?php

$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";

function test_input($data) {
	if(empty($data)){
		echo "Username or Password cannot be left blank";
		die();
	}
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
  	return $data;
}



if($_SERVER["REQUEST_METHOD"]== "POST"){

	//Getting Values
	$user=test_input($_POST["loginuser"]);
	$pass=test_input($_POST["loginpassword"]);
	$rem="off";
	if(isset($_POST["remember"])){
		$rem="on";
	}
	$name="";

	//Processing values

	$conn=mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		echo "Cannot connect to server";
		die();
	}

	//username check

	$sql="SELECT uname FROM users WHERE uname='$user'" ;

	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)==0){
		echo "No account found";
		die();
	}

	$sql="SELECT name, uname FROM users WHERE uname='$user' AND password='$pass'";

	//Executing sql query
	$result=mysqli_query($conn, $sql);

	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)){
			$user=$row["uname"];
			$name=$row["name"];
		}
		if($rem=="on"){
			setcookie("username",$user,time()+(86400 * 365), "/");
			setcookie("accname",$name,time()+(86400 * 365), "/");
		}
		else{
			setcookie("username",$user,0, "/");
			setcookie("accname",$name,0, "/");
		}
		echo "Logged in";
	}
	else{
		echo "Wrong username and password combination";
		die();
	}
}
?>