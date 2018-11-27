<html>
<head>
<title>ACME Scouting tool v2</title>
</head>
 
<body>
<!-- WEBSITE MAP -->
<h3> Website map </h3>
<ul>
<li> <strong> Main page </strong></li>
<li> Comments</li>
<li> Edit player</li>
<li> <a href="./insert_player.php"> Add player</a></li>
</ul>

<h2><a href="insert_player.php"> Add a new player</a></h2>
<h2>List of players</h2>

<ul>
<?php
require_once dirname(__FILE__) . '/private/conf.php';

$query = "SELECT playerid, name, team FROM players order by playerId desc";

$result = $db->query($query) or die("Invalid query");

while ($row = $result->fetchArray()) {
	echo "<br><li>Name: " . $row['name']
	. "</b><br>Team: " . $row['team']
	. " <br><a href=\"show_comments.php?id=".$row['playerid']."\">(show comments)</a></li> <a href=\"edit_player.php?id=".$row['playerid']."\">(edit player)</a><br>\n";	
}

?>
</ul>

<?php
if (isset($_COOKIE['user']))
{
	echo "<br>Currently logged as " .$_COOKIE['user'] . ", you can exit using the next button:". "<form action=\"logout.php\" method=\"post\">"
	."<input type=\"submit\" name=\"Logout\" value=\"Logout\">"
	."</form>"
	."<br>";
}
?>
&lt; Buy other <a href="./ACME/index.html?list=products&amp;referrer=ACMEScouting/"> ACME's product</a> &gt;

</body>
</html>
