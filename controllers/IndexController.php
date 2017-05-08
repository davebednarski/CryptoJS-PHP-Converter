<?php

namespace Controllers;

include('./Crypto/Crypto.php');
use \Crypto\Crypto;


class IndexController
{
	const INDEX_VIEW = './views/index.phtml';
	public $view;

	public function __constructor() {

		$this->view = IndexController::INDEX_VIEW;
	}

	public function renderView($view) {

		switch($view){
			case 'index':
				require(IndexController::INDEX_VIEW);
				break;
			default:
				require($this->view);
		}
	}

	// example text message
	public function getExampleEncrypted1() {
		return $this->getEncryptedData('My secret message', '0123456789abcdef0123456789abcdef');
	}

	// example json data message
	public function getExampleEncrypted2() {
		return $this->getEncryptedData(['secret data' => ['test1' => true, 'test2' => false, 'test3' => true]], '0123456789abcdef0123456789abcdef');
	}

	private function getEncryptedData($data, $password) {
		$crypto = new Crypto();
		return $crypto->encrypt($data, $password);
	}
}