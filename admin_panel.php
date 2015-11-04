<html><head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<title>Segmentation Fault</title>
		<link rel = "stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
</head>
<body>

<?php
require_once("non_interface/util.php");
if(!check_admin() ) 
	die('You can access only as admin!');

try{
$con=connect() or die("db connection error");

$result = mysqli_query($con,"SELECT * FROM users") 
or die('query err1');

while($row = mysqli_fetch_array($result))
{
	$username=$row['username'];
	echo"
	
<form method=\"post\" action=\"non_interface/block_user.php\"><table><tr><td><u>Username:</u><input type=\"text\" name=\"username\" value=\"$username\"/></td><td><u>Mail:</u>".$row['email']."</td><td><u>Block Days:</u></td><td><input name=\"days\" type=\"text\"/></td><td><input value=\"Block\" type=\"submit\"/></td>
</table></form>";
}

mysqli_close($con);
	}catch(Exception $e){die('err');}
?>

</body>
</html>
