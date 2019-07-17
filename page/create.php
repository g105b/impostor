<?php
namespace Imposter\Page;

use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Imposter\Auth\User;
use Imposter\Game\GameRepository;

class CreatePage extends Page {
	/** @var User */
	private $user;

	public function before() {
		$this->user = $this->session->get(User::SESSION_FULL_PATH);
	}

	public function go() {

	}

	public function doStart(InputData $data) {
		$gameRepo = new GameRepository(
			$this->database->queryCollection("game")
		);
		$game = $gameRepo->create(
			$this->user,
			$data->get("scenario"),
			$data->get("type"),
			$data->getInt("limiter"),
			$data->get("round")
		);
		$this->redirect("/lobby?code=" . $game->getCode());
	}
}