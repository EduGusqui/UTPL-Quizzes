<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");

class UserService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select * from usuario where estado = ?";
			return $db->executeAll($sql,array("ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select * from usuario where id = ? and estado = ?";
			return $db->execute($sql,array($id, "ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function create($data) {
		try {
			$user = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into usuario (nombre,cedula,email,telefono,ciudad_residencia,nombre_usuario,contrasenia,estado,idRol) values (?,?,?,?,?,?,?,?,?)";
			$db->execute($sql, array($user->Name,$user->Identification,$user->Email,$user->Phone,$user->ResidenceCity,$user->Username,$user->Password,"ACT",$user->IdRol));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function update($data) {
		try {
  		$user = json_decode($data);
  		$db = Database::getConnection();
  		$sql = "update usuario set nombre=?,cedula=?,email=?,telefono=?,ciudad_residencia=?,nombre_usuario=?,idRol=? where id=?";
  		$db->execute($sql, array($user->Name,$user->Identification,$user->Email,$user->Phone,$user->ResidenceCity,$user->Username,$user->IdRol,$user->Id));
  		return true;
  	} catch (Exeption $e) {
  		print "Error!: " . $e->getMessage();
  		return false;
  	}
	}

	public static function delete($id) {
		try {
  		$db = Database::getConnection();
  		$sql = "update usuario set estado=? where id=?";
  		$db->execute($sql, array("INA",$id));
  		return true;
  	} catch (Exeption $e) {
  		print "Error!: " . $e->getMessage();
  		return false;
  	}
	}
} 
?>