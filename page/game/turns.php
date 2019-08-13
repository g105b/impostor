<?php
namespace Impostor\Page\Game;

use Gt\WebEngine\Logic\Page;

class TurnsPage extends Page {
	function go() {
		$li = $this->document->querySelector(".c-turn-list li");
		for($i = 0; $i < 10; $i++) {
			$clone = $li->cloneNode(true);
			$li->parentNode->appendChild($clone);
		}
	}
}