<?php
namespace Impostor\Game;

use DateTime;

class AccusedPlayer extends Player {
	/** @var int */
	private $voteCount;

	public function __construct(
		int $id,
		string $cookie,
		DateTime $joined,
		string $name,
		int $voteCount
	) {
		$this->voteCount = $voteCount;

		parent::__construct(
			$id,
			$cookie,
			$joined,
			$name,
			null
		);
	}

	public function getVoteCount():int {
		return $this->voteCount;
	}
}