<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/LoginService.php");

class LoginController extends RestService {

	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new LoginService();
	}

	public function authenticate() {
		$postBody = file_get_contents("php://input");
		$authenticate = $this->service->authenticate($postBody);
		if (!empty($authenticate)) {
			$this->response($this->json($authenticate),200);
		}else {
			$errorMessage = array('error'=>$this->get_error_message(404));
			$this->response($this->json($errorMessage),404);
		}
	}

	private function json($data){
		return json_encode($data);
	}

}
?>