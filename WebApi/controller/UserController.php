<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/UserService.php");

class UserController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new UserService();
	}

	public function getAll() {
		try {
			$this->verifyToken();
			$users = $this->service->getAll();
			
			if (!empty($users)) {
				$this->response($this->json($users), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
		
	}

	public function getById($id) {
		try {
			$this->verifyToken();
			$user = $this->service->getById($id);
			if (!empty($user)) {
				$this->response($this->json($user), 200);
			} else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
		
	}

	public function getByRol($idRol) {
		try {
			$this->verifyToken();
			$users = $this->service->getUserByRol($idRol);
			
			if (!empty($users)) {
				$this->response($this->json($users), 200);
			}else {
				$message = array('message'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		} catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
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
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
	}

	public function update() {
		try {
			$this->verifyToken();
			$postBody = file_get_contents("php://input");
			$this->service->update($postBody);
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
		} catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
	}

	public function delete($id) {
		try {
			$this->verifyToken();
			$result = $this->service->delete($id);
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
		} catch (Exception $e) {
			$errorMessage = array('error'=>$this->get_error_message(500));
			$this->response($this->json($errorMessage),500);
		}
	}

	private function json($data){
		return json_encode($data);
	}
}
?>