<?php
$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";
$user=$_COOKIE["username"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$id=$_POST["eveid"];
	$conn=mysqli_connect($servername, $username, $password, $dbname);
	if(!$conn){
		echo "Cannot connect to server";
		die();
	}
	$sql="DELETE FROM events WHERE id='$id'" ;
	$result=mysqli_query($conn,$sql);
	if(!$result){
		die("Sorry Can't connect to server");
	}
	header('Location: dashboard.php');
}
?>