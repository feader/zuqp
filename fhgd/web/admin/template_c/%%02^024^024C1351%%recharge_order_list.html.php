<?php /* Smarty version 2.6.25, created on 2017-07-20 16:51:51
         compiled from module/recharge_manager/recharge_order_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/recharge_manager/recharge_order_list.html', 51, false),array('modifier', 'date_format', 'module/recharge_manager/recharge_order_list.html', 57, false),)), $this); ?>
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
<title>充值记录</title>
</head>

<body>

<div id="position">当前位置：充值系统 > 充值管理</div>
<div>

<div>
    <form method="get" action="recharge_order_list.php" id="user_info">
    代理ID：<input type="text" name="uid" value="<?php echo $this->_tpl_vars['input_data']['uid']; ?>
" />
    <div class='show_br'></div>
    订单号：<input type="text" name="order_id" value="<?php echo $this->_tpl_vars['input_data']['order_id']; ?>
" />
    <div class='show_br'></div>
    支付号：<input type="text" name="alipay_order_id" value="<?php echo $this->_tpl_vars['input_data']['alipay_order_id']; ?>
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
        <td>代理ID</td>
        <td>订单号</td>
        <td>支付号</td>
        <td>金额</td>       
        <td>钻石数</td>       
        <td>下单时间</td>
        <td>支付方式</td>
        <td>状态</td>
    </tr>

    <?php $_from = $this->_tpl_vars['order_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['order']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['order']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['order_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['alipay_order_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['order']['money_number']; ?>
</td>          
            <td><?php echo $this->_tpl_vars['order']['dimond_number']; ?>
</td>          
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
&uid=<?php echo $this->_tpl_vars['input_data']['uid']; ?>
&order_id=<?php echo $this->_tpl_vars['input_data']['order_id']; ?>
&alipay_order_id=<?php echo $this->_tpl_vars['input_data']['alipay_order_id']; ?>
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