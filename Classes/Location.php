<?php
final class Location {
	public static function navigate(string $url, ?int $statusCode = null): void {
		if ($statusCode != null)
			header("Location: $url", true, $statusCode);
		else
			header("Location: $url");
		
		exit();
	}
}
