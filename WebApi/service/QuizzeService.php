<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");

class QuizzeService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select * from cuestionario where estado = ?";
			return $db->executeAll($sql,array("ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select * from cuestionario where id = ? and estado = ?";
			return $db->execute($sql,array($id, "ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function create($data) {
		try {
			$quizze = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into cuestionario (nombre,estado,idProfesor,idCurso) values (?,?,?,?)";
			$db->execute($sql, array($quizze->Name,"ACT",$quizze->IdProfessor,$quizze->IdCourse));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function update($data) {
		try {
  		$quizze = json_decode($data);
  		$db = Database::getConnection();
  		$sql = "update cuestionario set nombre=?,idProfesor=?,IdCourse=? where id=?";
  		$db->execute($sql, array($quizze->Name,$quizze->IdProfessor,$quizze->IdCourse,$quizze->Id));
  		return true;
  	} catch (Exeption $e) {
  		print "Error!: " . $e->getMessage();
  		return false;
  	}
	}

	public static function delete($id) {
		try {
  		$db = Database::getConnection();
  		$sql = "update cuestionario set estado=? where id=?";
  		$db->execute($sql, array("INA",$id));
  		return true;
  	} catch (Exeption $e) {
  		print "Error!: " . $e->getMessage();
  		return false;
  	}
	}
} 
?>