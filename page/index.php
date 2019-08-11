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
		$this->forwardToGameIfJoined();
	}

	function doLeave() {
		$user = $this->userRepo->load();
		$this->gameRepo->leave($user);
		$this->reload();
	}

	function forwardToGameIfJoined() {
		$user = $this->userRepo->load();
		$game = $this->gameRepo->getByUser($user);

		if(!$game) {
			return;
		}

		$this->redirect("/game");
	}
}