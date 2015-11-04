<?php
require_once "util.php";

if( !isset($_SESSION) ) 
{ 
	session_start(); 
} 
		
if(check_login()==1) 
	die('You\'re already logged in!');

if(isset($_POST['username']))
{
	$username=test_input_sql_injection($_POST['username']);
}
else{die('username empty');}

if(isset($_POST['password']))
{
	$password=test_input_sql_injection($_POST['password']);
}
else{die('password empty');}

try{
	$con=connect();

	$getPwdSql = "SELECT password,blocked_until FROM Users WHERE username = '$username' ";
	$result = mysqli_query($con, $getPwdSql ) or die('err');
	if( $row = mysqli_fetch_array($result) ){
		if( $row['password'] != sha1($password )){
			die( 'passwords not match' );
		} 
		$blockeduntil=$row['blocked_until'];
		
		$nowis=date('Y-m-d H:i:s',time());
		if($nowis<$blockeduntil)
			die('You are blocked until '.$blockeduntil);
	}
	else die( 'username not found' );
	
	$getUserSql = "SELECT * FROM Users WHERE username = '$username' ";
	$result = mysqli_query($con, $getUserSql ) or die('err');
	while($row = mysqli_fetch_array($result))
	{
		$_SESSION["username"] =$username;
		$_SESSION["user_type"] =$row['type'];
		$_SESSION["sessionid"] = sha1($password);
	}
	mysqli_close($con);
	header("Location: ../home.php");
}catch(Exception $e){die('exception');}
?>

