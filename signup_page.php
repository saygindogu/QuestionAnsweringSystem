<!DOCTYPE HTML>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<title>Stack Overflow Sign Up</title>
		<link rel = "stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body class="page">
	<div class="wrapper">
	<h2>Sign Up</h2><br><form action="non_interface/signup.php" method="post">
	<table>
		<tr>
			<td>Username:</td><td><input type="text" id="username" name="username"/></td>
		</tr>
		<tr>
			<td>Password:</td><td><input type="password" id="password" name="password"/></td>
		</tr>
		<tr>
			<td>E-Mail:</td><td><input type="text" id="mail" name="mail"/></td>
		</tr>
		<tr>
			<td><input type="submit" value="SignUp"/></td><td><a href="home.php"> Back to home </a></td>
		</tr>
	</form>
</div>
</body>
</html>