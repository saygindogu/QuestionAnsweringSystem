
<?php
header('Location: ../admin_panel.php');
require_once("util.php");
if(!check_admin()) 
	die('You can access only as admin!');

try{
$con=connect() or die("db connection error");

$username=$_POST['username'];
$days=intval($_POST['days']) ;
$until=time()+$days*24*60*60;
$until=date('Y-m-d H:i:s',$until);
$result = mysqli_query($con,"UPDATE users SET blocked_until =  '$until' where username='$username'");
// where username='$username'") or die('query err1');
mysqli_close($con);
	}catch(Exception $e){die('err');}
?>
