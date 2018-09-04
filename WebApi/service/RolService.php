<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/RolModel.php");

class RolService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select * from rol where estado = ?";
			$data = $db->executeAll($sql,array("ACT"));
			for ($i = 0; $i < count($data); $i++) {
				$rol = new RolModel();
				$rol->Id = $data[$i]->id;
				$rol->Name = $data[$i]->nombre;
				$rol->Status = $data[$i]->estado;
				$roles[$i] = $rol;
			}

			if (!empty($roles))
				return $roles;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select * from rol where id = ? and estado = ?";
			$data = $db->execute($sql,array($id, "ACT"));
			if (!is_null($data)) {
				$rol = new RolModel();
				$rol->Id = $data->id;
				$rol->Name = $data->nombre;
				$rol->Status = $data->estado;
				return $rol;
			} else {
				return null;
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data) {
		try {
			$rol = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into rol (nombre,estado) values (?,?)";
			$db->execute($sql, array($rol->Name,"ACT"));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {
		try {
			$user = json_decode($data);
			$db = Database::getConnection();
			$sql = "update rol set nombre=? where id=?";
			$db->execute($sql, array($user->Name,$user->Id));
		} catch (Exeption $e) {
			return $e->getMessage();
		}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update rol set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
		} catch (Exeption $e) {
			return $e->getMessage();
		}
	}
} 
?>