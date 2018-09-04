<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/QuestionModel.php");
require_once("WebApi/model/QuizzeModel.php");
require_once("WebApi/model/QuestionTypeModel.php");
require_once("WebApi/model/AnswerModel.php");

class QuestionService implements IBaseService {
	
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select p.id, p.descripcion, p.estado, c.id as idCuestionario, c.nombre as nombreCuestionario,
				t.id as idTipoPregunta, t.nombre as nombrePregunta
				from pregunta p 
				left join cuestionario c on c.id = p.idCuestionario 
				left join tipo_pregunta t on t.id = p.idTipoPregunta 
				where p.estado = ?";
			$data = $db->executeAll($sql,array("ACT"));
			for($i = 0; $i < count($data); $i++) {
				$question = new QuestionModel();
				$question->Id = $data[$i]->id;
				$question->Description = $data[$i]->descripcion;
				$question->Status = $data[$i]->estado;

				$quizze = new QuizzeModel();
				$quizze->Id = $data[$i]->idCuestionario;
				$quizze->Name = $data[$i]->nombreCuestionario;
				$question->Quizze = $quizze;

				$questionType = new QuestionTypeModel();
				$questionType->Id = $data[$i]->idTipoPregunta;
				$questionType->Name = $data[$i]->nombrePregunta;
				$question->QuestionType = $questionType;

				$questions[$i] = $question;
			}
			
			if (!empty($questions))
				return $questions;
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
			$sql = "select p.id, p.descripcion, p.estado, c.id as idCuestionario, c.nombre as nombreCuestionario,
				t.id as idTipoPregunta, t.nombre as nombrePregunta
				from pregunta p 
				left join cuestionario c on c.id = p.idCuestionario 
				left join tipo_pregunta t on t.id = p.idTipoPregunta
				where p.id = ?
				and p.estado = ?";
			$data = $db->execute($sql,array($id, "ACT"));
			if (!empty($data)) {
				$question = new QuestionModel();
				$question->Id = $data->id;
				$question->Description = $data->descripcion;
				$question->Status = $data->estado;

				$quizze = new QuizzeModel();
				$quizze->Id = $data->idCuestionario;
				$quizze->Name = $data->nombreCuestionario;
				$question->Quizze = $quizze;

				$questionType = new QuestionTypeModel();
				$questionType->Id = $data->idTipoPregunta;
				$questionType->Name = $data->nombrePregunta;
				$question->QuestionType = $questionType;

				return $question;
			} else {
				return null;
			}
		}
		catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getByQuizzeId($id) {
		try {
			$db = Database::getConnection();
			$sql = "select p.id, p.descripcion, p.estado, c.id as idCuestionario, c.nombre as nombreCuestionario,
				t.id as idTipoPregunta, t.nombre as nombrePregunta
				from pregunta p 
				left join cuestionario c on c.id = p.idCuestionario 
				left join tipo_pregunta t on t.id = p.idTipoPregunta 
				where p.estado = ?
				and c.id = ?";
			$data = $db->executeAll($sql,array("ACT",$id));
			for($i = 0; $i < count($data); $i++) {
				$question = new QuestionModel();
				$question->Id = $data[$i]->id;
				$question->Description = $data[$i]->descripcion;
				$question->Status = $data[$i]->estado;

				$quizze = new QuizzeModel();
				$quizze->Id = $data[$i]->idCuestionario;
				$quizze->Name = $data[$i]->nombreCuestionario;
				$question->Quizze = $quizze;

				$questionType = new QuestionTypeModel();
				$questionType->Id = $data[$i]->idTipoPregunta;
				$questionType->Name = $data[$i]->nombrePregunta;
				$question->QuestionType = $questionType;
				
				$questions[$i] = $question;
			}
			
			if (!empty($questions))
				return $questions;
			else
				return null;
		}
		catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getByAssignation($idAssignation) {
		try {
			$db = Database::getConnection();
			$sql = "select p.id, p.descripcion, p.estado
				from pregunta p
				left join cuestionario c on c.id = p.idCuestionario
				left join asignar_cuestionario a on a.idCuestionario = c.id
				where a.id = ?
				and p.estado = 'ACT'";
			$data = $db->executeAll($sql,array($idAssignation));
			for($i = 0; $i < count($data); $i++) {
				$question = new QuestionModel();
				$question->Id = $data[$i]->id;
				$question->Description = $data[$i]->descripcion;
				$question->Status = $data[$i]->estado;
				$sql = "select id, descripcion, correcta from respuesta where idPregunta = ? and estado = 'ACT'";
				$resp = $db->executeAll($sql,array($question->Id));
				for($j = 0; $j < count($resp); $j++) {
					$answer = new AnswerModel();
					$answer->Id = $resp[$j]->id;
					$answer->Description = $resp[$j]->descripcion;
					$answer->Correct = $resp[$j]->correcta;
					$answers[$j] = $answer;
				}

				$question->Answers = $answers;
				$questions[$i] = $question;
			}
			
			if (!empty($questions))
				return $questions;
			else
				return null;
		}
		catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data) {
		try {
			$question = json_decode($data);
			$db = Database::getConnection();
			$sql = "insert into pregunta (descripcion,estado,idCuestionario,idTipoPregunta) values (?,?,?,?)";
			$db->execute($sql, array($question->Description,"ACT",$question->Quizze->Id,$question->QuestionType->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {
		try {
			$question = json_decode($data);
			$db = Database::getConnection();
			$sql = "update pregunta set descripcion=?,idCuestionario=?,idTipoPregunta=? where id=?";
			$db->execute($sql, array($question->Description,$question->Quizze->Id,$question->QuestionType->Id,$question->Id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function delete($id) {
		try {
			$db = Database::getConnection();
			$sql = "update pregunta set estado=? where id=?";
			$db->execute($sql, array("INA",$id));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}
} 
?>