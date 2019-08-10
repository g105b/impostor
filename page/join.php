<?php
namespace Impostor\Page;

use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\UserRepository;
use Impostor\Game\GameCodeNotFoundException;
use Impostor\Game\GameRepository;
use Impostor\Game\JoiningGameAlreadyStartedException;

class JoinPage extends Page {
	/** @var GameRepository */
	public $gameRepo;
	/** @var UserRepository */
	public $userRepo;

	function go() {
		$this->userRepo->ensureUserHasName(
			"/settings?forced=join"
		);
	}

	function doJoin(InputData $data) {
		$code = $data->getString("code");

		try {
			$game = $this->gameRepo->getByCode($code);
			$user = $this->userRepo->load();
			$this->gameRepo->join($game, $user);
			$this->redirect("/lobby?code=" . $game->getCode());
		}
		catch(GameCodeNotFoundException $exception) {
			$error = $this->document->getTemplate(
				"error-no-game-code"
			)->insertTemplate();
			$error->bind("code", $code);
		}
		catch(JoiningGameAlreadyStartedException $exception) {
			$error = $this->document->getTemplate(
				"error-already-started"
			)->insertTemplate();
			$error->bind("code", $code);
		}
	}
}