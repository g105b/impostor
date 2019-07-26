<?php
namespace Imposter\Auth;

use Gt\Cookie\CookieHandler;
use Gt\Database\Query\QueryCollection;
use Gt\Session\SessionStore;

class UserRepo {
	/** @var string */
	private $cookie;
	/** @var QueryCollection */
	private $db;
	/** @var SessionStore */
	private $session;

	public function __construct(
		string $cookie,
		QueryCollection $db,
		SessionStore $session
	) {
		$this->cookie = $cookie;
		$this->db = $db;
		$this->session = $session;
	}

	public function load(bool $forceDbUpdate = false):User {
		/** @var User|null $user */
		$user = $this->session->get(User::SESSION_KEY);

		if($forceDbUpdate || !$user) {
			$user = $this->loadFromDb();
			$this->session->set(User::SESSION_KEY, $user);
		}

		return $user;
	}

	private function loadFromDb():User {
		do {
			$userRow = $this->db->fetch(
				"getByCookie",
				$this->cookie
			);

			if(!$userRow) {
				$this->db->insert(
					"createEmpty",
					$this->cookie
				);
			}
		}
		while(!$userRow);

		$user = new User(
			$userRow->id,
			$userRow->cookie,
			$userRow->name
		);

		return $user;
	}
}