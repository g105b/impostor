<?php
namespace Impostor\Game;

use DateTime;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;

class Game {
	const CODE_LENGTH = 7;
	const TYPE_TIME_LIMIT = "time";
	const TYPE_QUESTION_LIMIT = "question";

	/** @var int */
	private $id;
	/** @var string */
	private $code;
	/** @var int */
	private $scenarioId;
	/** @var string */
	private $type;
	/** @var int */
	private $limiter;
	/** @var string */
	private $round;
	/** @var int */
	private $creatorId;
	/** @var DateTime */
	private $started;
	/** @var DateTime */
	private $completed;

	public function __construct(
		int $id,
		string $code,
		int $scenarioId,
		string $type,
		int $limiter,
		string $round,
		int $creatorId,
		DateTime $started = null,
		DateTime $completed = null
	) {
		$this->id = $id;
		$this->code = $code;
		$this->scenarioId = $scenarioId;
		$this->type = $type;
		$this->limiter = $limiter;
		$this->round = $round;
		$this->creatorId = $creatorId;
		$this->started = $started;
		$this->completed = $completed;
	}

	public function getId():int {
		return $this->id;
	}

	public function getCode():string {
		return $this->code;
	}

	public function getCreator(UserRepository $userRepo):User {
		return $userRepo->getById($this->creatorId);
	}

	public function getCreatorId():int {
		return $this->creatorId;
	}

	public function isStarted():bool {
		return (bool)$this->started;
	}

	public function isComplete():bool {
		return (bool)$this->completed;
	}

	public function getLobbyUri():string {
		return "/lobby?code=" . $this->getCode();
	}

	public function getScenarioId():int {
		return $this->scenarioId;
	}

	public function getLimiter():int {
		return $this->limiter;
	}

	public function getLimitType():string {
		$type = strtolower($this->type);

		if(strstr($type, self::TYPE_QUESTION_LIMIT)) {
			return self::TYPE_QUESTION_LIMIT;
		}

		if(strstr($type, self::TYPE_TIME_LIMIT)) {
			return self::TYPE_TIME_LIMIT;
		}
	}
}