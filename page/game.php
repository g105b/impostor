<?php
namespace Impostor\Page;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;
use Impostor\Game\Game;
use Impostor\Game\GameRepository;
use Impostor\Game\Player;

class GamePage extends Page {
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
}