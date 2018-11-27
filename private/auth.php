<?php
require_once dirname(__FILE__) . '/conf.php';

$userId = FALSE;

# Check whether a pair of user and password are valid; returns true if valid.
function areUserAndPasswordValid($user, $password) {
	global $db, $userId;
	
	$query = "SELECT userId FROM users WHERE username = '" . SQLite3::escapeString($user) . "' AND password = '". SQLite3::escapeString($password) ."';";

	$result = $db->query($query) or die ("Invalid query: " . $query . ". Field user introduced is: " . $user);
	$row = $result->fetchArray();	

	if ($row == FALSE) 
		return FALSE;
	else
	{
		$userId = $row['userId'];
		$_COOKIE['userID'] = $userId;
		return TRUE;
	}
}

# On login
if (isset($_POST['username']) && isset($_POST['password'])) {		
	$_COOKIE['user'] = $_POST['username'];
	$_COOKIE['password'] = $_POST['password'];
}

# On logout
if (isset($_POST['Logout'])) {
	# Delete cookies
	setcookie('user', FALSE);
	setcookie('password', FALSE);
	setcookie('userId', FALSE);
	
	unset($_COOKIE['user']);
	unset($_COOKIE['password']);
	unset($_COOKIE['userId']);

	header("Location: index.html");
}

# Check user and password
if (isset($_COOKIE['user']) && isset($_COOKIE['password'])) {
	if (areUserAndPasswordValid($_COOKIE['user'], $_COOKIE['password'])) {
		$login_ok = TRUE;
		$error = "";
	} else {
		$login_ok = FALSE;
		$error = "Invalid user or password.<br>";
	}
} else {
	$login_ok = FALSE;
	$error = "This page requires you to be logged in.<br>";
}

if ($login_ok == FALSE) {

?><html><head><title>Authentication page</title></head>
<body>
<h1>Authentication page</h1>
<?= $error ?>
<h2>Login</h2>
<form action="#" method="post">
User: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<input type="submit" value="Login">
</form>
</body></html><?php 

exit (0);

}

setcookie('user', $_COOKIE['user']);
setcookie('password', $_COOKIE['password']);


?>
