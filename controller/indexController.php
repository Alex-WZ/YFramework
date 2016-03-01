<?php

class indexController  extends Controller{

	function __construct(){
	}

	public function index(){
		$a = $this->_getParam('a');
		$b = $this->_getParam('b');
		$c = $this->_getParam('c');
		$this->_assign('p',$a.$b.$c);
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