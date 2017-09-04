<?php /* Smarty version 2.6.25, created on 2017-08-08 17:05:34
         compiled from module/agency/agency_recharge.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>

<script type="text/javascript">
    function Buy(product_id) {
        window.location.href = "?action=recharge&product_id="+product_id;
    }
    function Pay(product_id) {
        var url = 'wxpay/example/native.php?product_id='+product_id;
        window.location.href = url;     
    }

</script>
<style>
    .wxpay{
        background-color:#71FF60;
        border:1px solid #71FF60;
    }
</style>
<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">您当前位置：充值</div>
<div><!-- <font color="red">请在浏览器里操作充值</font> --></div>



<?php $_from = $this->_tpl_vars['pay_config']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['pay']):
?>
    <div>
        充值：<?php echo $this->_tpl_vars['pay']['dimond_cnt']; ?>
钻石 <br>
        <!-- 赠送：<?php echo $this->_tpl_vars['pay']['gift_dimond_cnt']; ?>
钻石 <br> -->
        价格：<?php echo $this->_tpl_vars['pay']['total_fee']; ?>
元 <br>
        支付宝：<input type="button" name="buy1" value="购买" onclick="Buy(<?php echo $this->_tpl_vars['key']+1; ?>
)">&nbsp;&nbsp;&nbsp;&nbsp;
        <div class='show_br'></div>
        微信扫码支付：<input type="button" name="pay1" value="购买" onclick="Pay(<?php echo $this->_tpl_vars['key']+1; ?>
)" class='wxpay'>
        <br><br>
    </div>
<?php endforeach; endif; unset($_from); ?>

</body>
</html>