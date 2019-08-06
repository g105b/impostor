<?php
namespace Impostor\Game;

class Persona {
	private $id;
	private $max;
	private $title;
	private $description;

	private $gameAllowance;

	public function __construct(
		int $id,
		?int $max,
		string $title,
		?string $description
	) {
		$this->id = $id;
		$this->max = $max;
		$this->title = $title;
		$this->description = $description;

		$this->gameAllowance = $max;
	}

	public function getId():int {
		return $this->id;
	}

	public function getTitle():string {
		return $this->title;
	}

	public function getDescription():string {
		return $this->description ?? "";
	}

	public function hasAllowance():bool {
		return is_null($this->gameAllowance)
			|| $this->gameAllowance > 0;
	}

	public function allocate():void {
		if(!is_null($this->gameAllowance)) {
			$this->gameAllowance--;
		}
	}
}