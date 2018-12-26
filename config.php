<?php
//数据库配置信息，根据情况修改，否则无法安装
$db_servername = "localhost";
//Mysql服务器地址 将 localhost 修改为你的数据库地址
$db_username = "xptt_ji";
//数据库用户名 将 username 修改为你的数据库用户名
$db_password = "jimima";
//数据库密码 将 password 修改为你的数据库密码
$db_dbname = "xptt_ji";
//数据库名 将 jizhang 修改为你的数据库名
$qianzui = "jizhang_";
//表前缀
$zyemail = "xxx@163.com";
//配置找回密码邮箱，推荐163邮箱
$zyemailpass = "";
//邮箱密码
$conn = new mysqli($db_servername,$db_username,$db_password);
if ($conn->connect_error) {
    die("数据库连接错误，请检查config.php设置！");
} 
if (indatabase($db_dbname,$conn)) {
    mysqli_select_db($conn,$db_dbname);
    mysqli_query($conn,'SET NAMES utf8');
}

$banben=PHP_VERSION;
if($banben<5){
	die('PHP版本小于5.0，请升级！');
}


function user_shell($uid,$shell) {
    //其他页面权限判断
    global $conn;
    global $qianzui;
    $query = mysqli_query($conn,"SELECT * FROM jizhang_user WHERE uid = $uid");
    $exist = is_array($row = mysqli_fetch_array($query));
    $exist2 = $exist?$shell == md5($row['username'].$row['password']):FALSE;
    if ($exist2) {
        return $row;
    } else {
        echo "你无权限访问该页,正在跳转登入页面。。。";
        //echo "<meta http-equiv=refresh content='0; url=login.php'>";
        exit();
    }
}


//基本设置
date_default_timezone_set("Asia/Shanghai");
//date_default_timezone_set('America/Argentina/Buenos_Aires');
//时区设置为北京时间 亚洲/上海 阿根廷时间date_default_timezone_set( 'America/Argentina/Buenos_Aires' );

function user_mktime($onlinetime) {
    $new_time = mktime();
    if (($new_time - $onlinetime) > '900') {
        session_destroy();
        echo "登陆超时";
        exit ();
    } else {
        $_SESSION['times'] = mktime();
    }
}


//数据库是否存在
function indatabase($db_dbname,$conn) {
    mysqli_select_db($conn,"information_schema");
    $query = mysqli_query($conn,"select * from SCHEMATA where SCHEMA_NAME='".$db_dbname."'");
    $indb = is_array($row = mysqli_fetch_array($query));
    return $indb;
}
//表是否存在
function intable($dbname,$tablename,$conn) {
    mysqli_select_db($conn,"information_schema");
    $query = mysqli_query($conn,"select * from TABLE_CONSTRAINTS where TABLE_SCHEMA='".$dbname."' and TABLE_NAME='".$tablename."'");
    $intable = is_array($row = mysqli_fetch_array($query));
    mysqli_select_db($conn,$dbname);
    //重新关联账本数据库
    return $intable;
}

?>