//获取选中的病人
function getPation(obj)
{
	var id = obj.getAttribute("id")
	,name = obj.getAttribute("name")
	,sex = obj.getAttribute("sex")
	,age = obj.getAttribute("age")
	,address = obj.getAttribute("address");

	$(".patient_ul").hide();

	if(id == 0) return;
	
	//选中病人后，改变名字、性别、年龄、最好再加上隐藏框，标识病人是输入还是选择
	$(".patientName").val(name);
	$(".patinetType").val(id);

	//设置性别，先全部不选中
	$("#sex1").next().removeClass('layui-form-radioed');
	$("#sex2").next().removeClass('layui-form-radioed');
	$("#sex1").next().find("i").html("&#xe63f;");
	$("#sex2").next().find("i").html("&#xe63f;");
	$("#sex1").attr('checked',false);
	$("#sex2").attr('checked',false);
	$("#sex"+sex).attr('checked','checked');
	$("#sex"+sex).next().addClass("layui-form-radioed");
	$("#sex"+sex).next().find("i").html("&#xe643;");

	//设置年龄
	$(".age").val(age);
// 	console.log($(".patientName").val());

	//设置地址
	$(".address").val(address);
	
}	

//input搜索所有病人姓名
function selectPatient(name){
	$.post("/index.php/site/searchPatient",{"name":name},function(data){
			$(".patient_ul").show();
			$(".patient_ul").html(data);
		});
	
}

//获取药名赋值
function medicineChange(obj)
{
	//药名赋值以后要获取对应药品的价格
	var value = obj.getAttribute("param");
	if(value !=0 ){
		$.post("/index.php/site/searchMedicine",{"id":value},function(data){
			if(data){
				//价格
				$(obj).parent().parent().parent().parent().find(".price").val(data);
			}
		});
	}
}

/**
 * 更新重量，份数和总数
 */
function updateWeight(){
	var count_weight = 0;
	$(".weight").each(function(){
		var weight = parseFloat($(this).val());
		if(weight) count_weight = count_weight +weight;
	});
	$("#count_weight").text(count_weight);
}

function updateAmount(){
	var count_amount = 0;
	$(".amount").each(function(){
		var amount = parseInt($(this).val());
		if(amount) count_amount = count_amount + amount;
	});
	$("#count_amount").text(count_amount);
}

function updateTotal(){
	var count_total = 0;
	$(".total").each(function(){
		var total = parseFloat($(this).val());
		if(total) count_total = accAdd(count_total,total);
	});
	$("#count_total").text(count_total);
}

/**
 * 乘法计算精确
 */
function ride(x,y,z){
	var m=0,
	s1=x.toString(),
	s2=y.toString();
	s3=z.toString();

	try{m+=s1.split(".")[1].length}catch(e){}
	try{m+=s2.split(".")[1].length}catch(e){}
	try{m+=s3.split(".")[1].length}catch(e){}
	return Number(s1.replace(".",""))*Number(s2.replace(".",""))*Number(s3.replace(".",""))/Math.pow(10,m)
}
/**
 * 加法精确
 */
function accAdd(x, y) {
    var s1,s2,m;
    try {
        s1 = x.toString().split(".")[1].length;
    }
    catch (e) {
        s1 = 0;
    }
    try {
       s2 = y.toString().split(".")[1].length;
    }
    catch (e) {
        s2 = 0;
    }
    m = Math.pow(10, Math.max(s1, s2));
    return (x * m + y * m) / m;
} 
// $(document).on('change','.weight',function(){
	
// });