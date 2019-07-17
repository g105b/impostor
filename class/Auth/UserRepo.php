<?php
namespace Imposter\Auth;

use Gt\Cookie\CookieHandler;
use Gt\Database\Query\QueryCollection;
use Gt\Session\SessionStore;

class UserRepo {
	/** @var User */
	private $user;

	public function __construct(
		string $cookie,
		QueryCollection $db
	) {
		do {
			$userRow = $db->fetch("getByCookie", $cookie);

			if(!$userRow) {
				$db->insert("createEmpty", $cookie);
			}
		}
		while(!$userRow);

		$this->user = new User(
			$userRow->id,
			$userRow->cookie,
			$userRow->name
		);
	}

	public function persist(SessionStore $session):void {
		$session->set(User::SESSION_KEY, $this->user);
	}
}