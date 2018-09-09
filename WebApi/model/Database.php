<?php
require_once("WebApi/database/MySQLProvider.php");

class Database
{
	private $provider;
	private $params;
	private static $_con;
	private $user;
	private $pass;
	private $dbname;
	private $host;
	private $dbProvider;

	private function __construct() {
		$config = parse_ini_file("WebApi/config/config.ini");
		$this->user = $config["user"];
		$this->pass = $config["pass"];
		$this->dbname = $config["dbname"];
		$this->host = $config["host"];
		$this->dbProvider = $config["provider"];
		
		if(!class_exists($this->dbProvider)){
			throw new Exception("El proveedor especificado no ha sido implentado o añadido.");
		}
		$this->provider = new $this->dbProvider;
		$this->provider->connect($this->host, $this->user, $this->pass, $this->dbname);
		if(!$this->provider->isConnected()) {
			print("Connect failed: %s\n" . mysqli_connect_error());
		}
	}

	public static function getConnection(){
		if(self::$_con){
			return self::$_con;
		}
		else{
			$class = __CLASS__;
			self::$_con = new $class();
			return self::$_con;
		}
	}

	private function replaceParams($coincidencias){
		$b=current($this->params);
		next($this->params); 
		return $b;
	}

	private function prepare($sql, $params){
		for($i=0;$i<sizeof($params); $i++){
			if(is_bool($params[$i])){
				$params[$i] = $params[$i]? 1:0;
			}
			elseif(is_double($params[$i]))
				$params[$i] = str_replace(',', '.', $params[$i]);
			/*elseif(is_numeric($params[$i]))
				$params[$i] = $this->provider->escape($params[$i]);*/
			elseif(is_null($params[$i]))
				$params[$i] = "NULL";
			else
				$params[$i] = "'".$this->provider->escape($params[$i])."'";
		}
		
		$this->params = $params;
		$q = preg_replace_callback("/(\?)/i", array($this,"replaceParams"), $sql);
		
		return $q;
	}

	private function sendQuery($q, $params){
		$query = $this->prepare($q, $params);
		$result = $this->provider->query($query);
		if($this->provider->getErrorNo()){
			throw new Exception($this->provider->getError());
		}
		return $result;
	}

	public function executeScalar($q, $params=null){
		$result = $this->sendQuery($q, $params);
		if(!is_null($result)){
			if(!is_object($result)){
				return $result;
			}
			else{
				$row = $this->provider->fetchAll($result);
				return $row[0];
			}
		}
		return null;
	}

	public function executeAll($q, $params=null){
		$result = $this->sendQuery($q, $params);
		if(is_object($result)){
			$arr = array();
			while($row = $this->provider->fetchAll($result)){
				$arr[] = $row;
			}
			return $arr;
		}
		return null;
		
	}

	public function execute($q, $params=null){
		$result = $this->sendQuery($q, $params);
		if(is_object($result)){
			$obj = $this->provider->fetch($result);
			return $obj;
		}
		return null;
	}
}
?>