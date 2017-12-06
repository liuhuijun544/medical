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
				<label class="layui-form-label">姓名：</label>
				<div class="layui-input-block">
					<input type="text" name="name" lay-filter="name" lay-verify="required" placeholder="请输入病人姓名" class="layui-input name" value="<?php echo $patient->name?$patient->name:'';?>">
				</div>
			</div>
			<div class="layui-form-item" style="padding-top:20px">
		    	<label class="layui-form-label">性别：</label>
			    <div class="layui-input-block">
			      <input type="radio" name="sex" id=sex1 value="1" title="男" <?php if ($patient->sex==1 || $patient->sex!=2){ echo "checked";}?>>
			      <input type="radio" name="sex" id=sex2 value="2" title="女" <?php if ($patient->sex==2){ echo "checked";}?>>
			    </div>
		  	</div>
			<div class="layui-form-item" style="padding-top:20px">
				<label class="layui-form-label">年龄：</label>
				<div class="layui-input-block">
					<input type="text" name="age" lay-filter="age" lay-verify="required|number" placeholder="请输入年龄" class="layui-input age" value="<?php echo $patient->age?$patient->age:'';?>">
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">家庭住址：</label>
				<div class="layui-input-block">
			    	<textarea name="address" placeholder="请输入描述" class="layui-textarea address"><?php echo $patient->address?$patient->address:'';?></textarea>
			    </div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<input type="hidden" name="type" value="<?php echo $type?>">
					<input type="hidden" name="id" value="<?php echo $patient->id?$patient->id:'' ?>">
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
		$.post("/index.php/patient/postAjax",{"data":data.field},function(data){
			//处理结果
			if(data==1){
				layer.msg("处理成功，1秒后跳转", {time : 1000,});
				setTimeout(function() {
	               location.replace("/index.php/patient");  //跳转到对应页面
	               return false;
	           }, 1000);
			}else{
				layer.msg(data);
			}
		});
	});

	form.verify({
		
	});
});
</script>