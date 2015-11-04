<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<title>Segmentation Fault</title>
		<link rel = "stylesheet" type="text/css" href="../style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body>
	<?php
	require_once( "../non_interface/util.php");
	if(check_login()==1){
		if(isset($_POST['text']))
		{
			$text=$_POST['text'];
			
			try{
	$con= connect();
	$sql="INSERT INTO categories(creation_time,text) VALUES(NOW(),'$text')";
	mysqli_query($con,$sql) or die('err');
	echo'<div class="succes">New Category '.$text.' is added!</div>';
	mysqli_close($con);
		}catch(Exception $e){die('err');}
			
		}
		else{
		echo"
			<table>
			</td></tr><form action=\"category_adder.php\" method=\"post\"><tr><td>
			<u>Add Category:</u></br>
			Category Name:
			</td></tr>
			<tr><td>
			<input type=\"text\" id=\"text\" name=\"text\"/>
			</td></tr>
			<tr><td>
			<input type=\"submit\" value=\"Add\"/>
			</td></tr></form>";}
		}
	?>
	<!--div><a href="../home.php">Back to home</a></div-->
	</body>
</html>