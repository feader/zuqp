<?php /* Smarty version 2.6.25, created on 2017-09-02 10:37:52
         compiled from module/game_manager/dimond_log_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/game_manager/dimond_log_list.html', 69, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
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
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">当前位置：游戏管理 > 消耗钻石</div>
<div>
<div class="divOperation">

    <form name="myform" method="get" action="dimond_log_list.php">
    开始时间：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" id="dateStart" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['date_time']['start']; ?>
">
    <div class='show_br'></div>
    结束时间：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" id="dateEnd" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['date_time']['end']; ?>
">
    <div class='show_br'></div>
    排序：
    <select name="sort">
        <option value="1" selected="selected">时间↓</option>
        <option value="2">时间↑</option>
        <option value="3">金额↓</option>
        <option value="4">金额↑</option>
    </select>
    <div class='show_br'></div>
    <input type="submit" value="查询">
    <input type="hidden" value="search" name="action" />
    </form>

</div>
<div>
    <p>总消耗房卡数：<?php echo $this->_tpl_vars['all_cost']; ?>
</p>
    <p>查询区间总消耗房卡数：<?php echo $this->_tpl_vars['total']; ?>
</p>
</div>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>日期</td>
        <td>消耗钻石数量</td>       
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['dimond_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['dimond_log']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td>
                <?php echo $this->_tpl_vars['dimond_log']['date_time']; ?>

            </td>
            <td><?php echo $this->_tpl_vars['dimond_log']['everyday_total_use']; ?>
</td>         
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>

<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
&dateStart=<?php echo $this->_tpl_vars['date_time']['start']; ?>
&dateEnd=<?php echo $this->_tpl_vars['date_time']['end']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>

</body>
</html>