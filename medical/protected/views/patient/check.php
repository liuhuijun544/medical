<style>
.layui-colla-title span,.layui-colla-title span i{float: left;height:42px;line-height: 42px;}

</style>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>病人详情</legend>
</fieldset>
<div class="layui-form">
  <table class="layui-table">
    <colgroup>
      <col width="130">
      <col width="200">
      <col width="130">
      <col width="200">
      <col width="130">
      <col >
    </colgroup>
    <tbody>
      <tr>
        <td>姓名：</td>
        <td><?php echo $patient->name?$patient->name:"";?></td>
        <td>性别：</td>
        <td><?php echo $patient->sex==1?"男":($patient->sex==2?"女":"未知");?></td>
        <td>年龄：</td>
        <td><?php echo $patient->age?$patient->age:"";?></td>
      </tr>
      <tr>
        <td>家庭地址：</td>
        <td colspan=3><?php echo $patient->address?$patient->address:"";?></td>    
        <td>创建时间：</td>
        <td><?php echo $patient->created_at?date("Y-m-d H:i:s",$patient->created_at):'';?></td>
      </tr>
    </tbody>
  </table>
</div>
<?php if ($scription){?>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>病例</legend>
</fieldset>
<div class="layui-collapse">
<?php foreach ($scription as $item){?>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">
    	<span>
    	<i class="layui-icon" style="font-size: 24px;">&#xe637;</i>
    	<i>开单时间：<?php echo date("Y-m-d H:i:s",$item->created_at)?></i>
    	<i style="margin-left: 30px;"><i class="layui-icon" style="font-size: 30px;">&#xe60a;</i>病名：<?php echo $item->etiology?></i>
    	<i style="margin-left: 30px;"><i class="layui-icon" style="font-size: 30px;">&#xe60a;</i>服用方式：<?php echo $item->way?></i></span>
    </h2>
    <div class="layui-colla-content">
    	<table class="layui-table">
    		<thead>
		      <tr>
		      	<th>序号</th>
		        <th>药名</th>
		        <th>重量(g)</th>
		        <th>份数</th>
		        <th>单价(元)</th>
		        <th>明细总价(元)</th>
		      </tr> 
		    </thead>
		    <tbody>
		    <?php 
		    $a=1;$weight = $amount = $total = 0;
		    foreach ($item->detail as $tmp){
		    	$weight += $tmp->weight;
		    	$amount+= $tmp->amount;
		    	$total+= $tmp->total;
		    ?>
		    <tr>
			    <td><?php echo $a;?></td>
				<td><?php echo $tmp->medicine_name;?></td>
	        	<td><?php echo $tmp->weight;?></td>
	        	<td><?php echo $tmp->amount?></td>
	        	<td><?php echo $tmp->price?></td>
	        	<td><?php echo $tmp->total?></td>
      		</tr>
     <?php $a++;}?>
		    </tbody>
		    <tfoot>
		    	<tr>
			     	<td colspan=2>汇总：</td>
			     	<td><?php echo $weight?$weight:''?></td>
			     	<td><?php echo $amount?$amount:''?></td>
			     	<td></td>
			     	<td><?php echo $total?$total:''?></td>
		     	</tr>
		     </tfoot>
    	</table>
    </div>
  </div>
<?php }?>
</div>
<?php }?>