<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/AnswerService.php");
require_once("WebApi/model/AnswerModel.php");

class AnswerController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new AnswerService();
	}

	public function getAll() {
		try {
			$answers = $this->service->getAll();
			$listAnswer;
			for($i = 0; $i < count($answers); $i++) {
				$answer = new AnswerModel();
				$answer->Id = $answers[$i]->id;
				$answer->Description = $answers[$i]->descripcion;
				$answer->Correct = $answers[$i]->correcta;
				$answer->Status = $answers[$i]->estado;
				$answer->IdQuestion = $answers[$i]->idPregunta;
				$listAnswer[$i] = $answer;
			}
			
			if (!empty($listAnswer)) {
				$this->response($this->json($listAnswer), 200);
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
			
			$answer = new AnswerModel();
			$answer->Id = $data->id;
			$answer->Description = $data->descripcion;
			$answer->Correct = $data->correcta;
			$answer->Status = $data->estado;
			$answer->IdQuestion = $data->idPregunta;
			
			if ($answer->Id > 0) {
				$this->response($this->json($answer), 200);
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