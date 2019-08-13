<?php
namespace Impostor\Game;

use DateTime;

class Turn {
	/** @var int */
	private $id;
	/** @var int */
	private $num;
	/** @var Player */
	private $from;
	/** @var Player|null */
	private $to;
	/** @var DateTime|null */
	private $asked;

	public function __construct(
		int $id,
		int $num,
		Player $from,
		Player $to = null,
		DateTime $asked = null
	) {
		$this->id = $id;
		$this->num = $num;
		$this->from = $from;
		$this->to = $to;
		$this->asked = $asked;
	}

	public function getFrom():Player {
		return $this->from;
	}

	public function getTo():?Player {
		return $this->to;
	}
}