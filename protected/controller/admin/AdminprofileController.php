<?php
class AdminprofileController extends BaseController{ 
	 
	function actionIndex()
	{
		 
	}
	function actionEditpass()
	{
		 
	}
	function actionSavepass()
	{
		
		$oldpass=arg('oldpass');
		$newpass=arg('newpass');
		$renewpass=arg('renewpass');
		if($newpass=="")
		{
			returnJson(array('result'=>0,'msg'=>'新密码不能为空'));
		}
		if($newpass!=$renewpass)
		{
			returnJson(array('result'=>0,'msg'=>'两次输入的新密码不一致'));
		}
		$tab=new LoginModel();
		$rs=$tab->editPass($oldpass,$newpass); 
		if($rs!=1)
		{
			returnJson(array('result'=>0,'msg'=>$rs));
		}
		returnJson(array('result'=>1,'msg'=>'修改成功'));
	}
   
} 

