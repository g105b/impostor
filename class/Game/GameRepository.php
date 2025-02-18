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
		$row = $this->db->fetch("getGameByPlayerId", $user->getId());
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
			$row->description,
			$row->guessTerm
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
				$row->description,
				$row->guessTerm
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

	public function createTurn(
		Game $game,
		Player $player,
		int $accusedId,
		string $hash
	):int {
		return $this->db->insert("createTurn", [
			"gameId" => $game->getId(),
			"playerId" => $player->getId(),
			"accusedPlayerId" => $accusedId,
			"hash" => $hash,
		]);
	}

	public function createTurnResponse(
		Game $game,
		string $hash
	) {
		$turnList = $this->getTurnList($game);
		$lastTurn = end($turnList);

		return $this->db->insert("createTurnResponse", [
			"turnId" => $lastTurn->getId(),
			"hash" => $hash,
		]);
	}

	public function voteImpostor(
		Player $player,
		Player $voteePlayer
	) {
		$this->db->insert("voteForImpostor", [
			"playerId" => $player->getId(),
			"votePlayerId" => $voteePlayer->getId(),
		]);
	}

	public function impostorVoteGuess(
		Player $impostorPlayer,
		int $guessId
	) {
		$this->db->insert("voteForGuess", [
			"playerId" => $impostorPlayer->getId(),
			"guessId" => $guessId,
		]);
	}

	/** @return Player[] */
	public function getAccusedImpostors(Game $game):array {
		$playerList = [];

		foreach($this->db->fetchAll(
			"getVoteImpostors",
			$game->getId()
		) as $row) {
			$playerList []= new AccusedPlayer(
				$row->playerId,
				$row->cookie,
				new DateTime($row->joined),
				$row->name,
				$row->voteCount
			);
		}

		return $playerList;
	}

	public function hasPlayerAccusedSomeone(Player $player):bool {
		$row = $this->db->fetch(
			"getAccusationByPlayerId",
			$player->getId()
		);

		return !is_null($row);
	}

	public function getImpostorGuess(Game $game):?Guess {
		$row = $this->db->fetch("getVoteGuess", $game->getId());

		if(is_null($row)) {
			return null;
		}

		return new Guess(
			$row->guessId,
			$row->title,
			$row->description,
			$row->term
		);
	}

	/** @return Player[] */
	public function waitingForVotes(Game $game):array {
		$impostorVotes = $this->db->fetchAll(
			"getImpostorVotesForGame",
			$game->getId()
		);
		$guessVote = $this->db->fetch(
			"getGuessVoteForGame",
			$game->getId()
		);

		$waitingForPlayers = $this->getPlayerList($game);
		foreach($waitingForPlayers as $i => $player) {
			if($guessVote
			&& $guessVote->playerId == $player->getId()) {
				unset($waitingForPlayers[$i]);
			}

			foreach($impostorVotes as $row) {
				if($row->playerId == $player->getId()) {
					unset($waitingForPlayers[$i]);
				}
			}
		}

		return $waitingForPlayers;
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
					new DateTime($row->askingJoined),
					$row->askingName
				),
				new Player(
					$row->accusedPlayerId,
					$row->accusedCookie,
					new DateTime($row->accusedJoined),
					$row->accusedName
				),
				new DateTime($row->asked),
				$row->hash,
				$row->responded
					? new DateTime($row->responded)
					: null,
				$row->responseHash
			);
		}

		return $turnList;
	}

	public function completeGame(Game $game):void {
		$this->db->update("completeGame", $game->getId());
	}

	public function delete(Game $game):void {
		$this->db->delete("delete", $game->getId());
	}

	private function gameFromRow(Row $gameRow) {
		$started = null;
		if($gameRow->started) {
			$started = new DateTime($gameRow->started);
		}
		$completed = null;
		if($gameRow->completed) {
			$completed = new DateTime($gameRow->completed);
		}

		return new Game(
			$gameRow->id,
			$gameRow->code,
			$gameRow->scenarioId,
			$gameRow->type,
			$gameRow->limiter,
			$gameRow->round,
			$gameRow->userCreatorId,
			$started,
			$completed
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
				$row->description,
				$row->guessTerm
			);
		}

		shuffle($guessList);
		return $guessList;
	}
}