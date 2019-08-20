<?php
namespace Impostor\Page\Game;

use Gt\DomTemplate\Element;
use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\UserRepository;
use Impostor\Game\Game;
use Impostor\Game\GameRepository;
use Impostor\Game\Player;

class LastChancePage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;
	/** @var Game */
	private $game;
	/** @var Player */
	private $player;

	function go() {
		$this->loadEntities();
		$this->skipIfAlreadyVoted();
		$this->displayLastChance();
	}

	function doGuess(InputData $data) {
		$this->loadEntities();

		$this->gameRepo->impostorVoteGuess(
			$this->player,
			$data->getInt("id")
		);
		$this->redirect("/game/results");
	}

	function doGuessImpostor(InputData $data) {
		$this->loadEntities();

		$voteePlayer = $this->userRepo->getPlayer(
			$this->userRepo->getPlayerById(
				$data->getInt("playerId")
			)
		);

		$this->gameRepo->voteImpostor(
			$this->player,
			$voteePlayer
		);
		$this->redirect("/game/results");
	}

	function loadEntities() {
		$user = $this->userRepo->load();
		$this->game = $this->gameRepo->getByUser($user);
		$this->player = $this->userRepo->getPlayer($user);
	}

	function displayLastChance() {
		$lastChanceContainerName = $this->player->isImpostor()
			? "impostor"
			: "player";
		$lastChanceContainer = $this->document->querySelector(
			".c-last-chance .$lastChanceContainerName"
		);
		$lastChanceContainer->classList->add("display");

		if($this->player->isImpostor()) {
			$this->displayImpostorLocations($lastChanceContainer);
		}
		else {
			$this->displayPlayerChoices($lastChanceContainer);
		}
	}

	function displayImpostorLocations(Element $container) {
		$guessList = $this->gameRepo->getGuessList($this->game);
		$container->bindKeyValue("term", $guessList[0]->getTerm());
		$container->querySelector(".guessList")->bindList(
			$guessList
		);
	}

	function displayPlayerChoices(Element $container) {
		$container->bindData($this->player);
		$container->querySelector(".playerList")->bindList(
			$this->gameRepo->getPlayerList(
				$this->game,
				$this->player->getId()
			)
		);
	}

	function skipIfAlreadyVoted() {
		if($this->player->isImpostor()) {
			$guess = $this->gameRepo->getImpostorGuess($this->game);
			if($guess) {
				$this->redirect("/game/results");
			}
		}
		else {
			if($this->gameRepo->hasPlayerAccusedSomeone($this->player)) {
				$this->redirect("/game/results");
			}
		}
	}
}