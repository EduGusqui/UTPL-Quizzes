<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/TakeQuizModel.php");
require_once("WebApi/model/AssignQuizModel.php");
require_once("WebApi/model/UserModel.php");
require_once("WebApi/model/QuestionModel.php");
require_once("WebApi/model/QuizzeModel.php");
require_once("WebApi/model/CourseModel.php");
require_once("WebApi/model/TakeQuizDetailModel.php");

class TakeQuizService implements IBaseService {

	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select u.id as idUsuario, u.nombre as nombreUsuario, c.id as idCuestionario, 
					c.nombre as nombreCuestionario, cu.id as idCurso, cu.nombre as nombreCurso, r.numero_intento, r.calificacion
					from rendir_cuestionario r
					left join asignar_cuestionario a on a.id = r.idAsignarCuestionario
					left join cuestionario c on c.id = a.idCuestionario
					left join curso cu on cu.id = c.idCurso
					left join usuario u on u.id = a.idEstudiante";
			$data = $db->executeAll($sql);
			for ($i = 0; $i < count($data); $i++) {
				$takeQuiz = new TakeQuizModel();
				$takeQuiz->AssignQuiz = new AssignQuizModel();
				$takeQuiz->AssignQuiz->Student = new UserModel();
				$takeQuiz->AssignQuiz->Student->Id = $data[$i]->idUsuario;
				$takeQuiz->AssignQuiz->Student->FullName = $data[$i]->nombreUsuario;
				$takeQuiz->Questions = new QuestionModel();
				$takeQuiz->Questions->Quiz = new QuizzeModel();
				$takeQuiz->Questions->Quiz->Id = $data[$i]->idCuestionario;
				$takeQuiz->Questions->Quiz->Name = $data[$i]->nombreCuestionario;
				$takeQuiz->Questions->Quiz->Course = new CourseModel();
				$takeQuiz->Questions->Quiz->Course->Id = $data[$i]->idCurso;
				$takeQuiz->Questions->Quiz->Course->Name = $data[$i]->nombreCurso;
				$takeQuiz->AttempNumber = $data[$i]->numero_intento;
				$takeQuiz->Score = $data[$i]->calificacion;
				$takeQuizzes[$i] = $takeQuiz;
			}

			if (!empty($takeQuizzes))
				return $takeQuizzes;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getById($id) {
		try {
			$db = Database::getConnection();
			$sql = "select u.id as idUsuario, u.nombre as nombreUsuario, c.id as idCuestionario, 
					c.nombre as nombreCuestionario, cu.id as idCurso, cu.nombre as nombreCurso, r.numero_intento, r.calificacion,
					a.id as idAsignarCuestionario
					from rendir_cuestionario r
					left join asignar_cuestionario a on a.id = r.idAsignarCuestionario
					left join cuestionario c on c.id = a.idCuestionario
					left join curso cu on cu.id = c.idCurso
					left join usuario u on u.id = a.idEstudiante
					where r.id = ?";
			$data = $db->execute($sql, array($id));
			if (!empty($data)) {
				$takeQuiz = new TakeQuizModel();
				$takeQuiz->AssignQuiz = new AssignQuizModel();
				$takeQuiz->AssignQuiz->Id = $data->idAsignarCuestionario;
				$takeQuiz->AssignQuiz->Student = new UserModel();
				$takeQuiz->AssignQuiz->Student->Id = $data->idUsuario;
				$takeQuiz->AssignQuiz->Student->FullName = $data->nombreUsuario;
				$takeQuiz->Questions = new QuestionModel();
				$takeQuiz->Questions->Quiz = new QuizzeModel();
				$takeQuiz->Questions->Quiz->Id = $data->idCuestionario;
				$takeQuiz->Questions->Quiz->Name = $data->nombreCuestionario;
				$takeQuiz->Questions->Quiz->Course = new CourseModel();
				$takeQuiz->Questions->Quiz->Course->Id = $data->idCurso;
				$takeQuiz->Questions->Quiz->Course->Name = $data->nombreCurso;
				$takeQuiz->AttempNumber = $data->numero_intento;
				$takeQuiz->Score = $data->calificacion;
				return $takeQuiz;
			} else {
				return null;
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getTakeByStudent($idStudent) {
		try {
			$db = Database::getConnection();
			$sql = "select r.id, u.id as idUsuario, u.nombre as nombreUsuario, c.id as idCuestionario, 
					c.nombre as nombreCuestionario, cu.id as idCurso, cu.nombre as nombreCurso, r.numero_intento, r.calificacion,
					a.id as idAsignarCuestionario
					from rendir_cuestionario r
					left join asignar_cuestionario a on a.id = r.idAsignarCuestionario
					left join cuestionario c on c.id = a.idCuestionario
					left join curso cu on cu.id = c.idCurso
					left join usuario u on u.id = a.idEstudiante
					where a.idEstudiante = ?
					order by r.id desc limit 1";
			$data = $db->executeAll($sql, array($idStudent));
			for ($i = 0; $i < count($data); $i++) {
				$takeQuiz = new TakeQuizModel();
				$takeQuiz->Id = $data[$i]->id;
				$takeQuiz->AssignQuiz = new AssignQuizModel();
				$takeQuiz->AssignQuiz->Id = $data[$i]->idAsignarCuestionario;
				$takeQuiz->AssignQuiz->Student = new UserModel();
				$takeQuiz->AssignQuiz->Student->Id = $data[$i]->idUsuario;
				$takeQuiz->AssignQuiz->Student->FullName = $data[$i]->nombreUsuario;
				$takeQuiz->Questions = new QuestionModel();
				$takeQuiz->Questions->Quiz = new QuizzeModel();
				$takeQuiz->Questions->Quiz->Id = $data[$i]->idCuestionario;
				$takeQuiz->Questions->Quiz->Name = $data[$i]->nombreCuestionario;
				$takeQuiz->Questions->Quiz->Course = new CourseModel();
				$takeQuiz->Questions->Quiz->Course->Id = $data[$i]->idCurso;
				$takeQuiz->Questions->Quiz->Course->Name = $data[$i]->nombreCurso;
				$takeQuiz->AttempNumber = $data[$i]->numero_intento;
				$takeQuiz->Score = $data[$i]->calificacion;
				$takeQuizzes[$i] = $takeQuiz;
			}

			if (!empty($takeQuizzes))
				return $takeQuizzes;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getTakeDetailsByTakeId($idTakeQuiz) {
		try {
			$db = Database::getConnection();
			$sql = "select id, id_pregunta, id_respuesta, id_rendir_cuestionario
					from rendir_cuestionario_detalle
					where id_rendir_cuestionario = ?";
			$data = $db->executeAll($sql, array($idTakeQuiz));
			for ($i = 0; $i < count($data); $i++) {
				$takeQuizDetail = new TakeQuizDetailModel();
				$takeQuizDetail->Id = $data[$i]->id;
				$takeQuizDetail->IdQuestion = $data[$i]->id_pregunta;
				$takeQuizDetail->IdAnswer = $data[$i]->id_respuesta;
				$takeQuizDetail->IdTakeQuiz = $data[$i]->id_rendir_cuestionario;
				$takeQuizDetails[$i] = $takeQuizDetail;
			}

			if (!empty($takeQuizDetails))
				return $takeQuizDetails;
			else
				return null;
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data) {
		try {
			$takeQuiz = json_decode($data);
			$db = Database::getConnection();
			$correctAnswer = 0;
			$errors = 0;
			for ($i = 0; $i < count($takeQuiz->Questions); $i++) {
				for ($j = 0; $j < count($takeQuiz->Questions[$i]->Answers); $j++) {
					if ($takeQuiz->Questions[$i]->Answers[$j]->Correct == 1) {
						$correctAnswer = $takeQuiz->Questions[$i]->Answers[$j]->Id;
						break;
					}
				}

				if ($takeQuiz->Questions[$i]->AnswerSelected != $correctAnswer) {
					$errors = $errors + 1;
				}
			}

			$calificacion = 20;
			$score = ((count($takeQuiz->Questions) - $errors) * $calificacion) / count($takeQuiz->Questions);
			$sql = "select count(numero_intento) from rendir_cuestionario where idAsignarCuestionario = ?";
			$attempNumber = $db->execute($sql, array($takeQuiz->AssignQuiz->Id));
			$attempNumber = is_null($attempNumber) ? 1 : 2;
			$sql = "insert into rendir_cuestionario (idAsignarCuestionario,numero_intento,calificacion) 
					values (?,?,?)";
			$db->execute($sql, array($takeQuiz->AssignQuiz->Id,$attempNumber,$score));
			$sql = "select id from rendir_cuestionario where idAsignarCuestionario = ? order by id desc limit 1";
			$quizTake = $db->execute($sql, array($takeQuiz->AssignQuiz->Id));
			
			for ($i = 0; $i < count($takeQuiz->Questions); $i++) {
				$sql = "insert into rendir_cuestionario_detalle (id_pregunta, id_respuesta, id_rendir_cuestionario)
					values (?,?,?)";
				$db->execute($sql, array($takeQuiz->Questions[$i]->Id,$takeQuiz->Questions[$i]->AnswerSelected,$quizTake->id));
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {
		try {
			$db = Database::getConnection();
			$takeQuiz = json_decode($data);
			$sql = "update rendir_cuestionario set idAsignarCuestionario = ?, numero_intento = ?,
					calificacion = ? where id=?";
			$db->execute($sql, array($takeQuiz->AssignQuiz->Id,$takeQuiz->AttempNumber,$takeQuiz->Score,$takeQuiz->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "delete from rendir_cuestionario where id=?";
			$db->execute($sql, array($id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}
}
?>