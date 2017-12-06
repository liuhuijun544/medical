<?php 
if (!$patient){
	?>
	<li onClick=getPation(this) id=0 age=0 sex=0>无搜索结果</li>
<?php
}else{
	foreach ($patient as $item){
		
	?>
	<li onClick=getPation(this) id=<?php echo $item->id?> age=<?php echo $item->age?> sex=<?php echo $item->sex?> name='<?php echo $item->name?>' address='<?php echo $item->address?>'><?php echo $item->name."--".($item->sex==1?'男':($item->sex==2?'女':'未知'))."--".$item->age?></li>
<?php
	}
}
?>