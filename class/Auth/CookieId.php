<?php
namespace Impostor\Auth;

class CookieId {
	/** @var string */
	private $value;

	public function __construct() {
		$this->value = bin2hex(random_bytes(16));
	}

	public function __toString():string {
		return $this->value;
	}
}