<?php /* Smarty version 2.6.25, created on 2017-09-01 09:33:59
         compiled from module/admin/group_manage.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>群组管理</title>
        <link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css"/>
        <link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css"/>
        <style type="text/css">

            #all {text-align:left;margin-left:4px; line-height:1;}
            #nodes {width:100%; float:left;border:1px #ccc solid;}
            #result {width: 100%; height:100%; clear:both; border:1px #ccc solid;}

        </style>
        <script type="text/javascript" src="/web/admin/static/js/jquery.min.js"></script>
        <script type="text/javascript">
            function checkAll (chkbox) {
                $(chkbox).attr("checked",'true')
            }
            
            function checkNone(chkbox){
                $(chkbox).removeAttr("checked");
            }

            function checkReverse(chkbox){
                $(chkbox).each(function(){
                if($(this).attr("checked"))
                    $(this).removeAttr("checked");
                else
                    $(this).attr("checked",'true');
                })
            }

            function checkcy(chkbox){
                $(chkbox).each(function(){
                    var value = $(this).val();
                if( (value > 2 && value <= 10) || value == 50)
                    $(this).attr("checked",'true');
                else
                    $(this).removeAttr("checked");
                })
            }
        </script>
    </head>
    <body>
        <div id="all">
            <div id="position">后台管理：群组权限管理</div>
            <div id="main">
                <form  name=checkboxform action="" method="post">
                    <input type='hidden' name='action' value='<?php echo $this->_tpl_vars['action']; ?>
'/>
                    <input type='hidden' name='gid' value='<?php echo $this->_tpl_vars['gid']; ?>
'/>
                    <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
                        <tr bgcolor="#D2E9FF">
                            <td width="15%">群组名：</td>
                            <td width="85%"><input type="text" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
"/></td>
                        </tr>
                        <tr bgcolor="#D2E9FF">
                            <td width="15%">描述：</td>
                            <td width="85%"><input type="text" size="90"  name="remark" value="<?php echo $this->_tpl_vars['remark']; ?>
"/></td>
                        </tr>
                        <tr bgcolor="#D2E9FF">
                            <td colspan='1' width="15%">设置功能操作：</td>
                            <td colspan='1' width="85%">
                                <input type=button value="全部选中" onclick="checkAll('.chkbox')"/>
                                <input type=button value="全部不选" onClick="checkNone('.chkbox')"/>
                                <input type=button value="反选" onClick="checkReverse('.chkbox')"/>
                                <input type=button value="对外权限" onClick="checkcy('.chkbox')"/>
                            </td>
                        </tr>
                        <tr bgcolor="#E0EEEE" height="50">
                            <td width="15%">数据总览</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'GAME_DATA'): ?>
                                <input type="checkbox" id="1" class="chkbox" name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>

                                    <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/>
                                    <?php echo $this->_tpl_vars['loop']['desc']; ?>

                                <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <tr bgcolor="#F7F7F7" height="50">
                            <td width="15%">游戏管理</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'GAME_MANAGER'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?> /><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <tr bgcolor="#E0EEEE" height="50">
                            <td width="15%">用户管理</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'USER_MANAGER'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?> /><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <tr bgcolor="#F7F7F7" height="50">
                            <td width="15%">充值与管理</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'RECHARGE_MANAGER'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <tr bgcolor="#E0EEEE" height="50">
                            <td width="15%">代理系统</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'AGENCY_MANAGER'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
						<tr bgcolor="#E0EEEE" height="50">
                            <td width="15%">管理员系统</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'ADMIN_MANAGER'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <!-- <tr bgcolor="#F7F7F7" height="50">
                            <td width="15%">消息管理</td>
                            <td width="85%">                          
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'MSG_MAN'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <tr bgcolor="#E0EEEE" height="50">
                            <td width="15%">GM管理</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'GM_MAN'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <tr bgcolor="#F7F7F7" height="50">
                            <td width="15%">后台管理</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'BACK_MAN'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr>
                        <tr bgcolor="#E0EEEE" height="50">
                            <td width="15%">系统管理</td>
                            <td width="85%">
                                <?php $_from = $this->_tpl_vars['group_power']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['loop']):
?>
                                <?php if ($this->_tpl_vars['loop']['man_type'] == 'SYSTEM'): ?>
                                <input type="checkbox" id="1" class="chkbox"  name="power[]" value=<?php echo $this->_tpl_vars['loop']['man_id']; ?>
 <?php if ($this->_tpl_vars['loop']['check_flag'] == 1): ?>checked<?php endif; ?>/><?php echo $this->_tpl_vars['loop']['desc']; ?>

                                    <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                            </td>
                        </tr> -->
                        <tr><td colspan="2"><div align="center"><input type="submit" name="submit" value="保存"/>
                                    <input type="reset" name="reset" value="重置" /></div></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>



