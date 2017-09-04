<?php /* Smarty version 2.6.25, created on 2017-09-02 16:44:41
         compiled from module/agency/agency_setting.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'module/agency/agency_setting.html', 43, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
<style>
    .write_area{width:100px;}
</style>
<title>信息设置</title>
</head>

<body>

<div id="position">您当前位置：设置</div>

<div>
    <form name='search_condition' method="post" action="agency_setting.php">
        <table align="center">
            <tr>
                <td align="right">用户ID：</td><td align="left"><span><?php echo $this->_tpl_vars['agency']['uid']; ?>
</span></td>
            </tr>
             <tr>
                <td align="right">昵称：</td><td><input type="text" name="nick_name" value='<?php echo $this->_tpl_vars['agency']['nick_name']; ?>
' class='write_area'></td>
            </tr>
             <tr>
                <td align="right">手机：</td><td><input type="text" name="phone_number" value='<?php echo $this->_tpl_vars['agency']['phone_number']; ?>
' class='write_area'></td>
            </tr>
             <tr>
                <td align="right">修改密码：</td>
                <td>
                    <input type="password" name="password1" value=""  placeholder="*不输入则不更改" class='write_area'>       
                </td>
            </tr>
             <tr>
                <td align="right">确认密码：</td><td><input type="password" name="password2" value="" class='write_area'></td>
            </tr>
             <tr>
                <td align="right">注册时间：</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['agency']['register_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
            </tr>     
        </table>
        <input type="hidden" name="action" value="save">
        <input type="submit" name="submit" value="保存" /><br><br>
        <span><a href="index.php">返回首页</a></span>
    </form>
</div>

</body>
</html>