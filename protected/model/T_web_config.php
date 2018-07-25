<?php
class T_web_config extends model{
	var $table_name='web_config';
	function data($k,$v=null)
	{
		if($v==null)
		{
			$row=$this->find(array('name'=>$k));
			return $row?$row['value']:null;
		}else{
			$this->update(array('name'=>$k),array('value'=>$v));
		} 
	}
}