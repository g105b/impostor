<?php
namespace Impostor\Page;

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

		$this->document->querySelector(".c-game-guesses ul")->bindList([
			["guess" => "one"],
			["guess" => "two"],
			["guess" => "three"],
		]);
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
}