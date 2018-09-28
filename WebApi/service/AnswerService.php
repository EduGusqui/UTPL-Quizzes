<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/AnswerModel.php");
require_once("WebApi/model/QuestionModel.php");

class AnswerService implements IBaseService {
	
	public static function getAll() {
		try {
			$db = Database::getConnection();
			$sql = "select r.id, r.descripcion, r.estado, r.correcta, p.id as idPregunta,
					p.descripcion as descripcionPregunta 
					from respuesta r
					left join pregunta p on p.id = r.idPregunta
					where r.estado = ?";

			$data = $db->executeAll($sql,array("ACT"));
			for($i = 0; $i < count($data); $i++) {
				$answer = new AnswerModel();
				$answer->Id = $data[$i]->id;
				$answer->Description = $data[$i]->descripcion;
				$answer->Correct = $data[$i]->correcta;
				$answer->Status = $data[$i]->estado;
				$question = new QuestionModel();
				$question->Id = $data[$i]->idPregunta;
				$question->Description = $data[$i]->descripcionPregunta;
				$answer->Question = $question;
				$answers[$i] = $answer;
			}

			if (!empty($answers)) 
				return $answers;
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
			$sql = "select r.id, r.descripcion, r.estado, r.correcta, p.id as idPregunta,
					p.descripcion as descripcionPregunta
					from respuesta r
					where r.id = ? and r.estado = ?";
			$data = $db->execute($sql,array($id, "ACT"));
			if (!empty($data)) {
				$answer = new AnswerModel();
				$answer->Id = $data->id;
				$answer->Description = $data->descripcion;
				$answer->Correct = $data->correcta;
				$answer->Status = $data->estado;
				$question = new QuestionModel();
				$question->Id = $data->idPregunta;
				$question->Description = $data->descripcionPregunta;
				$answer->Question = $question;

				return $answer;
			} else {
				return null;
			}
		}
		catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function getByQuestionId($idQuestion) {
		try {
			$db = Database::getConnection();
			$sql = "select r.id, r.descripcion, r.estado, r.correcta, p.id as idPregunta,
					p.descripcion as descripcionPregunta
					from respuesta r
					left join pregunta p on p.id = r.idPregunta
					where r.estado = ?
					and r.idPregunta = ?";
			$data = $db->executeAll($sql,array("ACT",$idQuestion));
			for($i = 0; $i < count($data); $i++) {
				$answer = new AnswerModel();
				$answer->Id = $data[$i]->id;
				$answer->Description = $data[$i]->descripcion;
				$answer->Correct = $data[$i]->correcta;
				$answer->Status = $data[$i]->estado;
				$question = new QuestionModel();
				$question->Id = $data[$i]->idPregunta;
				$question->Description = $data[$i]->descripcionPregunta;
				$answer->Question = $question;
				$answers[$i] = $answer;
			}

			if (!empty($answers)) {
				return $answers;
			} else {
				return null;
			}
		}
		catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function create($data) {
		try {
			$db = Database::getConnection();
			$answers = json_decode($data);
			foreach ($answers as $answer) {
				$sql = "insert into respuesta (descripcion,correcta,estado,idPregunta) values (?,?,?,?)";
				$db->execute($sql, array($answer->Description,$answer->Correct,"ACT",$answer->Question->Id));
			}
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {
		try {
			$db = Database::getConnection();
			$answers = json_decode($data);
			foreach ($answers as $answer) {
				$sql = "update respuesta set descripcion=?,correcta=?,idPregunta=? where id=?";
				$db->execute($sql, array($answer->Description,$answer->Correct,$answer->Question->Id,$answer->Id));
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function delete($idQuestion) {
		try {
			$db = Database::getConnection();
			$sql = "update respuesta set estado=? where idPregunta=?";
			$db->execute($sql, array("INA",$idQuestion));
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}
} 
?>