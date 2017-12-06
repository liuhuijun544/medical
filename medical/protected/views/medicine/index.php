<!-- 药品名称 -->
<!-- 药品拼音 -->
<!-- 价格 -->
<!-- 创建时间 -->

<form class="layui-form layui-col-space30" action = '/index.php/medicine/index' method='post'>
<div class="layui-col-md2">
	<input type="text" name="search[mname]" placeholder="请输入药名或者首字母拼音" autocomplete="off" class="layui-input" value="<?php echo $search['mname']?$search['mname']:"";?>">
</div>
<div class="layui-col-md1">
	<button class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
</div>
</form>
<hr class="layui-bg-gray">
<table id="table1" lay-filter="table1"></table>

<script>
//一般直接写在一个js文件中
layui.use(['layer', 'form','table'], function(){
  var layer = layui.layer
  ,form = layui.form
  ,table = layui.table;
  

	table.render({
		elem: '#table1'
		,url: '/index.php/medicine/getList' //数据接口
		,where:<?php echo json_encode($search)?>
		,page: true //开启分页
		,limit:20
		,cols: [[ //表头
			{field: 'operation', title: '操作', width:140,align:'center',fixed: 'left'}
			,{field: 'name', title: '药品名称', width:180,align:'center'}
			,{field: 'spell', title: '首字母拼音', width:100,align:'center'}
			,{field: 'price', title: '价格(g/元)', width:100,align:'center'} 
			,{field: 'created_at', title: '创建时间', width:170,align:'center'}
		    ,{field: 'desc', title: '描述', width: 200,align:'center'}
		]],
	});

	table.on('tool(table1)',function(obj){
		var data = obj.data;//获取数据
		var layEvent = obj.event;//获取点击事件
		var tr = obj.tr//获取对应行
		if(layEvent == "edit"){//编辑
			window.location.href = "/index.php/medicine/update?id="+data.id;
		}else if(layEvent == "del"){//删除
			layer.confirm('确定需要删除？', function(index){
			      layer.close(index);
			      //向服务端发送删除指令
			      $.post("/index.php/medicine/del",{"id":data.id},function(data){
				      if(data==1) window.location.reload();
				      else layer.alert(data);
			    	  
			      });
			});
		}
	});	
});

</script>

