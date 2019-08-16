<?php
namespace Impostor\Page\Game;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;
use Impostor\Game\Game;
use Impostor\Game\GameRepository;
use Impostor\Game\Player;
use Impostor\Game\Turn;

class IndexPage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;
	/** @var User */
	private $user;
	/** @var Player|null */
	private $player;
	/** @var Game|null */
	private $game;

	function go() {
		$this->user = $this->userRepo->load();
		$this->player = $this->userRepo->getPlayer($this->user);
		$this->game = $this->gameRepo->getByUser($this->user);

		$this->checkGameStarted();
		$this->outputIdentity(
			$this->document->querySelector(".c-helper-buttons .identify")
		);
		$this->outputGuesses(
			$this->document->querySelector(".c-game-guesses ul")
		);
		$this->outputPlayers(
			$this->document->querySelector(".c-game-players ul")
		);
		$this->outputTurn(
			$this->document->querySelector(".c-game-turn")
		);
	}

	function checkGameStarted():void {
		if(!$this->game) {
			$this->redirect("/");
		}

		if(!$this->game->isStarted()) {
			$this->redirect($this->game->getLobbyUri());
		}
	}

	function outputGuesses(Element $guessList) {
		$guessList->bindList($this->gameRepo->getGuessList(
			$this->game
		));
	}

	function outputPlayers(Element $playerList) {
		$playerList->bindList($this->gameRepo->getPlayerList(
			$this->game
		));
	}

	function outputIdentity(Element $identityElement) {
		if($this->player->isImpostor()) {
			$this->document->getTemplate(
				"impostor-description"
			)->insertTemplate();

			return;
		}

		$this->document->getTemplate(
			"player-description"
		)->insertTemplate();

		$identityElement->bindKeyValue(
			"role",
			$this->player->getPersonaTitle()
		);

		$guess = $this->gameRepo->getCorrectGuessForGame($this->game);
		$identityElement->bindKeyValue(
			"guess-title",
			$guess->getTitle()
		);
	}

	function outputTurn(Element $turnElement) {
		/** @var Turn[] $turnList */
		$turnList = $this->gameRepo->getTurnList($this->game);

		if($this->game->getLimitType() === Game::TYPE_TIME_LIMIT) {
			$this->document->getTemplate("turnNoLimitCount")
				->insertTemplate();
		}
		elseif($this->game->getLimitType() === Game::TYPE_QUESTION_LIMIT) {
			$this->document->getTemplate("turnLimitCount")
				->insertTemplate();
			$turnElement->bindKeyValue(
				"turnTotal",
				$this->game->getLimiter()
			);
		}

		$turnNumber = 1;
		foreach($turnList as $turn) {
			if($turn->hasResponse()) {
				$turnNumber++;
			}
		}
		$turnElement->bindKeyValue("turnNumber", $turnNumber);

		/** @var Turn $turn */
		$turn = end($turnList);
		$turnEl = null;

		if(empty($turnList)) {
			if($this->game->getCreatorId() === $this->user->getId()) {
				$turnEl = $this->document->getTemplate("turn-first")->insertTemplate();
				$this->document->getTemplate("ask-button")->insertTemplate();
			}
			else {
				$t = $this->document->getTemplate("turn-waiting-ask")->insertTemplate();
				$t->bindKeyValue(
					"playerTurn",
					$this->game->getCreator($this->userRepo)->getName()
				);
			}
		}
		else {
			if($turn->questionTo()->getId() === $this->player->getId()) {
				$turnEl = $this->document->getTemplate("turn-answer")->insertTemplate();
				$this->document->getTemplate("answer-button")->insertTemplate();
			}
			else {
				if($turn->questionFrom()->getId() === $this->player->getId()) {
					$turnEl = $this->document->getTemplate(
						"turn-waiting-your-answer"
					)->insertTemplate();
				}
				else {
					$turnEl = $this->document->getTemplate(
						"turn-waiting-answer"
					)->insertTemplate();
				}
			}
		}

		if($turnEl) {
			$turnEl->bindData($turn);
		}
	}
}