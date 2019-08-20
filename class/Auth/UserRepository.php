<?php
namespace Impostor\Auth;

use DateTime;
use Gt\Database\Query\QueryCollection;
use Gt\Database\Result\Row;
use Gt\Session\SessionStore;
use Impostor\Game\Persona;
use Impostor\Game\Player;

class UserRepository {
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

	public function getById(int $id):?User {
		$userRow = $this->db->fetch("getById", $id);
		if(is_null($userRow)) {
			return null;
		}

		return $this->userFromRow($userRow);
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

	public function getPlayer(User $user):?Player {
		$row = $this->db->fetch(
			"getPlayerByUserId",
			$user->getId()
		);

		if(is_null($row)) {
			return null;
		}

		$persona = null;

		if(!is_null($row->personaId)) {
			$persona = new Persona(
				$row->personaId,
				$row->personaTitle,
				$row->personaDescription
			);
		}

		return new Player(
			$row->id,
			$row->cookie,
			new DateTime($row->joined),
			$row->name,
			$persona
		);
	}

	public function getPlayerById(int $id):?Player {
		$row = $this->db->fetch(
			"getPlayerById",
			$id
		);

		if(is_null($row)) {
			return null;
		}

		$persona = null;

		if(!is_null($row->personaId)) {
			$persona = new Persona(
				$row->personaId,
				$row->personaTitle,
				$row->personaDescription
			);
		}

		return new Player(
			$row->id,
			$row->cookie,
			new DateTime($row->joined),
			$row->name,
			$persona
		);
	}

	public function ensureUserHasName(string $uriToSetName):void {
		$user = $this->load();
		if(empty($user->getName())) {
			header("Location: $uriToSetName");
			exit;
		}
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

		return $this->userFromRow($userRow);
	}

	private function userFromRow(Row $userRow):User {
		return new User(
			$userRow->id,
			$userRow->cookie,
			$userRow->name
		);
	}
}