<?php
//数据库配置信息，根据情况修改，否则无法安装
$db_servername="localhost";//Mysql服务器地址 将 localhost 修改为你的数据库地址
$db_username="xpttcom_ji";//数据库用户名 将 username 修改为你的数据库用户名
$db_password="jimima";//数据库密码 将 password 修改为你的数据库密码
$db_dbname="xpttcom_ji";//数据库名 将 jizhang 修改为你的数据库名
$qianzui="ji_";//表前缀
$zyemail="jizhangxptt@163.com";//配置找回密码邮箱，推荐163邮箱
$zyemailpass="1314520iloveyou";//邮箱密码
$conn=mysql_connect($db_servername,$db_username,$db_password);
if(indatabase($db_dbname,$conn)){
  mysql_select_db($db_dbname,$conn);
  mysql_query('SET NAMES utf8');
}


function user_shell($uid,$shell){ //其他页面权限判断
 $sqlshell="SELECT * FROM `jizhang_user` WHERE `uid` = '$uid'";
  $query=mysql_query($sqlshell);
     $exist=is_array($row=mysql_fetch_array($query));
  $exist2=$exist?$shell==md5($row['username'].$row['password']):FALSE;
  if($exist2){  return $row;  }else{   echo "你无权限访问该页,正在跳转登入页面。。。"; 
  echo "<meta http-equiv=refresh content='0; url=index.php'>";
   exit();
   }  } 

   
//基本设置
//date_default_timezone_set("Asia/Shanghai");
//date_default_timezone_set('America/Argentina/Buenos_Aires');
//时区设置为北京时间 亚洲/上海 阿根廷时间date_default_timezone_set( 'America/Argentina/Buenos_Aires' );

function user_mktime($onlinetime) {  $new_time = mktime();   if (($new_time - $onlinetime) > '900') {  session_destroy();   echo "登陆超时";  exit ();  } else {   $_SESSION['times'] = mktime();  }  } 


//数据库是否存在
function indatabase($db_dbname,$conn){
  mysql_select_db("information_schema",$conn);
  $sql="select * from SCHEMATA where SCHEMA_NAME='".$db_dbname."'";
  $query=mysql_query($sql);
  $indb=is_array($row=mysql_fetch_array($query));
  return $indb;
}
//表是否存在
function intable($dbname,$tablename,$conn){
  mysql_select_db("information_schema",$conn);
  $sql="select * from TABLE_CONSTRAINTS where TABLE_SCHEMA='".$dbname."' and TABLE_NAME='".$tablename."'";
  $query=mysql_query($sql);
  $intable=is_array($row=mysql_fetch_array($query));
  mysql_select_db($dbname,$conn);//重新关联账本数据库
  return $intable;
}

?>