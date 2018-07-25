<?php
class LoginController extends Controller{
	 
	function init(){
		header("Content-type: text/html; charset=utf-8");
	}
	 
	function actionIndex()
	{
		$from=arg('from');
		$this->from=$from?urldecode($from):url('admin/main','index');
		//如果已经登陆了,则不再显示登陆界面
		$login=new LoginModel();
		if($login->checkLogin())
		{
			header('Location:'.$from);
			exit;
		}
	}
	function actionLogin_ajax()
	{
		$username=arg('username');
		$password=arg('password');
		$remember=arg('remember');
		$login=new LoginModel();
		echo json_encode( $login->login($username,$password,$remember));
	}
    function actionLogout()
	{
		$login=new LoginModel();
		$login->logout();
		header('Location:'.url('admin/main'));
	}
} 