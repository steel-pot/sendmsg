<?php
class LoginModel extends model{
	var $table_name='admin_user';
	function editPass($oldpass,$newpass)
	{	
		$userinfo=session('userinfo'); 
		$password=md5(md5($oldpass));
		$row=$this->find(array('username'=>$userinfo['username'],'password'=>$password));
		if(!$row)
		{
			return  '旧密码错误';
		}
		$this->update(array('username'=>$userinfo['username']),array('password'=>md5(md5($newpass))));
		return 1;
	}
	 function checkLogin()
	{
		//检查session登陆状态
		$userinfo=session('userinfo');
		if($userinfo)
		{
			//检查帐号密码是否修改,如果修改退出登陆
			$row=$this->find(array('username'=>$userinfo['username'],'password'=>$userinfo['password'],'token'=>$userinfo['token'],'state'=>0));
			if($row)
			{
				session('userinfo',$row);
				return true;
			}else{
				$this->logout();
				return false;
			}
		}
		
		//使用cookie登陆
		$token=cookie('token');
		if($token){
			$row=$this->find(array('token'=>$token,'state'=>0));
			if($row&&strtotime($row['tokenexpire'])>time())
			{
				session('userinfo',$row);
				//添加一条登陆记录
				$log=new AdminLoginLog();
				$log->addLog('','',$row?$row['id']:0,request('ip'),'token登陆');
				return true;
			} 
			$this->logout();
		}
		
		return false;
	}	
	
	function login($username,$password,$remember)
	{
		$log=new AdminLoginLog();
		$row=$this->find(array('username'=>$username));
		if($row&&$row['err']>20)
		{
			return array('result'=>3,'info'=>'错误次数过多,请与管理员联系!');
		}
		if(!$row||$row['password']!=md5(md5($password)))
		{ 
			if($row)
			{
				$this->incr(array('id'=>$row['id']),'err');
			}
			$log->addLog($username,$password,$row?$row['id']:0,request('ip'),'验证失败');
			return array('result'=>0,'info'=>'用户名或者密码错误!');
		}
		if($row['state']!='0')
		{
			$log->addLog($username,$password,$row?$row['id']:0,request('ip'),'帐号被禁用');
			return array('result'=>2,'info'=>'帐号被禁用,请与管理员联系!');
		}
		//创建token和过期时间 过期时间对cookie有效,对session无效
		$tokenexpire=date('Y-m-d H:i:s',strtotime('+7 day'));
		$token=md5($username.$password.time());
		$row['token']=$token;
		$row['tokenexpire']=$tokenexpire;
		$this->update(array('id'=>$row['id']),array('token'=>$token,'tokenexpire'=>$tokenexpire));
		//如果登陆成功,保存session 
		session('userinfo',$row);
		if($remember=='1')
		{
			cookie('token', $token, time()+60*60*24*7);
		}
		$log->addLog($username,'',$row?$row['id']:0,request('ip'),'登陆成功');
		return array('result'=>1,'info'=>'登陆成功!'); 
	}
	
	function logout()
	{
		sessionClear(); 
		cookieClear();
	}
}