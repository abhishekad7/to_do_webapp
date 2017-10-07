<?php
$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";
$user=$_COOKIE["username"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$id=$_POST["eventid"];
	$conn=mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		echo "Cannot connect to server";
		die();
	}
	$time=time()+12560;
	$sql="UPDATE events SET status=0, eventtime='$time' WHERE id='$id' AND username='$user'" ;
	$result=mysqli_query($conn,$sql);
	if(!$result){
		die("Sorry Can't connect to server");
	}
	header('Location: dashboard.php');
}
?>