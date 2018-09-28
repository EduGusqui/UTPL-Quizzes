<?php
require_once("WebApi/service/RestService.php");
require_once("WebApi/service/AssignQuizService.php");

class AssignQuizController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new AssignQuizService();
	}

	public function getAll() {
		try {
			$this->verifyToken();
			$assignations = $this->service->getAll();
			
			if (!empty($assignations)) {
				$this->response($this->json($assignations), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
	}

	public function getByUser($idUser) {
		try {
			$this->verifyToken();
			$users = $this->service->getAssignationsByUser($idUser);
			
			if (!empty($users)) {
				$this->response($this->json($users), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
		
	}

	public function getByTeacher($idUser) {
		try {
			$this->verifyToken();
			$users = $this->service->getAssignationsByTeacher($idUser);
			
			if (!empty($users)) {
				$this->response($this->json($users), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
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
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
	}

	public function delete($id) {
		try {
			$this->verifyToken();
			$result = $this->service->delete($id);
			$success = array('status' => "Success", "msg" => "Successfully delete.");
			$this->response($this->json($success),200);
		}catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
	}

	private function json($data){
		return json_encode($data);
	}

}
?>