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
			$takeQuizzes = $this->service->getAll();
			
			if (!empty($takeQuizzes)) {
				$this->response($this->json($takeQuizzes), 200);
			}else {
				$message = array('status'=>'404','message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function getById($id) {
		try {
			$this->verifyToken();
			$takeQuiz = $this->service->getById($id);
			
			if (!empty($takeQuiz)) {
				$this->response($this->json($takeQuiz), 200);
			}else {
				$message = array('status'=>'404','message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function getByStudent($idStudent) {
		try {
			$this->verifyToken();
			$takeQuizzes = $this->service->getTakeByStudent($idStudent);
			
			if (!empty($takeQuizzes)) {
				$this->response($this->json($takeQuizzes), 200);
			}else {
				$message = array('status'=>'404','message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function getByTakeQuiz($idTakeQuiz) {
		try {
			$this->verifyToken();
			$takeQuizzes = $this->service->getTakeDetailsByTakeId($idTakeQuiz);
			
			if (!empty($takeQuizzes)) {
				$this->response($this->json($takeQuizzes), 200);
			}else {
				$message = array('status'=>'404','message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
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