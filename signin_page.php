<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<title>Segmentation Fault</title>
		<link rel = "stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body class="page">
	<div class="wrapper">
	<?php
		require_once( "non_interface/util.php");
		if(check_login() == 0){
			echo"<div>
				<form action=\"non_interface/signin.php\" method=\"post\">
					<h3>Login</h3>
					<table>
						<tbody>
							<tr>
								<td> Username: </td> <td> <input type=\"text\" id=\"username\" name=\"username\"/> </td>
							</tr>
							<tr>
								<td> Password: </td> <td> <input type=\"password\" id=\"password\" name=\"password\"/> </td>
							</tr>
							<tr>
								<td><input type=\"submit\" value=\"Signin\"/></td><td><a href=\"home.php\"> Back to home </a></td>
							</tr>
						</tbody>
					</table>
				</form></div>";
		}
		else {
			echo"<div><input type=\"button\" style=\"width: 100px;\" value=\"logout\" onClick=\"navigate('logout.php')\"/></div>";
		}
	?>
	</div>
	</body>
</html>