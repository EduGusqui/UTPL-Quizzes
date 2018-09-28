<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/QuizzeModel.php");
require_once("WebApi/model/CourseModel.php");
require_once("WebApi/model/UserModel.php");
require_once("WebApi/model/CategoryModel.php");


class QuizzeService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select c.id, c.nombre, c.numero_intento, u.id as idUsuario, u.nombre as nombreUsuario, 
					c.estado, cur.id as idCurso, cur.nombre as nombreCurso, ca.id as idCategoria, ca.nombre as nombreCategoria
					from cuestionario c 
					left join usuario u on u.id = c.idProfesor
					left join curso cur on cur.id = c.idCurso
					left join categoria ca on ca.id = cur.id_categoria
					where c.estado = ?";
			$data = $db->executeAll($sql,array("ACT"));
			
			for ($i = 0; $i < count($data); $i++) {
				$quizze = new QuizzeModel;
				$quizze->Id = $data[$i]->id;
				$quizze->Name = $data[$i]->nombre;
				$quizze->AttemptNumber = $data[$i]->numero_intento;
				$quizze->Status = $data[$i]->estado;
				$user = new UserModel();
				$user->Id = $data[$i]->idUsuario;
				$user->FullName = $data[$i]->nombreUsuario;
				$quizze->User = $user;
				$course = new CourseModel();
				$course->Id = $data[$i]->idCurso;
				$course->Name = $data[$i]->nombreCurso;
				
				$category = new CategoryModel();
				$category->Id = $data[$i]->idCategoria;
				$category->Name = $data[$i]->nombreCategoria;
				$course->Category = $category;

				$quizze->Course = $course;
				$quizzes[$i] = $quizze;
				
			}

			if (!empty($quizzes))
				return $quizzes;
			else
				return null;
		}
		catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select c.id, c.nombre, c.numero_intento, u.id as idUsuario, u.nombre as nombreUsuario, 
						cur.id as idCurso, cur.nombre as nombreCurso, c.estado,
						ca.id as idCategoria, ca.nombre as nombreCategoria
						from cuestionario c
						left join usuario u on u.id = c.idProfesor
						left join curso cur on cur.id = c.idCurso
						left join categoria ca on ca.id = cur.id_categoria
						where c.id = ? and c.estado = ?";
			$data = $db->execute($sql,array($id, "ACT"));

			if (!empty($data)) {
				$quizze = new QuizzeModel();
				$quizze->Id = $data->id;
				$quizze->Name = $data->nombre;
				$quizze->AttemptNumber = $data->numero_intento;
				$quizze->Status = $data->estado;
				$user = new UserModel();
				$user->Id = $data->idUsuario;
				$user->FullName = $data->nombreUsuario;
				$quizze->User = $user;
				$course = new CourseModel();
				$course->Id = $data->idCurso;
				$course->Name = $data->nombreCurso;
				$category = new CategoryModel();
				$category->Id = $data->idCategoria;
				$category->Name = $data->nombreCategoria;
				$course->Category = $category;
				$quizze->Course = $course;

				return $quizze;
			} else {
				return null;
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getQuizzesByRol($idUser) {
		try {
			$db = Database::getConnection();
			$sql = "select c.id, c.nombre, c.numero_intento, u.id as idUsuario, u.nombre as nombreUsuario, 
						cur.id as idCurso, cur.nombre as nombreCurso, c.estado,
						ca.id as idCategoria, ca.nombre as nombreCategoria
						from cuestionario c
						left join usuario u on u.id = c.idProfesor
						left join curso cur on cur.id = c.idCurso
						left join categoria ca on ca.id = cur.id_categoria
						where c.estado = ? and c.idProfesor = ?";
			$data = $db->executeAll($sql,array("ACT", $idUser));
			
			for ($i = 0; $i < count($data); $i++) {
				$quizze = new QuizzeModel;
				$quizze->Id = $data[$i]->id;
				$quizze->Name = $data[$i]->nombre;
				$quizze->AttemptNumber = $data[$i]->numero_intento;
				$quizze->Status = $data[$i]->estado;
				$quizzes[$i] = $quizze;
			}

			if (!empty($quizzes)) 
				return $quizzes;
			else
				return null;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data) {
		try {
			$quizze = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into cuestionario (nombre,numero_intento,estado,idProfesor,idCurso) values (?,?,?,?,?)";
			$db->execute($sql, array($quizze->Name,$quizze->AttemptNumber,"ACT",$quizze->User->Id,$quizze->Course->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {
		try {
	  		$quizze = json_decode($data);
	  		$db = Database::getConnection();
	  		$sql = "update cuestionario set nombre=?,idProfesor=?,numero_intento=?,idCurso=? where id=?";
	  		$db->execute($sql, array($quizze->Name,$quizze->User->Id,$quizze->AttemptNumber,$quizze->Course->Id,$quizze->Id));
	  	} catch (Exeption $e) {
  			throw new Exception($e->getMessage());
  		}
	}

	public static function delete($id) {
		try {
	  		$db = Database::getConnection();
	  		$sql = "update cuestionario set estado=? where id=?";
	  		$db->execute($sql, array("INA",$id));
	  	} catch (Exeption $e) {
	  		throw new Exception($e->getMessage());
	  	}
	}
} 
?>