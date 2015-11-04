<?php
class dbAuth {
		const SERVER_NAME = "localhost";
		const DB_USER_NAME = "saygin";
		const DB_PASSWORD = "1234";
		const DB_NAME = "qasdb";
	}
	
function connect(){
	$con = mysqli_connect( dbAuth::SERVER_NAME, dbAuth::DB_USER_NAME, dbAuth::DB_PASSWORD, dbAuth::DB_NAME) or die( "db connection error");
	return $con;
} 

function test_input_sql_injection($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $con = connect();
  mysqli_real_escape_string( $con, $data);
  mysqli_close($con);
  return $data;
}

function check_admin()
{
	if( !isset($_SESSION) ) 
	{ 
		session_start(); 
	}

	if( !isset($_SESSION["sessionid"]) ){
return 0;
	}
	else{
		$username = test_input_sql_injection( $_SESSION["username"]);
		$password = test_input_sql_injection( $_SESSION["sessionid"]);
		try{
			$con= connect();

			$result = mysqli_query($con,"SELECT * FROM users WHERE username = '$username'") or die('query err');
			$pas;

			if( $row = mysqli_fetch_array($result) ){
				$pas=$row['password'];
			}

			mysqli_close( $con );
			
			
			if( $pas ==  $password){
				return $username=='idil';
			}else return 0; 
		}catch( Exception $e){ return 0;}
	}
}

function getPermissions(){
	if( !isset($_SESSION) ) 
	{ 
		session_start(); 
	}
	if( check_login() == 0) return null;
	$username = $_SESSION['username'];
	$permissionNames = array(	"can_ask_question",
								"can_answer_question",
								"can_comment_on_post",
								"can_edit_post",
								"can_vote_post",
								"can_close_post",
								"can_create_categories",
								"can_assign_moderators",
								"can_see_database",
								"can_modify_database");
	$permissions = array( 
		"can_ask_question"=>false,
		"can_answer_question"=>false,
		"can_comment_on_post"=>false,
		"can_edit_post"=>false,
		"can_vote_post"=>false,
		"can_close_post"=>false,
		"can_create_categories"=>false,
		"can_assign_moderators"=>false,
		"can_see_database"=>false,
		"can_modify_database"=>false		
	);
	try{
		$con = connect();
		$sql = "SELECT * FROM users ,type_permissions 
				WHERE username = '$username' and users.type = type_permissions.user_type";
		$result = mysqli_query($con, $sql );
		while($row = mysqli_fetch_array($result))
		{
			foreach ( $permissionNames as $value){
				if( $row['permission_type'] == $value){
					$permissions[$value] = true;
						
					
					break;
				}
			}
		
		}
		
		return $permissions;
	}
	catch(Exception $e){return null;}
	$retval= array( 
		"ask_question"=>$ask_question,
		"can_ask_question"=>$can_ask_question,
		"can_answer_question"=>$can_answer_question,
		"can_comment_on_post"=>$can_comment_on_post,
		"can_edit_post"=>$can_edit_post,
		"can_vote_post"=>$can_vote_post,
		"can_close_post"=>$can_close_post,
		"can_create_categories"=>$can_create_categories,
		"can_assign_moderators"=>$can_assign_moderators,
		"can_see_database"=>$can_see_database,
		"can_modify_database"=>$can_modify_database		
	);
	
	return $retval;
}

function check_login(){
	if( !isset($_SESSION) ) 
	{ 
		session_start(); 
	}

	if( !isset($_SESSION["sessionid"]) ){
return 0;
	}
	else{
		$username = test_input_sql_injection( $_SESSION["username"]);
		$password = test_input_sql_injection( $_SESSION["sessionid"]);
		try{
			$con= connect();

			$result = mysqli_query($con,"SELECT * FROM users WHERE username = '$username'") or die('query err');
			$pas;

			if( $row = mysqli_fetch_array($result) ){
				$pas=$row['password'];
			}

			mysqli_close( $con );
			
			
			if( $pas ==  $password){
				return 1;
			}else return 0; 
		}catch( Exception $e){ return 0;}
	}
}

function logout(){
	// Initialize the session.
	// If you are using session_name("something"), don't forget it now!
	session_start();

	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	// Finally, destroy the session.
	session_destroy();
}
?>