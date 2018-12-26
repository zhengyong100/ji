<?php
session_start();
include("config.php");
$arr = user_shell($_SESSION['uid'],$_SESSION['user_shell']); //权限判断
//对权限进行判断
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
if ($action == 'import') {
    //导入CSV
    $filename = $_FILES['file']['tmp_name'];
    if (empty ($filename)) {
        echo "<meta charset='UTF-8'>";
        echo "<script type='text/javascript'>alert('请选择文件！');window.location='search.php';</script>";
        exit;
    }
    $handle = fopen($filename, 'r');
    $result = input_csv($handle);
    //解析csv
    $len_result = count($result);
    if ($len_result == 0) {
        echo "<meta charset='UTF-8'>";
        echo "<script type='text/javascript'>alert('你的文件没有任何数据！');window.location='search.php';</script>";
        exit;
    }
    /* $sqlchongfu=mysqli_query($conn,"select actime from ".$qianzui."account where jiid='$_SESSION[uid]'");
  while($chongfu=mysqli_fetch_array($sqlchongfu)){
  if($chongfu[actime]==$timechongfu){
    echo '数据重复提交！';
    mysqli_close($sqlchongfu);
    exit;
  }
  } */
    for ($i = 1; $i < $len_result; $i++) {
        //循环获取各字段值
        $classify = iconv('gb2312', 'utf-8', $result[$i][0]);
        //中文转码
        $shouzhi = iconv('gb2312', 'utf-8', $result[$i][1]);
        if ($shouzhi == "收入") {
            $shouzhi = "1";
        } else {
            $shouzhi = "2";
        }
        $sqlclassify = "select * from ".$qianzui."account_class where classname='$classify' and ufid='$_SESSION[uid]'";
        $queryclassify = mysqli_query($conn,$sqlclassify);
        $attitle = is_array($rowclassify = mysqli_fetch_array($queryclassify));
        if ($attitle) {
            $sqlclassid = "select * from ".$qianzui."account_class where ufid='$_SESSION[uid]' and classname='$classify'";
            $queryclassid = mysqli_query($conn,$sqlclassid);
            while ($rowclassid = mysqli_fetch_array($queryclassid)) {
                $acclassid = $rowclassid['classid'];
            }

        } else {
            $sqladd = "insert into ".$qianzui."account_class (classname, classtype,ufid) values ('$classify', '$shouzhi',$_SESSION[uid])";
            $queryadd = mysqli_query($conn,$sqladd);
            $acclassid = mysqli_insert_id($conn);
        }
        $jine = $result[$i][2];
        $time100 = strtotime($result[$i][3]);
        $beizhu = $result[$i][4];
        $jiid = $_SESSION['uid'];
        $data_values .= "('$jine','$acclassid','$time100','$beizhu','$jiid','$shouzhi'),";
    }
    $data_values = substr($data_values,0,-1);
    //去掉最后一个逗号
    fclose($handle);
    //关闭指针
    $query = mysqli_query($conn,"insert ".$qianzui."account (acmoney,acclassid,actime,acremark,jiid,zhifu) values $data_values");
    //批量插入数据表中
    if ($query) {
        echo "<meta charset='UTF-8'>";
        $d = "导入成功！导入了";
        $e = " 条！";
        $f = $d.$len_result.$e;
        echo "<script type='text/javascript'>alert('$f');window.location='search.php';</script>";
    } else {
        echo "<meta charset='UTF-8'>";
        $c = "导入失败，请检查文件格式！";
        echo "<script type='text/javascript'>alert('$c');window.location='search.php';</script>";
    }
} elseif ($action == 'export') {
    //导出CSV
    $result = mysqli_query($conn,"select acclassid,zhifu,acmoney,actime,acremark from ".$qianzui."account where jiid='$_SESSION[uid]'");
    $str = "分类,收支,金额,时间,备注\n";
    $str = iconv('utf-8','gb2312',$str);
    while ($row = mysqli_fetch_array($result)) {
        $sql = "select * from ".$qianzui."account_class where classid=$row[acclassid] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn,$sql);
        $classinfo = mysqli_fetch_array($classquery);
        $classify = iconv('utf-8','gb2312',$classinfo['classname']);
        if ($classinfo['classtype'] == 1) {
            $shouzhi = iconv('utf-8','gb2312',"收入");
        } else {
            $shouzhi = iconv('utf-8','gb2312',"支出");
        }
        $jine = $row['acmoney'];
        $shijian = date("Y-m-d H:i",$row['actime']);
        $beizhu = iconv('utf-8','gb2312',$row['acremark']);
        $str .= $classify.",".$shouzhi.",".$jine.",".$shijian.",".$beizhu."\n";
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
?>