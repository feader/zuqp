<?php /* Smarty version 2.6.25, created on 2017-08-10 17:27:46
         compiled from module/agency_manager/agency_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency_manager/agency_list.html', 65, false),array('modifier', 'date_format', 'module/agency_manager/agency_list.html', 83, false),)), $this); ?>
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
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">当前位置：代理系统 > 代理管理</div>
<div>
    <form action="agency_list.php" method="get" id="user_info">        
        代理账号：<input type="text" name="uid" value="<?php echo $this->_tpl_vars['input_data']['uid']; ?>
" />
        <div class='show_br'></div>
        上级代理：<input type="text" name="uber_agency" value="<?php echo $this->_tpl_vars['input_data']['uber_agency']; ?>
" />
        <div class='show_br'></div>
        开始时间：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
">
        <div class='show_br'></div>
        结束时间：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
">    
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
        <td>代理级别</td>
        <td>上级代理</td>
        <td>账号</td>
        <td>昵称</td>
        <td>充值钻石</td>
        <td>充值金额</td>
        <td>生成日期</td>
        <td>备注</td>
        <td>操作</td>
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['agency_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['agency']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td>
            <?php if ($this->_tpl_vars['agency']['grade'] == '1'): ?> 皇冠
            <?php elseif ($this->_tpl_vars['agency']['grade'] == '2'): ?> 钻石
            <?php else: ?> 白金
            <?php endif; ?>
            </td>
            <td>
                <?php if ($this->_tpl_vars['agency']['uber_agency'] != ''): ?>
                <?php echo $this->_tpl_vars['agency']['uber_agency']; ?>

                <?php else: ?>
                无上级
                <?php endif; ?>
            </td>
            <td><?php echo $this->_tpl_vars['agency']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['nick_name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['recharge_dimond']; ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['recharge_money']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['agency']['register_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
</td>
            <td><?php echo $this->_tpl_vars['agency']['note']; ?>
</td>
            <td>
                 <?php if ($this->_tpl_vars['gid'] != 3): ?>
                <a href="agent_edit.php?id=<?php echo $this->_tpl_vars['agency']['id']; ?>
">编辑</a>|
               
                <a href="agent_del.php?id=<?php echo $this->_tpl_vars['agency']['id']; ?>
">删除</a>
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