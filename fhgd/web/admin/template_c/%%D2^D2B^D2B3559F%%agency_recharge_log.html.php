<?php /* Smarty version 2.6.25, created on 2017-08-08 16:59:01
         compiled from module/agency/agency_recharge_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency/agency_recharge_log.html', 30, false),array('modifier', 'date_format', 'module/agency/agency_recharge_log.html', 35, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>

<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">您当前位置：充值系统 > 充值管理</div>
<div>
<table cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head'>
        <td>订单号</td>
        <td>金额</td>
        <td>钻石</td>
        <!-- <td>用户ID</td> -->
        <td>下单时间</td>
        <td>支付方式</td>
        <td>状态</td>
    </tr>

    <?php $_from = $this->_tpl_vars['agency_charge_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['order']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['order']['order_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['money_number']/100; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['dimond_number']; ?>
</td>
            <!-- <td><?php echo $this->_tpl_vars['order']['uid']; ?>
</td> -->
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['order']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
            <td>
                <?php if ($this->_tpl_vars['order']['pay_way'] == 'alipay'): ?>
                    支付宝
                <?php else: ?>
                    微信
                <?php endif; ?>
            </td>
            <td>
                <?php if ($this->_tpl_vars['order']['order_status'] == 1): ?>
                    已支付
                <?php else: ?>
                    未支付
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
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
        <input type="submit" name="submit" value="搜索" />
        <input type="hidden" name="uid" value="<?php echo $this->_tpl_vars['uid']; ?>
">
    </form>
</div> -->
</body>
</html>