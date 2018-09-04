<?php
require_once("WebApi/service/RestService.php");
require_once("WebApi/service/CourseService.php");

class CourseController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new CourseService();
	}

	public function getAll() {
		try {
			$this->verifyToken();
			$courses = $this->service->getAll();
			
			if (!empty($courses)) {
				$this->response($this->json($courses), 200);
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
			$course = $this->service->getById($id);
			if (!empty($course)) {
				$this->response($this->json($course), 200);
			}else {
				$message = array('error'=>$this->get_error_message(404));
				$this->response($this->json($message), 404);
			}
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
		}
		
	}

	public function getByProfessorId($idProfessor) {
		try {
			$this->verifyToken();
			$courses = $this->service->getByProfessorId($idProfessor);
			if (!empty($courses)) {
				$this->response($this->json($courses), 200);
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
			$message = array('status' => "Success", "msg" => "Successfully create.");
			$this->response($this->json($message),200);
		}catch (Exception $e) {
			$message = array('error'=>$this->get_error_message(500));
			$this->response($message,500);
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
			$this->response($message,500);
		}
	}

	private function json($data){
		return json_encode($data);
	}
}
?>