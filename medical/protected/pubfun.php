<?php

function baseUrl() {
	return Yii::app ()->baseUrl;
}
function imgUrl($img) {
	return baseUrl () . "/images/$img";
}

/**
 * 判断用户是否拥有权限
 */
function checkOperation($authitem) 
{
	$auth = Yii::app()->authManager;
	$bool = $auth->checkAccess($authitem, Yii::app()->user->userid);
	return $bool;
}

/*
 * 计算时间戳相差天数
 */
function count_days($a,$b){
	$a_dt = getdate($a);
	$b_dt = getdate($b);
	$a_new = mktime(12, 0, 0, $a_dt['mon'], $a_dt['mday'], $a_dt['year']);
	$b_new = mktime(12, 0, 0, $b_dt['mon'], $b_dt['mday'], $b_dt['year']);
	return round(abs($a_new-$b_new)/86400);
}


// 添加一个css文件,注,文件必须在css文件下
function include_css($file) {
	if (func_num_args () >= 1) {
		foreach ( func_get_args () as $p ) {
			if (substr ( $p, - 4 ) != ".css") {
				$p .= ".css";
			}
			echo '<link rel="stylesheet" type="text/css" href="' . baseUrl () . '/css/' . $p . '" media="screen, projection" />';
		}
	}
}
function include_js($file) {
	if (func_num_args () >= 1) {
		foreach ( func_get_args () as $p ) {
			if (substr ( $p, - 3 ) != ".js") {
				$p .= ".js";
			}
			echo '<script type="text/javascript" language="javascript" src="' . baseUrl () . '/js/' . $p . '"></script>';
			// Yii::app()->clientScript->registerScript($p,baseUrl()."/".$p);
		}
	}
}

function currentUserId() {
// 	return 1;//单元测试
	if(Yii::app()->user->isGuest){
		return 0;
	}else{
		return Yii::app()->user->userid;
	}
}


function rand_str($len=10){
	$str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ";
	$ret = "";
	for($i=0;$i < $len; $i++){
		$ret .= $str{mt_rand(0,61)};
	}
	return $ret;
}

function ValidateCode($len=4){
  	$str = "0123456789";
  	$ret = "";
  	for($i=0;$i < $len; $i++){
  		$ret .= $str{mt_rand(0,9)};
  	}
  	return $ret;
}



function updateSearch($search,$name)
{
	if(empty($search)){
		if($_COOKIE[$name]){
			$search=(Array)json_decode($_COOKIE[$name]);
			setcookie($name,$_COOKIE[$name],time()+60*30,'/');
		}else{
			$search=array();
		}
	}else{
		setcookie($name,json_encode($search),time()+60*30,'/');
	}
	return $search;
}

function updateSingleCookie($val,$name)
{
	if($val=='cc'){
		if($_COOKIE[$name]){
			$val=$_COOKIE[$name];
			setcookie($name,$_COOKIE[$name],time()+60*30,'/');
		}
	}else{
		setcookie($name,$val,time()+60*30,'/');
	}
	return $val;
}

/*
 * 判断文件上传类型
 */
function checkUploadFileType($filename,$type=""){
	$filter_pic = array('jpg','png','bmp','gif','icon','jpeg');
	$filter_file = array('xls','xlsx','xlsm','doc');
	$fileType = strtolower(trim(substr(strrchr($filename, '.'), 1)));
	 
	if ($type=="image"){
		return in_array($fileType,$filter_pic);
	}else{
		return in_array($fileType,$filter_file);
	}
}



//获取首字母
function getfirstchar($s0){
	$fchar = ord($s0{0});
	if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
	$s1 = iconv("UTF-8","gb2312", $s0);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $s0){$s = $s1;}else{$s = $s0;}
	$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
	if($asc >= -20319 and $asc <= -20284) return "A";
	if($asc >= -20283 and $asc <= -19776) return "B";
	if($asc >= -19775 and $asc <= -19219) return "C";
	if($asc >= -19218 and $asc <= -18711) return "D";
	if($asc >= -18710 and $asc <= -18527) return "E";
	if($asc >= -18526 and $asc <= -18240) return "F";
	if($asc >= -18239 and $asc <= -17923) return "G";
	if($asc >= -17922 and $asc <= -17418) return "I";
	if($asc >= -17417 and $asc <= -16475) return "J";
	if($asc >= -16474 and $asc <= -16213) return "K";
	if($asc >= -16212 and $asc <= -15641) return "L";
	if($asc >= -15640 and $asc <= -15166) return "M";
	if($asc >= -15165 and $asc <= -14923) return "N";
	if($asc >= -14922 and $asc <= -14915) return "O";
	if($asc >= -14914 and $asc <= -14631) return "P";
	if($asc >= -14630 and $asc <= -14150) return "Q";
	if($asc >= -14149 and $asc <= -14091) return "R";
	if($asc >= -14090 and $asc <= -13319) return "S";
	if($asc >= -13318 and $asc <= -12839) return "T";
	if($asc >= -12838 and $asc <= -12557) return "W";
	if($asc >= -12556 and $asc <= -11848) return "X";
	if($asc >= -11847 and $asc <= -11056) return "Y";
	if($asc >= -11055 and $asc <= -10247) return "Z";
	return null;
}

 function pinyin1($zh){
	$ret = "";
	$s1 = iconv("UTF-8","gb2312", $zh);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $zh){$zh = $s1;}
	for($i = 0; $i < strlen($zh); $i++){
		$s1 = substr($zh,$i,1);
		$p = ord($s1);
		if($p > 160){
			$s2 = substr($zh,$i++,2);
			$ret .=getfirstchar($s2);
		}else{
			$ret .= $s1;
		}
	}
	return $ret;
}


//数组转大写
function ch_num($num, $mode = true) {
	$char = array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖");
	$dw = array("","拾","佰","仟","","萬","億","兆");
	$dec = "點";
	$retval = "";
	if ($mode) preg_match_all("/^0*(\d*)\.?(\d*)/", $num, $ar);
	else preg_match_all("/(\d*)\.?(\d*)/", $num, $ar);
	if ($ar[2][0] != "") $retval = $dec . ch_num($ar[2][0], false); //如果有小数，则用递归处理小数
	if ($ar[1][0] != "") {
		$str = strrev($ar[1][0]);
		for ($i = 0; $i < strlen($str); $i++) {
			$out[$i] = $char[$str[$i]];
			if ($mode) {
				$out[$i] .= $str[$i] != "0" ? $dw[$i%4] : "";
				if ($str[$i] + $str[$i-1] == 0) $out[$i] = "";
				if ($i % 4 == 0) $out[$i] .= $dw[4+floor($i/4)];
			}
		}
		$retval = join("",array_reverse($out)) . $retval;
	}
	return $retval;
}

//金额 转大写
function cny($ns) {
	static $cnums = array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),
	$cnyunits = array("圆","角","分"),
	$grees = array("拾","佰","仟","万","拾","佰","仟","亿");
	
	list($ns1,$ns2) = explode(".",$ns,2);
	$ns2 = array_filter(array($ns2[1], $ns2[0]));
	$ret = array_merge($ns2, array(implode("", _cny_map_unit(str_split($ns1), $grees)), ""));
	$ret = implode("", array_reverse(_cny_map_unit($ret,$cnyunits)));
	return str_replace(array_keys($cnums), $cnums, $ret);
}

function _cny_map_unit($list, $units) {
	$ul = count($units);
	$xs = array();
	foreach (array_reverse($list) as $x) {
		$l = count($xs);
		if ($x != "0" || !($l % 4)) $n = ($x == '0' ? '' : $x).($units[($l - 1) % $ul]);
		else $n = is_numeric($xs[0][0]) ? $x : '';
		array_unshift($xs, $n);
	}
	return $xs;
}

function sortRank($arr)
{
	$return=array();
	$aa=array();
	$bb=array();
	if(is_array($arr)&&!empty($arr))
	{
		foreach($arr as $k=>$v)
		{
			if(substr($v, 0,1)=='Φ')
				$aa[$k]=mb_substr($v, 1,100,'utf-8');
			else 
				$bb[$k]=$v;
		}
		asort($aa);
		asort($bb);
		foreach($aa as $k=>$v)
		{
			$return[$k]='Φ'.$v;
		}
		foreach($bb as $k=>$v)
		{
			$return[$k]=$v;
		}
// 		array_merge($return,$bb);
	}
	return $return;
}

function requestByCurl($remote_server,$post_string,$use_post=true){
	if(function_exists('curl_init')){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$remote_server);
		if($use_post){
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$post_string);
		}
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}else{
		return '请先安装curl';
	}
}

//比较两个字符串长度，并按照由长到短排列
function compareStr($str1,$str2){
	if(strlen($str1) >= strlen($str2)){
		return array($str1,$str2);
	}else{
		return array($str2,$str1);
	}
}
?>
