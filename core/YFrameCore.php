<?php
include ROOT_PATH.'core/Controller.php';
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
