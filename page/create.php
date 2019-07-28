<?php
namespace Imposter\Page;

use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Imposter\Auth\User;
use Imposter\Auth\UserRepository;
use Imposter\Game\GameRepository;

class CreatePage extends Page {
	/** @var UserRepository */
	public $userRepo;
	/** @var GameRepository */
	public $gameRepo;

	public function go() {

	}

	public function doStart(InputData $data) {
		$user = $this->userRepo->load();

		$game = $this->gameRepo->create(
			$user,
			$data->get("scenario"),
			$data->get("type"),
			$data->getInt("limiter"),
			$data->get("round")
		);
		$this->gameRepo->join($game, $user);
		$this->redirect("/lobby?code=" . $game->getCode());
	}
}