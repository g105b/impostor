<?php
namespace Impostor\Game;

use DateTime;
use Impostor\Auth\User;

class Player extends User {
	/** @var DateTime */
	private $joined;

	public function __construct(
		int $id,
		string $cookie,
		?string $name,
		DateTime $joined
	) {
		parent::__construct($id, $cookie, $name);

		$this->joined = $joined;
	}
}