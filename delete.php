<?php
include_once("header.php");
?>
<?php
if ($_GET['id']) {

    $sql = "delete from ".$qianzui."account where acid='$_GET[id]' and jiid='$_SESSION[uid]'";
    $result = mysqli_query($conn,$sql);
    if ($result)
        echo("<script type='text/javascript'>alert('已删除一条记录！');history.go(-1);</script>");
    else
        echo("<script type='text/javascript'>alert('删除出错！');history.go(-1);</script>");
}
// end if

?>
<?php
if ($_GET['uid']) {

    $sql = "delete from ".$qianzui."account where jiid='$_SESSION[uid]'";
    $result = mysqli_query($conn,$sql);
    $sqls = "delete from ".$qianzui."account_class where ufid='$_SESSION[uid]'";
    $results = mysqli_query($conn,$sqls);
    if ($results)
        echo("<script type='text/javascript'>;window.location='users.php';</script>");
    //数据已全部删除成功！
    else
        echo("<script type='text/javascript'>alert('删除出错！');window.location='users.php';</script>");
}
// end if

?>
<?php
if ($_REQUEST['delete']) {
    if ($_POST['del_id'] != "") {
        $del_id = implode(",",$_POST['del_id']);
        mysqli_query($conn,"delete from ".$qianzui."account where jiid='$_SESSION[uid]' and acid in ($del_id)");
        echo("<script type='text/javascript'>alert('删除成功！');window.location='edit.php';</script>");
    } else {
        echo("<script type='text/javascript'>alert('请先选择项目！');window.location='edit.php';</script>");
    }
}
?>

<?php
if ($_REQUEST['go']) {
    echo "<meta http-equiv=refresh content='0; url=edit.php?p=$_POST[zhuan]'>";
}
?>
<br /><br />
<?php
include_once("footer.php");
?>