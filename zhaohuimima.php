<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>php mysql 简单记账xptt程序 - 修改密码</title>
 </head>
<?php
include_once("config.php");//连接数据库 
 
$token = stripslashes(trim($_GET['token'])); 
$email = stripslashes(trim($_GET['email'])); 
$sql = "select * from `jizhang_user` where email='$email'"; 
 
$query = mysql_query($sql); 
$row = mysql_fetch_array($query); 
if($row){ 
    $mt = md5($row['uid'].$row['username'].$row['password']); 
    if($mt==$token){ 
        if(time()-$row['utime']>24*60*60){ 
            $msg = '不好意思，该链接已过期！再来一次吧 ：）'; 
        }else{ 
            
         
         
         
         
         
          echo "<form action='' method='post' name='submitxiugai'>
        <label for='Name'>用户名</label>
        ".$row[username]."<br />   
        <label for='password'>新密码</label>
        <input type='password' name='password' id='password' size='18' maxlength='15' /> 
        *(最多15个字符)<br />
        <input name='Submitxiugai' type='submit' class='buttom' value='提交' /> 
</form>";

        if($_POST[Submitxiugai]){   

           if($_POST[password]<>""){
             $umima=md5($_POST[password]);
             $uid=$row['uid'];
      $sql="update jizhang_user set password='$umima' where uid='$uid'";
      $query=mysql_query($sql);
      if($query){
        echo "<font color='green'>OK，修改成功！需要重新登陆，马上为你跳转。。</font><meta http-equiv=refresh content='2; url=index.php'>";
      }else{
        echo "<font color='red'>出错啦，写入数据库时出错！</font>";
        }
          
           }else{
             $msg = '密码不能为空';}
          
          
    }             
         
   
          
          
        } 
    }else{ 
        $msg =  '无效的链接'; 
    } 
}else{ 
    $msg =  '错误的链接！';     
} 
echo $msg;
?>
  </body>
</html>