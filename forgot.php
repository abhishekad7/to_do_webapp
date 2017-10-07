<?php
$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";

if($_SERVER["REQUEST_METHOD"]=="POST"){

	$email="";
	$name="";
	$pass="";
	$user=$_POST["u"];

	$sql="SELECT * FROM users WHERE uname='$user'";

	//Executing sql query
	$result=mysqli_query($conn, $sql);

	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)){
			$email=$row["email"];
			$user=$row["uname"];
			$name=$row["name"];
			$pass=$row["password"];
		}
		$to = $email;
		$subject = "Forgot Password";
		$txt = "Hi $name, Your Password is $pass for username $user.";
		$headers = "From: help@todo.com";
		if(mail($to,$subject,$txt,$headers)){
			echo "<script type='text/javascript'>alert('Password is sent to your registered email.');window.location='index.php';</script>";
		}
		else{
			echo "<script type='text/javascript'>alert('Unable to reset password, Try again');window.location='index.php';</script>";
		}
	}
	else{
		echo "<script type='text/javascript'>alert('Sorry, Cannot connect to server.');window.location='forgot.php';</script>";
		die();
	}


}
?>

<!doctype html>
<html>
	<head>
		<title>Forgot Password</title>
	</head>
	<body>
		<center>
			<fieldset style="width: 25%;margin-top: 60px">
				<legend>Forgot Password</legend>
				<form action='forgot.php' method='post'>
					<input type='text' name='u' id='u' placeholder="Username" style="border: 1px solid aqua;display: block;width:50%;height: 25px"><br>
					<button type='submit' style="width: 50%;display: block;height: 25px">Find Password</button>
				</form>
			</fieldset>
		</center>
	</body>
</html>