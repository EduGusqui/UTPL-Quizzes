<?php
require_once("WebApi/service/RestService.php");
require_once("WebApi/service/QuizzeService.php");

class QuizzeController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new QuizzeService();
	}

	public function getAll() {
		try {
			$this->verifyToken();
			$quizzes = $this->service->getAll();
			
			if (!empty($quizzes)) {
				$this->response($this->json($quizzes), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
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
			$quizze = $this->service->getById($id);
			
			if ($quizze->Id > 0) {
				$this->response($this->json($quizze), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
		
	}

	public function getByUser($idUser) {
		try {
			$this->verifyToken();
			$quizzes = $this->service->getQuizzesByRol($idUser);
			
			if (!empty($quizzes)) {
				$this->response($this->json($quizzes), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
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
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function update() {
		try {
			$this->verifyToken();
			$postBody = file_get_contents("php://input");
			$this->service->update($postBody);
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($this->json($message),500);
		}
	}

	public function delete($id) {
		try {
			$this->verifyToken();
			$this->service->delete($id);
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
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