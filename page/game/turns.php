<?php
namespace Impostor\Page\Game;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\UserRepository;
use Impostor\Game\Game;
use Impostor\Game\GameRepository;
use Impostor\Game\Player;
use Impostor\Game\Turn;

class TurnsPage extends Page {
	/** @var GameRepository */
	public $gameRepo;
	/** @var UserRepository */
	public $userRepo;
	/** @var Game */
	private $game;
	/** @var Player */
	private $player;

	/** @var Turn[] */
	private $turnList;
	/** @var Turn */
	private $lastTurn;

	function go() {
		$this->loadEntities();
		$this->loadTurns();
		$this->outputTurns(
			$this->document->querySelector(".c-turn-list")
		);

		$this->input->when(["action" => "asked"])
			->call([$this, "asked"]);
		$this->input->when(["action" => "answered"])
			->call([$this, "answered"]);
	}

	function loadEntities() {
		$user = $this->userRepo->load();
		$this->game = $this->gameRepo->getByUser($user);
		$this->player = $this->userRepo->getPlayer($user);
	}

	function loadTurns() {
		$this->turnList = $this->gameRepo->getTurnList($this->game);
		$this->lastTurn = end($turnList);
	}

	function asked() {
		if(count($this->turnList) < $this->game->getLimiter()) {
			$this->document->getTemplate(
				"asked-message"
			)->insertTemplate();
		}
	}

	function answered() {
		if(count($this->turnList) >= $this->game->getLimiter()) {
			$message = $this->document->getTemplate(
				"last-answer-message"
			)->insertTemplate();
		}
		else {
			$message = $this->document->getTemplate(
				"answered-message"
			)->insertTemplate();
		}

		$message->bindKeyValue(
			"questionPlayer",
			$this->lastTurn->questionFrom()->getName()
		);
	}

	function outputTurns(Element $turnListEl) {
		foreach($this->turnList as $turn) {
			$questionTemplate = $this->document->getTemplate("question");
			$questionTemplate->bindData($turn);
			$questionElement = $turnListEl->appendChild($questionTemplate);

			if($turn->hasResponse()) {
				$answerTemplate = $this->document->getTemplate("answer");
				$answerTemplate->bindData($turn);
				$questionElement->appendChild($answerTemplate);
			}
		}
	}
}