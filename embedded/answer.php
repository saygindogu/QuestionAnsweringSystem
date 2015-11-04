<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<link rel = "stylesheet" type="text/css" href="../style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body>

	<?php
		require_once( '../non_interface/util.php');
		if( !isset($_SESSION) ) 
		{ 
			session_start(); 
		}
		$perms = getPermissions();
		try{
			
			$q_id = 0;
			if( isset( $_POST['q_id'] ) && !isset( $_POST['text'] )){
				$q_id = $_POST['q_id'];
				$con= connect() or die("db connection error");

				$sql="SELECT title, text FROM posts where post_id = $q_id";
				
				
				$result = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($result);
				
				echo "<div class=\"question\"><h3>".$row['title']."</h3><br><p class=\"text\">".$row['text']."</p><br>";
				
				echo "<table class=\"answer\">
				</td></tr><form action=\"answer.php\" method=\"post\"><tr><td>
				<u>Answer question:</u></td><tr><td>
				<textarea rows=\"20\" cols=\"30\" id=\"text\" name=\"text\"></textarea>
				</td></tr><tr><td><input type=\"hidden\" name=\"q_id\" value=$q_id><input class=\"button1\" type=\"submit\" value=\"Submit\"></td></tr>";
			}
			else if( isset( $_POST['text'] ) ){
				$con= connect() or die("db connection error");
				$text = $_POST['text'];
				$q_id = $_POST['q_id'];

				$cat_sql = "SELECT ca_id FROM posts WHERE post_id=$q_id";
				$result = mysqli_query($con, $cat_sql);
				$row = mysqli_fetch_array($result);
				$ca_id = $row['ca_id'];
				
				$sql="INSERT INTO posts(post_time,text,ca_id, parent_id, post_type, post_username) VALUES( NOW(),'$text', $ca_id, $q_id, 'A','".$_SESSION['username']."')";
				mysqli_query($con, $sql);
				echo "<div class=\"succes\">Successfully answered!</div>";
				header("Location: show_questions.php");
			}
			else{
				echo "error!";
			}
			
			mysqli_close($con);
				
		}catch(Exception $e){}
	?>
	<script>		
			function vote( id, poin ) {
				var jQuery = $.post( "../non_interface/vote.php",
					{
					  post_id:id,
					  point:poin
					} 
					);
				 jQuery.success( function(data) {
					document.write("<div class=\"success\">Voted Successfully!</div>" );
				});
			}
	</script>
	</body>
</html>
