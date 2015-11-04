
<?php
require_once("util.php");
if(!check_admin()) 
	die('You can access only as admin!');

try{
	$con=connect() or die("db connection error");
	echo "close.php";
	if(!isset($_POST['post_id']))
		die('No quest. selected');

	echo "hala close.php";
	$postid=intval($_POST['post_id']);
	$username=$_SESSION['username'];
	$result = mysqli_query($con,"UPDATE posts SET close_username =  '$username' where post_id=$postid");
	// where username='$username'") or die('query err1');
	mysqli_close($con);
	}catch(Exception $e){die('err');}
?>
