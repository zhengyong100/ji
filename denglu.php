<?php session_start();
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
<title>php mysql 简单记账xptt程序</title>
<style type="text/css">
<!--
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size:12px;
    color:#666666;
    background:#fff;
    text-align:center;

}

* {
    margin:0;
    padding:0;
}

a {
    color:#1E7ACE;
    text-decoration:none;    
}

a:hover {
    color:#000;
    text-decoration:underline;
}
h3 {
    font-size:14px;
    font-weight:bold;
}

pre,p {
    color:#1E7ACE;
    margin:4px;
}
input, select,textarea {
    padding:1px;
    margin:2px;
    font-size:11px;
}
.buttom{
    padding:1px 10px;
    font-size:12px;
    border:1px #1E7ACE solid;
    background:#D0F0FF;
}
#formwrapper {
    width:450px;
    margin:15px auto;
    padding:20px;
    text-align:left;
    border:1px #1E7ACE solid;
}

fieldset {
    padding:10px;
    margin-top:5px;
    border:1px solid #1E7ACE;
    background:#fff;
}

fieldset legend {
    color:#1E7ACE;
    font-weight:bold;
    padding:3px 20px 3px 20px;
    border:1px solid #1E7ACE;    
    background:#fff;
}

fieldset label {
    float:left;
    width:120px;
    text-align:right;
    padding:4px;
    margin:1px;
}

fieldset div {
    clear:left;
    margin-bottom:2px;
}

.enter{ text-align:center;}
.clear {
    clear:both;
}

-->
</style>
</head>
<body>
<?php include("config.php"); ?>
<div id="formwrapper">

<h3>已注册用户登录</h3>
    <form action="" method="post">
    <fieldset>
        <legend>用户登录</legend>
        <div>
            <label for="Name">用户名</label>
            <input type="text" name="username" id="username" size="18" maxlength="30" /><br />
        </div>
        <div>
            <label for="password">密码</label>
            <input type="password" name="password" id="password" size="18" maxlength="15" /><br />
        </div>
        <div class="enter">
           
            <input name="submit" type="submit" class="buttom" value="登录" /> <?php
if($_POST['submit']){
  $username=str_replace(" ","",$_POST['username']);
   //去除空格
     $sql="SELECT * FROM jizhang_user WHERE username = '$username'";
     $query=mysql_query($sql);
        $exist=is_array($row=mysql_fetch_array($query));
         //判断是否存在这样一个用户
            $exist2=$exist?md5($_POST['password'])==$row['password']:FALSE;
            //判断密码  
            if($exist2){
               $_SESSION['uid']=$row['uid'];
             // session赋值
                $_SESSION['user_shell']=md5($row['username'].$row['password']);
                  echo "<br><font color='green'>登陆成功咯！稍等，努力穿越中...</font><meta http-equiv=refresh content='2; url=index.php'>";
}else{   echo "<br><font color='red'>用户名或密码错误啦！</font>";  SESSION_DESTROY();  }  } ?>
        </div>    
        <div class="forgotpass"><a href="#">您忘记密码?</a></div>    
    </fieldset>
    </form><br />
    <SCRIPT LANGUAGE=javascript RUNAT=Server>
function isEmail(strEmail) {
if (strEmail.search(/^w+((-w+)|(.w+))*@[A-Za-z0-9]+((.|-)[A-Za-z0-9]+)*.[A-Za-z0-9]+$/) != -1)
return true;
else
alert("请填写正确的邮箱地址！");
}
</SCRIPT>
    <h3>未注册创建帐户</h3>
    <form action="" method="post" name="submitzhuce">
    <fieldset>
        <legend>用户注册</legend>
        <p><strong>您的电子邮箱不会被公布出去,但是必须填写.</strong>用来找回密码.</p>
        <div>
        <label for="Name">用户名</label>
        <input type="text" name="username" id="username" value="" size="20" maxlength="30" /> 
        *(最多30个字符)<br />    
    </div>
        <div>
        <label for="Email">电子邮箱</label>
        <input type="text" name="email" id="email" value="" size="20" maxlength="150" onblur=isEmail(this.value) /> *<br />    
    </div>    
        <div>
        <label for="password">密码</label>
        <input type="password" name="password" id="password" size="18" maxlength="15" /> 
        *(最多15个字符)<br />
    </div>
        <div>
        <br />
    </div>
     
        <div class="enter">
        <input name="Submitzhuce" type="submit" class="buttom" value="提交" /> <?php if($_POST[Submitzhuce]){
        
        
        if ( empty($_POST[email])
|| !ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+.)+[A-Za-z]{2,5}$",$_POST[email])
) {
echo "<font color='red'>邮箱格式不正确！</font>";exit;

} 
        
        $sql="select * from jizhang_user where username='$_POST[username]' or email='$_POST[email]'";
  $query=mysql_query($sql);
  $attitle=is_array($row=mysql_fetch_array($query));
  if($attitle){
    echo "<font color='red'>用户或则邮箱已存在！换一个吧！</font>";
    exit();
  }else{
        $umima=md5($_POST[password]);
        $utime=strtotime("now");
  $sql="insert into jizhang_user (username, password,email,utime) values ('$_POST[username]', '$umima', '$_POST[email]', '$utime')";
  $query=mysql_query($sql);
  if($query)
    echo "<font color='green'>OK，你已经成功注册！在上面登录！</font>";
  else
    echo "<font color='red'>出错啦，写入数据库时出错！</font>";
}
}
?>
    </div>

        <p><strong></strong></p>    
    </fieldset>
    </form><br />
    
    
    
    <h3>找回密码</h3>
    <form action="" method="post">
    <fieldset>
        <legend>找回密码</legend>
        <div>
            <label for="Name">邮箱</label>
            <input type="text" name="email" id="email" size="18" maxlength="30" onblur=isEmail(this.value) /><br />
        </div>
        <div class="enter">
           
            <input name="submitmima" type="submit" class="buttom" value="提交" />
            <?php
            include('class.phpmailer.php'); 
include('class.smtp.php'); 
  if($_POST['submitmima']){
  
  if ( empty($_POST[email])
|| !ereg("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+.)+[A-Za-z]{2,5}$",$_POST[email])
) {
echo "<font color='red'>邮箱格式不正确！</font>";exit;

} 
      $email=str_replace(" ","",$_POST['email']);
       //去除空格

         $sql="select * from jizhang_user where email='$email'";
    $query=mysql_query($sql);
    $attitle=is_array($row=mysql_fetch_array($query));
    if($attitle){
           $username = $row['username'];
    $user_pass = $row['password'];
        $uid = $row['uid'];
      $getpasstime = time();
      $time = date('Y-m-d H:i'); 
      $token = md5($uid.$row['username'].$row['password']);//组合验证码 
      
      $url = $_SERVER['HTTP_HOST']."/ji/zhaohuimima.php?email=".$email."&token=".$token;//构造URL

$mail = new PHPMailer();    
   
$mail->IsSMTP();                                      // set mailer to use SMTP    
$mail->Host = "smtp.163.com";  // SMTP服务器    
$mail->Port = 25; 
$mail->SMTPAuth = true;     // SMTP认证？    
$mail->Username = "jizhangxptt";  // 用户名    
$mail->Password = "1314520iloveyou"; // 密码    
$mail->From = "jizhangxptt@163.com"; //发件人地址    
$mail->FromName = "xptt记账系统管理员"; //发件人    
$mail->AddAddress($email, $username); //收件人地址，收件人名称    
$mail->WordWrap = 50;   
//$mail->AddAttachment("/var/tmp/file.tar.gz");       // 附件    
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // 附件,新文件名    
$mail->IsHTML(true);       // HTML格式    
$mail->Subject    = "你的密码找回信"; 
      $mail->Body       = "亲：".$username."：<Br>您在".$time."提交了找回密码请求，<Br>请点击下面的链接，按流程进行密码重设。<Br>".$url." <Br>本程序由http://xptt.com提供。";   
 }
 
 if(!$mail->Send()) 
{
 echo "Mailer Error: " . $mail->ErrorInfo; 
 echo "<font color=red>邮箱设置错误!</font>"; 
}else{ 
  mysql_query("update `jizhang_user` set `utime`='$getpasstime' where uid='$uid '");
 echo "<font color=green>找回密码邮件发送成功！请查收</font>"; 
 }
    
 } ?>
        </div>       
    </fieldset>
    </form>
</div>
</body>
</html>