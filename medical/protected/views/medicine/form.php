<style>
	.content-content{width:800px;min-height: 600px;float: left;border:1px solid #e6e6e6;margin-left:50px;padding-right:20px;}
	.layui-form-label{width:100px;}
	.layui-input-block{margin-left:130px;}
	.layui-form-text{padding-top:20px;}
</style>
<div class="layui-main">
	<div style="height: 38px;width:100%;">
	
	</div>
	<div class="content-content">
		<form class="layui-form" action=""  onsubmit="return false">
			<div class="layui-form-item" style="padding-top:20px">
				<label class="layui-form-label">药品名称：</label>
				<div class="layui-input-block">
					<input type="text" name="medicine" lay-filter="medicine" lay-verify="required" placeholder="请输入药品名称" class="layui-input medicine" value="<?php echo $medicine->name?$medicine->name:'';?>">
				</div>
			</div>
			<div class="layui-form-item" style="padding-top:20px">
				<label class="layui-form-label">首字母拼音：</label>
				<div class="layui-input-block">
					<input type="text" name="spell" lay-filter="spell" lay-verify="required" placeholder="请输入药品首字母的拼音，用于开单时拼音检索药品名称" class="layui-input spell" value="<?php echo $medicine->spell?$medicine->spell:'';?>">
				</div>
			</div>
			<div class="layui-form-item" style="padding-top:20px">
				<label class="layui-form-label">单价(元/g)：</label>
				<div class="layui-input-block">
					<input type="text" name="price" lay-filter="price" lay-verify="required" placeholder="请输入药品单价，最多1位小数" class="layui-input price" value="<?php echo $medicine->price?$medicine->price:'';?>">
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">描述：</label>
				<div class="layui-input-block">
			    	<textarea name="desc" placeholder="请输入描述" class="layui-textarea desc"><?php echo $medicine->desc?$medicine->desc:'';?></textarea>
			    </div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<input type="hidden" name="type" value="<?php echo $type?>">
					<input type="hidden" name="id" value="<?php echo $medicine->id?$medicine->id:'' ?>">
					<button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
layui.use(['layer', 'form'], function(){
	  var layer = layui.layer
	  ,form = layui.form;
	
	//监听提交按钮
	form.on('submit(*)', function(data){
		$.post("/index.php/medicine/postAjax",{"data":data.field},function(data){
			//处理结果
			if(data==1){
				layer.msg("处理成功，1秒后跳转", {time : 1000,});
				setTimeout(function() {
	               location.replace("/index.php/medicine");  //跳转到对应页面
	               return false;
	           }, 1000);
			}else{
				layer.msg(data);
			}
		});
	});

	form.verify({
		price: function(value, item){
			if(!/^[0-9]+(.[0-9]{1})?$/.test(value)||value==0) 
			return "单价不符合规则（非空、且最多保留一位小数的正数）";
		}
	});
});
</script>