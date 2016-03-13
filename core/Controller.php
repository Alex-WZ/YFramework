<?php
/**
* 控制器基类
*/
class Controller 
{
	protected $tplParams =array();

	function __construct()
	{
	}

	public function _notFind(){
		echo "404";
	}

	/**
	* 参数获取
	**/
	protected function _getParam($paramKey,$filterHtmlEntities=false){
		$params = array_merge($_GET,$_POST,$_REQUEST);
		foreach ($params as $key => $paramValue) {
			if($filterHtmlEntities==true){
				htmlentities($params[$key]);
				htmlentities($params[$paramValue]);
			}
			strip_tags($params[$key]);
			strip_tags($params[$paramValue]);
			unset($key,$paramValue);
		}
		return $params[$paramKey];
	}

	/**
	* 	模版变量赋值
	**/
	protected function _assign($paramKey,$paramValue){
		$this->tplParams[$paramKey] = $paramValue;
	}

	/**
	*   模版展示
	**/
	protected function _display($htmlFilePath,$charset='',$contentType='',$cacheControl=''){
		if(file_exists(ROOT_PATH.$htmlFilePath)){
			$content = file_get_contents(ROOT_PATH.$htmlFilePath);
			$content = preg_replace('#\{(\$\w+)\}#', '<?php echo $1;?>', $content);
			ob_start();
			extract($this->tplParams, EXTR_OVERWRITE);
			// include $htmlFilePath;
			eval('?>'.$content);
			$content = ob_get_clean();
			if(empty($charset))  $charset = 'utf-8';
			if(empty($contentType)) $contentType = 'text/html';
	        // 网页字符编码
			header('Content-Type:'.$contentType.'; charset='.$charset);
	        header('Cache-control: '.$cacheControl);  // 页面缓存控制
	        header('X-Powered-By:YFrame');
	        // 输出模板文件
	        echo $content;
	    }
	    else
	    {
	    	throw new Exception("page not exists", 1);
	    }
	}

	protected function getUserIdFromCookie(){}
}