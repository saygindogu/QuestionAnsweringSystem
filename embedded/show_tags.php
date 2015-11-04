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
		require_once( '../non_interface/util.php');

		try{
			$limit = 50;
			$offset = 0;
			if( isset( $_POST['offset'] ) ){
				$offset = $_POST['offset'];
			}
			if( isset( $_POST['limit'] ) ){
				$limit = $_POST['limit'];
			}
			$con= connect();
			
			if( isset( $_GET['follow'] ) ){
				$sql="SELECT * FROM tags, follow_tag WHERE follow_tag.username = '".$_SESSION['username']."' AND follow_tag.t_id = tags.t_id limit $limit offset $offset";
			}
			else{
				$sql="SELECT * FROM tags limit $limit offset $offset";
			}
			
			$result = mysqli_query( $con, $sql);
			$i=1;
			echo "<h1>Tags</h1><br><p>Showing $limit tags per page.</p><br><table class=\"tags\">";
			while($row = mysqli_fetch_array($result)){
				echo"<tr><th rowspan=\"4\">".($i+$offset)."</th><td><button class=\"title\" type=\"button\" onclick=\"goToQuestionsOf( ".$row['t_id']." );\">".$row['text']."</button></td></tr><tr><td><i>".$row['creation_time']."</i></td></tr><tr><td>".$row['text']."</td></tr><tr><td>";
				echo_follow_button( $row['t_id'] );
				echo "</td></tr>";
				$i++;
			}
			echo "</table>";
			if( $offset > 0){
				echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( ".($offset-$limit)." )\">Previous</button>";
			}
			echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( ".($offset+$limit)." )\">Next</button>";
			
			if( check_login() == 1){
				echo "<button class=\"button1\" type=\"button\" onclick=\"document.location='tag_adder.php' \">add tag</button>";
			}
			mysqli_close($con);
			}catch(Exception $e){ die( 'exception');}
			
			function echo_follow_button( $t_id ){
				if( check_login() == 1){
					echo "<button class=\"tagFollow\" onclick=\"follow( $t_id, '".$_SESSION['username']."')\">Follow</button>";
				}
				else{
					echo "<div>Not Logged In.<div>";
				}
			}


	?>
	<script>
			function follow( t_id_val, username_val ){
				var jQuery = $.post( "../non_interface/follow_tag.php",
					{
						tag_id:t_id_val,
						username:username_val
					} 
					);
				 jQuery.success( function(data) {
					document.body.innerHTML = '';
					document.write(data);
				});
			}
			function goToQuestionsOf( t_id_val ){
				var jQuery = $.post( "show_questions.php",
					{
						t_id:t_id_val
					} 
					);
				 jQuery.success( function(data) {
					document.body.innerHTML = '';
					document.write(data);
				});
			}
			function loadAgain( offsetval ) {
				var jQuery = $.post( "show_tags.php",
					{
					  offset:offsetval
					} 
					);
				 jQuery.success( function(data) {
					$("body").html(data);
				});
			}
	</script>
	</div>
	</body>
</html>
