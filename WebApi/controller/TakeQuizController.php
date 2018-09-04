<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/TakeQuizService.php");

class TakeQuizController extends RestService { 
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new TakeQuizService();
	}

	public function getAll() {
		try {
			$this->verifyToken();
			$answers = $this->service->getAll();
			
			if (!empty($answers)) {
				$this->response($this->json($answers), 200);
			}else {
				$message = array('status'=>'404','message'=>$this->get_error_message(404));
				$this->response($this->json($message), 200);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function create() {
		try {
			$this->verifyToken();
			$postBody = file_get_contents("php://input");
			$this->service->create($postBody);
			$success = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($success),200);
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	private function json($data){
		return json_encode($data);
	}

}
?>