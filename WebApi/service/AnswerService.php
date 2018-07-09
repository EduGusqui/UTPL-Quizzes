<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");

class AnswerService implements IBaseService {
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select * from respuesta where estado = ?";
			return $db->executeAll($sql,array("ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select * from respuesta where id = ? and estado = ?";
			return $db->execute($sql,array($id, "ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function create($data) {
		try {
			$answer = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into respuesta (descripcion,correcta,estado,idPregunta) values (?,?,?,?)";
			$db->execute($sql, array($answer->Description,$answer->Correct,"ACT",$answer->IdQuestion));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function update($data) {
		try {
			$answer = json_decode($data);
			$db = Database::getConnection();
			$sql = "update respuesta set descripcion=?,correcta=?,idPregunta=? where id=?";
			$db->execute($sql, array($answer->Description,$answer->Correct,$answer->IdQuestion,$answer->Id));
			return true;
		} catch (Exception $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update pregunta set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
} 
?>