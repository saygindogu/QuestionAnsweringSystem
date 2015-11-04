 <?php
require_once( 'util.php');
if(isset($_POST['post_id']))
	$post_id=$_POST['post_id'];
	else
die('post-id empty');

if(isset($_POST['point']))
	$point=$_POST['point'];
	else
die('Action empty');

try{
	if( isset( $_POST['post_id'] ) && isset( $_POST['point'] ) ){
		$post_id = $_POST[ 'post_id'];
		$point = $_POST['point'];
	}
	else{
		die( 'variables not set');
	}
	$con= connect();
	$sql="UPDATE posts SET rating = rating + $point where post_id=$post_id";
	
	mysqli_query($con,$sql) or die('err');
	mysqli_close($con);
}catch(Exception $e){die('err');}
?>
