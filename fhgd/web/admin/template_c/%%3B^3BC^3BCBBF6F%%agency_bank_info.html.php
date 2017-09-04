<?php /* Smarty version 2.6.25, created on 2017-07-25 15:22:20
         compiled from module/agency/agency_bank_info.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<style>
    .write_area{width:100px;}
</style>
<title>银行资料</title>
</head>

<body>

<div id="position">您当前位置：银行资料</div>

<div>
    <form method="post" action="agency_bank_info.php">
        <table align="center">
            <tr>
                <td align="right">用户ID：</td><td align="left"><span><?php echo $this->_tpl_vars['agency']['uid']; ?>
</span></td>
            </tr>
             <tr>
                <td align="right">微信：</td><td><input type="text" name="weixin" value="<?php echo $this->_tpl_vars['agency']['weixin']; ?>
" class='write_area'></td>
            </tr>
             <tr>
                <td align="right">支付宝：</td><td><input type="text" name="alipay" value="<?php echo $this->_tpl_vars['agency']['alipay']; ?>
" class='write_area'></td>
            </tr>
             <tr>
                <td align="right">开户行：</td><td><input type="text" name="opening_bank" value="<?php echo $this->_tpl_vars['agency']['opening_bank']; ?>
" class='write_area'></td>
            </tr>
             <tr>
                <td align="right">分行：</td><td><input type="text" name="branch" value="<?php echo $this->_tpl_vars['agency']['branch']; ?>
" class='write_area'></td>
            </tr>
             <tr>
                <td align="right">开户名：</td><td><input type="text" name='bank_name' value="<?php echo $this->_tpl_vars['agency']['bank_name']; ?>
" class='write_area'></td>
            </tr>
             <tr>
                <td align="right">开户账号：</td><td><input type="text" name='bank_account' value="<?php echo $this->_tpl_vars['agency']['bank_account']; ?>
" class='write_area'></td>
            </tr>
            
        </table>
        <input type="hidden" name="action" value="save">
        <input type="submit" name="submit" value="保存" />
    </form>
</div>

</body>
</html>