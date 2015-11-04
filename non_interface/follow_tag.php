<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<link rel = "stylesheet" type="text/css" href="../style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
<?php
require_once("util.php");
if(!check_login()) 
	die('You can access only after login!');

try{
$con=connect() or die("db connection error");

if(!isset($_POST['tag_id']))
	die('No quest. selected');

if(!isset($_SESSION['username']))
	die('No login');


$tagid = intval($_POST['tag_id']);
$username = $_SESSION['username'];
$result = mysqli_query($con,"INSERT INTO follow_tag(username,t_id) VALUES ('$username',$tagid)");
echo "<div class=\"succes\">Successfully followed tag!</div>";

mysqli_close($con);
	}catch(Exception $e){die('err');}
?>
