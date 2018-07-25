<?php


if($GLOBALS['debug']){
	error_reporting(-1);
	ini_set("display_errors", "On");
}else{
	error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
	ini_set("display_errors", "Off");
	ini_set("log_errors", "On");
}

if((!empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == "https") || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)){
	$GLOBALS['http_scheme'] = 'https://';
}else{
	$GLOBALS['http_scheme'] = 'http://';
}

if(!empty($GLOBALS['rewrite'])){
	foreach($GLOBALS['rewrite'] as $rule => $mapper){
		if('/' == $rule)$rule = '/$';
		if(0!==stripos($rule, $GLOBALS['http_scheme']))
			$rule = $GLOBALS['http_scheme'].$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER["SCRIPT_NAME"]), '/\\') .'/'.$rule;
		$rule = '/'.str_ireplace(array('\\\\', $GLOBALS['http_scheme'], '/', '<', '>',  '.'), 
			array('', '', '\/', '(?P<', '>[-\w]+)', '\.'), $rule).'/i';
		if(preg_match($rule, $GLOBALS['http_scheme'].$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $matchs)){
			$route = explode("/", $mapper);
			
			if(isset($route[2])){
				list($_GET['m'], $_GET['c'], $_GET['a']) = $route;
			}else{
				list($_GET['c'], $_GET['a']) = $route;
			}
			foreach($matchs as $matchkey => $matchval){
				if(!is_int($matchkey))$_GET[$matchkey] = $matchval;
			}
			break;
		}
	}
}

$_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
$__module     = isset($_REQUEST['m']) ? strtolower($_REQUEST['m']) : '';
$__controller = isset($_REQUEST['c']) ? strtolower($_REQUEST['c']) : 'main';
$__action     = isset($_REQUEST['a']) ? strtolower($_REQUEST['a']) : 'index';

spl_autoload_register('inner_autoload');
function inner_autoload($class){
	GLOBAL $__module;
	$class = str_replace("\\","/",$class);
	foreach(array('model', 'include', 'controller'.(empty($__module)?'':DS.$__module)) as $dir){
		$file = APP_DIR.DS.'protected'.DS.$dir.DS.$class.'.php';
		if(file_exists($file)){
			include $file;
			return;
		}
		$phpfiles = glob(APP_DIR.DS.'protected'.DS.$dir.DS.'*.php');
		if(is_array($phpfiles)){
			$lowerfile = strtolower($file);
			foreach($phpfiles as $file){
				if(strtolower($file) === $lowerfile){
					include $file;
					return;
				}
			}
		}
	}
}

$controller_name = $__controller.'Controller';
$action_name = 'action'.$__action;

if(!empty($__module)){
	if(!is_available_classname($__module))_err_router("Err: Module '$__module' is not correct!");
	if(!is_dir(APP_DIR.DS.'protected'.DS.'controller'.DS.$__module))_err_router("Err: Module '$__module' is not exists!");
}
if(!is_available_classname($__controller))_err_router("Err: Controller '$controller_name' is not correct!");
if(!class_exists($controller_name, true))_err_router("Err: Controller '$controller_name' is not exists!");
if(!method_exists($controller_name, $action_name))_err_router("Err: Method '$action_name' of '$controller_name' is not exists!");

$controller_obj = new $controller_name();
$controller_obj->$action_name();

if($controller_obj->_auto_display){
	$auto_tpl_name = (empty($__module) ? '' : $__module.DS).$__controller.'_'.$__action.'.html';
	if(file_exists(APP_DIR.DS.'protected'.DS.'view'.DS.$auto_tpl_name))$controller_obj->display($auto_tpl_name);
}