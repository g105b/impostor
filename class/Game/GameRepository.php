<?php
namespace Impostor\Game;

use DateTime;
use Gt\Database\Query\QueryCollection;
use Gt\Database\Result\Row;
use Impostor\Auth\User;

class GameRepository {
	/** @var QueryCollection */
	private $db;

	public function __construct(QueryCollection $db) {
		$this->db = $db;
	}

	public function create(
		User $user,
		int $scenarioId,
		string $type,
		int $limiter,
		string $round
	):Game {
		$code = $this->generateCode();

		$gameId = $this->db->insert("create", [
			"code" => $code,
        		"userId" => $user->getId(),
        		"scenarioId" => $scenarioId,
        		"type" => $type,
        		"limiter" => $limiter,
        		"round" => $round,
		]);

		return $this->getById($gameId);
	}

	public function getById(int $id):Game {
		$gameRow = $this->db->fetch("getById", $id);
		return $this->gameFromRow($gameRow);
	}

	private function generateCode():string {
		$letters = [
			["a", "e", "i", "o", "u"],
			["b", /*"c",*/ "d", "f", "g", "h", /*"j",*/ "k", "l", "m", "n", "p", /*"q",*/ "r", "s", "t", /*"v",*/ "w", /*"x",*/ "y", "z"],
		];
		$letterType = mt_rand(0, 1);
		$code = "";

		for($i = 0; $i < Game::CODE_LENGTH; $i++) {
			$currentLetters = $letters[$letterType];
			$charIndex = array_rand($currentLetters);
			$code .= $currentLetters[$charIndex];
			$letterType = (int)!$letterType;
		}

		return $code;
	}

	public function getByCode(string $code):Game {
		$gameRow = $this->db->fetch("getByCode", $code);

		if(!$gameRow) {
			throw new GameCodeNotFoundException($code);
		}

		return $this->gameFromRow($gameRow);
	}

	/**
	 * @return Player[]
	 */
	public function getPlayerList(
		Game $game,
		int $excludePlayerId = null
	):array {
		$playerList = [];
		foreach($this->db->fetchAll("getPlayers", $game->getId())
			as $row) {
			$persona = null;

			if(!is_null($row->personaId)) {
				$persona = new Persona(
					$row->personaId,
					$row->personaTitle,
					$row->personaDescription
				);
			}

			if($excludePlayerId && $row->id == $excludePlayerId) {
				continue;
			}

			$playerList []= new Player(
				$row->id, $row->cookie, new DateTime($row->joined), $row->name, $persona
			);
		}

		return $playerList;
	}

	/**
	 * @return Player[]
	 */
	public function getPlayerListByCode(string $code):array {
		$game = $this->getByCode($code);
		return $this->getPlayerList($game);
	}

	public function join(Game $game, User $user):void {
		$this->leave($user);

		if($game->isStarted()) {
			$isAllowedToJoin = false;

			foreach($this->getPlayerList($game) as $player) {
				if($player->getCookie() === $user->getCookie()) {
					$isAllowedToJoin = true;
					break;
				}
			}

			if(!$isAllowedToJoin) {
				throw new JoiningGameAlreadyStartedException(
					$game->getId()
				);
			}
		}

		$this->db->insert("join", [
			"gameId" => $game->getId(),
			"userId" => $user->getId(),
		]);
	}

	/**
	 * Sets the game to started. Note that only the creator can start the
	 * game. Anyone else bypassing the disabled start button will not
	 * succeed.
	 */
	public function start(Game $game, User $user):void {
		$guesses = $this->pickGuesses($game, 10);
		foreach($guesses as $guess) {
			$this->db->insert(
				"addGuessToGame",
				$guess->getId(),
				$game->getId()
			);
		}

		$correctGuess = $guesses[array_rand($guesses)];
		$this->db->update(
			"setCorrectGuessForGame",
			$correctGuess->getId(),
			$game->getId()
		);

		$playerList = $this->getPlayerListByCode($game->getCode());
		$personaList = $this->getPersonaList($correctGuess);

		$impostor = $playerList[array_rand($playerList)];

		foreach($playerList as $player) {
			if($player === $impostor) {
				continue;
			}

			do {
				$persona = $personaList[array_rand($personaList)];
			}
			while(!$persona->hasAllowance());

			$this->db->insert(
				"setPersonaForPlayer",
				$persona->getId(),
				$player->getId()
			);
			$persona->allocate();
		}

		$this->db->update("start", $game->getId(), $user->getId());
	}

	public function leave(User $user):void {
		$this->db->delete("leave", $user->getId());
	}

	/**
	 * Loads the game that the provided user is currently in, or null if
	 * the user isn't in a game.
	 */
	public function getByUser(User $user):?Game {
		$row = $this->db->fetch("getByPlayerId", $user->getId());
		if(is_null($row)) {
			return null;
		}

		return $this->gameFromRow($row);
	}

	public function getCorrectGuessForGame(Game $game):Guess {
		$row = $this->db->fetch("getCorrectGuessForGame", $game->getId());
		return new Guess(
			$row->id,
			$row->title,
			$row->description
		);
	}

	/** @return Guess[] */
	public function getGuessList(Game $game):array {
		$guessList = [];

		foreach($this->db->fetchAll("getGuessesForGame", $game->getId())
		as $row) {
			$guessList []= new Guess(
				$row->id,
				$row->title,
				$row->description
			);
		}

		return $guessList;
	}

	/** @return Scenario[] */
	public function getScenarioList():array {
		$scenarioList = [];

		foreach($this->db->fetchAll("getAllScenarios") as $row) {
			$scenarioList []= new Scenario(
				$row->id,
				$row->title
			);
		}

		return $scenarioList;
	}

	/** @return Persona[] */
	private function getPersonaList(Guess $guess):array {
		$personaList = [];

		foreach($this->db->fetchAll("getPersonasForGuess", $guess->getId())
		as $row) {
			$personaList [] = new Persona(
				$row->id, $row->title, $row->description, $row->max
			);
		}

		return $personaList;
	}

	/** @return Turn[] */
	public function getTurnList(Game $game):array {
		$turnList = [];

		foreach($this->db->fetchAll("getTurnsForGame", $game->getId())
		as $row) {
			$turnList []= new Turn(
				$row->id,
				$row->turnNum,
				new Player(
					$row->askingPlayerId,
					$row->askingCookie,
					$row->askingJoined,
					$row->askingName
				),
				new Player(
					$row->accusedPlayerId,
					$row->accusedCookie,
					$row->accusedJoined,
					$row->accusedName
				),
				new DateTime($row->asked)
			);
		}

		return $turnList;
	}

	private function gameFromRow(Row $gameRow) {
		$started = null;
		if($gameRow->started) {
			$started = new DateTime($gameRow->started);
		}

		return new Game(
			$gameRow->id,
			$gameRow->code,
			$gameRow->scenarioId,
			$gameRow->type,
			$gameRow->limiter,
			$gameRow->round,
			$gameRow->userCreatorId,
			$started
		);
	}

	/** @return Guess[] */
	private function pickGuesses(Game $game, int $numberOfGuesses):array {
		$guessList = [];

		$resultSet = $this->db->fetchAll(
			"getGuessesForScenario",
			$game->getScenarioId()
		);

		foreach($resultSet as $row) {
			if(count($guessList) >= $numberOfGuesses) {
				break;
			}

			$guessList []= new Guess(
				$row->id,
				$row->title,
				$row->description
			);
		}

		shuffle($guessList);
		return $guessList;
	}
}