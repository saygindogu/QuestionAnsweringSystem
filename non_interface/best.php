 <?php
require_once( 'util.php');

try{
	if( isset( $_POST['post_id'] ) && isset( $_POST['q_id'] ) ){
		$post_id = $_POST[ 'post_id'];
		$q_id = $_POST['q_id'];
	}
	else{
		die( 'variables not set properly');
	}
	$con= connect();
	$sql="INSERT INTO best_answer values( $q_id, $post_id)";
	
	mysqli_query($con,$sql) or die('err');
	mysqli_close($con);
}catch(Exception $e){die('err');}
?>
