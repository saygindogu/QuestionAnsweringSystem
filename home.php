
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
		<title>Segmentation Fault</title>
		<link rel = "stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body id="home">
		<header>
		
			<?php
				require_once( "non_interface/util.php");
				if(!isset($_SESSION)) 
				{ 
					session_start(); 
				} 
				if( check_login() == 1 ){
					echo "<p>Hello:".$_SESSION["username"]."</p><a class=\"link1\" href=\"logout_page.php\">Log out</a>";
					if( check_admin() ){
						echo "<a class=\"link1\" href=\"admin_panel.php\">Admin Page</a>";
						echo "<a class=\"link1\" href=\"reports.php\">Reports</a>";
					}
				}
				else{
					echo "<a class=\"link1\" href=\"signin_page.php\">Sign in</a>
							<a class=\"link1\" href=\"signup_page.php\">Sign up</a>
							<a class=\"link1\" href=\"help_page.php\">HELP!</a>";
				}
			?>
		
		<div class="box">
			<div class="container-1">
			<input type="search" id="search"  placeholder="Search..." />
			<button type="button" class="search" id="search" onclick="myFunction()"> search</button>

				</div>
		</div>	
		</header>
		<div class="wrapper">
		<div class="buttons">
			<?php
			$perms = getPermissions();
			if( $perms['can_ask_question'] ){
				echo "<button class=\"topbutton\" type=\"button\" id=\"ask_q\" onclick=\"changeContext( this.id );\">Ask Question</button>";
				echo "<button type=\"button\" class=\"topbutton\" id=\"followed_tags\" onclick=\"changeContext( this.id );\">Followed Tags</button>";
			}
			?>
			<button type="button" class="topbutton" id="questions" onclick="changeContext( this.id );">Questions</button>
			<button type="button" class="topbutton" id="categories" onclick="changeContext( this.id );">Categories</button>
			<button type="button" class="topbutton" id="tags" onclick="changeContext( this.id );">Tags</button><br>
			<button type="button" class="topbutton" id="users" onclick="changeContext( this.id );">Users</button>
			<button type="button" class="topbutton" id="badges" onclick="changeContext( this.id );">Badges</button>
		<script>
			function changeContext( value ) {
				var jQuery = $.post( "home.php",
					{
					  request:value
					} 
					);
				 jQuery.success( function(data) {
					$("body").html(data);
				});
			}
			
			document.getElementById("search").onsearch = function() {myFunction()};
			 
			function myFunction() {
			var x = document.getElementById("search");

				var jQuery = $.post( "embedded/show_questions.php",
					{
					  text:x.value			
					} 
					);
					jQuery.success( function(data) {
											$("body").html(data);
				});
				
			}			
		</script>
		</div>
		<?php
			if( isset($_POST['request']) ){
				if( $_POST['request'] == 'questions'){
					echo "<div><iframe id=\"iframe\" src=\"embedded/show_questions.php\" style=\"border:none\" /></div>";
				}
				if( $_POST['request'] == 'categories'){
					echo "<div><iframe id=\"iframe\" src=\"embedded/show_categories.php\" style=\"border:none\" /></div>";
				}
				if( $_POST['request'] == 'tags'){
					echo "<div><iframe id=\"iframe\" src=\"embedded/show_tags.php\" style=\"border:none\" /></div>";
				}
				if( $_POST['request'] == 'users'){
					echo "<div><iframe id=\"iframe\" src=\"embedded/show_users.php\" style=\"border:none\" /></div>";
				}
				if( $_POST['request'] == 'badges'){
					echo "<div><iframe id=\"iframe\" src=\"embedded/show_badges.php\" style=\"border:none\" /></div>";
				}
				if( $_POST['request'] == 'ask_q'){
					echo "<div><iframe id=\"iframe\" src=\"embedded/ask_q.php\" style=\"border:none\" /></div>";
				}
				if( $_POST['request'] == 'followed_tags'){
					echo "<div><iframe id=\"iframe\" src=\"embedded/show_tags.php?follow=1\" style=\"border:none\" /></div>";
				}
				
			}else{ 
				echo "<div><iframe src=\"embedded/show_questions.php\" style=\"border:none\" /></div>";
			}
			?>  
	</div>			
	</body>
</html>