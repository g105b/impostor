<?php
namespace Impostor\Page\Game;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;
use Impostor\Game\Game;
use Impostor\Game\GameRepository;
use Impostor\Game\WaitingForVotesException;

class ResultsPage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;

	/** @var User */
	private $user;
	/** @var Game */
	private $game;

	function go() {
		$this->loadEntities();

		$resultsScreen = $this->document->querySelector(
			".c-results-screen"
		);

		$turnList = $this->gameRepo->getTurnList($this->game);

		if(count($turnList) === $this->game->getLimiter()) {
			// Turns are up - voting has begun.
			try {
				$this->waitForVotes($resultsScreen);
			}
			catch(WaitingForVotesException $exception) {
				return;
			}

			$this->outputVotes($resultsScreen);
			$this->completeGame();
		}
		else {
			// Game has been ended early by a vote.
			// TODO.
		}
	}

	function loadEntities() {
		$this->user = $this->userRepo->load();
		$this->game = $this->gameRepo->getByUser($this->user);

		if(is_null($this->user)
		|| is_null($this->game)) {
			$this->redirect("/");
		}
	}

	function waitForVotes(Element $resultsScreen) {
		$waitingPlayers = $this->gameRepo->waitingForVotes($this->game);

		$waitingListElement = $resultsScreen->querySelector(
			".waiting"
		);

		if(empty($waitingPlayers)) {
			return;
		}

		$waitingListElement->bindList(
			$waitingPlayers
		);
		$waitingListElement->classList->add("display");
		throw new WaitingForVotesException();
	}

	function outputVotes(Element $resultsScreen) {
		$section = $resultsScreen->querySelector(".end-game-votes");
		$section->classList->add("display");
		$accusedImpostors = $this->gameRepo->getAccusedImpostors(
			$this->game
		);
		$section->querySelector(".accusedList")->bindList(
			$accusedImpostors
		);

		$impostor = null;
		foreach($this->gameRepo->getPlayerList($this->game) as $player) {
			if($player->isImpostor()) {
				$impostor = $player;
				break;
			}
		}

		$section->bindKeyValue(
			"impostorName",
			$impostor->getName()
		);

		$correctGuess = $this->gameRepo->getCorrectGuessForGame($this->game);
		$impostorGuess = $this->gameRepo->getImpostorGuess($this->game);

		$section->bindKeyValue(
			"guess",
			$impostorGuess->getTitle()
		);
		$section->bindKeyValue(
			"term",
			$correctGuess->getTerm()
		);
		$section->bindKeyValue(
			"correctGuess",
			$correctGuess->getTitle()
		);

		$winner = null;

		if($impostorGuess->getId() === $correctGuess->getId()) {
			$winner = $impostor;
		}
//		if(count($accusedImpostors))

		$winnerName = "Nobody";
		if($winner) {
			$winnerName = $winner->getName();
		}
		$section->bindKeyValue("winner", $winnerName);
	}

	function completeGame() {
		$this->gameRepo->completeGame($this->game);
	}
}