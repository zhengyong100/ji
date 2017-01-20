<?php
session_start();
include("config.php");
$arr=user_shell($_SESSION['uid'],$_SESSION['user_shell']);//对权限进行判断
/**
 * @
 * @Description:
 * @Copyright (C) 2011 helloweba.com,All Rights Reserved.
 * -----------------------------------------------------------------------------
 * @author: Liurenfei (lrfbeyond@163.com)
 * @Create: 2012-5-1
 * @Modify:
*/
$action = $_GET['action'];
if ($action == 'import') { //导入CSV
  $filename = $_FILES['file']['tmp_name'];
  if (empty ($filename)) {
	echo "<meta charset='UTF-8'>";
	echo "<script type='text/javascript'>alert('请选择文件！');window.location='chaxun.php';</script>";
    exit;
  }
  $handle = fopen($filename, 'r');
  $result = input_csv($handle); //解析csv
  $len_result = count($result);
  if($len_result==0){
	echo "<meta charset='UTF-8'>";
	echo "<script type='text/javascript'>alert('你的文件没有任何数据！');window.location='chaxun.php';</script>";
    exit;
  }
/* $sqlchongfu=mysql_query("select actime from jizhang_account where jiid='$_SESSION[uid]'");
  while($chongfu=mysql_fetch_array($sqlchongfu)){
  if($chongfu[actime]==$timechongfu){
    echo '数据重复提交！';
    mysql_close($sqlchongfu);
    exit;
  }
  } */
  for ($i = 1; $i < $len_result; $i++) { //循环获取各字段值
    $fenlei = iconv('gb2312', 'utf-8', $result[$i][0]); //中文转码
    $shouzhi = iconv('gb2312', 'utf-8', $result[$i][1]);
    if($shouzhi=="收入"){$shouzhi="1";}else{$shouzhi="2";}
    $sqlfenlei="select * from jizhang_account_class where classname='$fenlei' and ufid='$_SESSION[uid]'";
  $queryfenlei=mysql_query($sqlfenlei);
  $attitle=is_array($rowfenlei=mysql_fetch_array($queryfenlei));
  if($attitle){
    $sqlclassid="select * from jizhang_account_class where ufid='$_SESSION[uid]' and classname='$fenlei'";
        $queryclassid=mysql_query($sqlclassid);
        while($rowclassid = mysql_fetch_array($queryclassid)){
          $acclassid=$rowclassid[classid];
        }
    
  }else{
    $sqltianjia="insert into jizhang_account_class (classname, classtype,ufid) values ('$fenlei', '$shouzhi',$_SESSION[uid])";
    $querytianjia=mysql_query($sqltianjia);
    $acclassid=mysql_insert_id();
  }
    $jine = $result[$i][2];
    $time100=strtotime($result[$i][3]);
    $beizhu = $result[$i][4];
    $jiid = $_SESSION[uid];
    $data_values .= "('$jine','$acclassid','$time100','$beizhu','$jiid','$shouzhi'),";
  }
  $data_values = substr($data_values,0,-1); //去掉最后一个逗号
  fclose($handle); //关闭指针
  $query = mysql_query("insert jizhang_account (acmoney,acclassid,actime,acremark,jiid,zhifu) values $data_values");//批量插入数据表中
  if($query){
	echo "<meta charset='UTF-8'>";
	$d="导入成功！导入了";
	$e=" 条！";
	$f=$d.$len_result.$e;
	echo "<script type='text/javascript'>alert('$f');window.location='chaxun.php';</script>";
  }else{
	echo "<meta charset='UTF-8'>";
	$c="导入失败，请检查文件格式！";
	echo "<script type='text/javascript'>alert('$c');window.location='chaxun.php';</script>";
  }
} elseif ($action=='export') { //导出CSV
    $result = mysql_query("select acclassid,zhifu,acmoney,actime,acremark from jizhang_account where jiid='$_SESSION[uid]'");
    $str = "分类,收支,金额,时间,备注\n";
    $str = iconv('utf-8','gb2312',$str);
    while($row=mysql_fetch_array($result)){
    $sql="select * from jizhang_account_class where classid=$row[acclassid] and ufid='$_SESSION[uid]'";
        $classquery=mysql_query($sql);
        $classinfo = mysql_fetch_array($classquery);
        $fenlei = iconv('utf-8','gb2312',$classinfo['classname']);
        if($classinfo[classtype]==1){$shouzhi=iconv('utf-8','gb2312',"收入");}else{$shouzhi=iconv('utf-8','gb2312',"支出");}
    $jine = $row['acmoney'];
        $shijian = date("Y-m-d H:i",$row[actime]);
    $beizhu = iconv('utf-8','gb2312',$row[acremark]);
      $str .= $fenlei.",".$shouzhi.",".$jine.",".$shijian.",".$beizhu."\n";
    }
    $filename = date('Ymd').'.csv';
    export_csv($filename,$str);
}
function input_csv($handle) {
  $out = array ();
  $n = 0;
  while ($data = fgetcsv($handle, 10000)) {
    $num = count($data);
    for ($i = 0; $i < $num; $i++) {
      $out[$n][$i] = $data[$i];
    }
    $n++;
  }
  return $out;
}

function export_csv($filename,$data) {
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $data;
}
mysql_close($sql);
mysql_close($$result);
?>