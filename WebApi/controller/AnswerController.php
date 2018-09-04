<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/AnswerService.php");

class AnswerController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new AnswerService();
	}

	public function getAll() {
		try {
			$this->verifyToken();
			$answers = $this->service->getAll();
			
			if (!empty($answers)) {
				$this->response($this->json($answers), 200);
			}else {
				$message = array('error'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
		}
		
	}

	public function getById($id) {
		try {
			$this->verifyToken();
			$answer = $this->service->getById($id);
			if (!empty($answer)) {
				$this->response($this->json($answer), 200);
			}else {
				$message = array('error'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
		}
		
	}

	public function getByQuestionId($idQuestion) {
		try {
			$this->verifyToken();
			$answers = $this->service->getByQuestionId($idQuestion);
			if (!empty($answers)) {
				$this->response($this->json($answers), 200);
			} else {
				$message = array('error'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
		}
	}

	public function create() {
		try {
			$this->verifyToken();
			$postBody = file_get_contents("php://input");
			$this->service->create($postBody);
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
		}
	}

	public function update() {
		try {
			$this->verifyToken();
			$postBody = file_get_contents("php://input");
			$this->service->update($postBody);
			$message = array('status' => "Success", "msg" => "Successfully update.");
			$this->response($this->json($message),200);
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
		}
	}

	public function delete($id) {
		try {
			$this->verifyToken();
			$result = $this->service->delete($id);
			$message = array('status' => "Success", "msg" => "Successfully delete.");
			$this->response($this->json($message),200);
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
		}
		
	}

	private function json($data){
		return json_encode($data);
	}
}
?>