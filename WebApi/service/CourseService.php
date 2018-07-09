<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");

class CourseService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select * from curso where estado = ?";
			return $db->executeAll($sql,array("ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select * from curso where id = ? and estado = ?";
			return $db->execute($sql,array($id, "ACT"));
		}
		catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
		}
	}

	public static function create($data)
	{
		try {
			$course = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into curso (nombre,estado,idProfesor) values (?,?,?)";
			$db->execute($sql, array($course->Name,"ACT",$course->IdProfessor));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function update($data) {
		try {
			$course = json_decode($data);
			$db = Database::getConnection();
			$sql = "update curso set nombre=?,idProfesor=? where id=?";
			$db->execute($sql, array($course->Name,$course->IdProfessor,$course->Id));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update curso set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
			return true;
		} catch (Exeption $e) {
			print "Error!: " . $e->getMessage();
			return false;
		}
	}
} 
?>