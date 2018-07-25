<?php
class BaseController extends Controller{
	public $layout = "admin/layout.html";
	var $mainMenu='main';
	var $subMenu='main';
	function init(){
		header("Content-type: text/html; charset=utf-8");
		$login=new LoginModel();
		if(!$login->checkLogin())
		{
			header('Location:'.url('admin/login','index',array('from'=>urlencode(request('url')))));
			exit;
		}
		$this->userinfo=session('userinfo');
		
		$this->userinfo=session('userinfo');
		
		$MenuModel=new MenuModel();
		$this->menus=$MenuModel->getMenu();
	}

    function tips($msg, $url){
    	$url = "location.href=\"{$url}\";";
		echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>function sptips(){alert(\"{$msg}\");{$url}}</script></head><body onload=\"sptips()\"></body></html>";
		exit;
    }
    function jump($url, $delay = 0){
        echo "<html><head><meta http-equiv='refresh' content='{$delay};url={$url}'></head><body></body></html>";
        exit;
    }
	
	//public static function err404($module, $controller, $action, $msg){
	//	header("HTTP/1.0 404 Not Found");
	//	exit;
	//}
} 