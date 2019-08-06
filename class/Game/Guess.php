<?php
namespace Impostor\Game;

use Gt\DomTemplate\BindDataGetter;

class Guess implements BindDataGetter {
	/** @var int */
	private $id;
	/** @var string */
	private $title;
	/** @var string|null */
	private $description;

	public function __construct(
		int $id,
		string $title,
		string $description = null
	) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
	}

	public function getId():int {
		return $this->id;
	}

	public function getTitle():string {
		return $this->title;
	}

	public function getDescription():string {
		return $this->description ?? "No description available";
	}
}