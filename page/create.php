<?php
namespace Impostor\Page;

use Gt\DomTemplate\Element;
use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;
use Impostor\Game\GameRepository;

class CreatePage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;

	function go() {
		$this->userRepo->ensureUserHasName(
			"/settings?forced=create"
		);
		$this->outputScenarios(
			$this->document->querySelector("[name=scenario]")
		);
	}

	function doStart(InputData $data) {
		$user = $this->userRepo->load();

		$game = $this->gameRepo->create(
			$user,
			$data->getInt("scenario"),
			$data->getString("type"),
			$data->getInt("limiter"),
			$data->getString("round")
		);
		$this->gameRepo->join($game, $user);
		$this->redirect("/lobby?code=" . $game->getCode());
	}

	function outputScenarios(Element $element) {
		$element->bindList(
			$this->gameRepo->getScenarioList()
		);
	}
}