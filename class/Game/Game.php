<?php
namespace Imposter\Game;

use DateTime;
use Imposter\Auth\User;
use Imposter\Auth\UserRepository;

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
	/** @var int */
	private $creatorId;
	/** @var DateTime */
	private $started;

	public function __construct(
		int $id,
		string $code,
		string $scenario,
		string $type,
		int $limiter,
		string $round,
		int $creatorId,
		DateTime $started = null
	) {
		$this->id = $id;
		$this->code = $code;
		$this->scenario = $scenario;
		$this->type = $type;
		$this->limiter = $limiter;
		$this->round = $round;
		$this->creatorId = $creatorId;
		$this->started = $started;
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

	public function getLobbyUri():string {
		return "/lobby?code=" . $this->getCode();
	}
}