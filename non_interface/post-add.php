 <?php
require_once( 'util.php');
if(isset($_POST['text']))
	$text=$_POST['text'];
	else
die('Input empty');

if(isset($_POST['title']))
	$title=$_POST['title'];

if(isset($_POST['parent_id']))
	$parent_id=$_POST['parent_id'];

if(isset($_POST['ca_id']))
	$ca_id=$_POST['ca_id'];

if(isset($_POST['post_type']))
	$post_type=$_POST['post_type'];

try{
	$con= connect();
	$sql=" INSERT INTO posts( 
		text, 
		post_time , 
		post_type, 
		title , 
		parent_id ,
		ca_id 
		)
	VALUES ('$text',NOW(),'$post_type','$title', $parent_id,'$ca_id')";
	mysqli_query($con,$sql) or die('err');
	mysqli_close($con);
}catch(Exception $e){die('err');}
?>
