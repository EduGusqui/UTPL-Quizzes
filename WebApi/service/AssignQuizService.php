<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/AssignQuizModel.php");
require_once("WebApi/model/UserModel.php");
require_once("WebApi/model/QuizzeModel.php");

class AssignQuizService implements IBaseService {

	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select a.id, u.id as idUsuario, u.nombre as nombreUsuario, c.id as idCuestionario, 
				c.nombre as nombreCuestionario, a.estado, p.id as idProfesor, p.nombre as nombreProfesor,
				c.numero_intento,
				(select count(numero_intento) from rendir_cuestionario where 
					idAsignarCuestionario = a.id) as numero_intento_realizado,
				coalesce((select calificacion from rendir_cuestionario where idAsignarCuestionario = a.id order by id 
					desc limit 1),0) as calificacion
				from asignar_cuestionario a
				left join usuario u on u.id = a.idEstudiante
				left join cuestionario c on c.id = a.idCuestionario
				left join usuario p on p.id = c.idProfesor
				where a.estado = ?
				order by c.nombre, u.nombre ";
			$data = $db->executeAll($sql, array("ACT"));
			for ($i = 0; $i < count($data); $i++) {
				$assign = new AssignQuizModel();
				$assign->Id = $data[$i]->id;
				$student = new UserModel();
				$student->Id = $data[$i]->idUsuario;
				$student->FullName = $data[$i]->nombreUsuario;
				$assign->Student = $student;
				$teacher = new UserModel();
				$teacher->Id = $data[$i]->idProfesor;
				$teacher->FullName = $data[$i]->nombreProfesor;
				$assign->Teacher = $teacher;
				$quiz = new QuizzeModel();
				$quiz->Id = $data[$i]->idCuestionario;
				$quiz->Name = $data[$i]->nombreCuestionario;
				$quiz->AttemptNumber = $data[$i]->numero_intento;
				$assign->Quiz = $quiz;
				$assign->Status = $data[$i]->estado;
				$assign->AttemptNumber = $data[$i]->numero_intento_realizado;
				$assign->Score = $data[$i]->calificacion;
				$assignations[$i] = $assign;
			}

			if (!empty($assignations))
				return $assignations;
			else
				return null;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getById($id) {

	}

	public static function getAssignationsByUser($idUser) { 
		try {
			$db = Database::getConnection();
			$sql = "select a.id, u.id as idUsuario, u.nombre as nombreUsuario, c.id as idCuestionario, 
					c.nombre as nombreCuestionario, a.estado, p.id as idProfesor, p.nombre as nombreProfesor,
					c.numero_intento,
					(select count(numero_intento) from rendir_cuestionario where 
						idAsignarCuestionario = a.id) as numero_intento_realizado,
					coalesce((select calificacion from rendir_cuestionario where idAsignarCuestionario = a.id order by id 
						desc limit 1),0) as calificacion
					from asignar_cuestionario a
					left join usuario u on u.id = a.idEstudiante
					left join cuestionario c on c.id = a.idCuestionario
					left join usuario p on p.id = c.idProfesor
					where a.estado = ?
					and u.id = ?
					order by c.nombre, u.nombre ";
			$data = $db->executeAll($sql, array("ACT",$idUser));
			for ($i = 0; $i < count($data); $i++) {
				$assign = new AssignQuizModel();
				$assign->Id = $data[$i]->id;
				$student = new UserModel();
				$student->Id = $data[$i]->idUsuario;
				$student->FullName = $data[$i]->nombreUsuario;
				$assign->Student = $student;
				$teacher = new UserModel();
				$teacher->Id = $data[$i]->idProfesor;
				$teacher->FullName = $data[$i]->nombreProfesor;
				$assign->Teacher = $teacher;
				$quiz = new QuizzeModel();
				$quiz->Id = $data[$i]->idCuestionario;
				$quiz->Name = $data[$i]->nombreCuestionario;
				$quiz->AttemptNumber = $data[$i]->numero_intento;
				$assign->Quiz = $quiz;
				$assign->Status = $data[$i]->estado;
				$assign->AttemptNumber = $data[$i]->numero_intento_realizado;
				$assign->Score = $data[$i]->calificacion;
				$assignations[$i] = $assign;
			}

			if (!empty($assignations))
				return $assignations;
			else
				return null;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data) {
		try {
			$assign = json_decode($data);
			$db = Database::getConnection();
			for ($i = 0; $i < count($assign->Students); $i++) {
				$sql = "select id from asignar_cuestionario where idEstudiante = ? and idCuestionario = ? and estado = ?";
				$exist = $db->execute($sql, array($assign->Students[$i]->Id,$assign->Quiz->Id,"ACT"));
				if (empty($exist)) {
					$sql = "insert into asignar_cuestionario (idEstudiante, idCuestionario, estado) values (?,?,?)";
					$db->execute($sql, array($assign->Students[$i]->Id,$assign->Quiz->Id,"ACT"));
				} 
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {

	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update asignar_cuestionario set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

}
?>