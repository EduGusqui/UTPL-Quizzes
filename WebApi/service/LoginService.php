<?php
require_once("WebApi/model/Database.php");
require_once("WebApi/model/AuthenticateModel.php");
require_once("WebApi/service/AuthService.php");

class LoginService {

	public static function authenticate($data) {
		$db = Database::getConnection();
		$credentials = json_decode($data);
		$sql = "select u.id, u.nombre_usuario, r.id as idRol
					from usuario u
					left join rol r on r.id = u.idRol
					where u.nombre_usuario = ?
					and u.contrasenia = ?";
		$result = $db->execute($sql, array($credentials->Username,md5($credentials->Password)));
		if (!is_null($result)) {
			$authenticate = new AuthenticateModel();
			$authenticate->Id = $result->id;
			$authenticate->Username = $result->nombre_usuario;
			$authenticate->IdRol = $result->idRol;
			$token = AuthService::SignIn([
				'id' => $authenticate->Id,
				'name' => $authenticate->Username
			]);
			$authenticate->Token = $token;

			return $authenticate;
		}
	}
}

?>