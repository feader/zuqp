<?php /* Smarty version 2.6.25, created on 2017-08-08 15:41:20
         compiled from module/agency/agency_charge_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency/agency_charge_list.html', 56, false),array('modifier', 'date_format', 'module/agency/agency_charge_list.html', 59, false),)), $this); ?>
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
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
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

<div id="position">您当前位置：<?php echo $this->_tpl_vars['agency_info']['uid']; ?>
的充值记录</div>
<div>

<div>
    <p>
        <span>会员ID：<?php echo $this->_tpl_vars['agency_info']['uid']; ?>
</span><div class='show_br'></div>
        <span>昵称：<?php echo $this->_tpl_vars['agency_info']['nick_name']; ?>
</span><div class='show_br'></div>
        <span>钻石余额：<?php echo $this->_tpl_vars['agency_info']['recharge_dimond']; ?>
</span><div class='show_br'></div>
        <span>累计金额：<?php echo $this->_tpl_vars['total_charge']['total_money']; ?>
</span><div class='show_br'></div>
        <span>累计钻石：<?php echo $this->_tpl_vars['total_charge']['total_dimond']; ?>
</span><div class='show_br'></div>
        <span>上级会员ID：<?php echo $this->_tpl_vars['agency_info']['uber_agency']; ?>
</span><div class='show_br'></div>
    </p>
    
</div>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>钻石数量</td>
        <td>金额</td>      
        <td>时间</td>       
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['charge_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['log_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['log_list']['dimond_number']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['money_number']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log_list']['finish_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>                      
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>
<div>
    <p><a href="javascript:history.back();">返回</a></p>
</div>


<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>

</body>
</html>