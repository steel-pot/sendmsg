<?php
class AdminLoginLog extends model{
	var $table_name='admin_login_log';
	function addLog($username,$password,$userid,$ip,$result)
	{
		$this->create(array('username'=>$username,'userid'=>$userid,'ip'=>$ip,'result'=>$result,'password'=>$password));
	}
}