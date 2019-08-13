<?php
namespace Impostor\Game;

use DateTime;
use Impostor\Auth\User;

class Player extends User {
	/** @var DateTime */
	private $joined;
	/** @var Persona|null */
	private $persona;

	public function __construct(
		int $id,
		string $cookie,
		DateTime $joined,
		?string $name,
		?Persona $persona = null
	) {
		parent::__construct($id, $cookie, $name);

		$this->persona = $persona;
		$this->joined = $joined;
	}

	public function isImpostor():bool {
		return is_null($this->persona);
	}

	public function getPersonaTitle():?string {
		if(is_null($this->persona)) {
			return null;
		}

		return $this->persona->getTitle();
	}

	public function getPersonaDescription():?string {
		if(is_null($this->persona)) {
			return null;
		}

		return $this->persona->getDescription();
	}
}