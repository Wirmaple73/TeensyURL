<?php
class RandomUrlProvider {
	private const URL_LENGTH = 6;
	private static ?array $characters = null;
	
	public function __construct() {
		if (self::$characters == null)
			self::$characters = [...range("A", "Z"), ...range("a", "z"), ...range(0, 9)];
	}
	
	public function next(): string {
		$url = "";
		
		for ($i = 0; $i < self::URL_LENGTH; ++$i) {
			$url .= self::$characters[random_int(0, count(self::$characters) - 1)];
		}
		
		return "https://{$_SERVER["SERVER_NAME"]}/TeensyURL/$url";
	}
}
