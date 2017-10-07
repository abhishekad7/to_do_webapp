
<?php
$target_dir = "dps/";
$target_file = $target_dir . basename($_FILES["dp"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["dp"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk=0;
        die();
    }
}
// Check if file already exists

// Check file size
if ($_FILES["dp"]["size"] > 600000) {
    echo "Sorry, your image size is too large(upto 600 KB is allowed).";
    $uploadOk=0;
    die();
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
    echo "Sorry, only JPG, JPEG & PNG files are allowed.";
    $uploadOk=0;
    die();
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your image was not uploaded.";
    die();
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["dp"]["tmp_name"], $target_file)) {
        rename($target_file,"dps/".$_COOKIE["username"].".jpg");
        $servername = "localhost";
		$username = "root";
		$password = "akk";
		$dbname = "todo";
		$user=$_COOKIE["username"];
        $conn=mysqli_connect($servername, $username, $password, $dbname);
		if(!$conn){
			echo "Cannot connect to server";
			die();
		}
		$sql="UPDATE dps SET dp=1 WHERE username='$user'" ;
		$result=mysqli_query($conn,$sql);
		if(!$result){
			echo "Sorry, there was an error uploading your image. mysql";
			die();
		}
        echo "<script type='text/javascript'>window.location='dashboard.php';</script>";
    } else {
        echo "Sorry, there was an error uploading your file.";
        die();
    }
}
?>
