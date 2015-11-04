 <?php
require_once( 'util.php');

try{
	if( isset( $_POST['q_id'] ) ){
		$q_id = $_POST[ 'q_id'];
	}
	else{
		die( 'variables not set properly');
	}
	$con= connect();
	$sql="DELETE FROM best_answer WHERE q_id=$q_id;)";
	echo $q_id;
	
	mysqli_query($con,$sql);
	mysqli_close($con);
}catch(Exception $e){die('err');}
?>
