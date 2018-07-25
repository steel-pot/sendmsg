<?php
class HistoryController extends BaseController{ 
	 var $mainMenu='history';
	var $subMenu='';
	function actionIndex()
	{
		$keyword=arg('keyword','');
		$this->keyword=$keyword;
		$page = (int)arg("p", 1);
		
		$tab=new model('sm_history');
		
		$where=null;
		if($keyword)
		{
			$where=array("p1 LIKE :keyword or p2 LIKE :keyword or p3 LIKE :keyword or rs LIKE :keyword",':keyword'=>"%{$keyword}%");
		}
		
		$this->rows = $tab->findAll($where, "id DESC", "*",array($page, 10));
		$this->pager= $tab->page;
	} 
	  
	
	function actionDelall()
	{
		$tab=new model('sm_history');
		$tab->execute('truncate table  sm_history');
		header('Location:'.url('admin/history','index'));
	}
	 
	function actionDel()
	{
		$id=arg('id');
		$tab=new model('sm_history');
		$tab->delete(array('id'=>$id));
	} 
} 