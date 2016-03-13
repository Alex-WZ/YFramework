<?php
/**
* pdo 基础数据库操作类
* @Y 2016.3.12
*/

class MyDBcore 
{
	
	private $pdo = null;

	function __construct(){
	}

	//get PDO obj
	private function getInstance()
	{
		if(!$this->pdo){
			try{
				$hostInfo = _configValue("dbtype") .":host=". _configValue("dbhost") . ";dbname=" . _configValue("dbname") . ";charset=utf8" ;
				$this->pdo = new PDO( $hostInfo,$_config["dbuser"],$_config["dbpasswd"]);
				$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			}catch(Exception $e){
				// print "Error!: " . $e->getMessage() . "<br/>";
				throw new Exception("error get db instance", 1);
				
			}
		}
		return $this->pdo;
	}

	//执行sql 不安全方式
	public function exec($sql){
		$PDO = $this->getInstance();
		$stmt = $PDO->prepare($prepareSql);
		$result = $stmt->execute();
		return $result;
	}

	//其他语句执行 采用绑定
	public function bindExec($prepareSql,$params){
		$PDO = $this->getInstance();
		try{
			$stmt = $PDO->prepare($prepareSql);
			foreach ($params as $key => $value) {
				$stmt->bindParam($key + 1, $value);
			}
			$result = $stmt->execute();
			$stmt = null;
		}catch(PDOException $e){
			throw new Exception("error insert db", 1);
		}	
		return $result;
	}

	//简单select查询，安全
	public function query($prepareSql,$param=array()){
		$PDO = $this->getInstance();
		if(empty($param)){
			try{
				$stmt = $PDO->prepare($prepareSql);
				$stmt->execute();
				while ($rs = $stmt->fetch()) {
					$result[] = $rs;
				}
			}catch(PDOException $e){
				throw new Exception("error query db", 1);
			}
		}else{
			try{
				$stmt = $PDO->prepare($prepareSql);
				$stmt->execute($param);
				while ($rs = $stmt->fetch()) {
					$result[] = $rs;
				}
				$stmt = null;
			}catch(PDOException $e){
				throw new Exception("error select db", 1);
			}
		}
		return $result;
	}

	//简单插入
	public function insert($table,$param){
		$PDO = $this->getInstance();
		if(!empty($param) && !empty($param)){
			 
			try{
				$stmt = $PDO->prepare($prepareSql);
				$result = $stmt->execute(array_values($param));
				$stmt = null;
			}catch(PDOException $e){
				throw new Exception("error insert db", 1);
			}
			return $result ? $PDO->lastInsertId() : $result ;
		}else{
			return false;
		}
	}
	//更新
	public function update($table,$setArr,$whereArr){
		$PDO = $this->getInstance();
		if(!empty($table) && !empty($setArr) && !empty($whereArr)){
			$params = array();
			$set = "";
			foreach ($setArr as $key => $value) {
				$set .= $key . " = ? ,";
				$params[] = $value;
				unset($key,$value); 
			}
			$setStr = substr($set, 0, -1);
			$where = "";
			foreach ($whereArr as $k => $val) {
				$where .= $k . " = ? AND ";
				$params[] = $val;
				unset($k,$val); 
			}
			$whereStr = substr($where, 0, -4);
			$prepareSql = "update {$table} set {$setStr} where {$whereStr}";
			try{
				$stmt = $PDO->prepare($prepareSql);
				foreach ($params as $idx => $v) {
					$stmt->bindParam($idx + 1,$v);
					unset($idx,$v);
				}
				$result = $stmt->execute();
				$stmt = null;
			}catch(PDOException $e){
				throw new Exception("error insert db", 1);
			}
			return $result ;
		}else{
			return false;
		}
	}
}