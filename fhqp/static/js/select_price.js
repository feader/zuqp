// $('#select_game').on("change select",function(){
// 	var gid = $(this).val();
// 	var uid = $(guid).val();
// 	get_play_info(gid,uid);

// })

function get_play_info(gid,uid,auid){		
	var url = get_post_play_url(gid);
	$.ajax({
		url: url,
		async:true,
		type: 'GET',
		data: {uid:uid,gid:gid},
		dataType:'jsonp',
		jsonp:'uinfo',
		success: function(res) {

			if(!res){
				$('.pays').html('');	
				$('.pays').html('你还没登陆过这个游戏');
				$('#uid').html('不存在');		
				$('#diamond').html('无');		
				return false;
			}
			if(res.uid!='' && res.dimond!=0){
				var str = '';
				$('.pays').html('');	
				$('#uid').html(res.uid);		
				$('#diamond').html(res.dimond);	
				str += return_str(gid,uid,auid);
				$('.pays').html(str);	
			}else{
				$('.pays').html('');	
				$('.pays').html('你还没登陆过这个游戏');	
			}								
		}
		// error: function(res){
		// 		$('.pays').html('你还没登陆过这个游戏');	
		// }
	})
}

function get_post_play_url(gid){		
	var url; 
	switch (gid) {
	    case '1':
	      	url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/get_user_info.php';
	      	break;   
	    case '2':
	      	url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/get_user_info.php';
	      	break;   
	    case '3':
	      	url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/get_user_info.php';
	      	break;     	  	
	    default:
	      	url = '';
	      	break;
	}
	return url;
}

function return_str(gid,uid,auid){
	var str=''; 
	switch (gid) {
	    case '1':
	      	str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=1&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥12 可获得 12 张房卡</a>';
			str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=2&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥30 可获得 30 张房卡</a>';
			str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=3&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥138 可获得 138 张房卡</a>';		
	      	break;   
	    case '2':
	      	str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=1&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥12 可获得 12 张房卡</a>';
			str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=2&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥36 可获得 36 张房卡</a>';
			str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=3&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥138 可获得 138 张房卡</a>';		
	      	break;   
	    case '3':
	      	str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=1&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥12 可获得 12 张房卡</a>';
			str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=2&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥60 可获得 60 张房卡</a>';
			str += "<a href='http://fhqp.yzbmsh.cn/tool/wxpay/example/jsapi.php?uid="+uid+'&tid=3&gid='+gid+'&auid='+auid+"'"+'>打赏 ¥138 可获得 138 张房卡</a>';		
	      	break;     	  	  	
	    default:
	      	str = '';
	      	break;
	}
	return str;
}
get_play_info(gid,uid,auid);
