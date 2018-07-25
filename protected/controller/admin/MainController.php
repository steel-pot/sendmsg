<?php
class MainController extends BaseController{ 
	 
	function actionIndex()
	{
		$keyword=arg('keyword','');
		$this->keyword=$keyword;
		//$page = (int)arg("p", 1);
		
		$tab=new model('sm_tmp');
		
		$where=null;
		if($keyword)
		{
			$where=array("p1 LIKE :keyword or p2 LIKE :keyword or p3 LIKE :keyword",':keyword'=>"%{$keyword}%");
		}
		
		$this->rows = $tab->findAll($where, "state DESC,id DESC", "*");
		$this->pager= null;
	}
	
	
	function actionSendmsg()
	{
		$id=arg('id');
		$tab=new model('sm_tmp'); 
		$row=$tab->find(array('id'=>$id));
		if(!$row)
		{
			echo '未找到记录';
			exit;
		}
		if($row['state']!='0')
		{
			echo '状态不正确，不发送';
			exit;
		}
		$content=C('msg_tpl');
		$p1=$row['p1'];
		$p2=$row['p2'];
		$p3=$row['p3'];
		$vcode=mt_rand(1000,9999);
		$p1=mb_substr($p1,0,3,'utf-8');
		$p2='*'.mb_substr($p2,-1,1,'utf-8');
		$content=str_replace('$p1',$p1,$content);
		$content=str_replace('$p2',$p2,$content); 
		$content=str_replace('$vcode',$vcode,$content);
		 
		
		$rs=$this->_sendmsg($p3,$content);  
	 
		//将记录移走
		$tab->delete(array('id'=>$id));
		$tab=new model('sm_history');
		$tab->create(array('p1'=>$row['p1'],'p2'=>$row['p2'],'p3'=>$row['p3'],'rs'=>$rs));
		echo $rs;
	}
	function _sendmsg($mobile,$content)
	{
		$fun='sendMsg'.C('msg_intid');
		return  MsgModel::$fun($mobile,$content);
	}
	
	function actionDelall()
	{
		$tab=new model('sm_tmp');
		$tab->execute('truncate table  sm_tmp');
		header('Location:'.url('admin/main','index'));
	}
	function actionSet()
	{
		$id=arg('id');
		$state=arg('state');
		$tab=new model('sm_tmp');
		$tab->update(array('id'=>$id),array('state'=>$state));
	}
	function actionDel()
	{
		$id=arg('id');
		$tab=new model('sm_tmp');
		$tab->delete(array('id'=>$id));
	}
	function _return($msg,$result=0,$data=array())
	{
	    header('Content-Type:application/json; charset=utf-8');
		echo json_encode(array('result'=>$result,'msg'=>$msg,'data'=>$data));
		exit;
	}
	
	function _import($upfile)
	{
		if(!file_exists($upfile))
		{
			$this->_return('导入失败，文件不存在！');
		}
		
		$file = fopen($upfile,'r'); 
		 
			$i=0;
			$h=false;
			$tab=new model('sm_tmp');
			$tabhistory=new model('sm_history');
			while ($data = fgetcsv($file)) {
				if(!$h)
				{
					$h=true;
					continue;
				}
				if(count($data)<3)
				{
					continue;
				}
				$p1=$data[0];
				$p2=$data[1];
				$p3=$data[2];
				$p1= iconv ( "GBK", "UTF-8//IGNORE",$p1);
				$p2= iconv ( "GBK", "UTF-8//IGNORE",$p2);
				
				$p3=str_replace(array(' ','-','+86','+'),'',$p3); 
				if($tab->findCount(array('p3'=>$p3))>0)
				{
					continue;
				}
				if(preg_match("/^1[34578]{1}\d{9}$/",$p3)){
					if($tabhistory->findCount(array('p3'=>$p3))>0) 
					{
						$state=1; 
					}else{
						$state=0; 
					}
				}else{
					$state=2; 
				}
				$tab->create(array('p1'=>$p1,'p2'=>$p2,'p3'=>$p3,'state'=>$state));
				$i++;
			}  
		fclose($file); 
		unlink($upfile); 
		$this->_return('导入成功！共导入'.$i.'条数据',1);
	}
	
	function actionUpload()
	{
		set_time_limit(0);
		if(!isset($_FILES['file']))
		{
			$this->_return('上传文件失败！');
		}
		$upfile=$_FILES['file'];
		
		if ($upfile["error"] > 0)
		{  
			$this->_return('上传文件失败！'.$upfile["error"]);
		}
				
		$ext=explode('.',$upfile["name"]);
		$ext=$ext[count($ext)-1];
		$ext=strtolower($ext);
		if($ext!='csv')
		{
			$this->_return('上传文件失败，只支持csv格式！');
		}
		if($upfile["size"] > 5*1024*1024)
		{
			$this->_return('上传文件失败，文件大小超过5M！');
		}
		if(!file_exists(APP_DIR.'/protected/tmp/'))
		{
			mkdir(APP_DIR.'/protected/tmp/');
		}
		$newfile=APP_DIR.'/protected/tmp/'.md5($_FILES["file"]["tmp_name"]).'.csv';
		if(move_uploaded_file($_FILES["file"]["tmp_name"],$newfile))
		{
			$this->_import($newfile);
			
		}else{
			$this->_return('上传文件失败，移动文件失败，原因未知！');
		}
	}
} 