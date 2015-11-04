<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<link rel = "stylesheet" type="text/css" href="../style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body>
	<div>
	<?php
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		require_once( 'non_interface/util.php');
		
		try{
			$con= connect();
			
			
			/*$sql="SELECT count(*) as cquest,post_username from posts where post_type='Q' group by post_username";
			$sql="SELECT count(*) as cuser from users";
			$sql="SELECT count(*) as cuser from users where blocked_until != 'NULL'";
		    $sql="SELECT count(*) as cquest from posts where post_type='Q'";
			$sql="SELECT count(*) as cans from posts where post_type='a_c'";
			$sql="SELECT count(*) as ccomm from posts where post_type='q_c'";
			$sql="SELECT count(*) as cfollt from follow_tag";
			$sql="SELECT count(*) as cfollq from follow_question";
			$sql="SELECT count(*) as cfollf from favorites";
			$sql="SELECT count(*) as cfollc from follow_category";
			$sql="SELECT count(*) as ceven from event";
			*/
			
			$sql="SELECT count(*) as cuser from users";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Users no:'.$row['cuser'].'<br>');
			}
			
				$sql="SELECT count(*) as cuser from users where blocked_until != 'NULL'";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Users blocked:'.$row['cuser'].'<br>');
			}
			
			$sql="SELECT count(*) as cquest from posts where post_type='Q' ";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Questions no:'.$row['cquest'].'<br>');
			}
			
			$sql="SELECT count(*) as cquest,post_username from posts where post_type='Q' group by post_username";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Questions no:'.$row['cquest'].' by '.$row['post_username'].'<br>');
			}
			
			$sql="SELECT count(*) as cans from posts where post_type='a_c'";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Answer no:'.$row['cans'].'<br>');
			}
			
			
			$sql="SELECT count(*) as ccomm from posts where post_type='q_c'";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Comment no:'.$row['ccomm'].'<br>');
			}
			
			$sql="SELECT count(*) as cfollt from follow_tag";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Following tags no:'.$row['cfollt'].'<br>');
			}
			
				$sql="SELECT count(*) as cfollc from follow_category";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Following category no:'.$row['cfollc'].'<br>');
			}
			
				$sql="SELECT count(*) as cfollq from follow_question";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Following question no:'.$row['cfollq'].'<br>');
			}
			
			$sql="SELECT count(*) as cfollf from favorites";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Favorites question no:'.$row['cfollf'].'<br>');
			}
			
			$sql="SELECT count(*) as ceven from event";
			$result = mysqli_query( $con, $sql);
			while($row = mysqli_fetch_array($result)){
				echo('Event no:'.$row['ceven'].'<br>');
			}
			
			mysqli_close($con);	
		}catch(Exception $e){ die( 'exception'); }
	?>
	</div>
	</body>
</html>
