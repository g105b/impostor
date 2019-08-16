<?php
namespace Impostor\Page\Game;

use Gt\DomTemplate\Element;
use Gt\Input\InputData\InputData;
use Gt\WebEngine\FileSystem\Path;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;
use Impostor\Game\Game;
use Impostor\Game\GameRepository;
use Impostor\Game\Player;

class AskPage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;

	/** @var User */
	private $user;
	/** @var Game */
	private $game;
	/** @var Player */
	private $player;

	function go() {
		$this->loadObjects();

		$this->checkPlayerCanAsk();
		$this->outputOtherPlayers(
			$this->document->querySelector(".c-audio-ask .playerList")
		);
	}

	function doAsk(InputData $data) {
		$hash = bin2hex(random_bytes(16));

		$dataFilePath = implode(DIRECTORY_SEPARATOR, [
			Path::getDataDirectory(),
			"audio",
			"$hash.webm",
		]);

		$audioFile = $data->getFile("audio");
		$audioFile->moveTo($dataFilePath);

		$this->loadObjects();
		$this->gameRepo->createTurn(
			$this->game,
			$this->player,
			$data->getInt("player"),
			$hash
		);

		$this->redirect("/game/turns#asked");
	}

	function loadObjects() {
		$this->user = $this->userRepo->load();
		$this->player = $this->userRepo->getPlayer($this->user);
		$this->game = $this->gameRepo->getByUser($this->user);
	}

	function checkPlayerCanAsk() {
		$turns = $this->gameRepo->getTurnList($this->game);

		if(empty($turns)
			&& $this->game->getCreatorId() !== $this->user->getId()) {
			$this->redirect("/game");
		}

		$lastTurn = end($turns);

		if($lastTurn
			&& $lastTurn->getTo()->getId() !== $this->user->getId()) {
			$this->redirect("/game");
		}
	}

	function outputOtherPlayers(Element $playerListEl) {
		$playerList = $this->gameRepo->getPlayerList(
			$this->game,
			$this->player->getId()
		);
		shuffle($playerList);

		$playerListEl->bindList($playerList);
	}
}