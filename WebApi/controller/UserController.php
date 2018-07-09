<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/UserService.php");
require_once("WebApi/model/User.php");

class UserController extends RestService {
	private $service;

	public function __construct() {
		parent::__construct();
		$this->service = new UserService();
	}

	public function getAll() {
		try {
			$users = $this->service->getAll();
			$listUsers;
			for($i = 0; $i < count($users); $i++) {
				$user = new User();
				$user->Id = $users[$i]->id;
				$user->Name = $users[$i]->nombre;
				$user->Username = $users[$i]->nombre_usuario;
				$user->Email = $users[$i]->email;
				$user->Status = $users[$i]->estado;
				$listUsers[$i] = $user;
			}
			
			if (!empty($listUsers)) {
				$this->response($this->json($listUsers), 200);
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
			
			$user = new User();
			$user->Id = $data->id;
			$user->Name = $data->nombre;
			$user->Username = $data->nombre_usuario;
			$user->Email = $data->email;
			$user->Status = $data->estado;
			
			if ($user->Id > 0) {
				$this->response($this->json($user), 200);
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