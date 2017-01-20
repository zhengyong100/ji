<?php
    include_once("shangmian.php");
?>

<script language="JavaScript"> 
function checkpost() 
{ 
   if(myform.classname.value==""){alert("请输入分类名称");
	window.location='tianjia.php';
    return false; 
   }  
 }
</script>
<?php
if($_GET["Submit"]){
	$sql="select * from jizhang_account_class where classname='$_GET[classname]' and ufid='$_SESSION[uid]'";
	$query=mysql_query($sql);
	$attitle=is_array($row=mysql_fetch_array($query));
	if($attitle){
		$status_text="此分类名称已存在！";
	}else{
		$sql="insert into jizhang_account_class (classname, classtype,ufid) values ('$_GET[classname]', '$_GET[classtype]',$_SESSION[uid])";
		$query=mysql_query($sql);
		if($query){
			$status_text="<font color=#00CC00>添加成功！</font>";
echo "<meta http-equiv=refresh content='0; url=fenlei.php'>";
		}else{
			$status_text="<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
echo "<meta http-equiv=refresh content='0; url=fenlei.php'>";
		}
	}
}
?>


<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
        <tr>
          <td bgcolor="#EBEBEB">　新建分类</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF">
<form id="myform" name="form1" method="get" onsubmit="return checkpost();">
            分类名称：<input name="classname" type="text" id="classname" />
            <select name="classtype" id="classtype"  style="height:26px;">
              <option value="1">收入</option>
              <option value="2">支出</option>
            </select><br /><br />



            <input type="submit" name="Submit" value="新建" class="btn btn-default" />
            <?php echo $status_text;?>
          </form></td>
        </tr>
      </table>
      
<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
        <tr>
          <td bgcolor="#EBEBEB">　分类管理</td>
        </tr>
      </table>
 
	<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

                <tr>
              <th align="left" bgcolor="#EBEBEB">类别名称</th>
              <th align="left" bgcolor="#EBEBEB"><font color='MediumSeaGreen'>收入</font></th>
              <th align="left" bgcolor="#EBEBEB">操作</th>
            </tr>
			<?php 
			$sql="select * from jizhang_account_class where ufid='$_SESSION[uid]' and classtype='1'";
			$query=mysql_query($sql);
			while($row = mysql_fetch_array($query)){
			  echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$row[classname]."</font></td>";
			  if($row[classtype]==1)
			  	echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>收入</font></td>";
			  else
			  	echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>支出</font></td>";
			  echo "<td align='left' bgcolor='#FFFFFF'><a href='xiugaifenlei.php?type=1&classid=".$row[classid]."'>修改</a> <a href='xiugaifenlei.php?type=2&classid=".$row[classid]."'>转移</a> <a href='xiugaifenlei.php?type=3&classid=".$row[classid]."'>删除</a></td>";
			 }
			 echo "</tr>";
			?>
          </table>
              
          <table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
              <th align="left" bgcolor="#EBEBEB">类别名称</th>
              <th align="left" bgcolor="#EBEBEB"><font color='red'>支出</font></th>
              <th align="left" bgcolor="#EBEBEB">操作</th>
            </tr>
			<?php 
			$sql="select * from jizhang_account_class where ufid='$_SESSION[uid]' and classtype='2'";
			$query=mysql_query($sql);
			while($row = mysql_fetch_array($query)){
			  echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$row[classname]."</font></td>";
			  if($row[classtype]==1){
			  	echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>收入</font></td>";
			  }else{
			  	echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>支出</font></td>";			 
			 }
 echo "<td align='left' bgcolor='#FFFFFF'><a href='xiugaifenlei.php?type=1&classid=".$row[classid]."'>修改</a> <a href='xiugaifenlei.php?type=2&classid=".$row[classid]."'>转移</a> <a href='xiugaifenlei.php?type=3&classid=".$row[classid]."'>删除</a></td>";
			 echo "</tr>";
 }
			?>
          </table>

<?php
    include_once("xiamian.php");
?>