<?php /* Smarty version 2.6.25, created on 2017-09-03 18:52:41
         compiled from module/agency/agency_left.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['_lang']['login']['back_sys_name']; ?>
</title>
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<meta id="viewport" name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0" />
<style type="text/css">
body { margin:3px; padding:0px; font-size:12px; font-family:"Courier New", Courier, monospace; background:#86C1FF; margin:3 0 0 0;}
.tdborder {
  border-left: 1px solid #43938B;
  border-right: 1px solid #43938B;
  border-bottom: 1px solid #43938B;
}
.tdrl {
  border-left: 1px solid #788C47;
  border-right: 1px solid #788C47;
}
.topitem {
  cursor: hand;
  background-image:url(../../../admin/static/images/mtbg1.gif);
  height:24px;
  width:95%;
  border-right: 1px solid #2FA1DB;
  border-left: 1px solid #2FA1DB;
  clear:left
}
.itemsct {
  border-right: 1px solid #2FA1DB;
  border-left: 1px solid #2FA1DB;
  background-color:#EEFAFE;
  margin-bottom:6px;
  width:95%;
}
.itemem {
  text-align:left;
  clear:left;
  border-bottom: 1px solid #2FA1DB;
  height:21px;
}
.tdl {
  float:left;
  margin-top:2px;
  margin-left:6px;
  margin-right:5px
}
.tdr {
  float:left;
  margin-top:2px
}
.topl {
  float:left;

  margin-right:3px;
}
.topr {
  padding-top:4px;
  cursor:pointer;
}
.toprt {
  text-align:center;
  padding-top:3px
}
body {
  scrollbar-base-color:#8CC1FE;
  scrollbar-arrow-color:#FFFFFF;
  scrollbar-shadow-color:#6994C2
}
.green{
  background-color:#CCFFCC;
}


</style>
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>

</head>

<body>

  <div id="all">

      <div class='topitem' align='left'>

        <div class='topl'></div>

        <div class='topr'>运营代理后台</div>

      </div>
 
      <div style='clear:both'></div>

      <div style='display:block' id='items1' class='itemsct'>

      <?php if ($this->_tpl_vars['grade'] == 1): ?>
        <dl class='itemem'>
          <dd class='tdr'><a href="agency_main.php" target='main_frame'>首页</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell.php' target='main_frame'>出售(玩家)</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_to_agency.php' target='main_frame'>出售(代理)</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_recharge.php' target='main_frame'>充值</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_recharge_log.php' target='main_frame'>充值记录</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_log.php' target='main_frame'>出售记录（玩家）</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_to_agency_log.php' target='main_frame'>出售记录（代理）</a></dd>
        </dl>
       
        <dl class='itemem'>
          <dd class='tdr'><a href='agency_leaguer_list.php' target='main_frame'>我的下级代理</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_wx_user.php' target='main_frame'>我的推广用户</a></dd>
        </dl>

         <dl class='itemem'>
          <dd class='tdr'><a href='agency_view_invite_user.php' target='main_frame'>用户消耗</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_dimond_back.php' target='main_frame'>我的返卡</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_money_back.php' target='main_frame'>我的返现</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_bank_info.php' target='main_frame'>我的银行资料</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_setting.php' target='main_frame'>设置</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_logoff.php' target='main_frame'>退出</a></dd>
        </dl>
      <?php endif; ?>
      
      <?php if ($this->_tpl_vars['grade'] == 2): ?>
        <dl class='itemem'>
          <dd class='tdr'><a href="agency_main.php" target='main_frame'>首页</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell.php' target='main_frame'>出售(玩家)</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_to_agency.php' target='main_frame'>出售(代理)</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_recharge.php' target='main_frame'>充值</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_recharge_log.php' target='main_frame'>充值记录</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_log.php' target='main_frame'>出售记录（玩家）</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_to_agency_log.php' target='main_frame'>出售记录（代理）</a></dd>
        </dl>
       
        <dl class='itemem'>
          <dd class='tdr'><a href='agency_leaguer_list.php' target='main_frame'>我的下级代理</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_wx_user.php' target='main_frame'>我的推广用户</a></dd>
        </dl>

         <dl class='itemem'>
          <dd class='tdr'><a href='agency_view_invite_user.php' target='main_frame'>用户消耗</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_dimond_back.php' target='main_frame'>我的返卡</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_money_back.php' target='main_frame'>我的返现</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_bank_info.php' target='main_frame'>我的银行资料</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_setting.php' target='main_frame'>设置</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_logoff.php' target='main_frame'>退出</a></dd>
        </dl>
      <?php endif; ?>

      <?php if ($this->_tpl_vars['grade'] == 3): ?>
        <dl class='itemem'>
          <dd class='tdr'><a href="agency_main.php" target='main_frame'>首页</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell.php' target='main_frame'>出售(玩家)</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_to_agency.php' target='main_frame'>出售(代理)</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_recharge.php' target='main_frame'>充值</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_recharge_log.php' target='main_frame'>充值记录</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_log.php' target='main_frame'>出售记录（玩家）</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_sell_to_agency_log.php' target='main_frame'>出售记录（代理）</a></dd>
        </dl>
       
        <dl class='itemem'>
          <dd class='tdr'><a href='agency_leaguer_list.php' target='main_frame'>我的下级代理</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_wx_user.php' target='main_frame'>我的推广用户</a></dd>
        </dl>

         <dl class='itemem'>
          <dd class='tdr'><a href='agency_view_invite_user.php' target='main_frame'>用户消耗</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_dimond_back.php' target='main_frame'>我的返卡</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_money_back.php' target='main_frame'>我的返现</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_bank_info.php' target='main_frame'>我的银行资料</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_setting.php' target='main_frame'>设置</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_logoff.php' target='main_frame'>退出</a></dd>
        </dl>
      <?php endif; ?>

      <?php if ($this->_tpl_vars['grade'] == 4): ?>
        <dl class='itemem'>
          <dd class='tdr'><a href="agency_main.php" target='main_frame'>首页</a></dd>
        </dl>
                                  
        <dl class='itemem'>
          <dd class='tdr'><a href='agency_get_wx_user.php' target='main_frame'>我的推广用户</a></dd>
        </dl>

         <dl class='itemem'>
          <dd class='tdr'><a href='agency_view_invite_user.php' target='main_frame'>用户消耗</a></dd>
        </dl>
        
        <dl class='itemem'>
          <dd class='tdr'><a href='agency_bank_info.php' target='main_frame'>我的银行资料</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_setting.php' target='main_frame'>设置</a></dd>
        </dl>

        <dl class='itemem'>
          <dd class='tdr'><a href='agency_logoff.php' target='main_frame'>退出</a></dd>
        </dl>
      <?php endif; ?>
      
      </div>

    </div>

  </body>

</html>