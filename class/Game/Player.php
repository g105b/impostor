<?php
namespace Imposter\Game;

use DateTime;
use Imposter\Auth\User;

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