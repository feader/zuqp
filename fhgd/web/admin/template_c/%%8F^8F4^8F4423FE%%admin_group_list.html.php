<?php /* Smarty version 2.6.25, created on 2017-08-10 17:21:51
         compiled from module/admin/admin_group_list.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset=utf-8" />
        <title><?php echo $this->_tpl_vars['_lang']['left']['group_manage']; ?>
</title>
        <link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css"/>
        <link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css"/>
        <style type="text/css">

            #all {text-align:left;margin-left:4px; line-height:1;}
            #nodes {width:100%; float:left;border:1px #ccc solid;}
            #result {width: 100%; height:100%; clear:both; border:1px #ccc solid;}

        </style>
        <script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
    </head>

<body>
    <div id="all">
        <div id="position"><?php echo $this->_tpl_vars['_lang']['left']['admin_manage']; ?>
：<?php echo $this->_tpl_vars['_lang']['left']['group_manage']; ?>
</div>
        <div id="main">
            <input type=button value="<?php echo $this->_tpl_vars['_lang']['left']['add_group']; ?>
" onclick="window.location='group_manage.php?action=new'"/>
            <table id="group" width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
                <tr class="table_list_head">
                    <th><?php echo $this->_tpl_vars['_lang']['left']['group_name']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['_lang']['left']['group_members']; ?>
</th>
                    <th><?php echo $this->_tpl_vars['_lang']['left']['function']; ?>
</th>
                </tr>
                <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
                <?php if ($this->_sections['loop']['rownum'] % 2 == 0): ?>
                <tr class="trEven">
                <?php else: ?>
                <tr class="trOdd">
                <?php endif; ?>
                <td width="20%"><?php echo $this->_tpl_vars['data'][$this->_sections['loop']['index']]['name']; ?>
</td>
                <td width="60%">
                   <?php $_from = $this->_tpl_vars['data'][$this->_sections['loop']['index']]['admin']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                   <a href="admin_manage.php?action=update&uid=<?php echo $this->_tpl_vars['item']; ?>
" ><?php echo $this->_tpl_vars['admin'][$this->_tpl_vars['item']]; ?>
</a>&nbsp
                   <?php endforeach; endif; unset($_from); ?>
                </td>
                <td width="20%"><a  href='group_manage.php?action=update&gid=<?php echo $this->_tpl_vars['data'][$this->_sections['loop']['index']]['gid']; ?>
'><?php echo $this->_tpl_vars['_lang']['left']['update_power']; ?>
</a> / <a  href='group_list.php?action=delete&gid=<?php echo $this->_tpl_vars['data'][$this->_sections['loop']['index']]['gid']; ?>
&name=<?php echo $this->_tpl_vars['data'][$this->_sections['loop']['index']]['name']; ?>
'><?php echo $this->_tpl_vars['_lang']['left']['delete_group']; ?>
</a></td>
                </tr>
                <?php endfor; endif; ?>
            </table>
        </div>
    </div>
    
</body>


</html>