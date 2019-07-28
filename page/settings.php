<?php
namespace Imposter\Page;

use Gt\DomTemplate\Element;
use Gt\Input\InputData\InputData;
use Gt\WebEngine\Logic\Page;
use Imposter\Auth\User;
use Imposter\Auth\UserRepository;

class SettingsPage extends Page {
	/** @var UserRepository */
	public $userRepo;

	public function go() {
		$this->fillForm(
			$this->document->querySelector("form")
		);
	}

	public function doSave(InputData $data) {
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
		$this->reload();
	}

	private function fillForm(
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