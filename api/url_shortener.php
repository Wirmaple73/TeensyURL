<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST")
	exit();

require_once("../classes/json_manager.php");
require_once("../classes/random_url_provider.php");
require_once("../classes/database_connection.php");

$jsonManager = new JsonManager();
$url = $jsonManager->getParameter("url");

if (!filter_var($url, FILTER_VALIDATE_URL)) {
	$jsonManager->printJson(["generatedUrl" => null, "errorMessage" => "The specified URL is invalid."]);
	exit();
}

$urlProvider = new RandomUrlProvider();

try {
	$connection = new DatabaseConnection();

	do {
		// Ensure the generated short URL isn't duplicated
		$generatedUrl = $urlProvider->next();
		$date = date("Y-m-d H:i:s");
	} while ($connection->query("SELECT COUNT(ShortURL) FROM url WHERE ShortURL = ?;", "s", $generatedUrl)->fetch_column() > 0);
	
	$connection->query("INSERT INTO url (ShortURL, TargetURL, GenerationDate) VALUES (?, ?, '$date');", "ss", $generatedUrl, $url);
}
catch (DatabaseException $ex) {
	$jsonManager->printJson(["generatedUrl" => null, "errorMessage" => $ex->getMessage()]);
	exit();
}
finally {
	$connection->disconnect();
}

$jsonManager->printJson(["generatedUrl" => $generatedUrl, "errorMessage" => null]);
