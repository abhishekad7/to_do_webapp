<?php

$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$event=$_POST["eventname"];
	if(empty($event)){
		die("Event name cannot be empty");
	}
	$desc=$_POST["eventdesc"];
	$time=$_POST["eventtime"];
	$date=$_POST["eventdate"];
	$user=$_POST["eventuname"];
	$datetime=strtotime($date." ".$time);
	$status=1;

	$now=time()+12560;

	if(($datetime-$now)<0){
		echo "<script type='text/javascript'>alert('Event cannot be in past.');window.location='dashboard.php';</script>";
		die();
	}
		//Processing values

	$conn=mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		echo "Cannot connect to server";
		die();
	}

	//username check

	$sql="INSERT INTO events (username,event,eventtime,description,status) VALUES ('$user' , '$event', '$datetime', '$desc', '$status')" ;

	$result=mysqli_query($conn,$sql);
	if(!$result){
		echo "Sorry Try again.";
		die();
	}
	header('Location: /softablitz/todo/dashboard.php');

}

?>