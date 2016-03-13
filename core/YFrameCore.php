<?php
	include ROOT_PATH.'core/Controller.php';
	include ROOT_PATH.'core/utilFunc.php';
	//简单路由
	@simpleRouter($_SERVER['PATH_INFO']);
	


	/**
	* router
	**/
	function simpleRouter($pathInfo){
		$routerArr = explode('/',$pathInfo);

		array_shift($routerArr);
		// var_dump($routerArr);
		@$action = ($routerArr[0] ? $routerArr[0] : 'index').'Controller.php';
		

		if(file_exists(ROOT_PATH.'controller/'.$action)){
			//router default index
			include ROOT_PATH.'controller/'.$action;
			@$class = ($routerArr[0] ? $routerArr[0] : 'index').'Controller';
			@$func = $routerArr[1] ? $routerArr[1] : 'index';
			$clazz =  new $class();
			if(null == $func || !method_exists($clazz,$func))
				$func = 'index';
			$clazz->$func();
		}else{
			// 404
			include ROOT_PATH.'controller/indexController.php';
			$class = 'indexController';
			$func = '_notFind';
			$clazz =  new $class();
			$clazz->$func();
		}
	}
	/**
	* config to json
	*/
	function _configValue($name,$file){
		$file = $file ? $file : DEFAULT_CONFIG;
		if(file_exists($file)){
			$config =  json_decode(file_get_contents($file),true);
			if($name)
				return $config[$name];
			else
				return $config;
		}
		return "";
	}

	function __autoload($className){
		$classMap = include ROOT_PATH . 'config/autoloadClass.php';
		if($classMap[$className] && file_exists($classMap[$className])){
			require_once($classMap[$className]);
		}
	}