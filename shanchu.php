<?php
    include_once("shangmian.php");
?>
<?php
        if ($_GET[id]) {

$sql="delete from jizhang_account where acid='$_GET[id]' and jiid='$_SESSION[uid]'";
            $result = mysql_query($sql);
            if ($result)
            echo("<script type='text/javascript'>alert('已删除一条记录！');history.go(-1);</script>");
            else
            echo("<script type='text/javascript'>alert('删除出错！');history.go(-1);</script>"); 
    } // end if

?>
<?php
        if ($_GET[uid]) {

$sql="delete from jizhang_account where jiid='$_SESSION[uid]'";
$result = mysql_query($sql);
$sqls="delete from jizhang_account_class where ufid='$_SESSION[uid]'";
            $results = mysql_query($sqls);
            if ($results)
            echo("<script type='text/javascript'>;window.location='zhanghao.php';</script>"); //数据已全部删除成功！
            else
            echo("<script type='text/javascript'>alert('删除出错！');window.location='zhanghao.php';</script>"); 
    } // end if

?>
<?php
if ( $_REQUEST['shanchu'] ){
 if($_POST['del_id']!=""){
             $del_id= implode(",",$_POST['del_id']); 
             mysql_query("delete from jizhang_account where jiid='$_SESSION[uid]' and acid in ($del_id)"); 
             echo("<script type='text/javascript'>alert('删除成功！');history.go(-1);</script>"); 
      }else{ 
             echo("<script type='text/javascript'>alert('请先选择项目！');history.go(-1);</script>"); 
      } 
	  } 
?>

<?php
if ( $_REQUEST['go'] ){
	echo "<meta http-equiv=refresh content='0; url=xiugai.php?p=$_POST[zhuan]'>";
		  } 
?>
<br /><br />
<?php
    include_once("xiamian.php");
?>
