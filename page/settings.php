<?php
namespace Imposter\Page;

use Gt\DomTemplate\Element;
use Gt\Input\InputData\InputData;
use Gt\WebEngine\FileSystem\Path;
use Gt\WebEngine\Logic\Page;
use Imposter\Auth\User;

class SettingsPage extends Page {
	/** @var User */
	private $user;

	public function before() {
		$this->user = $this->session->get(User::SESSION_FULL_PATH);
	}

	public function go() {
		$this->fillForm(
			$this->document->querySelector("form")
		);
	}

	public function doSave(InputData $data) {
		$this->database->update(
			"user.updateNameForCookie",
			$data->get("name"),
			$this->user->getCookie()
		);

		if($data->hasValue("picture")) {
			$file = $data->getFile("picture");
			$file->moveTo($this->user->getPicturePath());
		}

		$this->reload();
	}

	private function fillForm(
		Element $form
	):void {
		$form->bindKeyValue(
			"name",
			$this->user->getName()
		);
		$form->bindKeyValue(
			"user-picture-path",
			$this->user->getWebPictureUri()
		);
	}
}