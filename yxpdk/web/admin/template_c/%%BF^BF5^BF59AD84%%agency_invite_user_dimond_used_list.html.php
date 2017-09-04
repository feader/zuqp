<?php /* Smarty version 2.6.25, created on 2017-09-02 16:39:24
         compiled from module/agency/agency_invite_user_dimond_used_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency/agency_invite_user_dimond_used_list.html', 60, false),array('modifier', 'date_format', 'module/agency/agency_invite_user_dimond_used_list.html', 63, false),)), $this); ?>
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
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<title>钻石消耗明细</title>
</head>

<body>

<div id="position">您当前位置：钻石消耗</div>
<div>

<div class="divOperation">

    <form name="myform" method="get" action="agency_view_invite_user.php" id="user_info">
    会员ID：<input type="text" name="uid" value="<?php echo $this->_tpl_vars['uid']; ?>
" />
    <div class='show_br'></div>
    创建起始：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
">
    <div class='show_br'></div>
    创建结束：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
"> 
    <div class='show_br'></div>  
    <input type="button" value="查询" id='sub_btn'>
    </form>

</div>
<br/>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>编号</td>
        <td>玩家ID</td>
        <td>消耗时间</td>      
        <td>消耗钻石</td>              
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['agency_invite_user_cost']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['log_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['log_list']['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['uid']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log_list']['use_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>        
            <td><?php echo $this->_tpl_vars['log_list']['use_dimond']; ?>
</td>                                    
        </tr>
    <?php endforeach; endif; unset($_from); ?>   
    </tbody>
</table>


<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
&dateStart=<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
&dateEnd=<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
&uid=<?php echo $this->_tpl_vars['uid']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>
<script>
    $('#sub_btn').click(function(){
        
        $('#user_info').submit();
    })
    

</script>
</body>
</html>