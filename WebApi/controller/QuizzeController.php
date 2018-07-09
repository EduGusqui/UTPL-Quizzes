<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/QuizzeService.php");
require_once("WebApi/model/Quizze.php");

class QuizzeController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new QuizzeService();
	}

	public function getAll() {
		try {
			$quizzes = $this->service->getAll();
			$listQuizzes;
			for($i = 0; $i < count($quizzes); $i++) {
				$quizze = new Quizze();
				$quizze->Id = $quizzes[$i]->id;
				$quizze->Name = $quizzes[$i]->nombre;
				$quizze->Status = $quizzes[$i]->estado;
				$quizze->IdProfessor = $quizzes[$i]->idProfesor;
				$quizze->IdCourse = $quizzes[$i]->idCurso;
				$listQuizzes[$i] = $quizze;
			}
			
			if (!empty($listQuizzes)) {
				$this->response($this->json($listQuizzes), 200);
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
			
			$quizze = new Quizze();
			$quizze->Id = $data->id;
			$quizze->Name = $data->nombre;
			$quizze->Status = $data->estado;
			$quizze->IdProfessor = $data->idProfesor;
			$quizze->IdCourse = $data->idCurso;
			
			if ($quizze->Id > 0) {
				$this->response($this->json($quizze), 200);
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