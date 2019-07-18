<?php
namespace Imposter\Game;

use Gt\Database\Query\QueryCollection;
use Gt\Database\Result\Row;
use Imposter\Auth\User;

class GameRepository {
	/** @var QueryCollection */
	private $db;

	public function __construct(QueryCollection $db) {
		$this->db = $db;
	}

	public function create(
		User $user,
		string $scenario,
		string $type,
		int $limiter,
		string $round
	):Game {
		$code = $this->generateCode();

		$gameId = $this->db->insert("create", [
			"code" => $code,
        		"userCreatorId" => $user->getId(),
        		"scenario" => $scenario,
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

	private function gameFromRow(Row $gameRow) {
		return new Game(
			$gameRow->id,
			$gameRow->code,
			$gameRow->scenario,
			$gameRow->type,
			$gameRow->limiter,
			$gameRow->round,
			$gameRow->started
		);
	}
}