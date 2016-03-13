<?php
class indexController  extends Controller{

	function __construct(){
	}

	public function index(){
		$ipAddresss = getRealIpAddr();
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		// $userService = new userService();
		// $recordResult = $userService->addUsrRecord();
		$this->_display('view/index.html');
	}

	public function indexPage(){
		echo "indexPage";
	}

	public function article(){
		echo "article";
	}

	public function resources(){
		echo "resources";
	}
	public function personal(){
		echo "personal";
	}
	public function others(){
		echo "others";
	}

}