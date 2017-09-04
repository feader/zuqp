<?php /* Smarty version 2.6.25, created on 2017-09-04 08:59:59
         compiled from module/agency_manager/generate_agency.html */ ?>
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
<script type="text/javascript">

function generateAgency(agencyGrade) {
	var uberAgency = '';
	if (agencyGrade == 2) {
		uberAgency = $('#grade2_agency').val();
		if(uberAgency==''){
			alert('上级代理不能为空');
		}
	}
	else if (agencyGrade == 3) {
		uberAgency = $('#grade3_agency').val();
		if(uberAgency==''){
			alert('上级代理不能为空');
		}
	}
	


	$.getJSON('generate_agency.php?action=generate',
		{grade: agencyGrade, uberAgency: uberAgency},
		function(data) {
			var agencyType = "";
			switch (agencyGrade) {
				case 1:
					agencyType = "皇冠";
					break;
				case 2:
					agencyType = "钻石";
					break;
				case 3:
					agencyType = "白金";
					break;
			}
			if(data.result){
				alert('您输入的代理账号有误！');
			}else{
				$('#copy_area').show();
				$('#agencyType').html(agencyType);
				$('#agencyname').html(data.name);
				$('#agencypassword').html(data.password);			
			}
			
				$("#grade2_agency").val("");
				$("#grade3_agency").val("");
		}
	);
}

</script>


</head>

 <body>
 <div id="position">当前位置：代理系统 > 代理管理</div>

	<input name="excel" value="生成皇冠代理" onclick="generateAgency(1, 0)" type="button"><br><br>

	<font color="red">生成钻石或白金代理，必须输入上一级代理账号 <br><br></font>

	皇冠代理账号: <input type="text" name="grade2_agency" id="grade2_agency" value=""> <br>
	<input name="excel2" value="生成钻石代理" onclick="generateAgency(2)" type="button"><br><br>

	钻石代理账号: <input type="text" name="grade3_agency" id="grade3_agency" value=""> <br>
	<input name="excel3" value="生成白金代理" onclick="generateAgency(3)" type="button"><br><br>
	
	<div style="display:none;" id="copy_area">
		<p>成功生成 <span id='agencyType'></span>代理！</p>		
		<p>账号： <span id='agencyname'></span></p>		
		<p>密码： <span id='agencypassword'></span></p>		
	</div>
 </body>
</html>