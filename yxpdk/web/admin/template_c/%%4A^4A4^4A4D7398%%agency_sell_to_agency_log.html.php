<?php /* Smarty version 2.6.25, created on 2017-09-02 16:35:40
         compiled from module/agency/agency_sell_to_agency_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency/agency_sell_to_agency_log.html', 63, false),array('modifier', 'date_format', 'module/agency/agency_sell_to_agency_log.html', 66, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../static/css/style.css" type="text/css">
<style type="text/css">
tr.focus {
    background-color:#B0E2FF;
}
</style>

<script type="text/javascript" src="../../static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../static/js/My97DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../static/js/public.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tAgency tbody tr").click(function () {
            $(this).parent().find("tr.focus").toggleClass("focus"); //取消原先选中行
            $(this).toggleClass("focus"); //设定当前行为选中行
        });
    });
</script>

<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">您当前位置：出售记录</div>

<div class="total_data">
    <table cellspacing="1" cellpadding="3" border="0" class='table_list'>
        <tr class='table_list_head'>
            <td>今天售卡</td>
            <td>昨天售卡</td>
            <td>上周售卡</td>
        </tr>
        <tr class="trOdd">
            <td><?php echo $this->_tpl_vars['total_data']['today']; ?>
</td>
            <td><?php echo $this->_tpl_vars['total_data']['yesterday']; ?>
</td>
            <td><?php echo $this->_tpl_vars['total_data']['lastweek']; ?>
</td>
        </tr>
    </table>
</div>

<div style="margin:30px auto;">
    <form name="query" method="get" action="">
        开始日期：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" id='dateStart' name='dateStart' size="12" value='<?php echo $this->_tpl_vars['dateStart']; ?>
'/>       
        <input type="submit" name="submit" value="按日期查询" />
    </form>
</div>

<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head'>
        <td>代理名称</td>
        <td>钻石数量</td>        
        <td>时间</td>
    </tr>
    <?php $_from = $this->_tpl_vars['log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['log']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['log']['buy_agency_uid']; ?>
</td>          
            <td><?php echo $this->_tpl_vars['log']['dimond_num']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
&dateStart=<?php echo $this->_tpl_vars['dateStart']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>

</body>
</html>