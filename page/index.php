<?php
namespace Impostor\Page;

use Gt\WebEngine\Logic\Page;
use Impostor\Auth\UserRepository;
use Impostor\Game\GameRepository;

class IndexPage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;

	function go() {
		$this->displayCurrentGameInfo();
	}

	function doJoin() {
		$this->redirect("/game");
	}

	function doLeave() {
		$user = $this->userRepo->load();
		$this->gameRepo->leave($user);
		$this->reload();
	}

	function displayCurrentGameInfo() {
		$user = $this->userRepo->load();
		$game = $this->gameRepo->getByUser($user);

		if(!$game) {
			return;
		}

		$t = $this->document->getTemplate("in-game");
		$t->bindKeyValue("code", $game->getCode());
		$t->insertTemplate();
	}
}