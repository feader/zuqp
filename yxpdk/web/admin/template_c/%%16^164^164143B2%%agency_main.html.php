<?php /* Smarty version 2.6.25, created on 2017-09-03 18:53:04
         compiled from module/agency/agency_main.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>

<title><?php echo $this->_tpl_vars['_lang']['left']['recharge_record']; ?>
</title>
</head>

<body>

<div id="position">您当前位置：首页</div>

<div>
<table cellspacing="1" cellpadding="1" border="0" class='table_list' >
    <tr>
        <td align="left">呢称：<?php echo $this->_tpl_vars['agency']['nick_name']; ?>
</td>
    </tr>
    <tr>
        <td align="left">余额: <?php echo $this->_tpl_vars['agency']['recharge_dimond']; ?>
</td>
    </tr>
    <tr>
        <td align="left">推荐返利: <?php echo $this->_tpl_vars['agency']['recharge_send_dimond']; ?>
</td>
    </tr>
    <tr>
        <td align="left">累计充值奖励: <?php echo $this->_tpl_vars['agency']['recharge_send_dimond']; ?>
</td>
    </tr>
</table>
</div>
<div>
	<p><h1>公告</h1></p>
	<p align="left"><?php echo $this->_tpl_vars['notice']; ?>
</p>
</div>
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