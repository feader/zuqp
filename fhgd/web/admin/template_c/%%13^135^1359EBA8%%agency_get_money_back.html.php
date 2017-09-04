<?php /* Smarty version 2.6.25, created on 2017-07-25 16:15:12
         compiled from module/agency/agency_get_money_back.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency/agency_get_money_back.html', 46, false),array('modifier', 'date_format', 'module/agency/agency_get_money_back.html', 47, false),)), $this); ?>
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
        $("#tAgency1 tbody tr").click(function () {
            $(this).parent().find("tr.focus").toggleClass("focus"); //取消原先选中行
            $(this).toggleClass("focus"); //设定当前行为选中行
        });
    });
</script>

<title>返现记录</title>
</head>

<body>

<div id="position">您当前位置：返现记录</div>


<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head'>
        <td>月份</td>
        <td>代理名</td>
        <td>有消费的玩家数</td>
        <td>总消耗数</td>
        <td>奖励房卡</td>
    </tr>
    <?php $_from = $this->_tpl_vars['back_money_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['back_money_log']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['back_money_log']['get_money_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m") : smarty_modifier_date_format($_tmp, "%Y/%m")); ?>
</td>
            <td><?php echo $this->_tpl_vars['back_money_log']['auid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['back_money_log']['pay_person_num']; ?>
</td>
            <td><?php echo $this->_tpl_vars['back_money_log']['pay_person_dimond_num']; ?>
</td>
            <td><?php echo $this->_tpl_vars['back_money_log']['get_money']; ?>
</td>        
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<div style="width:100%;height:150px;"></div>

<table id="tAgency1" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head'>     
        <td>月份</td>
        <td>返现金额</td>
        <td>发放时间</td>
    </tr>
    <?php $_from = $this->_tpl_vars['every_month_get_money_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['get_money_log']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['get_money_log']['back_date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['get_money_log']['back_money']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['get_money_log']['back_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
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