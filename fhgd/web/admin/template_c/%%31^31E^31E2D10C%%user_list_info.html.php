<?php /* Smarty version 2.6.25, created on 2017-08-01 15:58:11
         compiled from module/user_manager/user_list_info.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/user_manager/user_list_info.html', 72, false),array('modifier', 'date_format', 'module/user_manager/user_list_info.html', 78, false),)), $this); ?>
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
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tAgency tbody tr").click(function () {
            $(this).parent().find("tr.focus").toggleClass("focus"); //取消原先选中行
            $(this).toggleClass("focus"); //设定当前行为选中行
        });
    });
</script>

<title>用户列表</title>
</head>

<body>

<div id="position">当前位置：用户列表</div>
<div>

<div class="divOperation">

    <form name="myform" method="get" action="user_list_info.php" id="user_info">
    会员ID：<input type="text" name="uid" />
    <div class='show_br'></div>
    呢称：<input type="text" name="username" />
    <div class='show_br'></div>
    总玩牌数：<input type="text" name="total_pay_times" />
    <div class='show_br'></div>
    注册起始：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
">
    <div class='show_br'></div>
    注册结束：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
">
    <div class='show_br'></div>
   
   
    <input type="button" value="查询" id='sub_btn'>
    <input type="hidden" value="" name="action" id='action'/>
    </form>
    <input type="button" value="导出" id='do_execel'/>
</div>
<br/>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>序号</td>
        <td>会员ID</td>
        <td>昵称</td>      
        <td>钻石余额</td>       
        <td>累计钻石</td>       
        <td>注册时间</td>       
        <td>最后登录时间</td>       
        <td>操作</td>       
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['user_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['log_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['key']+1; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['username']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['dimond']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['sum_dimond']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log_list']['register_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log_list']['last_login_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>                      
            <td></td>                      
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
<div style="height:150px;"></div>

<script>
    $('#sub_btn').click(function(){
        $('#action').val('search');
        $('#user_info').submit();
    })
    $('#do_execel').click(function(){
        $('#action').val('do_execel');
        $('#user_info').submit();
    })
</script>
</body>
</html>