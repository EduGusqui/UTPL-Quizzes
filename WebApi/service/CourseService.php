<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/UserModel.php");
require_once("WebApi/model/CourseModel.php");
require_once("WebApi/model/CategoryModel.php");

class CourseService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select c.id, c.nombre, c.estado, u.id as idProfesor, u.nombre as nombreCompleto,
					ca.id as idCategoria, ca.nombre as nombreCategoria
					from curso c
					left join usuario u on u.id = c.idProfesor
					left join categoria ca on ca.id = c.id_categoria
					where c.estado = ?";
			$data = $db->executeAll($sql,array("ACT"));
			for($i = 0; $i < count($data); $i++) {
				$course = new CourseModel();
				$course->Id = $data[$i]->id;
				$course->Name = $data[$i]->nombre;
				$course->Status = $data[$i]->estado;
				$teacher = new UserModel();
				$teacher->Id = $data[$i]->idProfesor;
				$teacher->FullName = $data[$i]->nombreCompleto;
				$course->Teacher = $teacher;
				$category = new CategoryModel();
				$category->Id = $data[$i]->idCategoria;
				$category->Name = $data[$i]->nombreCategoria;
				$course->Category = $category;
				$courses[$i] = $course;
			}

			if (!empty($courses))
				return $courses;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select c.id, c.nombre, c.estado, u.id as idProfesor, u.nombre as nombreCompleto,
					ca.id as idCategoria, ca.nombre as nombreCategoria
					from curso c
					left join usuario u on u.id = c.idProfesor
					left join categoria ca on ca.id = c.id_categoria
					where c.id = ? and c.estado = ?";
			$data = $db->execute($sql,array($id, "ACT"));
			if (!empty($data)) {
				$course = new CourseModel();
				$course->Id = $data->id;
				$course->Name = $data->nombre;
				$course->Status = $data->estado;
				$teacher = new UserModel();
				$teacher->Id = $data->idProfesor;
				$teacher->FullName = $data->nombreCompleto;
				$course->Teacher = $teacher;
				$category = new CategoryModel();
				$category->Id = $data->idCategoria;
				$category->Name = $data->nombreCategoria;
				$course->Category = $category;
				
				return $course;
			} else {
				return null;
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getByProfessorId($idProfessor) {
		try {
			$db = Database::getConnection();
			$sql = "select c.id, c.nombre, c.estado, u.id as idProfesor, u.nombre as nombreCompleto
					from curso c
					left join usuario u on u.id = c.idProfesor
					where c.estado = ? and u.id = ?";
			$data = $db->executeAll($sql,array("ACT", $idProfessor));

			for($i = 0; $i < count($data); $i++) {
				$course = new CourseModel();
				$course->Id = $data[$i]->id;
				$course->Name = $data[$i]->nombre;
				$course->Status = $data[$i]->estado;
				$teacher = new UserModel();
				$teacher->Id = $data[$i]->idProfesor;
				$teacher->FullName = $data[$i]->nombreCompleto;
				$course->Teacher = $teacher;
				$courses[$i] = $course;
			}

			if (!empty($courses))
				return $courses;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data)
	{
		try {
			$course = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into curso (nombre,estado,idProfesor,id_categoria) values (?,?,?,?)";
			$db->execute($sql, array($course->Name,"ACT",$course->Teacher->Id,$course->Category->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {
		try {
			$course = json_decode($data);
			$db = Database::getConnection();
			$sql = "update curso set nombre=?,idProfesor=?,id_categoria=? where id=?";
			$db->execute($sql, array($course->Name,$course->Teacher->Id,$course->Category->Id,$course->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update curso set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}
} 
?>