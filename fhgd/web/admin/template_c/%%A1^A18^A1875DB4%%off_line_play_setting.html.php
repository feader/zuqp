<?php /* Smarty version 2.6.25, created on 2017-07-25 17:34:35
         compiled from module/admin/off_line_play_setting.html */ ?>
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
    });
</script>

<title>活动设置</title>
</head>

<body>

<div id="position">当前位置：线下赛设置</div>
<div>
    <form action="off_line_play_setting.php" method="get" id="user_info">        
        报名分数：<input type="text" name="join_point" value="<?php echo $this->_tpl_vars['setting']['join_point']; ?>
" />
        <div class='show_br'></div>
        开始时间：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="start_time" size="12" value="<?php echo $this->_tpl_vars['data_time']['start_time']; ?>
">
        <div class='show_br'></div>
        结束时间：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="end_time" size="12" value="<?php echo $this->_tpl_vars['data_time']['end_time']; ?>
">    
        <div class='show_br'></div>
        <input type="button" value="保存" id='sub_btn'>
        <input type="hidden" value="save" name="action"/>
    </form>
</div>
<div>


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
       
        $('#user_info').submit();
    })
   

</script>
</body>
</html>