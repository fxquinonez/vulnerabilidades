<?php
require_once dirname(__FILE__) . '/private/conf.php';

# Require logged users
require dirname(__FILE__) . '/private/auth.php';

# Post comments
if (isset($_POST['body']) && isset($_GET['id'])) {
	# Just in from POST => save to database
	$body = $_POST['body'];
	$body = SQLite3::escapeString($body);

	$id = $_GET['id'];
	$id = SQLite3::escapeString($id);

	$userid = $_POST['userId'];
	$userid = SQLite3::escapeString($userid);


	$query = "INSERT INTO comments (playerId, userId, body) VALUES ('".$id."', '".$userid."', '$body')";
	$db->query($query) or die("Invalid query");
}

?><html><head><title>Comments</title></head>

<body>
<!-- WEBSITE MAP -->
<h3> Website map </h3>
<ul>
<li> <a href="./index.html"> Main page </a></li>
<li> <strong>Comments</strong></li>
<li> Edit player</li>
<li> <a href="./insert_player.php"> Add player</a></li>
</ul>

<h2>The player</h2>
<?php
	# Show the player Info
	$query = "SELECT name, team FROM players P WHERE P.playerid = " . $_GET['id'] ." ;";
	$result = $db->query($query) or die("Invalid query");

	while ($row = $result->fetchArray()) {
		echo "<li>Player name: " . $row['name']
		. "</li><li>Team name: " . $row['team']
		. "</li><br>\n";	
	}
?>
<h2>Comments</h2>
<?php
	# List comments
	if (isset($_GET['id']))
	{
		$query = "SELECT commentId, username, body FROM comments C, users U WHERE C.playerId =".$_GET['id']." AND U.userId = C.userId order by C.playerId desc";
		$result = $db->query($query) or die("Invalid query: " . $query );

		while ($row = $result->fetchArray()) {
			echo "Comment ". $row['commentId'] ." by ".  $row['username'] .": " . htmlspecialchars($row['body']) . "<br>";
		}
		$playerId = $_GET['id'];
	}
?>

<?php
	# Obtain the userID to use it when adding comments
	$query = "SELECT userId FROM users WHERE username = '" . $_COOKIE['user'] . "' AND password = '". $_COOKIE['password'] ."';";
	$result = $db->query($query) or die("Invalid query: " . $query );
	$row = $result->fetchArray();
	$userId = $row['userId'];
?>

<h2>Add a new comment</h2>
<form action="#" method="post">
<textarea name="body"></textarea><br>
<input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>">
<input type="submit" value="Send"><br>
</form><br>
</body>
</html>

