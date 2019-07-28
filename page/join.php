<?php
namespace Imposter\Page;

use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Imposter\Auth\UserRepository;
use Imposter\Game\GameCodeNotFoundException;
use Imposter\Game\GameRepository;

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
	}
}