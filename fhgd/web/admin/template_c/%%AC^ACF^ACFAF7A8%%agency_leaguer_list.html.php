<?php /* Smarty version 2.6.25, created on 2017-07-25 16:15:05
         compiled from module/agency/agency_leaguer_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency/agency_leaguer_list.html', 46, false),)), $this); ?>
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

<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">您当前位置：我的会员</div>
<div>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>会员ID</td>
        <td>昵称</td>      
        <td>累计充值金额</td>
        <td>累计充值返利</td>
        <td>级别</td>
        <td>操作</td>
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['leaguer_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['leaguer']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['leaguer']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['leaguer']['nick_name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['leaguer']['recharge_money']; ?>
</td>           
            <td><?php echo $this->_tpl_vars['leaguer']['recharge_send_dimond']; ?>
</td>
            <td>
            <?php if ($this->_tpl_vars['leaguer']['grade'] == '1'): ?> 皇冠
            <?php elseif ($this->_tpl_vars['leaguer']['grade'] == '2'): ?> 钻石
            <?php elseif ($this->_tpl_vars['leaguer']['grade'] == '3'): ?> 白金
            <?php else: ?>
                玩家
            <?php endif; ?>
            </td>
            <td><a href="../../../admin/module/agency/agency_charge_list.php?uid=<?php echo $this->_tpl_vars['leaguer']['uid']; ?>
">查看详情</a></td>
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

</body>
</html>