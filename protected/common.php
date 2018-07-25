<?php
	function page($pager,$url)
	{
		 
		if($pager)
		{
			$html="<span class='rows'>共 {$pager['total_count']}条记录, {$pager['current_page']}/{$pager['total_page']}页</span>";
			$pagestr="<li><a aria-label='Previous' href='{$url}{$pager['first_page']}'>首页</li>";
			$pagestr.="<li><a aria-label='Previous' href='{$url}{$pager['prev_page']}'>上一页</li>";
			foreach($pager['all_pages'] as $page)
			{
				if($page==$pager['current_page'])
				{
					$pagestr.="<li class='active'><span>' . $page . '</span></li>";
				}else
				{
					$pagestr.="<li><a  href='{$url}{$page}'>{$page}</li>";
				}
			}
			$pagestr.="<li><a aria-label='Next' href='{$url}{$pager['next_page']}'>下一页</li>";
			$pagestr.="<li><a aria-label='Next' href='{$url}{$pager['last_page']}'>尾页</li>";
			return $html."<nav><ul class='pagination pagination-lg'>{$pagestr}</ul></nav>";
		} 
	}
	function returnJson($data)
	{
		 header('Content-type: application/json'); 
		 echo json_encode($data);
		 exit;
	}
	function C($k,$v=null)
	{
		$tab=new T_web_config();
		return $tab->data($k,$v);
	}
	function session($key,$value=null)
	{
		if($value==null)
		{
			return isset($_SESSION[$key])?$_SESSION[$key]:null;
		}else{
			$_SESSION[$key]=$value;
		}
	}
	function cookie($key,$value=null,$time=0)
	{
		$key='jiguangserver_'.$key;
		if($value==null)
		{
			return isset($_COOKIE[$key])?$_COOKIE[$key]:null;
		}elseif($time==0)
		{
			$_COOKIE[$key]=$value;
		}else{
			setcookie($key, $value, $time);
		}
	}
	function sessionClear()
	{
		session_destroy();
	}
	function cookieClear()
	{
		foreach ($_COOKIE as $key => $value) {
			setcookie($key, null);
		}
	}
	function request($key)
	{
		static $request;
		if($request==null)
		{
			$request=array(
				'url'=>'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
				'ip'=>ip(),
				);
		}
		return $request[$key];
	}
    function ip() {
		//strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : ''; 
	}