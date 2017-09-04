<?php /* Smarty version 2.6.25, created on 2017-09-04 16:14:35
         compiled from module/game_data/game_data.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据总览</title>
<link rel="stylesheet" href="../../../admin/static/css/base.css" type="text/css">
<link rel="stylesheet" href="../../../admin/static/css/style.css" type="text/css">
<style type="text/css">

#all {text-align:left;margin-left:4px; line-height:1;}
#nodes {width:100%; float:left;border:1px #ccc solid;}
#result {width: 100%; height:100%; clear:both; border:1px #ccc solid;}

</style>
<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../admin/static/js/highcharts.js"></script>
<script type="text/javascript" src="../../../admin/static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'spline'
		},
			
		title: {
			text: '在线人数曲线图'
		},

		xAxis: {
			type: 'datetime'
		},
			
		yAxis: {
			title: {
				text: '在线人数'
			},
			min: 0,
			maxPadding: 0.02,
			minorGridLineWidth: 0, 
			gridLineWidth: 0,
			alternateGridColor: null
		},
					
		tooltip: {
			formatter: function() {
                return '<b>在线人数</b><br/>'+ this.series.name + Highcharts.dateFormat(' %H:%M:%S', this.x) +', '+ this.y +' 人';
			}
		},

		plotOptions: {
			spline: {
				lineWidth: 1,
				states: {
					hover: {
						lineWidth: 2
					}
				},
		
				marker: {
					enabled: false,
					states: {
						hover: {
							enabled: true,
							symbol: 'circle',
							radius: 5,
							lineWidth: 1
						}
					}	
				},

				pointInterval: 30, // one hour
				//pointStart: Date.UTC(2009, 9, 6, 0, 0, 0)
			}
		},

		series: [
			{
				name: '选择时段内',
				data: [<?php echo $this->_tpl_vars['today_data']; ?>
]
				
			}
		],

		navigation: {
			menuItemStyle: {
				fontSize: '10px'
			}
		}
	});
});
				
</script>
<link rel="stylesheet" href="../../../admin/static/css/public.css" type="text/css">
</head>

<body>
<div id="all">
	<div id="position">当前位置: 数据总览 > 数据总览</div>
    <div id="main">
    	<div>
			总注册人数：<?php echo $this->_tpl_vars['register_num_total']; ?>
 <br>
			当前在线人数：<?php echo $this->_tpl_vars['now_online']; ?>
 <br>
			房卡消耗总数：<?php echo $this->_tpl_vars['all_cost_dimond']; ?>
 <br>
			房卡销售总数：<?php echo $this->_tpl_vars['all_sell_dimond']; ?>
 <br>
			本日房卡消耗总数：<?php echo $this->_tpl_vars['today_cost_dimond']; ?>
 <br>
    	</div>

    	<div>
    	<!-- <form name="form" action="game_data.php" method="post" >
            在线人数曲线：
            <select name="select_time" >
				<option id="one_hour" value="one_hour" <?php if ($this->_tpl_vars['select_time'] == 'one_hour'): ?>selected<?php endif; ?> >一小时内</option>
				<option id="six_hour" value="six_hour" <?php if ($this->_tpl_vars['select_time'] == 'six_hour'): ?>selected<?php endif; ?> >六小时内</option>
				<option id="one_day" value="one_day" <?php if ($this->_tpl_vars['select_time'] == 'one_day'): ?>selected<?php endif; ?> >一天内</option>
				<option id="one_week" value="one_week" <?php if ($this->_tpl_vars['select_time'] == 'one_week'): ?>selected<?php endif; ?> >一周内</option>
				<option id="one_month" value="one_month" <?php if ($this->_tpl_vars['select_time'] == 'one_month'): ?>selected<?php endif; ?> >一月内</option>
				<option id="three_month" value="three_month" <?php if ($this->_tpl_vars['select_time'] == 'three_month'): ?>selected<?php endif; ?> >三月内</option>
				<option id="sex_month" value="sex_month" <?php if ($this->_tpl_vars['select_time'] == 'sex_month'): ?>selected<?php endif; ?> >六月内</option>
				<option id="one_year" value="one_year" <?php if ($this->_tpl_vars['select_time'] == 'one_year'): ?>selected<?php endif; ?> >一年内</option>
			</select>
            &nbsp;<input type="image" name='search' src="<?php echo $this->_tpl_vars['_lang']['new']['search_button']; ?>
" class="input2"/>
        </form> -->
    	</div>

		<div class="box">
			<div id="nodes">
				<div id="container" style="width: 95%; height: 100%"></div>
			</div>
		</div>
    </div>
</div>

<div class="divOperation" style="margin:10px 0 0 0;">

    <form name="myform" method="get" action="game_data.php" id="user_info">  
	    创建起始：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateStart" size="12" value="<?php echo $this->_tpl_vars['date_time']['datestart']; ?>
">
	    <div class='show_br'></div>
	    创建结束：<input type="text" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" name="dateEnd" size="12" value="<?php echo $this->_tpl_vars['date_time']['dateend']; ?>
">  
	    <div class='show_br'></div> 
    <input type="submit" value="导出" id='sub_btn'>
    <input type="hidden" value="do_execel" name="action" id='action'/>
    </form>
</div>
</body>
<script type="text/javascript" src="../../../admin/static/js/public.js"></script>
</html>