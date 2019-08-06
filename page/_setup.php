<?php
namespace Impostor\Page;

use DateTime;
use Gt\WebEngine\Logic\PageSetup;
use Impostor\Auth\CookieId;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;
use Impostor\Game\GameRepository;

class _SetupPage extends PageSetup {
	function go() {
		$this->user();
		$this->game();
	}

	function user():void {
		$cookie = $this->cookie->get(User::COOKIE_NAME)
			?? new CookieId();
		
		$this->cookie->set(
			User::COOKIE_NAME,
			$cookie,
			new DateTime("+1 year")
		);

		$this->logicProperty->set("userRepo", new UserRepository(
			$cookie,
			$this->database->queryCollection("auth"),
			$this->session->getStore(
				User::SESSION_NAMESPACE,
				true
			)
		));
	}

	function game():void {
		$this->logicProperty->set("gameRepo", new GameRepository(
			$this->database->queryCollection("game")
		));
	}
}