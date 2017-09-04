<?php /* Smarty version 2.6.25, created on 2017-09-02 15:33:52
         compiled from module/admin/set_values.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'module/admin/set_values.html', 30, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>

<title>设置参数</title>
</head>

<body>

<div id="position">您当前位置：设置参数</div>

<div>
    <table id="tAgency" cellspacing="1" cellpadding="3" border="0" class='table_list' >
        <thead>
            <tr class='table_list_head'>
                <td>参数名</td>                        
                <td>参数说明</td>    
                <td>参数值</td>               
                <td>操作</td>
            </tr>
        </thead>

        <tbody>
        <?php $_from = $this->_tpl_vars['setting_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['setting_info']):
?>
            <tr class="<?php echo smarty_function_cycle(array('values' => 'trOdd, trEven'), $this);?>
">
                <td><?php echo $this->_tpl_vars['setting_info']['setting_name']; ?>
</td>     
                <td><?php echo $this->_tpl_vars['setting_info']['value_introduce']; ?>
</td>  
                <td><input type="text" value="<?php echo $this->_tpl_vars['setting_info']['setting_value']; ?>
" /></td>                            
                <td> 
                <?php if ($this->_tpl_vars['gid'] == 1): ?>
                    <input type="button" class="edit_save" value="修改" />
                    <input type="hidden" value="<?php echo $this->_tpl_vars['setting_info']['id']; ?>
" />                          
                <?php endif; ?>     
                </td>          
            </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>
</div>
<script>
    $('.edit_save').click(function(){
        var id = $(this).next().val();
        var setting_value = $(this).parent().prev().children().val();
        $.ajax({
            type:'post',
            url:'setting_save.php?action=save_info',
            data:{id:id,setting_value:setting_value},
            dataType:'json',
            success:function(res){
                if(res.rcode){
                    alert('修改成功！');
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