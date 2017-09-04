<?php /* Smarty version 2.6.25, created on 2017-09-02 22:22:33
         compiled from module/game_manager/game_notice.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>代理首页公告编辑</title>
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<style type="text/css">

#all {text-align:left;margin-left:4px; line-height:1;}
#nodes {width:100%; float:left;border:1px #ccc solid;}
#result {width: 100%; height:100%; clear:both; border:1px #ccc solid;}

</style>
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="../../../admin/static/js/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/kindeditor/lang/zh_CN.js"></script>


</head>

 <body>
 <div id="position">当前位置：代理首页公告编辑</div>
	<form action="" method="post">
		<p>公告详细</p>
		<textarea name="setting_value" id="editor_id" cols="100" rows="20" style="width:100%">
			<?php echo $this->_tpl_vars['note_detail']['setting_value']; ?>

		</textarea>
		<br>
		<br>
		<input type="hidden" value="<?php echo $this->_tpl_vars['note_detail']['id']; ?>
" name="id" />
		<input name="submit" value="提交修改"  type="submit">
		<input type="hidden" name="action" value="edit" />
		<br><br>

	</form>
	

	
<script>
KindEditor.ready(function(K) {  
     window.editor = K.create('#editor_id');  
});  	
</script>
	

 </body>
</html>