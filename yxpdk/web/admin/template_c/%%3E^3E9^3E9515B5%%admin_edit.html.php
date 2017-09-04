<?php /* Smarty version 2.6.25, created on 2017-08-10 10:32:49
         compiled from module/admin/admin_edit.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['_lang']['left']['open_close']; ?>
</title>
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<style type="text/css">

#all {text-align:left;margin-left:4px; line-height:1;}
#nodes {width:100%; float:left;border:1px #ccc solid;}
#result {width: 100%; height:100%; clear:both; border:1px #ccc solid;}

</style>
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>


</head>

 <body>
 <div id="position">当前位置：管理员编辑</div>
	<form action="admin_save.php" method="post">
		<p>管理员：<?php echo $this->_tpl_vars['detail']['username']; ?>
</p>
		修改密码: <input type="password" name="pwd"  value=""> 
		<br>
		
		<?php if ($this->_tpl_vars['adimn_gid'] == '1'): ?> 
		<br>
		修改管理员等级:
		<select name="gid">
			<?php $_from = $this->_tpl_vars['group_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['group']):
?>
				<option value="<?php echo $this->_tpl_vars['group']['gid']; ?>
" <?php if ($this->_tpl_vars['group']['gid'] == $this->_tpl_vars['detail']['gid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['group']['name']; ?>
</option>				
			<?php endforeach; endif; unset($_from); ?>
		</select>
		<br>
        <?php endif; ?>
		
		<br>
		<input type="hidden" value="<?php echo $this->_tpl_vars['detail']['uid']; ?>
" name="uid" />
		<input name="submit" value="提交修改"  type="submit">
		<br><br>

	</form>
	

	

	

 </body>
</html>