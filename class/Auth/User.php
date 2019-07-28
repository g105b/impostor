<?php
namespace Imposter\Auth;

use Gt\DomTemplate\BindDataGetter;
use Gt\WebEngine\FileSystem\Path;

class User implements BindDataGetter {
	const SESSION_NAMESPACE = "auth";
	const SESSION_KEY = "user";
	const SESSION_FULL_PATH =
		self::SESSION_NAMESPACE
		. "."
		. self::SESSION_KEY;
	const COOKIE_NAME = "game-id";

	/** @var int */
	private $id;
	/** @var string */
	private $pubId;
	/** @var string */
	private $cookie;
	/** @var string|null */
	private $name;

	public function __construct(
		int $id,
		string $cookie,
		?string $name
	) {
		$this->id = $id;
		$this->pubId = $this->generatePubId($id, $cookie);
		$this->cookie = $cookie;
		$this->name = $name;
	}

	public function getId():int {
		return $this->id;
	}

	public function getName():?string {
		return $this->name;
	}

	public function getCookie():string {
		return $this->cookie;
	}

	public function getPicturePath():string {
		return implode(DIRECTORY_SEPARATOR, [
			Path::getDataDirectory(),
			"picture",
			$this->cookie . ".jpg",
		]);
	}

	public function getWebPictureUri() {
		$dataPath = $this->getPicturePath();
		$wwwPath = implode(
			DIRECTORY_SEPARATOR, [
				Path::getWwwDirectory(),
				"user-picture",
				$this->pubId . ".jpg",
		]);

		if(!is_dir(dirname($wwwPath))) {
			mkdir(dirname($wwwPath), 0775, true);
		}

		if(is_file($dataPath)) {
			if(!is_file($wwwPath)
				|| filemtime($dataPath) > filemtime($wwwPath)) {
				copy($dataPath, $wwwPath);
			}

			return "/user-picture/{$this->pubId}.jpg";
		}

		return "/asset/img/default.svg";
	}

	private function generatePubId(int $id, string $cookie):string {
		$idPadded = str_pad(dechex($id), 4, "0", STR_PAD_LEFT);
		$endOfCookie = substr($cookie, -6);
		return $idPadded . $endOfCookie;
	}
}