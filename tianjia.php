<?php
    include_once("shangmian.php");
?>
<script language="JavaScript"> 
function checkpost() 
{ 
   if(myform.money.value==""){alert("请输入金额");
	window.location='tianjia.php';
    return false; 
   } 
   if(myform.classid.value==""){alert("请添加分类");
	window.location='fenlei.php';
    return false; 
   }   
} 

function checkpost2() 
{ 

 if(myform2.money.value==""){alert("请输入金额");
	window.location='tianjia.php';
    return false; 
   }
      if(myform2.classid.value==""){alert("请添加分类");
	window.location='fenlei.php';
    return false; 
   }  
 }
</script>

<?php
$income=0;
$spending=0;
//检查是否记账并执行
if($_GET[Submit]){
	$time100=strtotime($_GET[time]);
	$sql="insert into jizhang_account (acmoney, acclassid, actime, acremark,jiid,zhifu) values ('$_GET[money]', '$_GET[classid]', '$time100', '$_GET[remark]', '$_SESSION[uid]', '$_GET[zhifu]')";
	$query=mysql_query($sql);
	if($query)
		$prompttext="<font color='#009900'>OK，记完了！</font>";
	else
		$prompttext="<font color='red'>出错啦，写入数据库时出错！</font>";
}
?>

	<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr>
        <td bgcolor="#EBEBEB">　<font color="red">支出</font></td>
        </tr>
<tr><td bgcolor="#FFFFFF">
<form id="form2" name="myform2" method="get" onsubmit="return checkpost2();">
          　<font color="red">金额：</font><input name="money" type="text" id="money" size="8" /><div style="display:none;"><input name="zhifu" type="text" id="zhifu" value="2" size="8" /></div>
          　<font color="red">分类：</font><select name="classid" id="classid" style="height:26px;">
              <?php
		  	$sql="select * from jizhang_account_class where classtype=2 and ufid='$_SESSION[uid]'";
			$query=mysql_query($sql);
			while($acclass=mysql_fetch_array($query)){
				echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
			}
		  ?>
              </select> <font color="red"><a href="fenlei.php" style="color:#ccc;">添加分类</a></font>
          <br /><br />　备注：
            <input name="remark" type="text" id="remark" /> <font color="#ccc">方便搜索</font>
         <br /><br />　时间：<input type="text" name="time" id="time" value="<?php $xz=date("Y-m-d H:i");;echo "$xz"; ?>"/>
            <input name="Submit" type="submit" id="Submit" value="记账" /> <a href="piliangtianjia.php" style="color:#ccc;">批量</a>
  </form>
</td></tr>

</div>
        <tr>
		<td bgcolor="#EBEBEB">　<font color="MediumSeaGreen">收入</font></td>
        </tr>
 <tr><td bgcolor="#FFFFFF">
<form id="form" name="myform" method="get" onsubmit="return checkpost();">
          　<font color="MediumSeaGreen">金额：</font>
            <input name="money" type="text" id="money" value="" size="8" /><div style="display:none;"><input name="zhifu" type="text" id="zhifu" value="1" size="8" /></div>
         　<font color="MediumSeaGreen">分类：</font>
            <select name="classid" id="classid" style="height:26px;">
              <?php
		  	$sql="select * from jizhang_account_class where classtype=1 and ufid='$_SESSION[uid]'";
			$query=mysql_query($sql);
			while($acclass=mysql_fetch_array($query)){
				echo "<option value='$acclass[classid]'>$acclass[classname]</option>";
			}
		  ?>
              </select> <font color="MediumSeaGreen"><a href="fenlei.php" style="color:#ccc;">添加分类</a></font>
          <br /><br />　备注：
            <input name="remark" type="text" id="remark" /> <font color="#ccc">方便搜索</font>
          <br /><br />　时间：<input type="text" name="time" id="time" value="<?php $xz=date("Y-m-d H:i");;echo "$xz"; ?>"/>
            <input type="submit" name="Submit" value="记账" /> <a href="piliangtianjia.php" style="color:#ccc;">批量</a>
 </form>
        
</td></tr>
</table>

 <table align="left" width="100%" height="20" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" class='table table-striped table-bordered'>
  <tr>
    <td align="left" bgcolor="#EBEBEB"><font id="tongji"></font></td>
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
$query_sql = "SELECT * FROM jizhang_account where jiid='$_SESSION[uid]' ORDER BY actime DESC LIMIT  $offset , $pagesize";
$query=mysql_query($query_sql);

			echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                <th bgcolor='#EBEBEB'>分类</th>
                <th bgcolor='#EBEBEB'>收支</th>
                <th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>时间</th>
                <th bgcolor='#EBEBEB'>备注</th>
                <th bgcolor='#EBEBEB'>操作</th>
                </tr>";
             
             if($result === FALSE) {
    die(mysql_error()); // TODO: better error handling
}

			while($row = mysql_fetch_array($query)){
				$sql="select * from jizhang_account_class where classid=$row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);

                echo "<tr>";
                if($classinfo[classtype]==1){
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $classinfo['classname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acmoney'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>收入</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".date("Y-m-d",$row[actime])."</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>". $row[acremark] ."</font></td>";
                }else{
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $classinfo['classname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acmoney'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>支出</font></td>";
               echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".date("Y-m-d",$row[actime])."</font></td>";
               echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>". $row[acremark] ."</font></td>";
                }
                echo "<td align='left' bgcolor='#FFFFFF'><a href=xiugai.php?id=".$row['acid'].">编辑</a> <a href=shanchu.php?id=".$row['acid'].">删除</a></td>";
                echo "</tr>";
            }
            echo "</table>";
			
			
echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr><td align='left' bgcolor='#FFFFFF'>";
			
//分页代码
//计算总数
$count_result = mysql_query("SELECT count(*) as count FROM jizhang_account where jiid='$_SESSION[uid]'");
$count_array = mysql_fetch_array($count_result);

//计算总的页数
$pagenum=ceil($count_array['count']/$pagesize);
echo '共记 ',$count_array['count'],' 条 '; echo ' 这里最多显示最近 ',$pagesize,' 条';

//循环输出各页数目及连接

/*if ($pagenum > 1) {
    for($i=1;$i<=$pagenum;$i++) {
        if($i==$p) {
            echo ' [',$i,']';
        } else {
            echo ' <a href="tianjia.php?p=',$i,'">',$i,'</a>';
        }
    }
}*/
echo "</td></tr></table>";
			
			
			
			
		  ?>
		  

	<?php
			
				$sql="select * from jizhang_account where jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			
			$query=mysql_query($sql);
			while($row = mysql_fetch_array($query)){
				$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
				
				if($classinfo[classtype]==1){
				 	
					$income=$income+$row[acmoney];
				}else{
					$spending=$spending+$row[acmoney];
				}    
			}
	
		  ?>	  
		  
	  
<script language="javascript">
document.getElementById("tongji").innerHTML="<?='总共收入<font color=MediumSeaGreen> '.$income.'</font> 总共支出 <font color=red>'.$spending.'</font>'?>"
</script>
<?php
    include_once("xiamian.php");
?>