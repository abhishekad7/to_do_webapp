<?php
if(!isset($_COOKIE["username"])){
	header('Location: /softablitz/todo/?ref=l');
	exit();
}

$servername = "localhost";
$username = "root";
$password = "akk";
$dbname = "todo";

$conn=mysqli_connect($servername, $username, $password, $dbname);
if(!$conn){
	echo "Cannot connect to server";
	die();
}

$us=$_COOKIE["username"];

$sql="SELECT dp FROM dps WHERE username='$us'";

$result=mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	if($row["dp"]==1){
		setcookie("dp","true",0, "/");
	}
	else{
		setcookie("dp","false",0, "/");
	}
}

arrange_events($conn,$us);

function arrange_events($conn, $user){
	$sql="SELECT eventtime FROM events WHERE status<>0 AND username='$user'";
	$result=mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($result)){
		$eventtime=$row["eventtime"];
		if($eventtime<(time()+12560)){
			$sql="UPDATE events SET status=-1 WHERE eventtime='$eventtime' AND username='$user'";
			mysqli_query($conn, $sql);
		}
	}
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
	<link rel="stylesheet" href="todo.css">
  	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title><?php echo $_COOKIE['accname']?> | ToDo</title>
	<style>
		body {
			background-color: #ccc;
			background-image: url("img/todobg.jg");
			background-position: center;
    		background-repeat: repeat-y;
    		background-size: cover;
		}

		.indexcon {
			height:100vh;
			width: 100%;
			background-image: url("img/todobg.jg");
			background-position: center;
    		background-repeat: repeat-y;
    		background-size: cover;
		}

		.top {
			background-color: #3a3a3a;
			position: fixed;
			top: 0;
			left: 0;
			width:100vw;
			opacity: 1;
		}

		.nav-links li:hover {
			background-color: #252525;
		}

		.quotes {
			color:#0a9113;
			text-align: center;
			text-decoration: none;
			font-size: 20px;
			font-family: "Comic Sans MS";
			font-weight: bold;
		}
		
	</style>

</head>

<!-- BODY -->

<body onload="setdp()">



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
        <li><a href='#' onclick="" id='accountlink' style="max-width: 200px;overflow: hidden;"><?php $firstname=$_COOKIE["accname"]; echo explode(" ", $firstname)[0]; ?></a></li>
        <li><a href='/softablitz/todo/logout.php' id='logoutlink'>Log out</a></li>
        </ul>
    </div>
  </div>
</nav>
<div style="border: 0px solid red; margin-top: 52px" class="indexcon">

	<!-- DP-->
	<hr color="#fefefe">
	<div class='imgcontain'>
		<img src='img/login_img.jpg' alt='avatar' class='avatar' id="dpimg" name="dpimg" onclick="uploaddpform ()" onmouseover="this.style.cursor='pointer'">
		<p class="proname"><?php $firstname=$_COOKIE["accname"]; echo $firstname; ?></p>
		<button onclick="addnewform()" style="background-color: #48d1cc;color: white;padding: 14px 20px;margin: 8px 0;border: none;cursor: pointer;widows: 100%;font-weight: bold;">Add New Event</button>
	</div>
	<hr style="background-color:#64afbc">

	<!--Main Content-->



	<!-- LIST-->

	<div class="todo">
		<div style="border: 0px solid red;width: 100%;height: 100%;float: left;">
			<div class="menuitem">
				<table border=0 width="100%"><tr><td width="33%" style="border: 0px solid red;vertical-align: top;">
				<p class="accordion" onclick="checked(this)" style="color: #047c3a; background-color: rgba(4,124,58,0.4);"><img src="img/completed.png" style=" width: 40px;height:auto;">&nbsp;&nbsp;Completed&nbsp;<span style="letter-spacing: 0px;color: white; border:0px solid red; border-radius: 0%; background-color: #047c3a;padding: 10px;border-radius: 50%;">
					<?php 
							$servername = "localhost";
							$username = "root";
							$password = "akk";
							$dbname = "todo";
							$user = $_COOKIE["username"];

							$conn=mysqli_connect($servername, $username, $password, $dbname);
							if(!$conn){
								echo "Cannot connect to server";
								die();
							}
							
							$sql="SELECT * FROM events WHERE status=0 AND username='$user' ORDER BY eventtime";

							$resul=mysqli_query($conn,$sql);
							echo mysqli_num_rows($resul);
							?>

				</span></p>
					<div class="panel">
						<?php 
							
							if(!$conn){
								echo "Cannot connect to server";
								die();
							}
							
							$sql="SELECT * FROM events WHERE status=0 AND username='$user' ORDER BY eventtime";

							$resul=mysqli_query($conn,$sql);

							if(mysqli_num_rows($resul)){
								while($row = mysqli_fetch_assoc($resul)){
									$event=$row["event"];
									$desc=$row["description"];
									$time=$row["eventtime"];
									$samay=date('d-M-y H:i:s',$time);
									echo "<div class='completed accordion' onclick='inchecked(this)''><center>
										<table width='100%'><tr><td width='50%''><center><span style='width: 100%;margin-left: 1%;text-align: justify; overflow: hidden;text-overflow: ellipsis; font-size:20px;color:#0a9113;display:inline-block;'><font color='#0a9113'><b>$event</b></font></span></center></td>
										<td width='50%'><center><span style='width: 100%;margin-right: 2%;overflow: hidden; text-overflow: ellipsis; font-size:20px;display:inline-block'><font color='#0a9113'>$samay</font></span></center></td></tr></table><hr>
									</div>
									</center>
									<div class='inpanel' style='display: block'>
										<div class='completed'>
											<center><div>Description</div><hr></center>
											<center><div class='desc'>$desc</div></center>
											<hr>
										</div>
									</div>";
								}

							}
							else{
								echo "<div class='completed accordion' onclick='inchecked(this)''><center>
										<table width='100%'><tr><td width='100%''><center><span style='width: 100%;margin-left: 1%;text-align: justify; overflow: hidden;text-overflow: ellipsis; font-size:20px;display:inline-block;'><font color='#0a9113'><b>No Event Found</b></font></span></center></td>
										</tr></table><hr>
									</div>
									</center>";
							}


						?>
						
					</div>
				</td>
				<td width="34%" style="vertical-align: top;">
				<p class="accordion" onclick="checked(this)" style="color: #01798e; background-color:  rgba(1,121,142,0.4);"><img src="img/upcoming.png" style=" width: 47px;height:auto;">&nbsp;&nbsp;Upcoming&nbsp;<span style="letter-spacing: 0px;color: white; border:0px solid red; border-radius: 0%; background-color: #01798e;padding: 10px;border-radius: 50%;">
					<?php
					$sql="SELECT * FROM events WHERE status=1 AND username='$user' ORDER BY eventtime";

							$resul=mysqli_query($conn,$sql);
							echo mysqli_num_rows($resul);
							?>
				</span></p>

					<div class="panel">
						<?php 
							
							$sql="SELECT * FROM events WHERE status=1 AND username='$user' ORDER BY eventtime";

							$resul=mysqli_query($conn,$sql);

							if(mysqli_num_rows($resul)){
								while($row = mysqli_fetch_assoc($resul)){
									$event=$row["event"];
									$desc=$row["description"];
									$time=$row["eventtime"];
									$id=$row["id"];
									$samay=date('d-M-y H:i:s',$time);
									echo "<div class='upcoming accordion' onclick='inchecked(this)''><center>
										<table width='100%'><tr><td width='50%''><center><span style='width: 100%;margin-left: 1%;text-align: justify; overflow: hidden;text-overflow: ellipsis; font-size:20px;display:inline-block;'><font color='#01798e'><b>$event</b></font></span></center></td>
										<td width='50%'><center><span style='width: 100%;margin-right: 2%;overflow: hidden; text-overflow: ellipsis; font-size:20px;display:inline-block'><font color='#01798e'><b>$samay</b></font></span></center></td></tr></table><hr>
									</div>
									</center>
									<div class='inpanel' style='display: block'>
										<div class='upcoming'>
											<center><div>Description</div><hr></center>
											<center><div class='desc'>$desc</div></center><hr>
											<center><form action='complete.php' method='post' style='display:inline;'><input type='hidden' value='$id' name='eventid' id='eventid'></input><button type='submit'>Complete</button></form>&nbsp;&nbsp<form action='delete.php' method='post' style='display:inline;'><input type='hidden' value='$id' name='eveid' id='eveid'></input><button type='submit'>Delete</button></form></center>
											<hr>
										</div>
									</div>";
								}

							}
							else{
								echo "<div class='upcoming accordion' onclick='inchecked(this)''><center>
										<table width='100%'><tr><td width='100%''><center><span style='width: 100%;margin-left: 1%;text-align: justify; overflow: hidden;text-overflow: ellipsis; font-size:20px;display:inline-block;'><font color='#01798e'><b>No Event Found</b></font></span></center></td>
										</tr></table><hr>
									</div>
									</center>";
							}


						?>
					</div>
				</td>
				<td width="33%" style="vertical-align: top;">
				<p class="accordion" onclick="checked(this)" style="color:#a80606; background-color:  rgba(168,6,6,0.4);"><img src="img/missed.png" style=" width: 40px;height:auto;">&nbsp;&nbsp;Missed&nbsp;<span style="letter-spacing: 0px;color: white; border:0px solid red; border-radius: 0%; background-color: #a80606;padding: 10px;border-radius: 50%;">

					<?php
					$sql="SELECT * FROM events WHERE status=-1 AND username='$user' ORDER BY eventtime";

						$resul=mysqli_query($conn,$sql);
						echo mysqli_num_rows($resul);
						?>
					</span></p>
					<div class="panel">
						<?php 
							
							$sql="SELECT * FROM events WHERE status=-1 AND username='$user' ORDER BY eventtime";

							$resul=mysqli_query($conn,$sql);

							if(mysqli_num_rows($resul)){
								while($row = mysqli_fetch_assoc($resul)){
									$event=$row["event"];
									$desc=$row["description"];
									$time=$row["eventtime"];
									$samay=date('d-M-y H:i:s',$time);
									echo "<div class='missed accordion' onclick='inchecked(this)''><center>
										<table width='100%'><tr><td width='50%''><center><span style='width: 100%;margin-left: 1%;text-align: justify; overflow: hidden;text-overflow: ellipsis; font-size:20px;display:inline-block;'><font color='#9b0007'><b>$event</b></font></span></span></center></td>
										<td width='50%'><center><span style='width: 100%;margin-right: 2%;overflow: hidden; text-overflow: ellipsis; font-size:20px;display:inline-block'><font color='#9b0007'>$samay</font></span></center></td></tr></table><hr>
									</div>
									</center>
									<div class='inpanel' style='display: block'>
										<div class='missed'>
											<center><div>Description</div><hr></center>
											<center><div class='desc'>$desc</div></center>
											<hr>
										</div>
									</div>";
								}

							}
							else{
								echo "<div class='missed accordion' onclick='inchecked(this)''><center>
										<table width='100%'><tr><td width='100%''><center><span style='width: 100%;margin-left: 1%;text-align: justify; overflow: hidden;text-overflow: ellipsis; font-size:20px;display:inline-block;'><font color='#9b0007'><b>No Event Found</b></font></span></center></td>
										</tr></table><hr>
									</div>
									</center>";
							}


						?>
					</div>
				</td></tr></table>
			</div>
		</div>		
	</div>
	<center>
	<div class="footer">
		TODO@avishkar2k17 By Null Pointers
	</div>
	</center>
</div>

<!-- DP FORM-->

<div name='dpcontain' id='dpcontain' class='lfcontain'>
	<form class='loginform lfanimate' action="upload.php" method="post" enctype="multipart/form-data">
		<div class='imgcontain'>
			<span onclick="document.getElementById('dpcontain').style.display='none'" class='close' title='Close'>&times;</span>
			<img src='img/login_img.png' alt='avatar' class='avatar'>
		</div>
		<div class='lfcontainer'>
			 Select image to upload:
		    <input type="file" name="dp" id="dp" required>
			<center><span id="dperr" style="display:none;color:red;font-weight: bold;"></span></center>
			<button type="submit" id="dpsubmit">Upload Image</button>
		</div>
	</form>
</div>

<!--ADD EVENT-->

<div name='addnewcontain' id='addnewcontain' class='lfcontain'>
<form class='loginform lfanimate' action="addevent.php" method="post">
	<div class='imgcontain'>
		<span onclick="document.getElementById('addnewcontain').style.display='none'" class='close' title='Close'>&times;</span>
		<center><div class="menuitem" style="background-color: #fefefe"><p style="color:#0861af; background-color: #fefefe; font-size: 20px">Add new Event</p></div></center>
	</div>
	<div class='lfcontainer'>
		<center><span style="display:block;color:red;font-weight: bold;"></span></center>
		<label><b>Event Name</b></label><input type="text" name="eventname" id="eventname" placeholder="Event Name" maxlength="50" required>
		<center><span id="eventerr" style="display:none;color:red;font-weight: bold;"></span></center><br>
		<label><b>Event Date</b></label>&nbsp;<input type="date" name="eventdate" id="eventdate" style="display: inline-block;border: 1px solid #ccc;" required>
		<label><b>Event Time</b></label>&nbsp;<input type="time" name="eventtime" id="eventtime" style="display: inline-block;border: 1px solid #ccc;" required><br>
		<hr>
		<label><b>Description</b></label><textarea class="textarea" id="eventdesc" name="eventdesc" placeholder="Description" maxlength="200"></textarea>
		<input type="hidden" name="eventuname" id="eventuname" value="">
		<button type='submit' id='eventsubmit'>Add Event</button>
		<span class="cancel" onclick="document.getElementById('addnewcontain').style.display='none'">Cancel</span>
	</div>
</form>
</div>

</center>
</body>

<script type="text/javascript">
	
	function checked(oka){
		oka.classList.toggle("active");
		oka.nextElementSibling.classList.toggle("show");
	}

	function inchecked(oka){
		oka.classList.toggle("activein");
		oka.nextElementSibling.classList.toggle("inshow");
	}

	function uploaddpform(){
			var form=document.getElementById('dpcontain');
			form.style.display='block';
	}

	function addnewform(){
			var form=document.getElementById('addnewcontain');
			form.style.display='block';
	}

	function setdp(){
		var dp=getCookie("dp");
		var name=getCookie("username");
		if(dp=="true"){
			filename="dps/"+name+".jpg";
			document.getElementById('dpimg').src=filename;
		}
		else{
			document.getElementById('dpimg').src="img/login_img.png";
		}
		document.getElementById('eventuname').value=name;
	}

	function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
	}


</script>

</html>
