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
			
			$sql="SELECT * FROM categories limit $limit offset $offset";
			$result = mysqli_query( $con, $sql);
			$i=1;
			echo "<h1>Categories</h1><br><p>Showing $limit categories per page.</p><br><table class=\"categories\">";
			while($row = mysqli_fetch_array($result)){
				echo"<tr><th rowspan=\"3\">".($i+$offset)."</th><td><button class=\"title\" type=\"button\" onclick=\"goToQuestionsOf( ".$row['ca_id']." );\">".$row['text']."</button></td></tr><tr><td><i>".$row['creation_time']."</i></td></tr><tr><td>".$row['text']."</td></tr>";
				$i++;
			}
			echo "</table>";
			if( $offset > 0){
				echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( $offset-$limit )\">Previous</button>";
			}
			echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( $offset+$limit )\">Next</button>";
			$perms = getPermissions();
			if( $perms['can_create_categories'] ){
				echo "<button class=\"button1\" type=\"button\" onclick=\"document.location='category_adder.php' \">Add Category</button>";

			}
			mysqli_close($con);
			}catch(Exception $e){ die( 'exception');}
		?>
		<script>
			function goToQuestionsOf( ca_id_val ){
				var jQuery = $.post( "show_questions.php",
					{
						ca_id:ca_id_val
					} 
					);
				 jQuery.success( function(data) {
					$("body").html(data);
				});
			}
			function loadAgain( offsetval ) {
				var jQuery = $.post( "show_categories.php",
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
