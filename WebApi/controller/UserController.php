<?php

require_once("WebApi/service/RestService.php");
require_once("WebApi/service/UserService.php");
require_once("WebApi/model/UserModel.php");

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
				$user = new UserModel();
				$user->Id = $users[$i]->id;
				$user->Name = $users[$i]->nombre;
				$user->Identification = $users[$i]->cedula;
				$user->Email = $users[$i]->email;
				$user->Phone = $users[$i]->telefono;
				$user->ResidenceCity = $users[$i]->ciudad_residencia;
				$user->Username = $users[$i]->nombre_usuario;
				$user->Password = $users[$i]->contrasenia;
				$user->Status = $users[$i]->estado;
				$user->IdRol = $users[$i]->idRol;
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
			if ($data != null) {
				$user = new UserModel();
				$user->Id = $data->id;
				$user->Name = $data->nombre;
				$user->Identification = $data->cedula;
				$user->Email = $data->email;
				$user->Phone = $data->telefono;
				$user->ResidenceCity = $data->ciudad_residencia;
				$user->Username = $data->nombre_usuario;
				$user->Password = $data->contrasenia;
				$user->Status = $data->estado;
				$user->IdRol = $data->idRol;

				$this->response($this->json($user), 200);
			} else {
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