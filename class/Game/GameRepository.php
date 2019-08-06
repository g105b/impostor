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
	public function getPlayerList(string $code):array {
		$playerList = [];

		$game = $this->getByCode($code);
		foreach($this->db->fetchAll("getPlayers", $game->getId())
		as $row) {
			$playerList []= new Player(
				$row->userId,
				$row->cookie,
				$row->name,
				new DateTime($row->joined)
			);
		}

		return $playerList;
	}

	public function join(Game $game, User $user):void {
		$this->leave($user);
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
		$guesses = $this->getGuesses($game, 10);
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

		$playerList = $this->getPlayerList($game->getCode());
		$personaList = $this->getPersonaList($correctGuess);

		$impostor = $playerList[array_rand($playerList)];
		$this->db->update(
			"setImpostorForGame",
			$impostor->getId(),
			$game->getId()
		);

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
				$row->id,
				$row->max,
				$row->title,
				$row->description
			);
		}

		return $personaList;
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
	private function getGuesses(Game $game, int $numberOfGuesses):array {
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