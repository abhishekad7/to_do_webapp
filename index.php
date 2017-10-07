<?php
if(count($_COOKIE)==0){
	echo "<script type='text/javascript'>alert('Please enable cookies');windoow.location='/softablitz/todo/index.php'</script>";
}
if(!isset($_COOKIE["test"])){
	setcookie("test","test",0,"/");
	header('Location: /softablitz/todo/index.php');
	exit();
}
if(isset($_COOKIE["username"])){
	header('Location: /softablitz/todo/dashboard.php');
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<!-- HEAD TAG -->

<head>
	<link rel="shortcut icon" href="img/todo_icon.png">
	<meta charset="=utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="forms.css">
  	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>ToDo</title>
	<style>
		body {
			background-color: #fefefe;
		}

		.indexcon {
			height:100vh;
			width: 100%;
			background-image: url("img/todobg.jpg");
			background-position: center;
    		background-repeat: no-repeat;
    		background-size: cover;
		}


		.nav-links li:hover {
			background-color: #252525;
		}

		.quotes {
			color:#0a9113;
			text-align: center;
			vertical-align: top;
			text-decoration: none;
			font-size: 16px;
			text-align: justify;
			font-family: "Comic Sans MS";
			font-weight: bold;
			padding: 0 10px 0 10px
		}

		.writer {
			position: relative;
			bottom: 0;
			right:0;
			border: 0px solid red;
			text-align: right;
			padding-right: 6px;
			font-family: 'script';
			font-variant: small-caps;
			color: #0a9113;
			font-weight: bold;
		}
		
	</style>

	<script type="text/javascript">
		function showlogin(){
			var form=document.getElementById('lfcontain');
			form.style.display='block';
		}

		function showregister(filling){
			var form=document.getElementById('regcontain');
			form.style.display='block';
			if(filling){
				filler();
			}
		}

		function filler(){
			obj=document.getElementById('fillerr');
			obj.innerHTML="Please fill all details";
			obj.style.display="inline-block";
		}

	</script>
</head>

<!-- BODY -->

<body onload="<?php $f=false;  if($_GET['ref']=='s'){if($_GET['fill']=='true'){$f=true;} echo 'showregister('.$f.')';} else if($_GET['ref']=='l'){echo 'showlogin()';}?>">
<!-- LOG IN FORM -->

<div name='lfcontain' id='lfcontain' class='lfcontain'>
	<form class='loginform lfanimate' action="#" method='post' onsubmit="return false">
		<div class='imgcontain'>
			<span onclick="document.getElementById('lfcontain').style.display='none'" class='close' title='Close'>&times;</span>
			<img src='img/login_img.png' alt='avatar' class='avatar'>
		</div>
		<div class='lfcontainer'>
			<label><b>Username</b></label><input type="text" name="loginuser" id="loginuser" placeholder="Enter Username" required>
			<label><b>Password</b></label><input type="password" name="loginpassword" id="loginpassword" placeholder="Enter Password" required>
			<center><span id="loginerr" style="display:none;color:red;font-weight: bold;"></span></center>
			<button type="submit" id="loginsubmit" onclick="login()">Login</button>&nbsp;&nbsp;
			<input type='checkbox' id='remember' name='remember' value="on">&nbsp;<font color="#01798e">Remember me</font>
		</div>
	</form>
</div>

<!--Signup-->

<div name='regcontain' id='regcontain' class='lfcontain'>
	<form class='loginform lfanimate' action='reg.php' method='post' onsubmit="return validatereg()">
		<div class='imgcontain'>
			<span onclick="document.getElementById('regcontain').style.display='none'" class='close' title='Close'>&times;</span>
			<img src='img/signup_img.jpg' alt='Sign Up' class='avatar'>
		</div>
		<div class='lfcontainer'>
			<center><span id="fillerr" style="display:none;color:red;font-weight: bold;"></span></center>
			<input type="text" name="regname" id="regname" placeholder="Your Fullname" onkeyup="validatename()" maxlength="200" required>
			<input type="text" name="reguser" id="reguser" placeholder="Username" onkeyup="validateuser()" required>
			<center><span id="usererr" style="display:none;color:red;font-weight: bold;"></span></center>
			<input type="text" name="regemail" id='regemail' placeholder="Your Email" onkeyup="validateemail()" required>
			<center><span id="emailerr" style="display:none;color:red;font-weight: bold;"></span></center>
			<input type="password" name="regpass" placeholder="New Password" maxlength="100" id="regpass" required>
			<center><span id="regpasserr" style="display:none;color:red;font-weight: bold;"></span></center>
			<input type="password" name="cnfregpass" id="cnfregpass" placeholder="Confirm New Password" onkeyup="validatecnfpass()" required>
			<button type='submit' id='regsubmit'>Sign Up</button>
		</div>
	</form>
</div>
	

<!-- Navigation Bar-->

<nav class="navbar navbar-inverse top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="/softablitz/todo/" style="font-family: 'Palatino Linotype'; font-weight: bold; font-variant: small-caps;">ToDo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right nav-links">
        <li><a href='#' onclick="showlogin()" id='loginlink'>Log In</a></li>
        <li><a href='#' onclick="showregister(false)" id='sighuplink'>New User</a></li>
        </ul>
    </div>
  </div>
</nav>
<center>
<div style="border: 0px solid red; margin-top: 55px" class="indexcon">
	<div class="imgcontain" style="z-index: 0;">
		<img src="img/action-stop-watch.jpg" style="width:30%; border-radius: 60%;">
	</div>
	<hr>
	<center><table border=0 width="85%"><tr>
		<td width="33.33%" style="border-right: 1px solid #fefefe">
		<p class="quotes">
			“Lack of direction, not lack of time, is the problem. We all have twenty-four hour days.”
		</p>
		<p class="writer">―Unknown</p>
		<td width="33.33%" style="border-right: 1px solid #fefefe">
		<p class="quotes">
			“I am definitely going to take a course on time management... just as soon as I can work it into my schedule."
		</p>
		<p class="writer">―Louis E. Boone</p>
		<td width="33.33%">
		<p class="quotes">
			“My hour for tea is half-past five, and my buttered toast waits for nobody.”
		</p> 
		<p class="writer">― Wilkie Collins, The Woman in White</p>
	</td>
	</tr>
	</table>
	</center>
	<hr>
	<br>
	<p style="font: 27px Garamond; color: #0a9113; font-weight:bold;">
		Give direction to your work. <a href="#" style="text-decoration: none;" onclick="showregister()">Join us</a> and feel the difference in managing your tasks.
	</p>

	<div class="footer">
		TODO@avishkar2k17 By Null Pointers
	</div>
</div>
</center>

</body>

<script type="text/javascript">
	function validatename(){
		obj=document.getElementById('regname');
		str=obj.value;
		n=str.search(/[^a-zA-Z\s]/i);
		if(n!=-1){
			obj.style.borderColor="red";
			document.getElementById('regsubmit').disabled=true;
			return false;
		}
		else{
			document.getElementById('regsubmit').disabled=false;
			obj.style.borderColor="";
			return true;
		}
	}
	function validateuser(){
		obj=document.getElementById('reguser');
		str=obj.value;
		n=str.search(/[^a-zA-Z0-9_]/i);
		l=str.length;
		if(n!=-1 || l<6){
			obj.style.borderColor="red";
			document.getElementById('regsubmit').disabled=true;
			if(n!=-1){
				document.getElementById('usererr').innerHTML="Only a-z, 0-9 and _ are allowed";	
			}
			else if(l<6){
				document.getElementById('usererr').innerHTML="Username contains atleast 6 characters";
			}
			document.getElementById('usererr').style.display="inline-block";
			return false;
		}
		else{
			if(!checkuser());
			obj.style.borderColor="";
			document.getElementById('regsubmit').disabled=false;
			document.getElementById('usererr').style.display="none";
			return true;
		}
	}
	function validatecnfpass(){
		obj=document.getElementById('cnfregpass');
		str=obj.value;
		pass=document.getElementById('regpass').value;
		if(str!=pass){
			obj.style.borderColor="red";
			document.getElementById('regsubmit').disabled=true;
			document.getElementById('regpasserr').innerHTML="Password do not match";
			document.getElementById('regpasserr').style.display="inline-block";	
			return false;
		}
		else{
			obj.style.borderColor="";
			document.getElementById('regsubmit').disabled=false;
			document.getElementById('regpasserr').style.display="none";
			return true;
		}
	}

	function validateemail(){
		obj=document.getElementById('regemail');
		email=obj.value;
		re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
		if(re.test(email)){
			obj.style.borderColor="";
			document.getElementById('regsubmit').disabled=false;
			document.getElementById('emailerr').style.display="none";
			return true;
		}
		else{
			obj.style.borderColor="red";
			document.getElementById('regsubmit').disabled=true;
			document.getElementById('emailerr').innerHTML="Invalid Email";
			document.getElementById('emailerr').style.display="inline-block";	
			return false;
		}
	}

	function validatereg(){
		if(validateuser() && validateemail() && validatecnfpass() && validatename()){
			return true;
		}
		else{
			return false;
		}
	}

	function checkuser(){
		u=document.getElementById('reguser').value;
		flag=true;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status ==200){
				str=this.responseText;
				if(str!="yes"){
					document.getElementById("usererr").innerHTML="Username not available";
					document.getElementById("usererr").style.display="inline-block";
					document.getElementById('regsubmit').disabled=true;
					flag=false;
				}
			}
		}
		xhttp.open("GET", "/softablitz/todo/checkuser.php?user="+u, true);
		xhttp.send();
		return flag;
	}

	function login(){
		u=document.getElementById('loginuser').value;
		p=document.getElementById('loginpassword').value;
		btn=document.getElementById('loginsubmit');
		check=document.getElementById('remember').value;
		btn.innerHTML="Checking";
		btn.disabled=true;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status ==200){
				btn.innerHTML="Login";
				btn.disabled=false;
				str=this.responseText;
				if(str=="Logged in"){
					document.getElementById("loginerr").innerHTML="Logged in";
					document.getElementById("loginerr").style.display="inline-block";
					document.getElementById("loginerr").style.color="green";
					window.location="/softablitz/todo/dashboard.php";
				}
				else{
					document.getElementById("loginerr").innerHTML=str;
					document.getElementById("loginerr").style.display="inline-block";
				}
			}
		}
		xhttp.open("POST", "/softablitz/todo/login.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send("loginuser="+u+"&loginpassword="+p+"&remember="+check);
	}
</script>

</html>
