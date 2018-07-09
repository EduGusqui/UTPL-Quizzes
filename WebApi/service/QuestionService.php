<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");

class QuestionService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select * from pregunta where estado = ?";
			return $db->executeAll($sql,array("ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select * from pregunta where id = ? and estado = ?";
			return $db->execute($sql,array($id, "ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function create($data) {
		try {
			$question = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into pregunta (descripcion,estado,idCuestionario,idTipoPregunta) values (?,?,?,?)";
			$db->execute($sql, array($question->Description,"ACT",$question->IdQuizze,$question->IdQuestionType));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function update($data) {
		try {
			$question = json_decode($data);
			$db = Database::getConnection();
			$sql = "update pregunta set descripcion=?,idCuestionario=?,idTipoPregunta=? where id=?";
			$db->execute($sql, array($question->Description,$question->IdQuizze,$question->IdQuestionType,$question->Id));
			return true;
		} catch (Exeption $e) {
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