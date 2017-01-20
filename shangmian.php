<?php
session_start();
?>
<?php
  if($_GET['tj'] == 'logout'){
  session_start(); //开启session
  session_destroy();  //注销session
  header("location:index.php"); //跳转到首页
  }
?>
<!DOCTYPE HTML>
<html>
<head>  
<meta charset="utf-8">

    <!-- 包含头部信息用于适应不同设备 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 包含 bootstrap 样式表 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
<title>php mysql 简单记账xptt程序</title>
</head>
<body>
<?php
include("config.php");
$arr=user_shell($_SESSION['uid'],$_SESSION['user_shell']);//对权限进行判断
?>
<div style="max-width:780px;width:auto;margin-left: auto;margin-right: auto;padding:5px;">
<div class="table-responsive">
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid"> 
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target="#example-navbar-collapse">
			<span class="sr-only">导航</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="tianjia.php">记一笔</a>
	</div>
	<div class="collapse navbar-collapse" id="example-navbar-collapse">
		<ul class="nav navbar-nav">
			<li><a href="tongji.php">近期统计</a></li>
			<li><a href="niantongji.php">全年统计</a></li>
			<li><a href="fenlei.php">分类编辑</a></li>
<li><a href="chaxun.php">导出导出</a></li>
<li><a href="xiugai.php">查询修改</a></li>
<li><a href="zhanghao.php"><?php echo"账号：";echo $arr['username'];?></a></li>
<li><a href="index.php?tj=logout">退出</a></li>

		</ul>
	</div>
	</div>
</nav>