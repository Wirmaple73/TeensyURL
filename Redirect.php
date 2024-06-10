<?php
if (!isset($_GET["url"]))
	exit();

require_once("Classes/DatabaseConnection.php");
require_once("Classes/Location.php");

$url = "https://{$_SERVER['SERVER_NAME']}/TeensyURL/{$_GET["url"]}";

try {
	$connection = new DatabaseConnection();
	$result = $connection->query("SELECT TargetURL FROM url WHERE ShortURL = ?;", "s", $url);
	
	if ($result->num_rows === 0)
		Location::navigate("404.html");
	
	$connection->query("UPDATE url SET Visits = Visits + 1 WHERE ShortURL = ?;", "s", $url);
	Location::navigate($result->fetch_column(), 302);
}
catch (DatabaseException $ex) {
	Location::navigate("404.html");
}
finally {
	if (isset($connection)) {
		$connection->disconnect();
	}
}
