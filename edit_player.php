<?php
require_once dirname(__FILE__) . '/private/conf.php';

# Require logged users
require dirname(__FILE__) . '/private/auth.php';

if (isset($_POST['name']) && isset($_POST['team'])) {
	# Just in from POST => save to database
	$name = $_POST['name'];
	$team = $_POST['team'];
	
	$name = SQLite3::escapeString($name);
	$team = SQLite3::escapeString($team);

	// Modify player or add a new one
	if (isset($_GET['id'])) $query = "INSERT OR REPLACE INTO players (playerid, name, team) VALUES ('".$_GET['id']."','$name', '$team')";

	$db->query($query) or die("Invalid query");
} else {
	# Show info to modify
	if (isset($_GET['id'])) {
		# Edit from database
		$id = $_GET['id'];
	
		$query = SQLite3::escapeString("SELECT name, team FROM players WHERE playerid = $id");

		$result = $db->query($query) or die ("$query");
		$row = $result->fetchArray() or die ("modifying a nonexistent player!");
	
		$name = $row['name'];
		$team = $row['team'];
	}
}

# Show form

?><html><head><title>Player edition</title></head>
<body>
<!--WEBSITE MAP -->

<h3> Website map </h3>
<ul>
<li> <a href="./index.html"> Main page </a></li>
<li> Comments</li>
<li> <strong>Edit player</strong></li>
<li> <a href="./insert_player.php"> Add player</a></li>
</ul>

<h1>Edit a player</h1>
<form action="#" method="post">
<input type="hidden" name="id" value="<?=$id?>"><br>

<h3>Player name</h3>
<textarea name="name"><?=htmlspecialchars($name)?></textarea><br>

<h3>Team name</h3>
<textarea name="team"><?=htmlspecialchars($team)?></textarea><br>
<input type="submit" value="Send"><br>
</form><br>
<br>
</body></html>

