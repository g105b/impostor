<?php
namespace Imposter\Page;

use DateTime;
use Gt\WebEngine\Logic\CommonPage;
use Imposter\Auth\CookieId;
use Imposter\Auth\User;
use Imposter\Auth\UserRepo;

class _CommonPage extends CommonPage {
	public function before() {
		$this->user();
	}

	private function user():void {
		$cookie = $this->cookie->get(User::COOKIE_NAME)
			?? new CookieId();
		
		$this->cookie->set(
			User::COOKIE_NAME,
			$cookie,
			new DateTime("+1 year")
		);

		$this->logicProperty->set("userRepo", new UserRepo(
			$cookie,
			$this->database->queryCollection("auth"),
			$this->session->getStore(
				User::SESSION_NAMESPACE,
				true
			)
		));
	}
}