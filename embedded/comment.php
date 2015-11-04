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
			
			$post_id = 0;
			if( isset( $_POST['post_id'] ) && !isset( $_POST['text'] )){
				$post_id = $_POST['post_id'];
				$con= connect() or die("db connection error");

				$sql="SELECT text, post_type, title FROM posts where post_id = $post_id";
				
				
				$result = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($result);
				
				if( $row['post_type'] == 'Q' ){
					echo "<div class=\"question\"><h3>".$row['title']."</h3>";
				}
				else{
					echo "<div class=\"answer\">";
				}
				echo "<br><p class=\"text\">".$row['text']."</p><br>";
				
				$post_type = $row['post_type'];
				
				echo "<table class=\"comment\">
				</td></tr><form action=\"comment.php\" method=\"post\"><tr><td>
				<u>Comment:</u></td><tr><td>
				<textarea rows=\"20\" cols=\"30\" id=\"text\" name=\"text\"></textarea>
				</td></tr><tr><td><input type=\"hidden\" name=\"post_id\" value=$post_id><input type=\"hidden\" name=\"post_type\" value=$post_type><input class=\"button1\" type=\"submit\" value=\"Submit\"></td></tr>";
			}
			else if( isset( $_POST['text'] ) &&  isset( $_POST['post_type']) ){
				$con= connect() or die("db connection error");
				$text = $_POST['text'];
				$post_id = $_POST['post_id'];
				$post_type = $_POST['post_type'];
				$post_type = $post_type."_C";

				$cat_sql = "SELECT ca_id FROM posts WHERE post_id=$post_id";
				$result = mysqli_query($con, $cat_sql);
				$row = mysqli_fetch_array($result);
				$ca_id = $row['ca_id'];
				
				$sql="INSERT INTO posts(post_time,text,ca_id, parent_id, post_type, post_username) VALUES( NOW(),'$text', $ca_id, $post_id, '$post_type','".$_SESSION['username']."')";
				mysqli_query($con, $sql);
				echo "<div class=\"succes\">Suyccessfully commented!</div>";
				mysqli_close($con);
				header("Location: show_questions.php");
			}
			else{
				echo "error!";
			}
			
			
				
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
