<?php
namespace Imposter\Page;

use Gt\WebEngine\Logic\Page;
use Imposter\Auth\UserRepository;
use Imposter\Game\GameRepository;

class IndexPage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;

	function go() {
		$this->displayCurrentGameInfo();
	}

	function doJoin() {
		$user = $this->userRepo->load();
		$game = $this->gameRepo->getByUser($user);
		$this->redirect($game->getLobbyUri());
	}

	function doLeave() {
		$user = $this->userRepo->load();
		$game = $this->gameRepo->getByUser($user);
		$this->gameRepo->leave($game, $user);
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