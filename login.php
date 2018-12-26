<?php
session_start();
error_reporting(E_ALL || ~E_NOTICE);
/*
if(isset($_SESSION['user_shell']))
{
echo "<script language='javascript' type='text/javascript'>window.location.href='add.php'</script>";
}
*/
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>记账多用户版</title>

    <link rel="stylesheet" type="text/css" href="css/default.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style type="text/css">
        /* <![CDATA[ */
        #tab-title .selected { color:#f00;
            font-weight:bold
        }
        #tab-title span {
            padding:0 18px 8px 0;
            cursor:pointer;
        }
        #tab-content .hide { display:none;
        }
        #tab-content ul {
            overflow:hidden;
            list-style:none
        }
        #tab-content ul li {
            overflow:hidden;
            border-top: 1px dotted #DDDDDD;
            line-height: 2.1em;
            padding: 0 1px;
        }
        #tab-content ul li span {
            color:#A1A3A6;
        }
        .tishi { position:absolute;
            bottom:10px;
        }
        /* ]]> */
    </style>

</head>
<body>
    <?php
    include("config.php");
    ?>


    <script type="text/javascript">
        //tab
        jQuery(document).ready(function() {
            jQuery('#tab-title span').click(function() {
                jQuery(this).addClass("selected").siblings().removeClass();
                jQuery("#tab-content > ul").slideUp('0').eq(jQuery('#tab-title span').index(this)).slideDown('0');
            });
        });
    </script>
    <div class='login'>
        <div class='login_title'>
            <div id="tab-title">
                <h3><span class="selected">登录</span><span>注册</span><span>忘记密码</span></h3>
            </div>
        </div>

        <div id="tab-content">



            <ul>
                <form action="" method="post">
                    <div class='login_fields'>

                        <div class='login_fields__user'>
                            <div class='icon'>
                                <img src='img/user_icon_copy.png'>
                            </div>
                            <input placeholder='用户名' type='text' id='username' name='username'>
                            <div class='validation'>
                                <img src='img/tick.png'>
                            </div>
                        </input>
                    </div>

                    <div class='login_fields__password'>
                        <div class='icon'>
                            <img src='img/lock_icon_copy.png'>
                        </div>
                        <input placeholder='密码' type='password' id='password' name='password'>
                        <div class='validation'>
                            <img src='img/tick.png'>
                        </div>
                    </div>

                    <div class='login_fields__submit'>
                        <input type='submit' value='登录' name='submit'>
                    </div>

                </div>
            </form>
        </ul>

        <ul class="hide">
            <form action="" method="post" name="submitzhuce">
                <div class='login_fields'>

                    <div class='login_fields__user'>
                        <div class='icon'>
                            <img src='img/user_icon_copy.png'>
                        </div>
                        <input placeholder='用户名' type='text' id='username' name='username'>
                        <div class='validation'>
                            <img src='img/tick.png'>
                        </div>
                    </input>
                </div>

                <div class='login_fields__user'>
                    <div class='icon'>
                        <img src='img/user_icon_copy.png'>
                    </div>
                    <input placeholder='邮箱' type='text' name='email' id='email'>
                    <div class='validation'>
                        <img src='img/tick.png'>
                    </div>
                </input>
            </div>

            <div class='login_fields__password'>
                <div class='icon'>
                    <img src='img/lock_icon_copy.png'>
                </div>
                <input placeholder='密码' type='password' id='password' name='password'>
                <div class='validation'>
                    <img src='img/tick.png'>
                </div>
                <div class='login_fields__submit'>
                    <input type='submit' value='提交' name='Submitzhuce'>
                </div>
            </div>


        </div>
    </form>
</ul>

<ul class="hide">
    <form action="" method="post">
        <div class='login_fields'>

            <div class='login_fields__user'>
                <div class='icon'>
                    <img src='img/user_icon_copy.png'>
                </div>
                <input placeholder='邮箱' type='text' name='email' id='email'>
                <div class='validation'>
                    <img src='img/tick.png'>
                </div>
            </input>
            <div class='login_fields__submit'>
                <input type='submit' value='找回' name='submitmima'>
            </div>
        </div>
    </div>
</form>
</ul>


</div>
<div class="tishi">
<p>
<?php
if ($_POST['submit']) {
$username = str_replace(" ","",$_POST['username']);
//去除空格
$sql = "SELECT * FROM ".$qianzui."user WHERE username = '$username'";
$query = mysqli_query($conn,$sql);
$exist = is_array($row = mysqli_fetch_array($query));
//判断是否存在这样一个用户
$exist2 = $exist?md5($_POST['password']) == $row['password']:FALSE;
//判断密码
if ($exist2) {
$_SESSION['uid'] = $row['uid'];
// session赋值
$_SESSION['user_shell'] = md5($row['username'].$row['password']);
echo "<br><br><font color='green'>登陆成功咯！稍等，努力穿越中...</font><meta http-equiv=refresh content='0; url=add.php'>";
} else {
echo "<br><br><font color='red'>用户名或密码错误啦！</font>";
SESSION_DESTROY();
}
}
?>

<?php if ($_POST[Submitzhuce]) {
if (empty($_POST[email]) || preg_match('^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+.)+[A-Za-z]{2,5}$',$_POST[email])
) {
echo "<br><br><font color='red'>邮箱格式不正确！</font>";
exit;

}

$sql = "select * from ".$qianzui."user where username='$_POST[username]' or email='$_POST[email]'";
$query = mysqli_query($conn,$sql);
$attitle = is_array($row = mysqli_fetch_array($query));
if ($attitle) {
echo "<br><br><font color='red'>用户或则邮箱已存在！换一个吧！</font>";
exit();
} else {
$umima = md5($_POST[password]);
$utime = strtotime("now");
$sql = "insert into ".$qianzui."user (username, password,email,utime) values ('$_POST[username]', '$umima', '$_POST[email]', '$utime')";
$query = mysqli_query($conn,$sql);
if ($query) {
echo "<br><br><font color='green'>OK，你已经成功注册！随时可以登录！</font>";
} else
{
echo "<br><br><font color='red'>出错啦，写入数据库时出错！</font>";
}
//给用户增加默认分类
$sql = "select * from ".$qianzui."user where username='$_POST[username]'";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($query);
$uid = $row['uid'];
$sql = "insert into ".$qianzui."account_class (classname, classtype,ufid) values ('默认收入', '1','".$uid."'),('默认支出', '2','".$uid."')";
$query = mysqli_query($conn,$sql);
if ($query) {
echo "<br><font color='green'>增加默认分类成功！</font>";
} else
{
echo "<br><font color='red'>增加默认分类出错！</font>";
}
}
}
?>

<?php
if ($_POST['submitmima']) {
include('class.phpmailer.php');
include('class.smtp.php');
if (empty($_POST[email]) || preg_match("^[-a-zA-Z0-9_.]+@([0-9A-Za-z][0-9A-Za-z-]+.)+[A-Za-z]{2,5}$",$_POST[email])
) {
echo "<br><br><font color='red'>邮箱格式不正确！</font>";
exit;

}
$email = str_replace(" ","",$_POST['email']);
//去除空格

$sql = "select * from ".$qianzui."user where email='$email'";
$query = mysqli_query($conn,$sql);
$attitle = is_array($row = mysqli_fetch_array($query));
if ($attitle) {
$username = $row['username'];
$user_pass = $row['password'];
$uid = $row['uid'];
$getpasstime = time();
$time = date('Y-m-d H:i');
$token = md5($uid.$row['username'].$row['password']);
//组合验证码
$dir = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
$path = dirname($dir);
$url = $path."/password_ret.php?email=".$email."&token=".$token;
//构造URL

$mail = new PHPMailer();
$mail->CharSet = "utf8";
$mail->IsSMTP();
// set mailer to use SMTP
$mail->Host = "smtp.163.com";
// SMTP服务器
$mail->Port = 25;
$mail->SMTPAuth = true;
// SMTP认证？
$mail->Username = $zyemail;
// 用户名
$mail->Password = $zyemailpass;
// 密码
$mail->From = $zyemail;
//发件人地址
$mail->FromName = "记账管理员";
//发件人
$mail->AddAddress($email, $username);
//收件人地址，收件人名称
$mail->WordWrap = 50;
//$mail->AddAttachment("/var/tmp/file.tar.gz");       // 附件
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // 附件,新文件名
$mail->IsHTML(true);
// HTML格式
$mail->Subject = "你的密码找回信";
$mail->Body = "亲：".$username."：<Br>您在".$time."提交了找回密码请求，<Br>请点击下面的链接，按流程进行密码重设。<Br>".$url." <Br>本程序由<a href='http://xptt.com'>http://xptt.com</a>提供。";
}

if (!$mail->Send()) {
echo "Mailer Error: " . $mail->ErrorInfo;
echo "<br><br><font color=red>邮箱设置错误!</font>";
} else {
mysqli_query($conn,"update `".$qianzui."user` set `utime`='$getpasstime' where uid='$uid '");
echo "<br><br><font color=green>找回密码邮件发送成功！请查收</font>";
}

}
?>
</p>
</div>
</div>
<script type="text/javascript" src='js/stopExecutionOnTimeout.js?t=1'></script>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script>
$('input[type="submit"]').click(function () {
$('.login').addClass('test');
setTimeout(function () {
$('.login').addClass('testtwo');
}, 300);
setTimeout(function () {
$('.authent').show().animate({
right: -320
}, {
easing: 'easeOutQuint',
duration: 600,
queue: false
});
$('.authent').animate({
opacity: 1
}, {
duration: 200,
queue: false
}).addClass('visible');
}, 500);
setTimeout(function () {
$('.authent').show().animate({
right: 90
}, {
easing: 'easeOutQuint',
duration: 600,
queue: false
});
$('.authent').animate({
opacity: 0
}, {
duration: 200,
queue: false
}).addClass('visible');
$('.login').removeClass('testtwo');
}, 2500);
setTimeout(function () {
$('.login').removeClass('test');
$('.login div').fadeOut(123);
}, 2800);
setTimeout(function () {
$('.success').fadeIn();
}, 3200);
});
$('input[type="text"],input[type="password"]').focus(function () {
$(this).prev().animate({
'opacity': '1'
}, 200);
});
$('input[type="text"],input[type="password"]').blur(function () {
$(this).prev().animate({
'opacity': '.5'
}, 200);
});
$('input[type="text"],input[type="password"]').keyup(function () {
if (!$(this).val() == '') {
$(this).next().animate({
'opacity': '1',
'right': '30'
}, 200);
} else {
$(this).next().animate({
'opacity': '0',
'right': '20'
}, 200);
}
});
var open = 0;
$('.tab').click(function () {
$(this).fadeOut(200, function () {
$(this).parent().animate({
'left': '0'
});
});
});
</script>
</body>
</html>