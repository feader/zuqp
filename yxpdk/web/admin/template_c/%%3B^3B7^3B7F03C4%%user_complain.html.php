<?php /* Smarty version 2.6.25, created on 2017-09-02 12:07:07
         compiled from module/game_manager/user_complain.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/game_manager/user_complain.html', 70, false),array('modifier', 'date_format', 'module/game_manager/user_complain.html', 90, false),)), $this); ?>
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
<title>用户列表</title>
</head>

<body>

<div id="position">当前位置：玩家反馈</div>
<div>

<div class="divOperation">

    <form name="myform" method="get" action="user_complain.php" id="user_info">
    会员ID：<input type="text" name="uid" value="<?php echo $this->_tpl_vars['uid']; ?>
" />
    <div class='show_br'></div>
    <!-- 处理人：<input type="text" name="handler" value="<?php echo $this->_tpl_vars['handler']; ?>
" />
    <div class='show_br'></div> -->
    创建起始：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
">
    <div class='show_br'></div>
    创建结束：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
">
    <div class='show_br'></div>
   
   
    <input type="button" value="查询" id='sub_btn'>
    <input type="hidden" value="" name="action" id='action'/>
    </form>
    <input type="button" value="导出" id='do_execel'/>
</div>
<br/>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>编号</td>
        <td>玩家ID</td>
        <td>联系方式</td>      
        <td>状态</td>       
        <td>内容</td>       
        <td>回复</td>       
        <td>处理人</td>       
        <td>创建时间</td>       
        <td>更新时间</td>             
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['user_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['log_list']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['log_list']['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['uid']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['contact_way']; ?>
</td>
            <td>
                <?php if ($this->_tpl_vars['log_list']['status'] == 1): ?>
                已回复
                <?php else: ?>
                未回复
                <?php endif; ?>
            </td>
            <td>
                <?php if ($this->_tpl_vars['log_list']['status'] == 0): ?>
                <a href="<?php echo $this->_tpl_vars['URL_SELF']; ?>
?page=<?php echo $this->_tpl_vars['page']; ?>
&id=<?php echo $this->_tpl_vars['log_list']['id']; ?>
"><?php echo $this->_tpl_vars['log_list']['content']; ?>
</a>
                <?php else: ?>
                <?php echo $this->_tpl_vars['log_list']['content']; ?>

                <?php endif; ?>
            </td>
            <td><?php echo $this->_tpl_vars['log_list']['call_back']; ?>
</td>
            <td><?php echo $this->_tpl_vars['log_list']['handler']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log_list']['create_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['log_list']['update_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>                                           
        </tr>
        <?php if ($this->_tpl_vars['detail_info']['id'] == $this->_tpl_vars['log_list']['id']): ?>
            <form action="user_complain.php" method="post" id="edit_area">
            <tr>
                <td>
                    <textarea name="call_back" id="" cols="40" rows="5" placeholder='给玩家的回复填在此处'></textarea>
                </td>
                <td>
                    <input type="button" value="提交" id="edit_sub" />
                </td>
            </tr>
            <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['detail_info']['id']; ?>
" />
            <input type="hidden" name="action" value="edit_info" />
            </form>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    
    </tbody>
</table>


<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
&handler=<?php echo $this->_tpl_vars['handler']; ?>
&uid=<?php echo $this->_tpl_vars['uid']; ?>
&dateStart=<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
&dateEnd=<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
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