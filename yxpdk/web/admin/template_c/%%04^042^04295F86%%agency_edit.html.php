<?php /* Smarty version 2.6.25, created on 2017-08-23 18:46:56
         compiled from module/agency_manager/agency_edit.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['_lang']['left']['open_close']; ?>
</title>
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">

<style type="text/css">

#all {text-align:left;margin-left:4px; line-height:1;}
#nodes {width:100%; float:left;border:1px #ccc solid;}
#result {width: 100%; height:100%; clear:both; border:1px #ccc solid;}

</style>
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="../../../admin/static/js/jquery.qrcode.min.js"></script>

</head>

 <body>
 <div id="position">当前位置：代理系统 > 代理编辑</div>
	<form action="agent_save.php" method="post">
		<p>代理：<?php echo $this->_tpl_vars['detail']['uid']; ?>
</p>代理：
		修改密码: <input type="password" name="pwd"  value=""> 
		<br>       
		备注: <input type="text" name="note"  value="<?php echo $this->_tpl_vars['detail']['note']; ?>
"> 
		<br>
        权限等级: 
        <select name="grade" id="">
            <option value="1" <?php if ($this->_tpl_vars['detail']['grade'] == 1): ?>selected<?php endif; ?>>皇冠</option>    
            <option value="2" <?php if ($this->_tpl_vars['detail']['grade'] == 2): ?>selected<?php endif; ?>>钻石</option>    
            <option value="3" <?php if ($this->_tpl_vars['detail']['grade'] == 3): ?>selected<?php endif; ?>>白金</option>    
            <option value="4" <?php if ($this->_tpl_vars['detail']['grade'] == 4): ?>selected<?php endif; ?>>水晶</option>    
        </select>
        <br>
		<input type="hidden" value="<?php echo $this->_tpl_vars['detail']['id']; ?>
" name="id" />
		<input name="submit" value="提交修改"  type="submit">
		<br><br>

	</form>

<div>
    <p>推广二维码</p>
</div>
<div id="qrcode" style="display:none;"></div>
<div id="show_qrcode"></div>
<div style="width:300px;margin:0 auto;">
        <p style="text-align:center;">
            分享链接:<?php echo $this->_tpl_vars['fx_url']; ?>
<?php echo $this->_tpl_vars['agency_uid']; ?>
-<?php echo $this->_tpl_vars['game_id']; ?>

        </p>
    </div>
</div>	

	

	
<script>
    jQuery('#qrcode').qrcode({
        render  : "canvas",//也可以替换为table
        width   : 160,
        height  : 160,
        text    : "<?php echo $this->_tpl_vars['fx_url']; ?>
<?php echo $this->_tpl_vars['agency_uid']; ?>
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