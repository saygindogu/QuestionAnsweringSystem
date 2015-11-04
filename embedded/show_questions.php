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
			$limit = 20;
			$offset = 0;
			
			
			if( isset( $_POST['offset'] ) ){
				$offset = $_POST['offset'];
			}
			if( isset( $_POST['limit'] ) ){
				$limit = $_POST['limit'];
			}
			$con= connect();

			$sql = "";
			if( isset( $_POST['t_id'] )){

				$t_id = $_POST['t_id'];
				$sql="SELECT *
						FROM posts NATURAL JOIN has_tag 
						WHERE 	post_type = 'Q' AND t_id = $t_id 
						ORDER BY post_time DESC
						LIMIT $limit
						OFFSET $offset";
			}
			else if( isset( $_POST['ca_id'] )){
				$ca_id = $_POST['ca_id'];
				$sql="SELECT post_id, title, text, post_time FROM posts where post_type = 'Q' and ca_id = $ca_id ORDER BY post_time DESC limit $limit offset $offset";
			}
			else if( isset( $_POST['text'] )){
								$text = $_POST['text'];

				$sql="SELECT * FROM posts WHERE text LIKE '%$text%' OR title LIKE '%$text%'";
			}
			
			else if( isset( $_POST['post_username'] )){

				$pusername = $_POST['post_username'];
				$sql="SELECT *
						FROM posts
						WHERE 	post_type = 'Q' AND post_username= '$pusername'
						ORDER BY post_time DESC
						LIMIT $limit
						OFFSET $offset";
			}
			else{
				$sql="SELECT post_id, title, text, post_time FROM posts where post_type = 'Q' ORDER BY post_time DESC  limit $limit offset $offset";
			}
			
			$result = mysqli_query( $con, $sql);
			$i=1;
			echo "<h1>Questions</h1><br><p>Showing $limit questions per page.</p><br><table class=\"questions\">";
			while($row = mysqli_fetch_array($result)){
			echo"<tr>\n\t<th rowspan=\"3\">".($i+$offset)."</td>\n<td><button class=\"title\" type=\"button\" onclick=\"goToQuestion( ".$row['post_id']." );\">".$row['title']."</button></td></tr>
			\n<tr><td><i>".$row['post_time']."</i></td></tr>
			\n<tr><td>".$row['text']."</td></tr>\n";
				$i++;
			}
			echo "</table>";
			if( isset( $_POST['t_id'] )){
				if( $offset > 0){
					echo "<button type=\"button\" onclick=\"loadAgainWithTags( ".($offset-$limit).",".$_POST['t_id'].")\">Previous</button>";
				}
				echo "<button type=\"button\" onclick=\"loadAgainWithTags( ".($offset+$limit).", ".$_POST['t_id']."  )\">Next</button>";
			}
			else if( isset( $_POST['ca_id'])){
				if( $offset > 0){
				echo "<button type=\"button\" onclick=\"loadAgainWithCategory( ".($offset-$limit).", ".$_POST['ca_id']." )\">Previous</button>";
				}
				echo "<button type=\"button\" onclick=\"loadAgainWithCategory( ".($offset+$limit).", ".$_POST['ca_id']." )\">Next</button>";
			}
			else if( isset( $_POST['post_username'])){
				if( $offset > 0){
				echo "<button type=\"button\" onclick=\"loadAgainWithUser( ".($offset-$limit).", '".$_POST['post_username']."' )\">Previous</button>";
				}
				echo "<button type=\"button\" onclick=\"loadAgainWithUser( ".($offset+$limit).", '".$_POST['post_username']."' )\">Next</button>";
			}
			else{
				if( $offset > 0){
				echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( ".($offset-$limit)." )\">Previous</button>";
				}
				echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( ".($offset+$limit)." )\">Next</button>";
			}
			
			mysqli_close($con);	
		}catch(Exception $e){ die( 'exception'); }
	?>
	</div>
	<script>
			function goToQuestion( post_id_val ){
				var jQuery = $.post( "question.php",
					{
						post_id:post_id_val
					} 
					);
				 jQuery.success( function(data) {
					document.body.innerHTML = '';
					document.write(data);
				});
			}
			function loadAgain( offsetval ) {
				var jQuery = $.post( "show_questions.php",
					{
					  offset:offsetval
					} 
					);
				 jQuery.success( function(data) {
					$("body").html(data);
				});
			}
			
			function loadAgainWithTags( offsetval, id ) {
				var jQuery = $.post( "show_questions.php",
					{
					  offset:offsetval,
					  t_id:id
					} 
					);
				 jQuery.success( function(data) {
					$("body").html(data);
				});
			}
			
			function loadAgainWithUser( offsetval, id ) {
				var jQuery = $.post( "show_questions.php",
					{
					  offset:offsetval,
					  post_username:id
					} 
					);
				 jQuery.success( function(data) {
					$("body").html(data);
				});
			}
			
			function loadAgainWithCategory( offsetval, id ) {
				var jQuery = $.post( "show_questions.php",
					{
					  offset:offsetval,
					  ca_id:id
					} 
					);
				 jQuery.success( function(data) {
					$("body").html(data);
				});
			}
	</script>
	</body>
</html>
