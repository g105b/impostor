<?php
namespace Imposter\Page;

use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Imposter\Game\GameCodeNotFoundException;
use Imposter\Game\GameRepository;

class JoinPage extends Page {
	public function go() {

	}

	public function doJoin(InputData $data) {
		$code = $data->getString("code");

		$gameRepo = new GameRepository(
			$this->database->queryCollection("game")
		);

		try {
			$gameRepo->getByCode($code);
		}
		catch(GameCodeNotFoundException $exception) {
			$error = $this->document->getTemplate(
				"error-no-game-code"
			)->insertTemplate();

			$error->bind("code", $code);
		}
	}
}