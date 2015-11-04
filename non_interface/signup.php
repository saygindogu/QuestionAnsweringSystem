
<?php


include"util.php";
if(check_login()==1) 
	die('You\'re already logged in!');

if(isset($_POST['username']))
{
	$username=test_input_sql_injection($_POST['username']);
}
else{die('username empty');}

if(isset($_POST['password']))
{
	$password=sha1(test_input_sql_injection($_POST['password']));
}
else{die('password empty');}

if(isset($_POST['mail']))
{
	$email=test_input_sql_injection($_POST['mail']);
}
else{die('email empty');}

try{
$con=connect();

$result = mysqli_query($con,"SELECT * FROM users WHERE username = '$username' ") or die('err');

while($row = mysqli_fetch_array($result))
  {
	  die('Username already exists!');
}

$result = mysqli_query($con,"INSERT INTO users (username,password,email,joined_date,type,reputation,blocked_until ) VALUES ('$username','$password','$email',NOW(),'regular',0,NULL) ") or die('err');

echo('OK!');
header('Location: ../home.php');

mysqli_close($con);
	}catch(Exception $e){die('err');}


?>

