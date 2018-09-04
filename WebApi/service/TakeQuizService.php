<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/service/IBaseService.php");
require_once("WebApi/model/TakeQuizModel.php");


class TakeQuizService implements IBaseService {

	public static function getAll() {

	}

	public static function getById($id) {

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
		} catch (Exeption $e) {
			throw new Exception($e->getMessage());
		}
	}

	public static function update($data) {

	}

	public static function delete($id) {

	}

}
?>