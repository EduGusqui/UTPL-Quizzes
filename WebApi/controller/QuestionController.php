<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/QuestionService.php");

class QuestionController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new QuestionService();
	}

	public function getAll() {
		try {
			$this->verifyToken();
			$questions = $this->service->getAll();
			
			if (!empty($questions)) {
				$this->response($this->json($questions), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
		
	}

	public function getById($id) {
		try {
			$this->verifyToken();
			$question = $this->service->getById($id);
			
			if (!empty($question)) {
				$this->response($this->json($question), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
		
	}

	public function getByQuizId($id) {
		try {
			$this->verifyToken();
			$questions = $this->service->getByQuizId($id);

			if (!empty($questions)) {
				$this->response($this->json($questions), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function getByAssignation($idAssignation) {
		try {
			$this->verifyToken();
			$questions = $this->service->getByAssignation($idAssignation);

			if (!empty($questions)) {
				$this->response($this->json($questions), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function create() {
		try {
			$this->verifyToken();
			$postBody = file_get_contents("php://input");
			$this->service->create($postBody);
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
		} catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function update() {
		try {
			$this->verifyToken();
			$postBody = file_get_contents("php://input");
			$this->service->update($postBody);
			$message = array('status' => "Success", "msg" => "Successfully update.");
			$this->response($this->json($message),200);
		} catch (Exception $e) {
			$this->response('',500);
		}
	}

	public function delete($id) {
		try {
			$this->verifyToken();
			$this->service->delete($id);
			$message = array('status' => "Success", "msg" => "Successfully delete.");
			$this->response($this->json($message),200);
		} catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
		
	}

	private function json($data){
		return json_encode($data);
	}
}
?>