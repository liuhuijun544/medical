<?php 

?>
<style>
	.layui-input[readonly]{cursor: not-allowed;background-color: #e5e5e5;}
	.content-content{width:1130px;min-height: 600px;float: left;border:1px solid #e6e6e6;}
	.content-left{width:400px;overflow: hidden;float: left;padding-right:20px; }
	.content-right{width:660px;overflow: hidden;float: left;padding:20px;}
	.patient_ul{margin-top:2px;border:1px solid #e6e6e6; border-bottom: none;position:absolute; left:110px;width:290px;z-index:100;background: #f5f5f5;display: none}
	.patient_ul li{height:38px;padding-left:10px;line-height: 38px;border-bottom:1px solid #e6e6e6;cursor:pointer;}
	.patient_ul li :HOVER {background: #e6e6e6}
	.content-right tr,.content-right th{text-align: center;}
	.content-right ul{text-align: left;}
	.addRow{text-align: center;background: #f5f5f5;border: 1px solid #dadada;height:30px;line-height: 30px;cursor: pointer;}
</style>
<script>
	var array_medicine = <?php echo $array_medicine;?>
</script>
<div class="layui-main">
	<div style="height: 38px;width:100%;">
	
	</div>
	<form class="layui-form" action="/index.php/site/addPost" method="post">
	<div class="content-content">
	<div class="content-left">
			<div class="layui-form-item" style="padding-top:20px">
		    	<label class="layui-form-label">病人姓名：</label>
		    	<div class="layui-input-block">
			     	<input type="text" name="patientName" lay-filter="patientName"  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input patientName">
			     	<input type="hidden" name="patinetType" class="patinetType" value=-1><!-- 判断病人是通过选取的还是通过模糊查询的 -->
			    </div>
			    <ul class="patient_ul"></ul>
		  	</div>
		  	<div class="layui-form-item">
		    	<label class="layui-form-label">性别：</label>
			    <div class="layui-input-block">
			      <input type="radio" name="sex" id=sex1 value="1" title="男" checked>
			      <input type="radio" name="sex" id=sex2 value="2" title="女">
			    </div>
		  	</div>
		  	<div class="layui-form-item">
		    	<label class="layui-form-label">年龄：</label>
		    	<div class="layui-input-block">
			     	<input type="text" name="age" lay-filter="age"  lay-verify="required|number" placeholder="请输入年龄" autocomplete="off" class="layui-input age">
			    </div>
		  	</div>
		  	<div class="layui-form-item">
				<label class="layui-form-label">家庭地址：</label>
			    <div class="layui-input-block">
			     	<input type="text" name="address" lay-filter="address" placeholder="请输入家庭地址" autocomplete="off" class="layui-input address">
			    </div>
			</div>
		  	<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">病名：</label>
			    <div class="layui-input-block">
			    	<textarea name="etiology" placeholder="请输入病名" lay-verify="required" class="layui-textarea"></textarea>
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">服药方式：</label>
			    <div class="layui-input-block">
			     	<input type="text" name="way" lay-filter="way" placeholder="请输入服药方式" autocomplete="off" class="layui-input way">
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">总价格：</label>
			    <div class="layui-input-block">
			     	<input type="text" name="totalMoney" lay-verify="totalMoney" lay-filter="totalMoney" placeholder="请输入总价" autocomplete="off" class="layui-input totalMoney">
			    </div>
			</div>
		  	<div class="layui-form-item">
		    	<div class="layui-input-block">
		     		<button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
<!-- 		      		<button type="reset" class="layui-btn layui-btn-primary">重置</button> -->
		    	</div>
		  	</div>
	</div>
	<div class="content-right">
		<table class="layui-table" style="margin-top: 0px;">
				<colgroup>
					<col width="20">
				    <col width="60">
				    <col width="160">
				    <col width="100">
				    <col width="80">
				    <col width="100">
				    <col>
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>操作</th>
						<th>药名</th>
						<th>重量(g)</th>
						<th>份数</th>
						<th>单价(元)</th>
						<th>总价</th>
					</tr> 
			  </thead>
			  <tbody id="tbody">
			  <?php for ($i=1;$i<=5;$i++){?>
					<tr>
						<td class="listNum"><?php echo $i?></td>
						<td><i class="layui-icon del_tr"  style="font-size: 25px;cursor: pointer;">&#xe640;</i></td>
						<td style="padding:9px 5px;">
							<div id="midicineselect<?php echo $i?>" style="float:left; display:inline;position: relative;width:150px;margin-right:-23px;">
								<input type="text" id="meidicine<?php echo $i?>" style="width:150px;" lay-verify="td_medicine"  value="" />
								<input type='hidden' id='medical<?php echo $i?>' value=""   name="medicine[]" class="td_medicine"/>
							</div>
							<script type="text/javascript">
    							$('#meidicine<?php echo $i?>').combobox(array_medicine, {imageUrl : "<?php echo imgUrl('dropdown.png');?>"},"midicineselect<?php echo $i?>","medical<?php echo $i?>",false,'medicineChange(this)');
    							$("#meidicine<?php echo $i?>").css("width", function(index, value) {return parseFloat(value) - 11});
    							$("#meidicine<?php echo $i?>").css("padding-left", "5px");
    						</script>	
						</td>
						<td><input type="text" name=weight[] lay-verify="td_weight"  class="layui-input weight"></td>
						<td><input type="text" name=amount[] lay-verify="td_amount"  class="layui-input amount"></td>
						<td><input type="text" name=price[] lay-verify="td_price"  class="layui-input price"></td>
						<td><input type="text" name=total[] lay-verify="td_total"  class="layui-input total" readonly></td>
					</tr>
				<?php }?>
			</tbody>
			<tfoot>
				<tr>
				<td colspan=2 >
					<div>汇总：</div>
				</td>
				<td></td>
				<td id="count_weight"></td>
				<td id="count_amount"></td>
				<td></td>
				<td id="count_total"></td>
				</tr>
			</tfoot>
		</table>
		<div class="addRow"><i class="layui-icon" style="font-size: 20px; color: #1E9FFF;">&#xe61f;</i></div>
	</div>
	</div>
	</form>
		
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/prescription.js"></script>
<script>
layui.use(['layer', 'form'], function(){
	  var layer = layui.layer
	  ,form = layui.form;

	<?php if ($msg){?>
		layer.msg("<?php echo $msg?>");
	<?php }?>
	
	//监听病人姓名变化时的处理
	var cpLock = false;
	$('.patientName').on('compositionstart', function () {
		cpLock = true;
	});
	$('.patientName').on('compositionend', function () {
		cpLock = false;
		var name = $('.patientName').attr("value");
	    selectPatient(name);
	});
	$('.patientName').on('input', function () {
		if (!cpLock) {
			var name = $('.patientName').attr("value");
			selectPatient(name);
		}
	});
	// 手动判断提交内容
	//获取焦点监听，如果有值需要去搜索
	$(".patientName").focus(function(){
		var name = $('.patientName').attr("value");
		//console.log(name);
		if(name){
			selectPatient(name);
		}
	});
	//鼠标失去焦点时
	$(".layui-body").click(function(){
		$(".patient_ul").hide();
	});
	//表格删除时删除整行
	$(".del_tr").live("click",function(){
		$(this).parent().parent().remove();
		var num = 0;
		//删除以后便利循环所有表格元素，保证顺序
		$("#tbody tr").each(function(){
			num++
			$(this).find(".listNum").html(num);
		});
	});
	var selectNum = 0;//药名的js编号
	//点击增加一行药品信息
	$(".addRow").click(function(){
		selectNum++;
		var count = parseInt($("#tbody").children("tr").length)+1;//后去目前行数
		var newRow = '<tr><td class="listNum">'+count+'</td>'+
			'<td><i class="layui-icon del_tr"  style="font-size: 25px;cursor: pointer;">&#xe640;</i></td>'+
			'<td style="padding:9px 5px;">'+
			'<div id="mmidicineselect'+selectNum+'" style="float:left; display:inline;position: relative;width:150px;margin-right:-23px;">'+
			'<input type="text" id="mmeidicine'+selectNum+'" style="width:150px;" lay-verify="td_medicine"  value="" />'+
			'<input type="hidden" id="mmedical'+selectNum+'" value=""  class="td_medicine"   name="medicine[]"/>'+
			'</div>'+
			'</td>'+
			'<td><input type="text" name=weight[] lay-verify="td_weight"  class="layui-input weight"></td>'+
			'<td><input type="text" name=amount[]  lay-verify="td_amount" class="layui-input amount"></td>'+
			'<td><input type="text" name=price[] lay-verify="td_price" class="layui-input price"></td>'+
			'<td><input type="text" name=total[] lay-verify="td_total" class="layui-input total" readonly></td>'+
			'</tr>';
		$("#tbody").append(newRow);
		$('#mmeidicine'+selectNum).combobox(array_medicine, {imageUrl : "<?php echo imgUrl('dropdown.png');?>"},"mmidicineselect"+selectNum,"mmedical"+selectNum,false,'medicineChange(this)');
		$("#mmeidicine"+selectNum).css("width", function(index, value) {return parseFloat(value) - 11});
		$("#mmeidicin"+selectNum).css("padding-left", "5px");
//		console.log(newRow);
	});
	//重量、份数、单价改变都需要计算总价格
	$(".weight").live("change",function(){
		var weight = $(this).val();
		$(this).removeClass("layui-form-danger");//去除错误标识
		if(!/^[0-9]+(.[0-9]{1})?$/.test(weight)||weight==0)
		{
			layer.msg('重量只能是大于0的整数或者小数点后1位的小数', {icon : 5,time : 3000,});
			$(this).focus();
			$(this).addClass("layui-form-danger");//加上错误标识
			return false;
		}	
		updateWeight();
		var amount = $(this).parent().parent().find(".amount").val();
		var price = $(this).parent().parent().find(".price").val();
		if(!/^\+?[1-9][0-9]*$/.test(amount)) return;//件数只能是整数
		if(!/^[0-9]+(.[0-9]{1})?$/.test(price)||price==0) return;//价格判断

		//三个参数都对，计算出总价格
		var tr_money =  ride(weight,amount,price);
		$(this).parent().parent().find(".total").val(tr_money);
		updateTotal();
//	 	console.log(weight);			
	});
	$(".amount").live("change",function(){
		var amount = $(this).val();
		$(this).removeClass("layui-form-danger");//去除错误标识
		if(!/^\+?[1-9][0-9]*$/.test(amount)){
			layer.msg('份数只能是正整数', {icon : 5,time : 3000,});
			$(this).focus();
			$(this).addClass("layui-form-danger");//加上错误标识
			return false;
		}
		updateAmount();
		var weight = $(this).parent().parent().find(".weight").val();
		if(!/^[0-9]+(.[0-9]{1})?$/.test(weight)||weight==0) return false;//总量判断
		var price = $(this).parent().parent().find(".price").val();
		if(!/^[0-9]+(.[0-9]{1})?$/.test(price)||price==0) return;//价格判断
		//三个参数都对，计算出总价格
		var tr_money =  ride(weight,amount,price);
		$(this).parent().parent().find(".total").val(tr_money);
		updateTotal();
	});
	$(".price").live("change",function(){
		var price = $(this).val();
		$(this).removeClass("layui-form-danger");//去除错误标识
		if(!/^[0-9]+(.[0-9]{1})?$/.test(price)||price==0)
		{
			layer.msg('价格只能是大于0的整数或者小数点后1位的小数', {icon : 5,time : 3000,});
			$(this).focus();
			$(this).addClass("layui-form-danger");//加上错误标识
			return false;
		}
		var weight = $(this).parent().parent().find(".weight").val();
		if(!/^[0-9]+(.[0-9]{1})?$/.test(weight)||weight==0) return false;//总量判断
		var amount = $(this).parent().parent().find(".amount").val();
		if(!/^\+?[1-9][0-9]*$/.test(amount)) return;//件数只能是整数
		//三个参数都对，计算出总价格
		var tr_money = ride(weight,amount,price);
		$(this).parent().parent().find(".total").val(tr_money);
		updateTotal();
	});


	//监听提交按钮
	form.on('submit(*)', function(data){
		var num = 0;
		var num_null = 0;
		$(".td_medicine").each(function(){
			num++;
			if($(".td_medicine").val()=="") num_null++;
		});
		if(num == num_null){
			layer.msg("明细不能为空");
			return false;
		}
//		console.log(data.field);
//		$.post("/index.php/site/addPost",{"data":data.field},function(result){
//			return false;
//			layer.msg("开单成功，3秒后跳转", {time : 3000,});
//			setTimeout(function() {
//               location.replace("/index.php/site");  //跳转到对应页面
//               return false;
//           }, 3000);
//		});
//		return false;
	});

	form.verify({
		totalMoney: function(value, item){
			if(!/^[0-9]+(.[0-9]{1,2})?$/.test(value)||value==0) 
			return "总价不符合规则（非空、且最多保留两位小数的正数）";
		}

		//获取所有列表药的名称，如果药名为空则不处理，不为空判断其他参数
		,td_medicine: function(value, item){
			var weight = $(item).parent().parent().parent().parent().find(".weight").val();
			var amount = $(item).parent().parent().parent().parent().find(".amount").val();
			var price = $(item).parent().parent().parent().parent().find(".price").val();
			if(weight !="" && amount!="" && price!="" && value ==""){
				return "药名不能为空";
			}
		}
		,td_weight: function(value, item){
			var medicine = $(item).parent().parent().find(".td_medicine").val();
			if(medicine !="" &&(value =="" || !/^[0-9]+(.[0-9]{1})?$/.test(value)||value==0)){
				return "重量不符合规则";
			}
		}
		,td_amount: function(value, item){
			var medicine = $(item).parent().parent().find(".td_medicine").val();
			if(medicine !="" &&(value =="" || !/^\+?[1-9][0-9]*$/.test(value))){
				return "份数不符合规则";
			}
		}
		,td_price: function(value, item){
			var medicine = $(item).parent().parent().find(".td_medicine").val();
			if(medicine !="" &&(value =="" || !/^[0-9]+(.[0-9]{1})?$/.test(value)||value==0)){
				return "单价不符合规则";
			}
		}
		,td_total: function(value, item){
			var medicine = $(item).parent().parent().find(".td_medicine").val();
			if(medicine !="" &&(value =="" || !/^[0-9]+(.[0-9]{1,2})?$/.test(value)||value==0)){
				return "总价不符合规则";
			}
		}
	});
});
</script>