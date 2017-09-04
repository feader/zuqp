<?php /* Smarty version 2.6.25, created on 2017-08-23 14:21:24
         compiled from module/agency/agency_get_wx_user_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/agency/agency_get_wx_user_list.html', 51, false),array('modifier', 'truncate', 'module/agency/agency_get_wx_user_list.html', 55, false),array('modifier', 'date_format', 'module/agency/agency_get_wx_user_list.html', 60, false),)), $this); ?>
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
<script type="text/javascript" src="../../../admin/static/js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tAgency tbody tr").click(function () {
            $(this).parent().find("tr.focus").toggleClass("focus"); //取消原先选中行
            $(this).toggleClass("focus"); //设定当前行为选中行
        });
    });
</script>

<title>我的微信推广用户</title>
</head>

<body>

<div id="position">您当前位置：我的微信推广用户</div>
<div>
<table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
    <thead>
    <tr class='table_list_head'>
        <td>编号</td>
        <td>推广者</td>
        <td>会员ID</td>
        <td>微信unionid</td>
        <td>下载IP</td>
        <td>昵称</td>      
        <td>钻石余额</td>
        <td>累计充值钻石</td>
        <td>推广绑定时间</td>       
        <td>注册时间</td>       
    </tr>
    </thead>

    <tbody>
    <?php $_from = $this->_tpl_vars['leaguer_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['leaguer']):
?>
        <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
            <td><?php echo $this->_tpl_vars['leaguer']['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['leaguer']['agency_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['leaguer']['uid']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['leaguer']['unionid'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 20, "*****", true) : smarty_modifier_truncate($_tmp, 20, "*****", true)); ?>
</td>
            <td><?php echo $this->_tpl_vars['leaguer']['agent_ip']; ?>
</td>
            <td><?php echo $this->_tpl_vars['leaguer']['username']; ?>
</td>
            <td><?php echo $this->_tpl_vars['leaguer']['dimond']; ?>
</td>           
            <td><?php echo $this->_tpl_vars['leaguer']['sum_dimond']; ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['leaguer']['action_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['leaguer']['register_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M:%S")); ?>
</td>
            
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>

<?php $_from = $this->_tpl_vars['pageHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page_name'] => $this->_tpl_vars['page_id']):
?>
    <a href="?pid=<?php echo $this->_tpl_vars['page_id']; ?>
"><?php echo $this->_tpl_vars['page_name']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
<br/>
<div>
    <p>推广二维码</p>
</div>
<div id="qrcode" style="display:none;"></div>
<div id="show_qrcode"></div>
<div style="width:300px;margin:0 auto;">
        <p style="text-align:center;">
            分享链接:<?php echo $this->_tpl_vars['fx_url']; ?>
<?php echo $this->_tpl_vars['myself']; ?>
-<?php echo $this->_tpl_vars['game_id']; ?>

        </p>
        <p style="text-align:center;">
            <a href="show_tgcode.php?code_url=<?php echo $this->_tpl_vars['fx_url']; ?>
<?php echo $this->_tpl_vars['myself']; ?>
-<?php echo $this->_tpl_vars['game_id']; ?>
" style='color:red;' target="_blank">ios或者不能保存二维码的手机用户请点击这里</a>
        </p>    
    </div>
</div>
<script>
    jQuery('#qrcode').qrcode({
        render  : "canvas",//也可以替换为table
        width   : 160,
        height  : 160,
        text    : "<?php echo $this->_tpl_vars['fx_url']; ?>
<?php echo $this->_tpl_vars['myself']; ?>
-<?php echo $this->_tpl_vars['game_id']; ?>
"
    });

    //从canvas中提取图片image
    function convertCanvasToImage(canvas) {
        //新Image对象，可以理解为DOM
        var image = new Image();
        // canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持
        // 指定格式PNG
        image.src = canvas.toDataURL("image/png");
        return image;
    }

    //获取网页中的canvas对象
    var mycanvas1=document.getElementsByTagName('canvas')[0];

    //将转换后的img标签插入到html中
    var img = convertCanvasToImage(mycanvas1);
    $('#show_qrcode').append(img);//imgDiv表示你要插入的容器id
</script>
</body>
</html>