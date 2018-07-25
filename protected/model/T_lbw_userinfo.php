<?php
class T_lbw_userinfo extends model{
	var $table_name='lbw_userinfo';
	function login($username,$password)
	{
		return $this->find(array('account'=>$username,'password'=>md5($password),'status'=>0));
	}
	function loginForToken($token)
	{
		return $this->find(array('token'=>$token,'status'=>0));
	}
}