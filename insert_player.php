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

	// add a new one
	$query = "INSERT INTO players (name, team) VALUES ('$name', '$team')";

	$db->query($query) or die("Invalid query");
}

# Show form
?><html><head><title>Player edition</title></head>
<body>
<!--WEBSITE MAP -->
<h3> Website map </h3>
<ul>
<li> <a href="./index.html"> Main page </a></li>
<li> Comments</li>
<li> Edit player</li>
<li> <strong>Add player</strong></li>
</ul>


<h1>Add or edit a player</h1>
<form action="#" method="post">
<input type="hidden" name="id" value="<?=$id?>"><br>

<h3>Player name</h3>
<textarea name="name"></textarea><br>

<h3>Team name</h3>
<textarea name="team"></textarea><br>
<input type="submit" value="Send"><br>
</form><br>
</body></html>

