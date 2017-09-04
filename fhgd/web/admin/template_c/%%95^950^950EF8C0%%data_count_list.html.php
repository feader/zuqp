<?php /* Smarty version 2.6.25, created on 2017-09-01 15:15:46
         compiled from module/game_data/data_count_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/game_data/data_count_list.html', 67, false),array('modifier', 'string_format', 'module/game_data/data_count_list.html', 81, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<title>数据统计</title>
</head>
<body>
<div id="position">数据统计</div>

<div class='divOperation'>
<form name="myform" method="get" action="data_count.php">
&nbsp;<?php echo $this->_tpl_vars['_lang']['conmon']['start_time']; ?>
：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" id='dateStart' name='dateStart' size='12' value='<?php echo $this->_tpl_vars['time_start']; ?>
'/>
&nbsp;<?php echo $this->_tpl_vars['_lang']['conmon']['end_time']; ?>
：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" id='dateEnd' name='dateEnd' size='12' value='<?php echo $this->_tpl_vars['time_end']; ?>
'/>

&nbsp;<input type="submit" name='search' class="input2"  />

</form>
</div>

<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
    	<td>时间</td>
        <td>新增注册</td>       
        <td>当天充值数</td>       
        <td>当天消耗房卡数</td>                       
        <td>日平均在线人数</td>                       
        <td>实时平均在线人数</td>                       
        <td>当日登录帐号数</td>                       
        <td>总充值付费用户</td>                       
        <td>历史注册总数</td>                       
        <td>日活跃账号数</td>                       
        <td>日活跃付费账号数</td>                       
        <td>月活跃账号数</td>                       
        <td>月活跃账付费号数</td>                       
        <td>用户日平均在线时长（分）</td>                       
        <td>用户流失率（日）</td>                       
        <td>用户流失率（月）</td>                       
        <td>活跃率</td>                       
        <td>月付费用户</td>                       
        <td>日付费用户</td>                       
        <td>注册用户付费率（日）</td>                       
        <td>平均在线付费率（日）</td>                       
        <td>活跃用户付费率（日）</td>                      
        <td>平均在线付费率（月）</td>                       
        <td>活跃用户付费率（月）</td>                        
        <td>活跃用户付费率（月）</td>                        
        <td>当日登陆账号数</td>                        
        <td>次留</td>             
        <td>三留</td>             
        <td>四留</td>             
        <td>五留</td>             
        <td>六留</td>             
        <td>七留</td>             
        <td>14留</td>             
        <td>30留</td>             
    </tr>
    </thead>

    <tbody>

    <?php $_from = $this->_tpl_vars['data_count']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['data_gather_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">         
            <td><?php echo $this->_tpl_vars['data_gather_list']['data_time']; ?>
</td> 
            <td><?php echo $this->_tpl_vars['data_gather_list']['register']; ?>
</td>
            <td><?php echo $this->_tpl_vars['data_gather_list']['total_charge_money']; ?>
</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['total_cost_dimond']; ?>
</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['acu']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['aacu']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['uv']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['pu']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['all_reg']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['dau']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['dau_apa']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['mau']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['mau_apa']; ?>
</td>                                          
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['data_gather_list']['dts']/60)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['dul']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['mul']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['rhyl']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['marpu']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['darpu']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['dau_reg_ffl']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['dau_avg_online_ffl']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['dau_nv_ffl']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['mau_reg_ffl']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['mau_avg_online_ffl']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['mau_nv_ffl']; ?>
</td>                                          
            <td><?php echo $this->_tpl_vars['data_gather_list']['au']; ?>
</td>                                                                                   
            <td><?php echo $this->_tpl_vars['data_gather_list']['second_retention']; ?>
%</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['third_retention']; ?>
%</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['fourth_retention']; ?>
%</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['fifth_retention']; ?>
%</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['sixth_retention']; ?>
%</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['seventh_retention']; ?>
%</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['fourteenth_retention']; ?>
%</td>                     
            <td><?php echo $this->_tpl_vars['data_gather_list']['thirty_retention']; ?>
%</td>                                    
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
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>

</body>
</html>