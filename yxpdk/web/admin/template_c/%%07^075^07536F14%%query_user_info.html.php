<?php /* Smarty version 2.6.25, created on 2017-09-04 15:41:28
         compiled from module/user_manager/query_user_info.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'module/user_manager/query_user_info.html', 39, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">当前位置：用户管理 > 用户查询</div>

<div>
    <form name="query" method="get" action="query_user_info.php">
        玩家UID：<input type="text" name="username" value=''>
        <input type="hidden" name="action" value="query">
        <input type="submit" name="submit" value="查询" />
    </form>
</div>

<div>
<table cellspacing="1" cellpadding="2" border="0" class='table_list' >
    <tr>
        <td align="left">ID</td>
        <td align="left"><?php echo $this->_tpl_vars['user']['uid']; ?>
</td>
    </tr>
    <tr>
        <td align="left">账号名</td>
        <td align="left"><?php echo $this->_tpl_vars['user']['username']; ?>
</td>
    </tr>
    <tr>
        <td align="left">创建日期</td>
        <td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['register_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
    </tr>
    <tr>
        <td align="left">最近登录</td>
        <td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['last_login_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
    </tr>
    <tr>
        <td align="left">最近充值</td>
        <td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['last_dimond_charge_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
    </tr>
    <tr>
        <td align="left">余额</td>
        <td align="left"><?php echo $this->_tpl_vars['user']['dimond']; ?>
</td>
    </tr>
    <tr>
        <td align="left">累计充值</td>
        <td align="left"><?php echo $this->_tpl_vars['user']['sum_dimond']; ?>
</td>
    </tr>
</table>
</div>

<div>
<input type="button" name="kickBtn" value="清除卡线" onclick="kickBtn()" >
<input type="button" name="clear_diamond" value="房卡清零" onclick="clear_diamond()" >
<input type="button" name="ban_account" value="封号" onclick="ban_account()" >
<input type="button" name="dis_ban_account" value="解封" onclick="dis_ban_account()" >
<input type="hidden" value="<?php echo $this->_tpl_vars['user']['uid']; ?>
" id='username'/>
</div>
<script>
    function kickBtn() {
        var name = $('#username').val();
        var part = 'gm/kick_down'
        if(name==''){
            alert('非法操作！');
            return false;
        }
        $.ajax({
            type:'GET',
            url:'curl_url.php',
            data:{username:name,part:part},
            dataType:'json',
            success:function(res){
                if(res){
                    alert('操作成功！');
                }else{
                    alert('操作失败！');
                }
            } 
        })
    }

    function clear_diamond() {
        var name = $('#username').val();
        var part = 'gm/clear_diamond'
        if(name==''){
            alert('非法操作！');
            return false;
        }
        $.ajax({
            type:'GET',
            url:'curl_url.php',
            data:{username:name,part:part},
            dataType:'json',
            success:function(res){
                if(res){
                    alert('操作成功！');
                }else{
                    alert('操作失败！');
                }
            } 
        })
    }

    function ban_account() {
        var name = $('#username').val();
        var part = 'gm/ban_account'
        if(name==''){
            alert('非法操作！');
            return false;
        }
        $.ajax({
            type:'GET',
            url:'curl_url.php',
            data:{username:name,part:part},
            dataType:'json',
            success:function(res){
                if(res){
                    alert('操作成功！');
                }else{
                    alert('操作失败！');
                }
            } 
        })
    }

    function dis_ban_account() {
        var name = $('#username').val();
        var part = 'gm/dis_ban_account'
        if(name==''){
            alert('非法操作！');
            return false;
        }
        $.ajax({
            type:'GET',
            url:'curl_url.php',
            data:{username:name,part:part},
            dataType:'json',
            success:function(res){
                if(res){
                    alert('操作成功！');
                }else{
                    alert('操作失败！');
                }
            } 
        })
    }
</script>

</body>
</html>