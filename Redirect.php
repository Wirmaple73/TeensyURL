<?php
if (!isset($_GET["url"]))
	exit();

require_once("Classes/DatabaseConnection.php");
$url = "https://{$_SERVER['SERVER_NAME']}/TeensyURL/{$_GET["url"]}";

try {
	$connection = new DatabaseConnection();
	
	$result = $connection->query("SELECT TargetURL FROM url WHERE ShortURL = ?;", "s", $url);
	
	if ($result->num_rows === 0)
		exit("The specified short URL does not exist.");
	
	$connection->query("UPDATE url SET Visits = Visits + 1 WHERE ShortURL = ?;", "s", $url);
	
	header("Location: {$result->fetch_column()}", true, 302);
	exit();
}
catch (DatabaseException $ex) {
	echo("An error has occurred: {$ex->getMessage()}");
}
finally {
	if (isset($connection)) {
		$connection->disconnect();
	}
}
