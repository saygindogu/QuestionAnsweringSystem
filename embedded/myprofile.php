<html>
<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<link rel = "stylesheet" type="text/css" href="../style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head><body>
<?php
include("check_login.php");
if(check_login()!=1) 
	die('Login please!');
$unam=$_COOKIE['username'];
try{
$con=mysqli_connect("") or die("db connection error");
$result = mysqli_query($con,"SELECT * FROM User WHERE username = '$unam'") or die('query err1');
while($row = mysqli_fetch_array($result))
{
	echo"<table><tr><td><u>Username:</u>".$row['username']."</td></tr><tr><td><u>Mail:</u>".$row['mail']."</td></tr></table>";

mysqli_close($con);
}}catch(Exception $e){die('err');}
?>
</body></html>
