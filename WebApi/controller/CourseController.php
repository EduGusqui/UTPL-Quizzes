<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/CourseService.php");
require_once("WebApi/model/Course.php");

class CourseController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new CourseService();
	}

	public function getAll() {
		try {
			$courses = $this->service->getAll();
			$listCourses;
			for($i = 0; $i < count($courses); $i++) {
				$course = new Course();
				$course->Id = $courses[$i]->id;
				$course->Name = $courses[$i]->nombre;
				$course->Status = $courses[$i]->estado;
				$course->IdProfessor = $courses[$i]->idProfesor;
				$listCourses[$i] = $course;
			}
			
			if (!empty($listCourses)) {
				$this->response($this->json($listCourses), 200);
			}else {
				$this->response('', 404);
			}
		}catch (Exception $e) {
			$this->response('',500);
		}
		
	}

	public function getById($id) {
		try {
			$data = $this->service->getById($id);
			
			$course = new Course();
			$course->Id = $data->id;
			$course->Name = $data->nombre;
			$course->Status = $data->estado;
			$course->IdProfessor = $data->idProfesor;
			
			if ($course->Id > 0) {
				$this->response($this->json($course), 200);
			}else {
				$this->response('', 404);
			}
		}catch (Exception $e) {
			$this->response('',500);
		}
		
	}

	public function create() {
		try {
			$postBody = file_get_contents("php://input");
			$result = $this->service->create($postBody);
			if ($result) {
				$success = array('status' => "Success", "msg" => "Successfully create.");
				$this->response($this->json($success),200);
			}else {
				$this->response('',404);
			}
			
		}catch (Exception $e) {
			$this->response('',500);
		}
	}

	public function update() {
		try {
			$postBody = file_get_contents("php://input");
			$result = $this->service->update($postBody);

			if ($result) {
				$success = array('status' => "Success", "msg" => "Successfully update.");
				$this->response($this->json($success),200);
			}else {
				$this->response('',404);
			}
			
		}catch (Exception $e) {
			$this->response('',500);
		}
	}

	public function delete($id) {
		try {
			$result = $this->service->delete($id);
			if ($result) {
				$success = array('status' => "Success", "msg" => "Successfully delete.");
				$this->response($this->json($success),200);
			}else {
				$this->response('',404);
			}
		}catch (Exception $e) {
			$this->response('',500);
		}
		
	}

	private function json($data){
		return json_encode($data);
	}
}
?>