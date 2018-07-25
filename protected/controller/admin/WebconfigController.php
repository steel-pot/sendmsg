<?php
class WebconfigController extends BaseController{ 
    var $mainMenu='systemconfig';
	var $subMenu='chatconfig';
	function actionIndex()
	{
		$tab=new model('web_config');
		if(count($_POST)>0)
		{
			foreach($_POST as $k=>$v)
			{
				$tab->update(array('name'=>$k),array('value'=>$v));
			}
		}
		$this->rows=$tab->findAll();
	}
   
} 