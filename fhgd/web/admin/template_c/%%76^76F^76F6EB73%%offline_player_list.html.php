<?php /* Smarty version 2.6.25, created on 2017-08-21 09:24:33
         compiled from module/game_manager/offline_player_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/game_manager/offline_player_list.html', 59, false),array('modifier', 'date_format', 'module/game_manager/offline_player_list.html', 62, false),)), $this); ?>
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
<title>线下赛玩家列表</title>
</head>

<body>

<div id="position">当前位置：线下赛已报名玩家</div>
<div>
    <form action="offline_player_list.php" method="get" id="user_info">        
        玩家uid：<input type="text" name="uid" value="<?php echo $this->_tpl_vars['input_data']['uid']; ?>
" />
        <div class='show_br'></div>
        玩家名：<input type="text" name="username" value="<?php echo $this->_tpl_vars['input_data']['username']; ?>
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
        <td>玩家uid</td>
        <td>玩家名</td>
        <td>报名时间</td> 
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['player_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['play']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['play']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['play']['username']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['play']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
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