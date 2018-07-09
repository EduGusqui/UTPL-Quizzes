<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/QuestionService.php");
require_once("WebApi/model/QuestionModel.php");

class QuestionController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new QuestionService();
	}

	public function getAll() {
		try {
			$questions = $this->service->getAll();
			$listQuestions;
			for($i = 0; $i < count($questions); $i++) {
				$question = new QuestionModel();
				$question->Id = $questions[$i]->id;
				$question->Description = $questions[$i]->descripcion;
				$question->Status = $questions[$i]->estado;
				$question->IdQuizze = $questions[$i]->idCuestionario;
				$question->IdQuestionType = $questions[$i]->idTipoPregunta;
				$listQuestions[$i] = $question;
			}
			
			if (!empty($listQuestions)) {
				$this->response($this->json($listQuestions), 200);
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
			
			$question = new QuestionModel();
			$question->Id = $data->id;
			$question->Description = $data->descripcion;
			$question->Status = $data->estado;
			$question->IdQuizze = $data->idCuestionario;
			$question->IdQuestionType = $data->idTipoPregunta;
			
			if ($question->Id > 0) {
				$this->response($this->json($question), 200);
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