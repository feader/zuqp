<?php /* Smarty version 2.6.25, created on 2017-09-02 14:55:22
         compiled from module/recharge_manager/sell_to_agency_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/recharge_manager/sell_to_agency_list.html', 82, false),array('modifier', 'date_format', 'module/recharge_manager/sell_to_agency_list.html', 87, false),)), $this); ?>
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

<title>上级代理出售钻石给下级代理明细</title>
</head>

<body>

<div id="position">当前位置：代理出售给代理</div>
<div>

<div class="total_data">
    <table cellspacing="1" cellpadding="3" border="0" class='table_list'>
        <tr class='table_list_head'>
            <td>今天售卡</td>
            <td>昨天售卡</td>
            <td>上周售卡</td>
            <td>总售卡</td>
        </tr>
        <tr class="trOdd">
            <td><?php echo $this->_tpl_vars['total_data']['today']; ?>
</td>
            <td><?php echo $this->_tpl_vars['total_data']['yesterday']; ?>
</td>
            <td><?php echo $this->_tpl_vars['total_data']['lastweek']; ?>
</td>
            <td><?php echo $this->_tpl_vars['all_dimond']; ?>
</td>
        </tr>
    </table>
</div>

<div class="divOperation">

    <form name="myform" method="get" action="sell_to_agency_list.php" id="user_info">
    出售代理ID：<input type="text" name="sell_agency_uid" value="<?php echo $this->_tpl_vars['input_data']['sell_agency_uid']; ?>
" />
    <div class='show_br'></div>
    购买代理ID：<input type="text" name="buy_agency_uid" value="<?php echo $this->_tpl_vars['input_data']['buy_agency_uid']; ?>
"/>
    <div class='show_br'></div>
    创建起始：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
">
    <div class='show_br'></div>
    创建结束：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
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
        <td>编号</td>
        <td>出售代理ID</td>
        <td>购买代理ID</td>      
        <td>出售钻石</td>              
        <td>出售时间</td>              
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['user_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['log_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['log_list']['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['sell_agency_uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['buy_agency_uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['dimond_num']; ?>
</td>       
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log_list']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
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
&sell_agency_uid=<?php echo $this->_tpl_vars['input_data']['sell_agency_uid']; ?>
&buy_agency_uid=<?php echo $this->_tpl_vars['input_data']['buy_agency_uid']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>
<script>
    $('#sub_btn').click(function(){
        $('#action').val('search');
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