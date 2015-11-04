
<?php
require_once("../non-interface/util.php");

	try{
$con= connect() or die("db connection error");

$sql="";
$gonderen=$_COOKIE['uyeadi'];
$result = mysqli_query($con,"SELECT * FROM Post where post_type = 'Q'");
$i=1;
echo "<table>";
while($row = mysqli_fetch_array($result))
  {
 echo"<tr><u>Text:</u>".$row['text']."<br><i>".$row['post_time']."</i><br><u>Title</u>".$row['title']."<hr></tr>";
$i++;
}
echo "</table>";

mysqli_close($con);
	
}catch(Exception $e){}
echo "</table>";

?>
