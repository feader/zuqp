<?php /* Smarty version 2.6.25, created on 2017-09-02 12:07:07
         compiled from module/game_manager/admin_action_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/game_manager/admin_action_log.html', 50, false),array('modifier', 'date_format', 'module/game_manager/admin_action_log.html', 56, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">您当前位置：日志管理</div>
<div>

<div>
    <form method="get" action="admin_action_log.php" id="user_info">
    玩家ID：<input type="text" name="uid" value="<?php echo $this->_tpl_vars['input_data']['uid']; ?>
" />
    <div class='show_br'></div>
    内容：<input type="text" name="content" value="<?php echo $this->_tpl_vars['input_data']['content']; ?>
" />
    <div class='show_br'></div>
    操作者：<input type="text" name="handler" value="<?php echo $this->_tpl_vars['input_data']['handler']; ?>
" />
    <div class='show_br'></div>
    创建起始：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['data_time']['datestart']; ?>
">
    <div class='show_br'></div>
    创建结束：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['data_time']['dateend']; ?>
"> 
    <div class='show_br'></div>  
    <input  type="button" value="查询" id='sub_btn' />       
    <input type="hidden" name="action" value="" id='action'/>       
    </form>
    <input type="button" value="导出" id='do_execel'/>
</div>

<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head'>
        <td>编号</td>
        <td>玩家ID</td>
        <td>内容</td>
        <td>操作者</td>       
        <td>类型(0是默认，1是封禁，2是解封)</td>       
        <td>操作时间</td>
        
    </tr>

    <?php $_from = $this->_tpl_vars['order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['order']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['order']['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['content']; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['handler']; ?>
</td>          
            <td><?php echo $this->_tpl_vars['order']['action_type']; ?>
</td>          
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['order']['action_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
&uid=<?php echo $this->_tpl_vars['input_data']['uid']; ?>
&content=<?php echo $this->_tpl_vars['input_data']['content']; ?>
&handler=<?php echo $this->_tpl_vars['input_data']['handler']; ?>
&dateStart=<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
&dateEnd=<?php echo $this->_tpl_vars['date_time']['dateEnd']; ?>
">
        <?php echo $this->_tpl_vars['page_name']; ?>

    </a>
<?php endforeach; endif; unset($_from); ?>
</div>
<script>
    $('#sub_btn').click(function(){
        $('#action').val('set_condition');
        $('#user_info').submit();
    })
    $('#do_execel').click(function(){
        $('#action').val('do_execel');
        $('#user_info').submit();
    })
    $('#edit_sub').click(function(){
        $('#edit_area').submit();
    })

</script>

</body>
</html>