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
			
			$sql="SELECT * FROM badges limit $limit offset $offset";
			$result = mysqli_query( $con, $sql);
			$i=1;
			echo "<h1>Badges</h1><br><p>Showing $limit badges per page.</p><br><table class=\"badges\">";
			while($row = mysqli_fetch_array($result)){
				echo"<tr><th>".($i+$offset)."</th><td>".$row['b_name']."</td>";
				$i++;
			}
			echo "</table>";
			if( $offset > 0){
				echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( ".($offset-$limit)." )\">Previous</button>";
			}
			echo "<button class=\"button1\" type=\"button\" onclick=\"loadAgain( ".($offset+$limit)." )\">Next</button>";
			
	
			mysqli_close($con);
			}catch(Exception $e){ die( 'exception');}


	?>
	<script>
			function loadAgain( offsetval ) {
				var jQuery = $.post( "show_badges.php",
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