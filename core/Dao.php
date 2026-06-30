<?php

namespace core;

use \PDO, \PDOStatement, \PDOException;

/**
 * 数据访问对象（DAO）
 *
 * 封装 PDO 连接和数据库操作：
 * - 自动连接配置（支持多种驱动）
 * - dao_query / dao_exec 基本查询
 * - prepare / execute 预处理（防 SQL 注入）
 * - 自动参数类型绑定（int/bool/null/string）
 * - 异常捕获和日志记录
 */
class Dao{
	//属性
	private $pdo;
	private $fetch_mode;

	//构造方法
	public function __construct($info = array(),$drivers = array()){
		$type = $info['type'] ?? 'mysql';
		$host = $info['host'] ?? 'localhost';
		$port = $info['port'] ?? '3306';
		$user = $info['user'] ?? 'root';
		$pass = $info['pass'] ?? 'root';
		$dbname = $info['dbname'] ?? 'my_database';
		$charset = $info['charset'] ?? 'utf8';
		$this->fetch_mode = $info['fetch_mode'] ?? PDO::FETCH_ASSOC;

		//驱动控制：异常模式处理
    	$drivers[PDO::ATTR_ERRMODE] = $drivers[PDO::ATTR_ERRMODE] ?? PDO::ERRMODE_EXCEPTION;


    	//实例化PDO对象
    	try{
    		$this->pdo = @new PDO($type . ':host=' . $host . ';port=' . $port . ';dbname=' . $dbname,$user,$pass,$drivers);
    	}catch(PDOException $e){
    		echo '连接错误！<br/>';
	        echo '错误文件为：' . $e->getFile() . '<br/>';
	        echo '错误行号为：' . $e->getLine() . '<br/>';
	        echo '错误描述为：' . $e->getMessage();
	        die();
    	}

    	//设定字符集
    	try{
    		$this->pdo->exec("set names {$charset}");
    	}catch(PDOException $e){
	        //调用异常处理方法
	        $this->dao_exception($e);
    	}
	}

	//SQL执行错误的异常处理
	private function dao_exception(PDOException $e){
		// 记录错误日志
		$this->logError($e->getMessage());

		// 根据调试模式决定是否显示错误信息
		if (defined('APP_DEBUG') && APP_DEBUG === true) {
			echo 'SQL执行错误！<br/>';
		    echo '错误文件为：' . $e->getFile() . '<br/>';
		    echo '错误行号为：' . $e->getLine() . '<br/>';
		    echo '错误描述为：' . $e->getMessage();
		    die();
		}

		die('数据库错误，请稍后重试');
	}

	// 记录错误日志
	private function logError($message)
	{
		$logDir = dirname(dirname(__DIR__)) . '/logs';
		if (!is_dir($logDir)) {
			@mkdir($logDir, 0755, true);
		}

		$logFile = $logDir . '/error_' . date('Y-m-d') . '.log';
		$logMessage = date('Y-m-d H:i:s') . ' - SQL ERROR: ' . $message . PHP_EOL;
		@file_put_contents($logFile, $logMessage, FILE_APPEND);
	}

	//写方法
	public function dao_exec($sql){
		//执行
		try{
			return $this->pdo->exec($sql);
		}catch(PDOException $e){
			$this->dao_exception($e);
		}
	}

	//获取自增长ID
	public function dao_insert_id(){
		return $this->pdo->lastInsertId();
	}

	//读方法：二合一（一条和多条，默认一条）
	public function dao_query($sql,$all = false){
		try{
			$stmt = $this->pdo->query($sql);

			//设置fetch_mode
			$stmt->setFetchMode($this->fetch_mode);

			//解析数据
			if(!$all){
				//考虑到可能查不到有效结果，要进行异常处理
				return $stmt->fetch();
			}else{
				return $stmt->fetchAll();
			}

		}catch(PDOException $e){
			$this->dao_exception($e);
		}
	}

	// 预处理查询（防SQL注入）
	public function prepare($sql, $params = [], $all = false){
		try{
			$stmt = $this->pdo->prepare($sql);
			$this->bindParams($stmt, $params);
			$stmt->execute();
			$stmt->setFetchMode($this->fetch_mode);
			return $all ? $stmt->fetchAll() : $stmt->fetch();
		}catch(PDOException $e){
			$this->dao_exception($e);
		}
	}

	// 预处理执行（用于增删改）
	public function execute($sql, $params = []){
		try{
			$stmt = $this->pdo->prepare($sql);
			$this->bindParams($stmt, $params);
			return $stmt->execute();
		}catch(PDOException $e){
			$this->dao_exception($e);
		}
	}

	private function bindParams($stmt, $params)
	{
		foreach ($params as $key => $value) {
			if (is_int($value)) {
				$stmt->bindValue(is_int($key) ? $key + 1 : $key, $value, PDO::PARAM_INT);
			} elseif (is_bool($value)) {
				$stmt->bindValue(is_int($key) ? $key + 1 : $key, $value, PDO::PARAM_BOOL);
			} elseif (is_null($value)) {
				$stmt->bindValue(is_int($key) ? $key + 1 : $key, $value, PDO::PARAM_NULL);
			} else {
				$stmt->bindValue(is_int($key) ? $key + 1 : $key, $value, PDO::PARAM_STR);
			}
		}
	}
}
