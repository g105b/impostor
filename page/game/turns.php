<?php
namespace Impostor\Page\Game;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\UserRepository;
use Impostor\Game\Game;
use Impostor\Game\GameRepository;
use Impostor\Game\Player;

class TurnsPage extends Page {
	/** @var GameRepository */
	public $gameRepo;
	/** @var UserRepository */
	public $userRepo;
	/** @var Game */
	private $game;
	/** @var Player */
	private $player;

	function go() {
		$this->loadEntities();
		$this->outputTurns(
			$this->document->querySelector(".c-turn-list")
		);
	}

	function outputTurns(Element $turnListEl) {
		$turnList = $this->gameRepo->getTurnList($this->game);

		foreach($turnList as $turn) {
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

	function loadEntities() {
		$user = $this->userRepo->load();
		$this->game = $this->gameRepo->getByUser($user);
		$this->player = $this->userRepo->getPlayer($user);
	}
}