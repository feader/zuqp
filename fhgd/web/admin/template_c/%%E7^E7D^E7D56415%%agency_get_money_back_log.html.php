<?php /* Smarty version 2.6.25, created on 2017-07-20 16:52:08
         compiled from module/agency_manager/agency_get_money_back_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency_manager/agency_get_money_back_log.html', 58, false),array('modifier', 'date_format', 'module/agency_manager/agency_get_money_back_log.html', 59, false),)), $this); ?>
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
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tAgency tbody tr").click(function () {
            $(this).parent().find("tr.focus").toggleClass("focus"); //取消原先选中行
            $(this).toggleClass("focus"); //设定当前行为选中行
        });
        $("#tAgency1 tbody tr").click(function () {
            $(this).parent().find("tr.focus").toggleClass("focus"); //取消原先选中行
            $(this).toggleClass("focus"); //设定当前行为选中行
        });
    });
</script>

<title>返现记录</title>
</head>

<body>

<div id="position">当前位置：返现记录</div>

<div>
    <form name="query" method="get" action="">
        开始日期：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM'})" id='dateStart' name='dateStart' size="12" value='<?php echo $this->_tpl_vars['dateStart']; ?>
'/>
        <div class='show_br'></div>
        结束日期：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM'})" id="dateEnd" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['dateEnd']; ?>
">
        <div class='show_br'></div>
        <input type="submit" name="submit" value="按日期查询" />
    </form>
</div>

<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head'>
        <td>月份</td>   
        <td>代理uid</td>   
        <td>有消费的玩家数</td>
        <td>总消耗数</td>
        <td>奖励房卡</td>       
        <td>操作</td>       
    </tr>
    <?php $_from = $this->_tpl_vars['back_money_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['back_money_log']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['back_money_log']['get_money_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m") : smarty_modifier_date_format($_tmp, "%Y/%m")); ?>
</td>            
            <td><?php echo $this->_tpl_vars['back_money_log']['auid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['back_money_log']['pay_person_num']; ?>
</td>
            <td><?php echo $this->_tpl_vars['back_money_log']['pay_person_dimond_num']; ?>
</td>
            <td><?php echo $this->_tpl_vars['back_money_log']['get_money']; ?>
</td>
            <td>
                <?php if ($this->_tpl_vars['back_money_log']['status']): ?>
                    已发放房卡
                <?php else: ?>
                    <input type="button" value="发放" class="give_dimond" />
                    <input type="hidden" value="<?php echo $this->_tpl_vars['back_money_log']['id']; ?>
" />
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<div style="width:100%;height:150px;"></div>

<table id="tAgency1" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <tr class='table_list_head'>     
        <td>月份</td>
        <td>代理uid</td>   
        <td>返现金额</td>
        <td>发放时间</td>
        <td>操作</td>       
    </tr>
    <?php $_from = $this->_tpl_vars['every_month_get_money_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['get_money_log']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['get_money_log']['back_date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['get_money_log']['auid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['get_money_log']['back_money']; ?>
</td>
            <td>
                <?php if ($this->_tpl_vars['get_money_log']['status']): ?>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['get_money_log']['back_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>

                <?php else: ?>
                    未发放
                <?php endif; ?>
            </td>
            <td>
                <?php if ($this->_tpl_vars['get_money_log']['status']): ?>
                    已发放返现
                <?php else: ?>
                    <input type="button" value="发放" class="give_money" />
                    <input type="hidden" value="<?php echo $this->_tpl_vars['get_money_log']['id']; ?>
" />
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
&dateStart=<?php echo $this->_tpl_vars['dateStart']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>

<script>
    $('.give_money').click(function(){
        var id = $(this).next().val();
        $.ajax({
            dataType:'json',
            url:'agency_back_handle.php?action=handle_money',
            type:'get',
            data:{id:id},
            success:function(res){
                if(res){
                    alert(res.msg);
                    window.location.reload();               
                }else{
                    alert(res.msg);
                    window.location.reload();           
                }
            }
        })
    })

    $('.give_dimond').click(function(){
        var id = $(this).next().val();
        $.ajax({
            dataType:'json',
            url:'agency_back_handle.php?action=handle_dimond',
            type:'get',
            data:{id:id},
            success:function(res){
                if(res){
                    alert(res.msg);
                    window.location.reload();               
                }else{
                    alert(res.msg);
                    window.location.reload();           
                }
            }
        })
    })
    
</script>
</body>
</html>