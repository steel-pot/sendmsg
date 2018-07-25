<?php if(!class_exists("View", false)) exit("no direct access allowed");?><link href="<?php echo I; ?>/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo I; ?>/plugins/bootstrap-table/bootstrap-table.min.js""></script>
 <div class="portlet light bordered">
 
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-social-dribbble font-dark hide"></i>
			<span class="caption-subject font-dark bold uppercase">申请管理</span>
		</div>
		 
		
	</div>
										
	<div class="portlet-body">
		<form method="post" action="<?php echo url(array('c'=>'admin/main', 'a'=>'index', ));?>">
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
                                        <th>用户名</th>
                                        <th>手机号</th>
										<th>累计存款</th>	
										<th>提交时间</th>		
										<th>当前状态</th>	
										<th>操作</th>										
                                    </tr>
                                </thead>
                                <tbody>
								<?php if (count($rows)>0) : ?>
									<?php if(!empty($rows)){ $_foreach_row_counter = 0; $_foreach_row_total = count($rows);?><?php foreach( $rows as $row ) : ?><?php $_foreach_row_index = $_foreach_row_counter;$_foreach_row_iteration = $_foreach_row_counter + 1;$_foreach_row_first = ($_foreach_row_counter == 0);$_foreach_row_last = ($_foreach_row_counter == $_foreach_row_total - 1);$_foreach_row_counter++;?>
									<tr class="odd gradeX" >
										<td  ><?php echo htmlspecialchars($row['id'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php echo htmlspecialchars($row['username'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php echo htmlspecialchars($row['phone'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php echo htmlspecialchars($row['deposit'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php echo htmlspecialchars($row['created'], ENT_QUOTES, "UTF-8"); ?></td>
										<td  ><?php if ($row['state']==0) : ?>未处理<?php elseif ($row['state']==1) : ?>已成功<?php else : ?>已拒绝<?php endif; ?></td>
										<td  ><?php if ($row['state']==0) : ?><button class="btn btn-success" onclick="setState(<?php echo htmlspecialchars($row['id'], ENT_QUOTES, "UTF-8"); ?>,1)">成功</button><button class="btn btn-default" onclick="setState(<?php echo htmlspecialchars($row['id'], ENT_QUOTES, "UTF-8"); ?>,2)">拒绝</button><?php endif; ?></td>
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
	function setState(id,state)
	{
		showLoading("正在处理...");
		$.post("<?php echo url(array('c'=>'admin/main', 'a'=>'set', ));?>",{'id':id,'state':state},function(rs){
			location.reload();
		});
	}
</script>