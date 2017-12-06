<!-- 药品名称 -->
<!-- 病人姓名 -->
<!-- 开始时间 -->
<!-- 结束时间 -->
<style>
.layui-table-cell{padding: 0 7px;}
.layui-btn+.layui-btn{margin-left:7px;}
.foot_count{float: right;height:33px;line-height: 33px;font-size:16px;margin-right:20px;}
.foot_count span{color: red}
.foot_count i{margin-left:10px;}
</style>
<form class="layui-form layui-col-space30" action = '/index.php/site/index' method='post'>
<div class="layui-col-md2">
	<input type="text" name="search[username]" placeholder="请输入病人姓名" autocomplete="off" class="layui-input" value="<?php echo $search['username']?$search['username']:"";?>">
</div>
<div class="layui-col-md2">
	<div id="comselect">
		<input type="text" id="combo" value="<?php echo Medicine::getNameByID($search['medicine']);?>"/>
		<input type='hidden' id='comboval' name="search[medicine]" value="<?php echo $search['medicine']?$search['medicine']:"";?>"/>
	</div>
</div>
<div class="layui-form-label" style=" padding: 15px;height: 36px;line-height: 36px;padding-right: 0px;width: 40px;">时间:</div>
<div class="layui-col-md2">
	<input type="text" class="layui-input" placeholder="输入开始时间" id="start" name='search[start]' value="<?php echo $search['start']?$search['start']:"";?>">
</div>
<div class="layui-form-label" style=" padding:15px 0;height: 36px;line-height: 36px;width: auto;">至</div>
<div class="layui-col-md2">
	<input type="text" class="layui-input" placeholder="输入截止时间" id="end" name='search[end]' value="<?php echo $search['end']?$search['end']:"";?>">
</div>
<div class="layui-col-md1">
	<button class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
</div>
</form>
<hr class="layui-bg-gray">
<table id="table1" lay-filter="table1"></table>

<script>
//一般直接写在一个js文件中
layui.use(['layer', 'form','laydate','table'], function(){
  var layer = layui.layer
  ,form = layui.form
  ,laydate = layui.laydate
  ,table = layui.table;
  
  //执行一个laydate实例
  laydate.render({
    elem: '#start' //指定元素
  });
  laydate.render({
		elem: '#end' //指定元素
	});

	table.render({
		elem: '#table1'
		,url: '/index.php/site/getList' //数据接口
		,where:<?php echo json_encode($search)?>
		,page: true //开启分页
		,limit:10
		,cols: [[ //表头
			{field: 'operation', title: '操作', width:140,align:'center',fixed: 'left'}
			,{field: 'username', title: '病人姓名', width:100,align:'center'}
			,{field: 'sex', title: '性别', width:60,align:'center'}
			,{field: 'age', title: '年龄', width:60,align:'center'} 
			,{field: 'address', title: '家庭地址', width:100,align:'center'}
		    ,{field: 'etiology', title: '病名', width: 160,align:'center'}
		    ,{field: 'medicine', title: '药材', width: 110,align:'center'}
		    ,{field: 'weight', title: '重量(g)', width: 80,align:'center'}
		    ,{field: 'amount', title: '份数', width: 80,align:'center'}
		    ,{field: 'price', title: '单价', width: 80,align:'center'}
		    ,{field: 'total', title: '明细总价', width: 80,align:'center'}
		    ,{field: 'totalMoney', title: '药方总价', width: 80,align:'center'}
		    ,{field: 'way', title: '服用方式', width: 100,align:'center'}
		]],
		done: function(res, curr, count){
			console.log(res);
			if($(".layui-table-tool p").hasClass("foot_count")){
				var str = "<i>总价汇总：<span>"+res.count_money+"</span></i>"+
							"<i>重量汇总：<span>"+res.count_weight+"</span></i>"+
							"<i>件数汇总：<span>"+res.count_amount+"</span></i>"+
							"<i>明细汇总：<span>"+res.count_total+"</span></i>";
				$(".foot_count").html(str);
			}else{
				var str = "<p class='foot_count'>"+
							"<i>总价汇总：<span>"+res.count_money+"</span></i>"+
							"<i>重量汇总：<span>"+res.count_weight+"</span></i>"+
							"<i>件数汇总：<span>"+res.count_amount+"</span></i>"+
							"<i>明细汇总：<span>"+res.count_total+"</span></i>"+
							"</p>";
				$(".layui-table-tool").append(str);
			}
		}
	});
	
// 	$str = '<div>123</div>';
// 	$(".layui-table-tool").append(123);
	
	table.on('tool(table1)',function(obj){
		var data = obj.data;//获取数据
		var layEvent = obj.event;//获取点击事件
		var tr = obj.tr//获取对应行
		if(layEvent == "detail"){//查看
			window.location.href = "/index.php/site/check?id="+data.main_id;
		}else if(layEvent == "edit"){//编辑
			window.location.href = "/index.php/site/update?id="+data.main_id;
		}else if(layEvent == "del"){//删除
			layer.confirm('确定需要删除？', function(index){
			      layer.close(index);
			      //向服务端发送删除指令
			      $.post("/index.php/site/del",{"mainId":data.main_id},function(data){
				      if(data==1) window.location.reload();
				      else layer.alert(data);
			    	  
			      });
			});
		}
	});
});

//读取对象
function writeObj(obj){ 
	 var description = ""; 
	 for(var i in obj){ 
	 var property=obj[i]; 
	 description+=i+" = "+property+"\n"; 
	 } 
	 alert(description); 
	}
</script>

<script>	
	$(function(){
		var array=<?php echo $medicine?$medicine:json_encode(array());?>;
		$('#combo').combobox(array, {imageUrl : "<?php echo imgUrl('dropdown.png');?>"},"comselect","comboval",false);
		$('#combo').css("width", function(index, value) {return parseFloat(value) - 10})
	})	
</script>
