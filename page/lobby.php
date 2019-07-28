<?php
namespace Imposter\Page;

use Gt\DomTemplate\Element;
use Gt\WebEngine\Logic\Page;
use Imposter\Auth\UserRepository;
use Imposter\Game\GameRepository;

class LobbyPage extends Page {
	/** @var GameRepository */
	public $gameRepo;
	/** @var UserRepository */
	public $userRepo;

	function go() {
		$code = $this->input->get("code");
		$this->document->bind("code", $code);

		$this->outputPlayers(
			$code,
			$this->document->querySelector(".player-list"),
			$this->document->querySelector(".start-form")
		);
	}

	function outputPlayers(
		string $code,
		Element $playerListElement,
		Element $startFormElement
	) {
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
}