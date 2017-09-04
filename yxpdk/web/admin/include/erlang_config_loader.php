<?php

/**
* creator : neelkey
* 读取erlang config文件的工具包，代码比较脏，集合到一起   以后再整理
*/

  if (!defined('MING2_WEB_ADMIN_FLAG')) {
    exit ('hack attemp');
}  



function  loadShopCfg()
{
    global $A_DEBUG;
    $cfgName = '/data/mccq/server/config/world/shop_shops.config';
    if( $A_DEBUG) 
    {
        //本地测试路径
        $cfgName = 'E:/datang2/mge/config/world/shop_shops.config';
    }
     
    $item_price_list =file($cfgName); 
    $item_sell = array(); 
    foreach($item_price_list as $key => $line)
    {
        $line = trim( $line);
        //find shop info 
        if(strstr($line,'r_shop_goods') == false)
            continue;  
 //{r_shop_goods,11300004,1,1,3,3,[{p_shop_price,1,[{p_shop_currency,2,68}]}],[{p_shop_price,1,[{p_shop_currency,2,108}]}],[0,0],[0,400],1,15},
        sscanf($line,"{r_shop_goods,%d,%d,%d,%d,%d,[{p_shop_price,1,[{p_shop_currency,%d,%d,%s}]",$id,$a1,$a2,$a3,$a4,$pt,$price,$t2);
        $item_sell[$id] = $price;
      //  $a = $line;
    }
    return $item_sell;
}
 
 //简单的取物品配置表数据函数，最好还是去t_PGoods表取
function  loadItemcfg_Base()
{  
    global $A_DEBUG;
    $cfgName = '/data/mccq/server/config/world/item.config';
    if( $A_DEBUG) 
    {
        //本地测试路径
        $cfgName = 'E:/datang2/mge/config/world/item.config';
    }
        
    $itemfile =file($cfgName); 
    $items = array(); 
    foreach($itemfile as $key => $line)
    {
        $line = trim( $line);
        //find item info  , ignore comment
        if(strstr($line,'p_item_base_info') == false || substr($line,0,1) == '%')
            continue;  
 //{p_item_base_info,10100001,<<"草药">>,2,1,1,1,1,{p_use_requirement,0,0,400,0,0,0,0,0,0},{p_   ...............   
        //sscanf($line,"{p_item_base_info,%d,<<\"%s\">>,%s}]",$id,$name,$tmp);
        $tmpArr = explode (',' ,$line,8);
        $id = (int)$tmpArr[1];
        $name = $tmpArr[2];
        
        //去掉前后尖括号 ,例如<<"草药">>
        $name = substr($name,3,strlen($name) - 6);  
        
        $items[$id] = array('name' => $name);
      //  $a = $line;
    }
    return $items;
} 

function  loadStoneCfg_Base()
{  
    global $A_DEBUG;
    $cfgName = '/data/mccq/server/config/world/stone.config';
    if( $A_DEBUG) 
    {
        //本地测试路径
        $cfgName = 'E:/datang2/mge/config/world/stone.config';
    }
        
    $itemfile =file($cfgName); 
    $items = array(); 
    foreach($itemfile as $key => $line)
    {
        $line = trim( $line);
        //find item info , ignore comment
        if(strstr($line,'p_stone_base_info') == false || substr($line,0,1) == '%')
            continue;  
 //{p_stone_base_info,20100007,<<"七级攻击石">>,5,{p_use_requirement  .............
        //sscanf($line,"{p_item_base_info,%d,<<\"%s\">>,%s}]",$id,$name,$tmp);
        $tmpArr = explode (',' ,$line,4);
        $id = (int)$tmpArr[1];
        $name = $tmpArr[2];
        
        //去掉前后尖括号 ,例如<<"草药">>
        $name = substr($name,3,strlen($name) - 6);  
        
        $items[$id] = array('name' => $name);
      //  $a = $line;
    }
    return $items;
}   

?>
