<?php
namespace Impostor\Page;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\UserRepository;
use Impostor\Game\GameRepository;

class LobbyPage extends Page {
	/** @var GameRepository */
	public $gameRepo;
	/** @var UserRepository */
	public $userRepo;

	function go() {
		$code = $this->input->get("code");
		$this->checkStarted($code);
		$this->document->bind("code", $code);

		$this->outputPlayers(
			$code,
			$this->document->querySelector(".player-list"),
			$this->document->querySelector(".start-form")
		);
	}

	function doStart() {
		$user = $this->userRepo->load();
		$game = $this->gameRepo->getByUser($user);
		$this->gameRepo->start($game, $user);
		$this->reload();
	}

	function outputPlayers(
		string $code,
		Element $playerListElement,
		Element $startFormElement
	):void {
		$user = $this->userRepo->load();
		$game = $this->gameRepo->getByCode($code);
		$playerList = $this->gameRepo->getPlayerList($code);
		$playerListElement->bindList($playerList);

		if(count($playerList) >= 3) {
			$button = $startFormElement->querySelector("button");
			$creator = $game->getCreator($this->userRepo);

			if($user->getId() === $creator->getId()) {
				$button->removeAttribute("disabled");
			}
			else {
				$button->textContent = "Waiting for {$creator->getName()} to start...";
			}
		}
		else {
			$this->document->getTemplate("not-enough-players")->insertTemplate();
		}
	}

	function checkStarted(string $code):void {
		$game = $this->gameRepo->getByCode($code);
		if($game->isStarted()) {
			$this->redirect("/game");
		}
	}
}