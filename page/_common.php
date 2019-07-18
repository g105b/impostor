<?php
namespace Imposter\Page;

use DateTime;
use Gt\WebEngine\Logic\Page;
use Imposter\Auth\CookieId;
use Imposter\Auth\User;
use Imposter\Auth\UserRepo;

class _CommonPage extends Page {
	public function go() {
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

		$userRepo = new UserRepo(
			$cookie,
			$this->database->queryCollection("auth")
		);
		$userRepo->persist(
			$this->session->getStore(
				User::SESSION_NAMESPACE,
				true
			)
		);
	}
}