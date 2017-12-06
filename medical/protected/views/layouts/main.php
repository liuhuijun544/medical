<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/layui/css/layui.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.combobox.css" />
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.0.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/layui/layui.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.combobox.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">明保國醫館</div>
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="/index.php/site/add">快速开药</a></li>
      <li class="layui-nav-item"><a href="#"></a></li>
      <li class="layui-nav-item"><a href="/index.php/medicine/add">药品新增</a></li>
      <li class="layui-nav-item"><a href="#"></a></li>
      <li class="layui-nav-item"><a href="/index.php/patient/add">病人新增</a></li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
          李明保
        </a>
      </li>
      <li class="layui-nav-item"><a href="/index.php/site/logout">退出</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item"><a href="/index.php/site">药方列表</a></li>
        <li class="layui-nav-item"><a href="/index.php/patient">病人履历</a></li>
        <li class="layui-nav-item"><a href="/index.php/medicine">药品管理</a></li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;"><?php echo $content?></div>
  </div>
  
</div>
<script>
//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;
  
});
</script>
</body>
</html>
