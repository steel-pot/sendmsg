<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!-- 模态框（Modal） -->
<div class="modal fade" id="myDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"  >提示</h4>
            </div>
            <div class="modal-body">在这里添加一些文本</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >关闭</button> 
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
	var myDialogBack=null;
	$('#myDialog').on('hidden.bs.modal',function(){
		if(myDialogBack!=null)
		{
			myDialogBack();
			myDialogBack=null;
		}
	});
	function showMsg(msg,title,callback)
	{
		if(typeof title =="undefined")
		{
			title="提示";
		}
		$("#myDialog").find(".modal-title").text(title);
		if(typeof callback =="undefined")
		{
			callback=null;
		}
		myDialogBack=callback;
		
		$("#myDialog").find(".modal-body").text(msg); 
		$("#myDialog").modal('show')
	}
</script>

 <link href="<?php echo I; ?>/css/loading.css" rel="stylesheet" type="text/css" />
 <div id="myDialogLoading" class="modal fade" data-keyboard="false" data-backdrop="static" data-role="dialog"  aria-hidden="true">
            <div  class="loading">加载中。。。</div>
 </div>
 <script>
	function showLoading(msg)
	{	
		if(typeof msg =="undefined")
		{
			msg="加载中。。。";
		}
		$("#myDialogLoading").find(".loading").text(msg);
		$('#myDialogLoading').modal({backdrop: 'static', keyboard: false});
		$("#myDialogLoading").modal("show");
	}
	function hideLoading()
	{
		$("#myDialogLoading").modal("hide");
	}
 </script>
 