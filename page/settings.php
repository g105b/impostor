<?php
namespace Impostor\Page;

use Gt\DomTemplate\Element;
use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Impostor\Auth\User;
use Impostor\Auth\UserRepository;

class SettingsPage extends Page {
	/** @var UserRepository */
	public $userRepo;

	function go() {
		$this->fillForm(
			$this->document->querySelector("form")
		);

		$this->input->when("forced")->call([$this, "forcedMessage"]);
	}

	function doSave(InputData $data) {
		$user = $this->userRepo->load();

		$this->database->update(
			"auth.updateNameForCookie",
			$data->get("name"),
			$user->getCookie()
		);

		if($data->hasValue("picture")) {
			$file = $data->getFile("picture");
			$file->moveTo($user->getPicturePath());
		}

		$this->userRepo->load(true);

		if($this->input->contains("forced")) {
			$forced = $this->input->getString("forced");
			switch($forced) {
			case "create":
			case "join":
				$this->redirect("/" . $forced);
				break;
			}
		}

		$this->reload();
	}

	function forcedMessage(InputData $data):void {
		$forceType = $data->getString("forced");
		$t = $this->document->getTemplate("forced-message");

		switch($forceType) {
		case "create":
			$t->bind("action", "creating");
			break;

		case "join":
			$t->bind("action", "joining");
			break;
		}

		$t->insertTemplate();
	}

	function fillForm(
		Element $form
	):void {
		$user = $this->userRepo->load();

		$form->bindKeyValue(
			"name",
			$user->getName()
		);
		$form->bindKeyValue(
			"user-picture-path",
			$user->getWebPictureUri()
		);
	}
}