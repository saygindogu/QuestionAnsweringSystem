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
	if( !isset($_SESSION) ) 
	{ 
		session_start(); 
	}
	if(check_login()==1){
		if(isset($_POST['text']))
		{
			$text=$_POST['text'];
			$title=$_POST['title'];
			$category=$_POST['category'];
			
			try{
	$con= connect();
	$sql="INSERT INTO posts(title,post_time,text,ca_id,post_type, post_username) VALUES('$title',NOW(),'$text',$category,'Q','".$_SESSION['username']."')";
	mysqli_query($con,$sql) or die('err');
	echo'<div class="succes">New question '.$text.' is added!</div>';
	mysqli_close($con);
}catch(Exception $e){die('err');}
			
		}
		else{
		$output="
			<table>
			</td></tr><form action=\"ask_q.php\" method=\"post\"><tr><td>
			<u>Ask question:</u></br>
			Title:
			</td></tr>
			<tr><td>
			<input type=\"text\" id=\"title\" name=\"title\"/>
			</td></tr>
			<tr><td>
			Question:<br>
			<textarea rows=\"20\" cols=\"30\" id=\"text\" name=\"text\"></textarea>
			</td></tr><tr><td><select name='category'>
			";
			$con= connect();
	$sql="select * from categories";
	$answersResult=mysqli_query($con,$sql) or die('err');
	
	while( $answerRow = mysqli_fetch_array($answersResult) ){
	$category=$answerRow['text'];
	$caid=$answerRow['ca_id'];
	$output=$output."<option value = '$caid'>$category</option>";
	}
	mysqli_close($con);
		$output=$output."
			</select><tr><td><input type=\"submit\" value=\"Add\"/>
			</td></tr></form>";
			echo $output;
			}
		}
	else {
		echo"<input type=\"button\" style=\"width: 100px;\" value=\"logout\" onClick=\"navigate('logout.php')\"/>";
	}
	?>
	</body>
</html>