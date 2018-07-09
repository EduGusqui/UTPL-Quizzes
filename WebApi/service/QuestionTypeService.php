<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");

class QuestionTypeService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select * from tipo_pregunta where estado = ?";
			return $db->executeAll($sql,array("ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select * from tipo_pregunta where id = ? and estado = ?";
			return $db->execute($sql,array($id, "ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function create($data) {
		try {
			$questionType = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into tipo_pregunta (nombre,estado) values (?,?)";
			$db->execute($sql, array($questionType->Name,"ACT"));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function update($data) {
		try {
  		$questionType = json_decode($data);
  		$db = Database::getConnection();
  		$sql = "update tipo_pregunta set nombre=? where id=?";
  		$db->execute($sql, array($questionType->Name,$questionType->Id));
  		return true;
  	} catch (Exeption $e) {
  		print "Error!: " . $e->getMessage();
  		return false;
  	}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update tipo_pregunta set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
} 
?>