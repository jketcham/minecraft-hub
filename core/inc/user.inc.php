<?php

//checks if the system username exists
function user_exists($user){
	$user = mysql_real_escape_string($user);
	
	$total = mysql_query("SELECT COUNT('user_id') FROM 'users' WHERE 'user_name' = '{$user}'");
	
	return (mysql_result($total, 0) == '1') ? true : false;
}

//checks if the given username and password combination is valid
function valid_credentials($user, $pass){
	$user = mysql_real_escape_string(htmlentities($user));
	$pass = sha1($pass);
	
	$total = mysql_query("SELECT COUNT('user_id') FROM 'users' WHERE 'user_name' = '{$user}' AND 'user_password' = '{$pass}'");
	
	return (mysql_result($total, 0) == '1') ? true : false;
}

//adds user to database 
function add_user($user, $pass){
	$user = mysql_real_escape_string(htmlentities($user));
	$pass = sha1($pass);
	
	mysql_query("INSERT INTO 'users' ('user_name, 'user_password') VALUES ('{$user}', '{$pass}')");
}

?>