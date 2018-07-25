<?php if(!class_exists("View", false)) exit("no direct access allowed");?><link href="<?php echo I; ?>/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo I; ?>/plugins/bootstrap-table/bootstrap-table.min.js"></script>
 <div class="portlet light bordered">
 
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-social-dribbble font-dark hide"></i>
			<span class="caption-subject font-dark bold uppercase">发送历史记录</span>
		</div>
		 
		
	</div>
										
	<div class="portlet-body">
	 

		<form class="form-inline" method="post" action="<?php echo url(array('c'=>'admin/history', 'a'=>'index', ));?>">
		<div  class="form-group"> 
			<a class="btn btn-warning" href="<?php echo url(array('c'=>'admin/history', 'a'=>'delall', ));?>" onclick="return confirmDelAll();">清空记录</a>
		</div>
	 
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
										<th>发送时间</th>	
										<th>发送结果</th>
										<th>操作</th>										
                                    </tr>
                                </thead>
                                <tbody>
								<?php if (count($rows)>0) : ?>
									<?php if(!empty($rows)){ $_foreach_row_counter = 0; $_foreach_row_total = count($rows);?><?php foreach( $rows as $row ) : ?><?php $_foreach_row_index = $_foreach_row_counter;$_foreach_row_iteration = $_foreach_row_counter + 1;$_foreach_row_first = ($_foreach_row_counter == 0);$_foreach_row_last = ($_foreach_row_counter == $_foreach_row_total - 1);$_foreach_row_counter++;?>
									<tr class="odd gradeX" >
										<td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars($row['p1'], ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars($row['p2'], ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars($row['p3'], ENT_QUOTES, "UTF-8"); ?></td>
										<td><?php echo htmlspecialchars($row['created'], ENT_QUOTES, "UTF-8"); ?></td> 
										<td> <?php echo htmlspecialchars($row['rs'], ENT_QUOTES, "UTF-8"); ?></td>
										<td> 
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
						<div style="float:right;"><?php echo page($pager,url('admin/history','index',array('keyword'=>$keyword,'p'=>'')));?>	</div>						
		<div class="clearfix"></div>
	</div>
</div>
<script>
	 
	function confirmDelAll()
	{
		var r=confirm('确认要清空记录吗？');
		if(r)
		{
			showLoading("正在清空...");
		}
		return r;
	}
	 
	function del(emt,id)
	{
		showLoading("正在处理...");
		$.post("<?php echo url(array('c'=>'admin/history', 'a'=>'del', ));?>",{'id':id},function(rs){
			hideLoading();
			$(emt).parent().parent().remove();
		});
	}
</script>