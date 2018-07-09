<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/QuestionTypeService.php");
require_once("WebApi/model/QuestionTypeModel.php");

class QuestionTypeController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new QuestionTypeService();
	}

	public function getAll() {
		try {
			$questionsTypes = $this->service->getAll();
			$listQuestionsTypes;
			for($i = 0; $i < count($questionsTypes); $i++) {
				$questionType = new QuestionTypeModel();
				$questionType->Id = $questionsTypes[$i]->id;
				$questionType->Name = $questionsTypes[$i]->nombre;
				$questionType->Status = $questionsTypes[$i]->estado;
				$listQuestionsTypes[$i] = $questionType;
			}
			
			if (!empty($listQuestionsTypes)) {
				$this->response($this->json($listQuestionsTypes), 200);
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
			
			$questionType = new QuestionTypeModel();
			$questionType->Id = $data->id;
			$questionType->Name = $data->nombre;
			$questionType->Status = $data->estado;
			
			if ($questionType->Id > 0) {
				$this->response($this->json($questionType), 200);
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