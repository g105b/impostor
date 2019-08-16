<?php
namespace Impostor\Game;

use DateTime;
use Gt\DomTemplate\BindDataGetter;
use Gt\WebEngine\FileSystem\Path;

class Turn implements BindDataGetter {
	/** @var int */
	private $id;
	/** @var int */
	private $num;
	/** @var string */
	private $hash;
	/** @var Player */
	private $from;
	/** @var Player */
	private $to;
	/** @var DateTime */
	private $asked;
	/** @var DateTime|null */
	private $responded;
	/** @var string|null */
	private $hashResponse;

	public function __construct(
		int $id,
		int $num,
		Player $from,
		Player $to,
		DateTime $asked,
		string $hash,
		DateTime $responded = null,
		string $hashResponse = null
	) {
		$this->id = $id;
		$this->num = $num;
		$this->from = $from;
		$this->to = $to;
		$this->asked = $asked;
		$this->hash = $hash;
		$this->responded = $responded;
		$this->hashResponse = $hash;
	}

	public function questionFrom():Player {
		return $this->from;
	}

	public function questionTo():?Player {
		return $this->to;
	}

	public function hasResponse():bool {
		return !is_null($this->responded);
	}

	public function getQuestionPlayer():string {
		return $this->from->getName();
	}

	public function getAnswerPlayer():string {
		return $this->questionTo()->getName();
	}

	public function getQuestionAudioUri():string {
		$hashFilename = $this->hash . ".webm";
		$uri = "/audio/$hashFilename";

		$dataFile = implode(DIRECTORY_SEPARATOR, [
			Path::getDataDirectory(),
			"audio",
			$hashFilename,
		]);

		$publicDataFile = implode(DIRECTORY_SEPARATOR, [
			Path::getWwwDirectory(),
			"audio",
			$hashFilename,
		]);

		if(!is_dir(dirname($publicDataFile))) {
			mkdir(dirname($publicDataFile), 0775, true);
		}

		if(!is_file($publicDataFile)) {
			copy($dataFile, $publicDataFile);
		}

		return $uri;
	}
}