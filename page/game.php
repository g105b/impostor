<?php
namespace Impostor\Page;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\UserRepository;
use Impostor\Game\GameRepository;

class GamePage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;

	function go() {
		$this->checkGameStarted();
		$this->outputGuesses(
			$this->document->querySelector(".c-game-guesses ul")
		);
	}

	function checkGameStarted():void {
		$user = $this->userRepo->load();
		$game = $this->gameRepo->getByUser($user);

		if(!$game) {
			$this->redirect("/");
		}

		if(!$game->isStarted()) {
			$this->redirect($game->getLobbyUri());
		}
	}

	function outputGuesses(Element $guessList) {
		$game = $this->gameRepo->getByUser($this->userRepo->load());
		$this->gameRepo->getGuessList($game);
	}
}