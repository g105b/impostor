<?php
namespace Imposter\Game;

use DateTime;

class Game {
	const CODE_LENGTH = 7;
	/** @var int */
	private $id;
	/** @var string */
	private $code;
	/** @var string */
	private $scenario;
	/** @var string */
	private $type;
	/** @var int */
	private $limiter;
	/** @var string */
	private $round;
	/** @var DateTime */
	private $started;

	public function __construct(
		int $id,
		string $code,
		string $scenario,
		string $type,
		int $limiter,
		string $round,
		DateTime $started = null
	) {
		$this->id = $id;
		$this->code = $code;
		$this->scenario = $scenario;
		$this->type = $type;
		$this->limiter = $limiter;
		$this->round = $round;
		$this->started = $started;
	}

	public function getCode() {
		return $this->code;
	}

	public function isStarted():bool {
		return (bool)$this->started;
	}
}