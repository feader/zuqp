<?php /* Smarty version 2.6.25, created on 2017-08-10 17:21:45
         compiled from module/admin/admin_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/admin/admin_list.html', 48, false),array('modifier', 'date_format', 'module/admin/admin_list.html', 55, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<style type="text/css">
tr.focus {
    background-color:#B0E2FF;
}
</style>

<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tAgency tbody tr").click(function () {
            $(this).parent().find("tr.focus").toggleClass("focus"); //取消原先选中行
            $(this).toggleClass("focus"); //设定当前行为选中行
        });
    });
</script>

<title>管理员管理</title>
</head>

<body>

<div id="position">当前位置：管理员管理</div>
<div>
<?php if (gid != 3): ?>
<a href="admin_new.php">添加管理员</a>
<?php endif; ?>

<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>管理员级别</td>
        <td>账号</td>              
        <td>最后登录时间</td>              
        <td>操作</td>
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['admin_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['admin_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td>
                <?php echo $this->_tpl_vars['admin_list']['gid']; ?>

            </td>
            <td><?php echo $this->_tpl_vars['admin_list']['username']; ?>
</td>         
            <td>
                <?php if ($this->_tpl_vars['admin_list']['last_login_time'] != 0): ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['admin_list']['last_login_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>

                <?php else: ?>
                无
                <?php endif; ?>
            </td>                      
            <td> 
            <?php if ($this->_tpl_vars['gid'] == 1): ?>       
                <a href="admin_edit.php?uid=<?php echo $this->_tpl_vars['admin_list']['uid']; ?>
">编辑</a> | 
                <a href="admin_del.php?uid=<?php echo $this->_tpl_vars['admin_list']['uid']; ?>
">删除</a>  
            <?php endif; ?>     
            </td>          
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>

<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>

<!-- <div>
    <form name=search_condition method="post" action="recharge_order_list.php?action=set_condition">
        <input type="submit" name="submit" value="重置密码" />
        <input type="hidden" name="uid" value="<?php echo $this->_tpl_vars['uid']; ?>
">
    </form>
</div> -->
</body>
</html>