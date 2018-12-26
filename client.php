<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">

    <!-- 包含头部信息用于适应不同设备 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 包含 bootstrap 样式表 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>记账多用户版</title>
</head>
<body>

    <?php
    session_start();
    include("config.php");

    ?>

    <?php
    if ($_GET['tc'] == 'logout') {
        session_destroy();
        //注销session
        header("location:client.php");
        //跳转到首页
    }
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
                        <a class="navbar-brand" href="client.php">快捷记账</a>
                    </div>
                    <div class="collapse navbar-collapse" id="example-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php if ($_SESSION['uuid'] != "") {
                                echo "<li><a href="."client.php?tc=logout".">退出</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php if ($_SESSION['uuid'] == "") {
                ?>
                <table align="center" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                    <tr>
                        <td bgcolor="#EBEBEB">　验证</td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF">

                            <form action="" method="get" name="submitdl">
                                账号：<input type="text" name="username" id="username"> <br /><br />
                                密码：<input type="password" name="password" id="password" size="18" maxlength="15" /><br /><br />
                                <input name="submitdl" type="submit" value="登入" class="btn btn-default" /> <?php
                                if ($_GET['submitdl']) {
                                    $user = $_GET['username'];
                                    $upass = $_GET['password'];
                                    $result = mysqli_query($conn,"SELECT * FROM jizhang_user WHERE username='$user'");
                                    $row = mysqli_fetch_array($result);
                                    if ($upass == $row['cpassword'] && $user == $row['username'] && $row['cpassword'] !== "") {
                                        $_SESSION['uuid'] = $row['uid'];
                                        echo "</font><meta http-equiv=refresh content='0; url=client.php'>";
                                    } else {
                                        echo " 用户名或密码错误！";
                                    }
                                }
                                ?>

                            </form>

                        </td>
                    </tr>
                </table>

                <?php
            }
            ?>



            <?php
            $income = 0;
            $spending = 0;
            //检查是否记账并执行
            if ($_GET['Submit']) {
                if ($_SESSION[uuid] != "") {
                    $path = $_GET['money'];
                    $path1 = $_GET['classid'];
                    $path2 = $_GET['time'];
                    $path3 = $_GET['remark'];
                    $path4 = $_GET['zhifu'];

                    foreach ($path as $key => $value) {
                        $shijiannn = $path2[$key];
                        $time100 = strtotime($shijiannn);
                        if ($value == "" || $path1 == "") {
                            echo "<script type='text/javascript'>alert('添加成功，空数据自动跳过！');window.location='client.php';</script>";
                            exit;
                        }
                        $query = mysqli_query($conn,"insert into ".$qianzui."account (acmoney, acclassid, actime, acremark,zhifu,jiid) values('$value','".$path1[$key]."','$time100','".$path3[$key]."','".$path4[$key]."','$_SESSION[uuid]')");


                        //$sql="insert into ".$qianzui."account (acmoney, acclassid, actime, acremark,zhifu,jiid) values('$path','$path1','$path2','$path3','$path4','$_SESSION[uuid]')";
                        //$query=mysqli_query($conn,$sql);

                    }
                    // $sql="insert into ".$qianzui."account (acmoney, acclassid, actime, acremark,jiid,zhifu) values('$_GET[money]', '$_GET[classid]', '$time100', '$_GET[remark]', '$_SESSION[uuid]', '$_GET[zhifu]')";
                    // $query=mysqli_query($conn,$sql);
                    if ($query) {
                        echo "<script type='text/javascript'>alert('添加成功！');window.location='client.php';</script>";
                    } else {
                        echo "<script type='text/javascript'>alert('添加失败！');window.location='client.php';</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('你还没登录！');window.location='client.php';</script>";
                }
            }
            ?>
            <script src="js/jquery-1.9.1.min.js"></script>
            <script>
                $(document).ready(function() {

                    var MaxInputs = 4; //maximum input boxes allowed
                    var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
                    var AddButton = $("#AddMoreFileBox"); //Add button ID
                    var myDate = new Date();
                    var Miao = myDate.getTime();

                    var x = InputsWrapper.length; //initlal text box count
                    var FieldCount = 1; //to keep track of text box added

                    $(AddButton).click(function (e)  //on add input button click
                        {
                            if (x <= MaxInputs) //max input box allowed
                            {
                                FieldCount++; //text box added increment
                                //add input box
                                $(InputsWrapper).append('<div><input name="zhifu[]" id="zhifu" type="text" value="1" style="display:none;"/><font color="MediumSeaGreen">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;"/><font color="MediumSeaGreen"> 分类：</font><select name="classid[]" id="classid" style="height:26px;"><?php
                                    $sql = "select * from ".$qianzui."account_class where classtype=1 and ufid=$_SESSION[uuid]";
                                    $query = mysqli_query($conn,$sql);
                                    while ($acclass = mysqli_fetch_array($query)) {
                                        echo "<option value=$acclass[classid]>$acclass[classname]</option>";
                                    }
                                    ?></select><font color="MediumSeaGreen"> 备注：</font><input name="remark[]" type="text" id="remark" style="width:120px;"/> 时间：<input type="text" name="time[]" id="time" value="<?php $xz = date("Y-m-d H:i");
                                    echo "$xz";
                                    ?>" style="width:120px;"/><a href="#" class="removeclass"> 删除</a><br /><br /></div>');
                                x++; //text box increment
                            }
                            return false;
                        });

                    var MaxInputs1 = 4; //maximum input boxes allowed
                    var InputsWrapper1 = $("#InputsWrapper1"); //Input boxes wrapper ID
                    var AddButton1 = $("#AddMoreFileBox1"); //Add button ID
                    var y = InputsWrapper1.length; //initlal text box count
                    var FieldCount = 1; //to keep track of text box added
                    $(AddButton1).click(function (e)  //on add input button click
                        {
                            if (y <= MaxInputs1) //max input box allowed
                            {
                                FieldCount++; //text box added increment
                                //add input box
                                $(InputsWrapper1).append('<div><input name="zhifu[]" id="zhifu" type="text" value="2" style="display:none;"/><font color="red">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;"/><font color="red"> 分类：</font><select name="classid[]" id="classid" style="height:26px;"><?php
                                    $sql = "select * from ".$qianzui."account_class where classtype=2 and ufid=$_SESSION[uuid]";
                                    $query = mysqli_query($conn,$sql);
                                    while ($acclass = mysqli_fetch_array($query)) {
                                        echo "<option value=$acclass[classid]>$acclass[classname]</option>";
                                    }
                                    ?></select><font color="red"> 备注：</font><input name="remark[]" type="text" id="remark" style="width:120px;"/> 时间：<input type="text" name="time[]" id="time" value="<?php $xz = date("Y-m-d H:i");
                                    echo "$xz";
                                    ?>" style="width:120px;"/><a href="#" class="removeclass"> 删除</a><br /><br /></div>');
                                y++; //text box increment
                            }
                            return false;
                        });

                    $("body").on("click", ".removeclass", function(e) {
                        //user click on remove text
                        if (x > 1) {
                            $(this).parent('div').remove(); //remove text box
                            x--; //decrement textbox
                        }
                        if (y > 1) {
                            $(this).parent('div').remove(); //remove text box
                            y--; //decrement textbox
                        }
                        return false;
                    })

                });
            </script>
            <table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                    <td bgcolor="#EBEBEB">　<font color="red">支出</font> - <a href="#" id="AddMoreFileBox1">再加一行</a></td>
                </tr>
                <tr><td bgcolor="#FFFFFF">
                    <form id="myform2" name="myform2" method="get" action="" onsubmit="return checkpost2();">
                        <div id="InputsWrapper1">
                            <div>
                                <input name="zhifu[]" id="zhifu" type="text" value="2" style="display:none;" /><font color="red">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="red"> 分类：</font><select name="classid[]" style="height:26px;"><?php
                                    $sql = "select * from ".$qianzui."account_class where classtype=2 and ufid='$_SESSION[uuid]'";
                                    $query = mysqli_query($conn,$sql);
                                    while ($acclass = mysqli_fetch_array($query)) {
                                        echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
                                    }
                                    ?></select><font color="red"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
                                ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
                            </div>
                        </div>
                        <div>
                            <input name="zhifu[]" id="zhifu" type="text" value="2" style="display:none;" /><font color="red">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="red"> 分类：</font><select name="classid[]" style="height:26px;"><?php
                                $sql = "select * from ".$qianzui."account_class where classtype=2 and ufid='$_SESSION[uuid]'";
                                $query = mysqli_query($conn,$sql);
                                while ($acclass = mysqli_fetch_array($query)) {
                                    echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
                                }
                                ?></select><font color="red"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
                            ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
                        </div>
                    </div>
                    <div>
                        <input name="zhifu[]" id="zhifu" type="text" value="2" style="display:none;" /><font color="red">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="red"> 分类：</font><select name="classid[]" style="height:26px;"><?php
                            $sql = "select * from ".$qianzui."account_class where classtype=2 and ufid='$_SESSION[uuid]'";
                            $query = mysqli_query($conn,$sql);
                            while ($acclass = mysqli_fetch_array($query)) {
                                echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
                            }
                            ?></select><font color="red"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
                        ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
                    </div>
                </div>
                    <div>
                        <input name="zhifu[]" id="zhifu" type="text" value="2" style="display:none;" /><font color="red">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="red"> 分类：</font><select name="classid[]" style="height:26px;"><?php
                            $sql = "select * from ".$qianzui."account_class where classtype=2 and ufid='$_SESSION[uuid]'";
                            $query = mysqli_query($conn,$sql);
                            while ($acclass = mysqli_fetch_array($query)) {
                                echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
                            }
                            ?></select><font color="red"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
                        ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
                    </div>
                </div>
                <div>
                    <input name="zhifu[]" id="zhifu" type="text" value="2" style="display:none;" /><font color="red">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="red"> 分类：</font><select name="classid[]" style="height:26px;"><?php
                        $sql = "select * from ".$qianzui."account_class where classtype=2 and ufid='$_SESSION[uuid]'";
                        $query = mysqli_query($conn,$sql);
                        while ($acclass = mysqli_fetch_array($query)) {
                            echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
                        }
                        ?></select><font color="red"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
                    ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
                </div>
            </div>
            <input name="Submit" type="submit" id="Submit" value="记账" class="btn btn-default" /> <font color="#ccc">空数据自动跳过！</font>
        </form>
    </td></tr>
<tr>
    <td bgcolor="#EBEBEB">　<font color="MediumSeaGreen">收入</font> - <a href="#" id="AddMoreFileBox">再加一行</a></td>
</tr>
<tr><td bgcolor="#FFFFFF">
    <form id="myform1" name="myform1" method="get" action="" onsubmit="return checkpost();">
        <div id="InputsWrapper">
            <div>
                <input name="zhifu[]" id="zhifu" type="text" value="1" style="display:none;" /><font color="MediumSeaGreen">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="MediumSeaGreen"> 分类：</font><select name="classid[]" style="height:26px;"><?php
                    $sql = "select * from ".$qianzui."account_class where classtype=1 and ufid='$_SESSION[uuid]'";
                    $query = mysqli_query($conn,$sql);
                    while ($acclass = mysqli_fetch_array($query)) {
                        echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
                    }
                    ?></select><font color="MediumSeaGreen"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
                ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
            </div>
        </div>
        <div>
            <input name="zhifu[]" id="zhifu" type="text" value="1" style="display:none;" /><font color="MediumSeaGreen">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="MediumSeaGreen"> 分类：</font><select name="classid[]" style="height:26px;"><?php
                $sql = "select * from ".$qianzui."account_class where classtype=1 and ufid='$_SESSION[uuid]'";
                $query = mysqli_query($conn,$sql);
                while ($acclass = mysqli_fetch_array($query)) {
                    echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
                }
                ?></select><font color="MediumSeaGreen"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
            ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
        </div>
    </div>
    <div>
        <input name="zhifu[]" id="zhifu" type="text" value="1" style="display:none;" /><font color="MediumSeaGreen">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="MediumSeaGreen"> 分类：</font><select name="classid[]" style="height:26px;"><?php
            $sql = "select * from ".$qianzui."account_class where classtype=1 and ufid='$_SESSION[uuid]'";
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
            }
            ?></select><font color="MediumSeaGreen"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
        ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
    </div>
</div>
    <div>
        <input name="zhifu[]" id="zhifu" type="text" value="1" style="display:none;" /><font color="MediumSeaGreen">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="MediumSeaGreen"> 分类：</font><select name="classid[]" style="height:26px;"><?php
            $sql = "select * from ".$qianzui."account_class where classtype=1 and ufid='$_SESSION[uuid]'";
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
            }
            ?></select><font color="MediumSeaGreen"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
        ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
    </div>
</div>
<div>
    <input name="zhifu[]" id="zhifu" type="text" value="1" style="display:none;" /><font color="MediumSeaGreen">金额：</font><input type="text" name="money[]" id="money" value="" style="width:70px;" /><font color="MediumSeaGreen"> 分类：</font><select name="classid[]" style="height:26px;"><?php
        $sql = "select * from ".$qianzui."account_class where classtype=1 and ufid='$_SESSION[uuid]'";
        $query = mysqli_query($conn,$sql);
        while ($acclass = mysqli_fetch_array($query)) {
            echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
        }
        ?></select><font color="MediumSeaGreen"> 备注：</font><input name="remark[]" type="text" style="width:120px;" /> 时间：<input type="text" name="time[]" value="<?php echo date("Y-m-d H:i");
    ?>" style="width:120px;" /><a href="#" class="removeclass"> 删除</a><br /><br />
</div>
</div>
<input name="Submit" type="submit" id="Submit" value="记账" class="btn btn-default" /> <font color="#ccc">空数据自动跳过！</font>
</form>
</td></tr>


</table>

<table align="left" width="100%" height="20" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" class='table table-striped table-bordered'>
<tr>
<td align="left" bgcolor="#EBEBEB"><font id="stat"></font></td>
</tr>
</table>

<?php

//每页显示的数
$pagesize = 31;

//确定页数 p 参数
$p = $_GET['p']?$_GET['p']:1;

//数据指针
$offset = ($p-1)*$pagesize;

//查询本页显示的数据
$query_sql = "SELECT * FROM ".$qianzui."account where jiid='$_SESSION[uuid]' ORDER BY actime DESC LIMIT  $offset , $pagesize";
$query = mysqli_query($conn,$query_sql);

echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                <th bgcolor='#EBEBEB'>分类</th>
                <th bgcolor='#EBEBEB'>收支</th>
                <th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>时间</th>
                <th bgcolor='#EBEBEB'>备注</th>
                </tr>";

if ($result === FALSE) {
die(mysqli_error());
// TODO: better error handling
}

while ($row = mysqli_fetch_array($query)) {
$sql = "select * from ".$qianzui."account_class where classid=$row[acclassid] and ufid='$_SESSION[uuid]'";
$classquery = mysqli_query($conn,$sql);
$classinfo = mysqli_fetch_array($classquery);

echo "<tr>";
if ($classinfo['classtype'] == 1) {
echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $classinfo['classname'] . "</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acmoney'] . "</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>收入</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".date("Y-m-d",$row['actime'])."</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>". $row['acremark'] ."</font></td>";
} else {
echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $classinfo['classname'] . "</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acmoney'] . "</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>支出</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".date("Y-m-d",$row['actime'])."</font></td>";
echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>". $row['acremark'] ."</font></td>";
}
echo "</tr>";
}
echo "</table>";


echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr><td align='left' bgcolor='#FFFFFF'>";

//分页代码
//计算总数
$count_result = mysqli_query($conn,"SELECT count(*) as count FROM ".$qianzui."account where jiid='$_SESSION[uuid]'");
$count_array = mysqli_fetch_array($count_result);

//计算总的页数
$pagenum = ceil($count_array['count']/$pagesize);
echo '共记 ',$count_array['count'],' 条';

//循环输出各页数目及连接

if ($pagenum > 1) {
for ($i = 1;$i <= $pagenum;$i++) {
if ($i == $p) {
echo ' [',$i,']';
} else {
echo ' <a href="client.php?p=',$i,'">',$i,'</a>';
}
}
}
echo "</td></tr></table>";




?>


<?php

$sql = "select * from ".$qianzui."account where jiid='$_SESSION[uuid]' ORDER BY actime ASC";


$query = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($query)) {
$sql = "select * from ".$qianzui."account_class where classid= $row[acclassid] and ufid='$_SESSION[uuid]'";
$classquery = mysqli_query($conn,$sql);
$classinfo = mysqli_fetch_array($classquery);

if ($classinfo['classtype'] == 1) {

$income = $income+$row['acmoney'];
} else {
$spending = $spending+$row['acmoney'];
}
}

?>

<script language="javascript">
document.getElementById("stat").innerHTML = "<?='总共收入<font color=MediumSeaGreen> '.$income.'</font> 总共支出 <font color=red>'.$spending.'</font>' ?>"
</script>


<?php
include_once("footer.php");
?>