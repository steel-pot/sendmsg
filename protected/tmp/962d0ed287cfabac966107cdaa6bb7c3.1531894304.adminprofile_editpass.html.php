<?php if(!class_exists("View", false)) exit("no direct access allowed");?>	<form action="" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">修改密码</h4>
				</div>
				<div class="modal-body">
					<div class="form-group"> 
						<input class="form-control" placeholder="请输入旧密码" type="password" name="oldpass">
					</div>
					<div class="form-group"> 
						<input class="form-control" placeholder="新密码" type="password" name="newpass">
					</div>
					<div class="form-group"> 
						<input class="form-control" placeholder="请再次输入新密码" type="password" name="renewpass">
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="button" onclick="subEdit()" class="btn btn-primary">提交更改</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</form>	
	
	<script>
		function subEdit()
		{
			showLoading("正在提交...");
			$.post("<?php echo url(array('c'=>'admin/adminprofile', 'a'=>'savepass', ));?>",$("form").serialize(),function(rs){
				hideLoading();
				
				if(rs.result==1)
				{
					$("form")[0].reset();
					showMsg(rs.msg,'提示',function(){
						location.reload();
					});
				}else{
					showMsg(rs.msg);
				}
			});
		}
	</script>