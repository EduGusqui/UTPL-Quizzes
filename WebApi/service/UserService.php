<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/UserModel.php");
require_once("WebApi/model/RolModel.php");

class UserService implements IBaseService {
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select u.id, u.nombre, u.cedula, u.email, u.telefono, u.ciudad_residencia, u.nombre_usuario, 
					u.contrasenia, u.estado, u.idRol, r.nombre as nombre_rol, r.estado as status
					from usuario u
					left join rol r on r.id = u.idRol
					where u.estado = ?";

			$data = $db->executeAll($sql,array("ACT"));
			$users;
			for($i = 0; $i < count($data); $i++) {
				$user = new UserModel();
				$user->Id = $data[$i]->id;
				$user->FullName = $data[$i]->nombre;
				$user->Identification = $data[$i]->cedula;
				$user->Email = $data[$i]->email;
				$user->Phone = $data[$i]->telefono;
				$user->ResidenceCity = $data[$i]->ciudad_residencia;
				$user->Username = $data[$i]->nombre_usuario;
				$user->Password = $data[$i]->contrasenia;
				$user->Status = $data[$i]->estado;
				$rol = new RolModel();
				$rol->Id = $data[$i]->idRol;
				$rol->Name = $data[$i]->nombre_rol;
				$rol->Status = $data[$i]->status;
				$user->Rol = $rol;
				$users[$i] = $user;
			}

			if (!empty($users))
				return $users;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select u.id, u.nombre, u.cedula, u.email, u.telefono, u.ciudad_residencia, u.nombre_usuario, 
					u.contrasenia, u.estado, u.idRol, r.nombre as nombre_rol
					from usuario u 
					left join rol r on r.id = u.idRol
					where u.id = ? and u.estado = ?";
			$data = $db->execute($sql,array($id, "ACT"));
			if (!is_null($data)) {
				$user = new UserModel();
				$user->Id = $data->id;
				$user->FullName = $data->nombre;
				$user->Identification = $data->cedula;
				$user->Email = $data->email;
				$user->Phone = $data->telefono;
				$user->ResidenceCity = $data->ciudad_residencia;
				$user->Username = $data->nombre_usuario;
				$user->Password = $data->contrasenia;
				$user->Status = $data->estado;
				$rol = new RolModel();
				$rol->Id = $data->idRol;
				$rol->Name = $data->nombre_rol;
				$user->Rol = $rol;

				return $user;
			} else {
				return null;
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data) {
		try {
			$user = json_decode($data);
			$user->Password = md5($user->Password);
			$db = Database::getConnection();
			$sql = "insert into usuario (nombre,cedula,email,telefono,ciudad_residencia,nombre_usuario,contrasenia,estado,idRol) 
					values (?,?,?,?,?,?,?,?,?)";
			$db->execute($sql, array($user->FullName,$user->Identification,$user->Email,$user->Phone,$user->ResidenceCity,
										$user->Username,$user->Password,"ACT",$user->Rol->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {
		try {
			$user = json_decode($data);
			$db = Database::getConnection();
			$sql = "update usuario set nombre=?,cedula=?,email=?,telefono=?,ciudad_residencia=?,nombre_usuario=?,idRol=? 
					where id=?";
			$db->execute($sql, array($user->FullName,$user->Identification,$user->Email,$user->Phone,$user->ResidenceCity,
									$user->Username,$user->Rol->Id,$user->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update usuario set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getUserByRol($idRol) {
		try {
			$db = Database::getConnection();
			$sql = "select u.id, u.nombre, u.cedula, u.email, u.telefono, u.ciudad_residencia, u.nombre_usuario, 
					u.contrasenia, u.estado, u.idRol, r.nombre as nombre_rol, r.estado as status
					from usuario u
					left join rol r on r.id = u.idRol
					where u.estado = ?
					and r.id = ?";

			$data = $db->executeAll($sql,array("ACT", $idRol));
			$users;
			for($i = 0; $i < count($data); $i++) {
				$user = new UserModel();
				$user->Id = $data[$i]->id;
				$user->FullName = $data[$i]->nombre;
				$user->Identification = $data[$i]->cedula;
				$user->Email = $data[$i]->email;
				$user->Phone = $data[$i]->telefono;
				$user->ResidenceCity = $data[$i]->ciudad_residencia;
				$user->Username = $data[$i]->nombre_usuario;
				$user->Password = $data[$i]->contrasenia;
				$user->Status = $data[$i]->estado;
				$rol = new RolModel();
				$rol->Id = $data[$i]->idRol;
				$rol->Name = $data[$i]->nombre_rol;
				$rol->Status = $data[$i]->status;
				$user->Rol = $rol;
				$users[$i] = $user;
			}

			if (!empty($users))
				return $users;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}
} 
?>