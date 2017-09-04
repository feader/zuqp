<?php /* Smarty version 2.6.25, created on 2017-07-28 16:27:46
         compiled from module/agency_manager/agency_bank_info.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency_manager/agency_bank_info.html', 58, false),)), $this); ?>
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
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<title>代理银行资料</title>
</head>

<body>

<div id="position">当前位置：代理银行资料</div>
<div>
    <form action="agency_bank_info.php" method="get" id="user_info">        
        代理账号：<input type="text" name="uid" value="<?php echo $this->_tpl_vars['input_data']['uid']; ?>
" />
        <div class='show_br'></div>
        <input type="button" value="查询" id='sub_btn'>
        <input type="hidden" value="" name="action" id='action'/>
    </form>
    <input type="button" value="导出" id='do_execel'/>
</div>
<div>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>代理账号</td>
        <td>微信</td>
        <td>支付宝</td>
        <td>开户行</td>
        <td>分行</td>
        <td>开户名</td>
        <td>开户账号</td>
        <td>操作</td>
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['agency_bank_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['agency']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['agency']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['weixin']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['alipay']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['opening_bank']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['branch']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['bank_name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['bank_account']; ?>
</td>
            <td>
                <?php if ($this->_tpl_vars['gid'] != 3): ?>
                    <a href="agency_bank_info_edit.php?id=<?php echo $this->_tpl_vars['agency']['id']; ?>
">编辑</a>          
                <?php endif; ?>
            </td>    
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>

<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
&uid=<?php echo $this->_tpl_vars['input_data']['uid']; ?>
&dateStart=<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
&dateEnd=<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
&uber_agency=<?php echo $this->_tpl_vars['input_data']['uber_agency']; ?>
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