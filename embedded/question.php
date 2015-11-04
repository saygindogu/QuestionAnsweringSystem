<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<link rel = "stylesheet" type="text/css" href="../style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body>

	<?php
		$post_id = 0;
		require_once( '../non_interface/util.php');
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		$perms = getPermissions();
		try{
			
			if( isset( $_POST['post_id'] ) ){
				$post_id = $_POST['post_id'];
			}
			else{
				echo "error!";
			}
			$con= connect() or die("db connection error");

			$sql="SELECT post_id, title, text, post_time, post_username, close_username FROM posts where post_id = $post_id";
			$answersSql="SELECT post_id, title, text, post_time, post_type, post_username  FROM posts where parent_id = $post_id ORDER BY post_type, post_time DESC";
			$result = mysqli_query($con, $sql);
			$answersResult = mysqli_query($con, $answersSql);
			
			$row = mysqli_fetch_array($result);
			echo "<div class=\"question\"><h3>".$row['title']."</h3><br>";
			echo_vote_buttons( $row['post_id'], $perms );
			echo "<br>";
			echo_answer_button( $row['post_id'], $perms, $row['close_username'] != null );
			echo_close_button( $row['post_id'], $perms );
			echo_comment_button( $row['post_id'], $perms);
			echo "<br><p class=\"text\">".$row['text']."</p><br><i>".$row['post_time']."</i>&emsp;<b>posted by:</b>".$row['post_username'];
			
			echo $post_id;
			$best_q_sql = "SELECT a_id FROM best_answer where q_id = $post_id";
			$best_q_result = mysqli_query($con, $best_q_sql);
			$best_set =false;
			if( $best_q_result != false && $best_q_result->num_rows != 0 ){
				$bestRow = mysqli_fetch_array($best_q_result);
				$best_q_result_post = mysqli_query($con, "SELECT * FROM posts WHERE post_id=".$bestRow['a_id'] );
				$bestRow_post =mysqli_fetch_array($best_q_result_post);
				$postid = $bestRow_post['post_id'];
					echo "<div class=\"answer\"><h3>Best Answer</h3><br><button class=\"best button1\" onclick=\"not_best( $post_id)\">Not Best</button><p class=\"text\">".$bestRow_post['text']."</p><br><i>".$bestRow_post['post_time']."</i>&emsp;<b>posted by:</b>".$bestRow_post['post_username'];
					echo_comment_button( $postid, $perms);
					echo_vote_buttons( $postid, $perms );
					echo "</div>";
					$best_set = true;
			}
			$i = 1;
			while( $answerRow = mysqli_fetch_array($answersResult) ){
				if( $answerRow['post_type'] == 'A' ){
					$postid = $answerRow['post_id'];
					echo "<div class=\"answer\"><p class=\"text\">".$answerRow['text']."</p><br><i>".$answerRow['post_time']."</i>&emsp;<b>posted by:</b>".$answerRow['post_username'];
					echo_comment_button( $postid, $perms);
					echo_vote_buttons( $postid, $perms );
					echo_favorite_button( $best_set, $row['post_id'], $row['post_username'], $postid );
					
					$commentSql = "SELECT post_id, title, text, post_time, post_type, post_username  FROM posts where parent_id =".$answerRow['post_id'];
					$commentResult = mysqli_query($con, $commentSql);
					$j = 1;
					while( $commentRow = mysqli_fetch_array($commentResult) ){
						$postid = $commentRow['post_id'];
					
						echo "<div class=\"comment\"><p class=\"text\">".$commentRow['text']."</p><i>".$answerRow['post_time']."</i>&emsp;<b>posted by:</b>".$answerRow['post_username'];
						echo_vote_buttons( $postid, $perms );
						echo "<br></div>";
					
						$j++;
						}
						echo "</div>";
				}
				else{
					$postid=$answerRow['post_id'];
					echo "<div class=\"comment\"><p class=\"text\">".$answerRow['text']."</p><br><i>".$answerRow['post_time']."</i>&emsp;<b>posted by:</b>".$answerRow['post_username'];
					echo_vote_buttons( $postid, $perms );
					echo "</div>";
				
				}
				$i++;
			}
			echo "</div>";
		
			mysqli_close($con);
				
		}catch(Exception $e){}
		
		function echo_favorite_button( $best_set, $q_id, $username, $post_id ){
			if( !$best_set){
				if( isset( $_SESSION['username'])){
					if( $_SESSION['username'] == $username ){
						echo "<button class=\"best\" onclick=\"best( $q_id, $post_id)\">Best</button>";
					}
				}
			}
		}
		
		function echo_close_button( $postid, $perms ){
			if( $perms['can_close_post']  ){
				echo "<button class=\"close button1\" onclick=\"closeQuestion( $postid)\">Close</button>";
			}
		}
		function echo_answer_button( $postid, $perms, $isClosed ){
			if( $perms['can_answer_question'] && !$isClosed ){
				echo "<button class=\"answer button1\" onclick=\"answer( $postid)\">Answer</button>";
			}
			else if( $isClosed ){
				echo "<p style=\"font-size:1.8em\"><b> This post is closed.</b> </p>";
			}
		}
		
		function echo_comment_button( $postid, $perms ){
			if( $perms['can_comment_on_post'] ){
				echo "<br><button class=\"comment button1\" onclick=\"comment( $postid)\">Comment</button>";
			}
		}
		
		function echo_vote_buttons( $postid, $perms ){
			if( $perms['can_vote_post'] ){
				echo "<br><button class=\"vote up button1\" onclick=\"vote( $postid, 1)\">up</button><button class=\"vote down button1\" onclick=\"vote( $postid, -1)\">down</button>";
			}
		}

	?>
	<script>	

			function closeQuestion( id ) {
				alert( "close");
				var jQuery = $.post( "../non_interface/close_question.php",
					{
					  post_id:id,
					} 
					);
				 jQuery.success( function(data) {
					 document.body.innerHTML = '';
						document.write(data);
				});
			}
			
			function not_best( q_id_val) {
				var jQuery = $.post( "../non_interface/not_best.php",
					{
					  q_id:q_id_val
					} 
					);
				 jQuery.success( function(data) {
					document.write(data);
					document.write("<div class=\"succes\">Deleted best answer Successfully!</div>" );
				});
			}
			
			function comment( id ) {
				var jQuery = $.post( "../embedded/comment.php",
					{
					  post_id:id
					} 
					);
				 jQuery.success( function(data) {
					document.body.innerHTML = '';
					document.write(data);
				});
			}
			
			function best( q_id_val, p_id_val ) {
				var jQuery = $.post( "../non_interface/best.php",
					{
					  post_id:p_id_val,
					  q_id:q_id_val
					} 
					);
				 jQuery.success( function(data) {
					document.write("<div class=\"succes\">Selected best answer Successfully!</div>" );
				});
			}
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
			
			function answer( id ) {
				var jQuery = $.post( "../embedded/answer.php",
					{
					  q_id:id,
					} 
					);
				 jQuery.success( function(data) {
					 document.body.innerHTML = '';
						document.write(data);
				});
			}
	</script>
	</body>
</html>
