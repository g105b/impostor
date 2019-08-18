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
use Impostor\Game\Turn;

class AnswerPage extends Page {
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

		$this->checkPlayerCanAnswer();
		$this->outputQuestion(
			$this->document->querySelector(".c-audio-recorder")
		);
	}

	function doAnswer(InputData $data) {
		$hash = bin2hex(random_bytes(16));

		$dataFilePath = implode(DIRECTORY_SEPARATOR, [
			Path::getDataDirectory(),
			"audio",
			"$hash.webm",
		]);

		$audioFile = $data->getFile("audio");
		$audioFile->moveTo($dataFilePath);

		$this->loadObjects();
		$this->gameRepo->createTurnResponse(
			$this->game,
			$hash
		);

		$this->redirect("/game/turns?action=answered");
	}

	function loadObjects() {
		$this->user = $this->userRepo->load();
		$this->player = $this->userRepo->getPlayer($this->user);
		$this->game = $this->gameRepo->getByUser($this->user);
	}

	function checkPlayerCanAnswer() {
		$turns = $this->gameRepo->getTurnList($this->game);

		if(empty($turns)) {
			$this->redirect("/game");
		}

		/** @var Turn $lastTurn */
		$lastTurn = end($turns);

		if($lastTurn->hasResponse()
		|| $lastTurn->questionTo()->getId() !== $this->user->getId()) {
			$this->redirect("/game");
		}
	}

	function outputQuestion(Element $form) {
		$turns = $this->gameRepo->getTurnList($this->game);
		/** @var Turn $lastTurn */
		$lastTurn = end($turns);

		$form->bindKeyValue(
			"questionPlayer",
			$lastTurn->questionFrom()->getName()
		);
		$form->bindKeyValue(
			"questionAudioUri",
			$lastTurn->getQuestionAudioUri()
		);
	}
}