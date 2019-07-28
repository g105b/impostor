<?php
namespace Imposter\Page;

use DateTime;
use Gt\WebEngine\Logic\CommonPage;
use Imposter\Auth\CookieId;
use Imposter\Auth\User;
use Imposter\Auth\UserRepository;
use Imposter\Game\GameRepository;

class _CommonPage extends CommonPage {
	function before() {
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