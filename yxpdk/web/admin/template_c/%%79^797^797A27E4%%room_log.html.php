<?php /* Smarty version 2.6.25, created on 2017-09-04 16:07:12
         compiled from module/game_data/room_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/game_data/room_log.html', 58, false),array('modifier', 'date_format', 'module/game_data/room_log.html', 68, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<title>房间统计</title>
</head>
<body>
<div id="position">房间统计</div>

<div class='divOperation'>
<form name="myform" method="get" action="room_log.php">
&nbsp;玩家UID：<input type="text" name='uid' value='<?php echo $this->_tpl_vars['uid']; ?>
'/>
&nbsp;<?php echo $this->_tpl_vars['_lang']['conmon']['start_time']; ?>
：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" id='dateStart' name='dateStart' size='12' value='<?php echo $this->_tpl_vars['time_start']; ?>
'/>
&nbsp;<?php echo $this->_tpl_vars['_lang']['conmon']['end_time']; ?>
：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" id='dateEnd' name='dateEnd' size='12' value='<?php echo $this->_tpl_vars['time_end']; ?>
'/>

&nbsp;<input type="submit" name='search' class="input2"  />

</form>
</div>

<div class="total_data">
    <table cellspacing="1" cellpadding="3" border="0" class='table_list'>
        <tr class='table_list_head'>
            <td>今天开房数</td>
            <td>昨天开房数</td>
            <td>本月开房数</td>
            <td>总开房数</td>
        </tr>
        <tr class="trOdd">
            <td><?php echo $this->_tpl_vars['count_data']['today']; ?>
</td>
            <td><?php echo $this->_tpl_vars['count_data']['yesterday']; ?>
</td>
            <td><?php echo $this->_tpl_vars['count_data']['month']; ?>
</td>
            <td><?php echo $this->_tpl_vars['count_data']['all']; ?>
</td>
        </tr>
    </table>
</div>

<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
        <tr class='table_list_head'>
            <td>序号</td>
            <td>房间号</td>       
            <td>参与游戏玩家UID</td>       
            <td>开房时间</td>                             
            <td>结束时间</td>                             
            <td>盘数</td>                             
        </tr>
    </thead>

    <tbody>

    <?php $_from = $this->_tpl_vars['room_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['room_log_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">         
            <td><?php echo $this->_tpl_vars['key']+1; ?>
</td> 
            <td><?php echo $this->_tpl_vars['room_log_list']['room_id']; ?>
</td>
            <td>                
                <?php if ($this->_tpl_vars['room_log_list']['uids'] != ''): ?>
                    <?php echo $this->_tpl_vars['room_log_list']['uids']; ?>

                <?php else: ?>
                    无数据
                <?php endif; ?>    
            </td>                     
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['room_log_list']['action_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>                     
            <td>
                <?php if ($this->_tpl_vars['room_log_list']['finish_time'] != 0): ?>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['room_log_list']['finish_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>

                <?php else: ?>
                    无数据
                <?php endif; ?>
            </td>                     
            <td>
                <?php if ($this->_tpl_vars['room_log_list']['play_times'] != 0): ?>
                    <?php echo $this->_tpl_vars['room_log_list']['play_times']; ?>

                <?php else: ?>
                    无数据
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
&dateStart=<?php echo $this->_tpl_vars['time_start']; ?>
&dateEnd=<?php echo $this->_tpl_vars['time_end']; ?>
&uid=<?php echo $this->_tpl_vars['uid']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>

</body>
</html>