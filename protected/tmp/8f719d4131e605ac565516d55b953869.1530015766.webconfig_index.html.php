<?php if(!class_exists("View", false)) exit("no direct access allowed");?> <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            
                        </ul> 
                    </div>
                    
                    <!-- END PAGE HEADER-->
<div class="panel panel-default">
	 
		
	<div class="panel-body">
	<form method="post" >
	<button class="btn btn-success" type="submit">保存配置</button> 
	<hr />
	<?php if(!empty($rows)){ $_foreach_row_counter = 0; $_foreach_row_total = count($rows);?><?php foreach( $rows as $row ) : ?><?php $_foreach_row_index = $_foreach_row_counter;$_foreach_row_iteration = $_foreach_row_counter + 1;$_foreach_row_first = ($_foreach_row_counter == 0);$_foreach_row_last = ($_foreach_row_counter == $_foreach_row_total - 1);$_foreach_row_counter++;?>
		<div class="col-xs-9">
			<div class="form-group">
				<label><?php echo htmlspecialchars($row['title'], ENT_QUOTES, "UTF-8"); ?></label>
				<?php if ($row['type']==0) : ?>
				<input type="text" class="form-control" name="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, "UTF-8"); ?>" value="<?php echo htmlspecialchars($row['value'], ENT_QUOTES, "UTF-8"); ?>" /> 
				<?php else : ?>
				<textarea class="form-control" rows="3" name="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($row['value'], ENT_QUOTES, "UTF-8"); ?></textarea>
				<?php endif; ?> 
			</div>
		</div>
	<?php endforeach; }?> 
	</form>
	</div>
</div>					