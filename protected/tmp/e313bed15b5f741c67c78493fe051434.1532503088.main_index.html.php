<?php if(!class_exists("View", false)) exit("no direct access allowed");?><link href="<?php echo I; ?>/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo I; ?>/plugins/bootstrap-table/bootstrap-table.min.js"></script>
 <div class="portlet light bordered">
 
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-social-dribbble font-dark hide"></i>
			<span class="caption-subject font-dark bold uppercase">短信批量发送</span>
		</div>
		 
		
	</div>
										
	<div class="portlet-body">
		<form id="formUpload" name="formUpload" enctype="multipart/form-data" method="post" action="" style="display:none">
		  <label for="file"></label>
		  <input type="file" name="file" id="file" onchange="upfile()" />
		</form>

		<form class="form-inline" method="post" action="<?php echo url(array('c'=>'admin/main', 'a'=>'index', ));?>">
		<div  class="form-group">
			<button class="btn btn-default" type="button" onclick="$('#file').trigger('click')">导入文件</button> 
			<button class="btn btn-success" type="button" onclick="beginsend(this)">开始发送</button>
			<a class="btn btn-warning" href="<?php echo url(array('c'=>'admin/main', 'a'=>'delall', ));?>" onclick="return confirmDelAll();">清空记录</a>
		</div>
		<div class="form-group">  <label  style="color:#c29d0b;">导入文件会自动去掉第一行，并且会验证手机号格式，不符合的会显示，但不会发送</label></div>
		<div class="form-group input-group col-xs-3" style="float:right">
				<input type="text" placeholder="手机号或用户名" class="form-control" name="keyword" value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, "UTF-8"); ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
					</button>
				</span>
		</div> 
		</form>
		<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-mytable">
                                <thead>
                                    <tr>
										<th>id</th>
                                        <th>目标姓名</th>
                                        <th>来源姓名</th>
										<th>手机号码</th> 		
										<th>记录状态</th>	
										<th>发送结果</th>
										<th>操作</th>										
                                    </tr>
                                </thead>
                                <tbody>
								<?php if (count($rows)>0) : ?>
									<?php if(!empty($rows)){ $_foreach_row_counter = 0; $_foreach_row_total = count($rows);?><?php foreach( $rows as $row ) : ?><?php $_foreach_row_index = $_foreach_row_counter;$_foreach_row_iteration = $_foreach_row_counter + 1;$_foreach_row_first = ($_foreach_row_counter == 0);$_foreach_row_last = ($_foreach_row_counter == $_foreach_row_total - 1);$_foreach_row_counter++;?>
									<tr class="odd gradeX" >
										<td id="id" ><?php echo htmlspecialchars($row['id'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php echo htmlspecialchars($row['p1'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php echo htmlspecialchars($row['p2'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php echo htmlspecialchars($row['p3'], ENT_QUOTES, "UTF-8"); ?></td>
										<td id="state" ><?php if ($row['state']==0) : ?>正常<?php elseif ($row['state']==1) : ?><span style="color:#f00">已存在</span><?php else : ?><span style="color:#f00">号码不正确</span><?php endif; ?></td> 
										<td id="rs"> </td>
										<td>
											<?php if ($row['state']!=0) : ?><button class="btn btn-default" onclick="setState(this,<?php echo htmlspecialchars($row['id'], ENT_QUOTES, "UTF-8"); ?>,0)">设为正常</button><?php endif; ?>
											<button class="btn btn-danger" onclick="del(this,<?php echo htmlspecialchars($row['id'], ENT_QUOTES, "UTF-8"); ?>)">删除</button>
										</td>	
									 </tr>
									 <?php endforeach; }?> 
								<?php else : ?>
								 <tr class="odd gradeX" >
									<td   colspan=7 style="text-align:center">暂无数据</td>
								 </tr>
								 <?php endif; ?>
								</tbody>
							</table>
						<div style="float:right;"><?php echo page($pager,url('admin/main','index',array('keyword'=>$keyword,'p'=>'')));?>	</div>						
		<div class="clearfix"></div>
	</div>
</div>
<script>
	var stop=true;
	var i=0;
	function beginsend(emt)
	{
		if(stop)
		{
			stop=false;
			 
			dosend($("tbody tr").not("[isSend=true]").first());
			$(emt).text("停止发送");
		}else{
			stop=true;
			$(emt).text("开始发送");
		} 
	}
	function dosend($emt)
	{
		if(stop)return ;
		if(!$emt.attr('isSend'))
		{
			i++;
			$emt.attr('isSend',true);
			$emt.find("#rs").text("正在发送..."); 
			var id=$emt.find("#id").text();
			$.post("<?php echo url(array('c'=>'admin/main', 'a'=>'sendmsg', ));?>",{"id":id},function(rs){
				$emt.find("#rs").text(rs); 
				dosend($emt.next());
			}) 
		}else{
			stop=true;
			$(emt).text("开始发送");
			showMsg("发送结束，共发送了"+i+"条记录");
		}
		
	}
	function confirmDelAll()
	{
		var r=confirm('确认要清空记录吗？');
		if(r)
		{
			showLoading("正在清空...");
		}
		return r;
	}
	var uploading=false;
	function upfile()
	{ 
		if(uploading){
			showMsg("文件正在上传中，请稍候");
			return false;
		}
		 $.ajax({
				url: "<?php echo url(array('c'=>'admin/main', 'a'=>'upload', ));?>",
				type: 'POST',
				cache: false,
				data: new FormData($('#formUpload')[0]),
				processData: false,
				contentType: false,
				dataType:"json",
				beforeSend: function(){
					uploading = true;
					showLoading("正在导入...");
				},
				success : function(rs) {
					hideLoading();
					$('#formUpload')[0].reset();
					if (rs.result == 1) { 
						showMsg(rs.msg,"成功",function(){
							showLoading("正在加载...");
							location.reload();
						});
					} else {
						showMsg(rs.msg);
					}
					uploading = false; 
				}
			});
		
	}
	function setState(emt,id,state)
	{
		showLoading("正在处理...");
		$.post("<?php echo url(array('c'=>'admin/main', 'a'=>'set', ));?>",{'id':id,'state':state},function(rs){
			hideLoading();
			$(emt).parents().find("#state").html("正常");	
		});
	}
	function del(emt,id)
	{
		showLoading("正在处理...");
		$.post("<?php echo url(array('c'=>'admin/main', 'a'=>'del', ));?>",{'id':id},function(rs){
			hideLoading();
			$(emt).parent().parent().remove();
		});
	}
</script>