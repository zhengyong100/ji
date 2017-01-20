<?php
    include_once("shangmian.php");
?>

    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class='table table-striped table-bordered'>
  <tr>
    <td height="5">亲，欢迎使用php mysql简单记账程序。</td>
  </tr>
</table>

<?php
$income=0;
$spending=0;
$zuorishou=0;
$zuorifu=0;
$yueshou=0;
$yuefu=0;
$nianshou=0;
$nianfu=0;
$qiannianshou=0;
$qiannianfu=0;
$zhoushou=0;
$zhoufu=0;
$qianzhoushou=0;
$qianzhoufu=0;
?>

<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                <th bgcolor='#EBEBEB' width="10%">统计</th>
                <th bgcolor='#EBEBEB'>本日</th>
                <th bgcolor='#EBEBEB'>本周</th>
                <th bgcolor='#EBEBEB'>本月</th>
                <th bgcolor='#EBEBEB'>本年</th>
                </tr>
                <tr><td align='left' width="20%" bgcolor='#FFFFFF'><font color="red">支出</font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="red" id="ri2"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="red" id="zhou2"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="red" id="yue2"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="red" id="nian2"></font></td>
                </tr>
                  <tr><td align='left' width="20%" bgcolor='#FFFFFF'><font color="MediumSeaGreen">收入</font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="ri1"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="zhou1"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="yue1"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="nian1"></font></td>
                </tr>
                
                <tr><td align='left' width="20%" bgcolor='#FFFFFF'><font>剩余</font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font id="sri"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font id="szhou"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font id="syue"></font></td>
                <td align='left' width="20%" bgcolor='#FFFFFF'><font id="snian"></font></td>
                </tr>
</table>

<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                <th width="20%" bgcolor='#EBEBEB'>统计</th>
                <th width="20%" bgcolor='#EBEBEB'>昨日</th>
                <th width="20%" bgcolor='#EBEBEB'>上周</th>
                <th width="20%" bgcolor='#EBEBEB'>上月</th>
                <th width="20%" bgcolor='#EBEBEB'>去年</th>
                </tr>
                <tr><td align='left' width="20%" bgcolor='#FFFFFF'><font color="red">支出</font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="red" id="qianri2"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="red" id="qianzhou2"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="red" id="qianyue2"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="red" id="qiannian2"></font></td>
                </tr>
                  <tr><td align='left' width="20%" bgcolor='#FFFFFF'><font color="MediumSeaGreen">收入</font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="qianri1"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="qianzhou1"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="qianyue1"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font color="MediumSeaGreen" id="qiannian1"></font></td>
                </tr>
                
                   <tr><td align='left' width="20%" bgcolor='#FFFFFF'><font>剩余</font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font id="sqianri"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font id="sqianzhou"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font id="sqianyue"></font></td>
                <td width="20%" align='left' bgcolor='#FFFFFF'><font id="sqiannian"></font></td>
                </tr>
</table>

<table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class='table table-striped table-bordered'>
  <tr>
    <td height="5"><font id="tongji"></font></td>
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
                <th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>收支</th>
                <th bgcolor='#EBEBEB'>时间</th>
                <th bgcolor='#EBEBEB'>备注</th>
                <th bgcolor='#EBEBEB'>操作</th>
                </tr>";
             
             if($result === FALSE) {
    die(mysql_error()); // TODO: better error handling
}

			while($row = mysql_fetch_array($query)){
				$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
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
            echo ' <a href="tongji.php?p=',$i,'">',$i,'</a>';
        }
    }
}*/
echo "</td></tr></table>";
	
		  ?>
            
<?php
//当日收付统计
$k=date("Y-m-d");

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($k." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]'";
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
		  		
				if($classinfo[classtype]==1){
					$rishou=$rishou+$row[acmoney];
				}else{
					$rifu=$rifu+$row[acmoney];
				}
				
				}  ?>
				
				<?php
//周收付统计
$k=date("Y-m-d",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y")));
$j=date("Y-m-d",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")));

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($j." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]' " ;
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
			
				
				if($classinfo[classtype]==1){
					$zhoushou=$zhoushou+$row[acmoney];
				}else{
					$zhoufu=$zhoufu+$row[acmoney];
				}

		
				
				} ?>
<?php
//当月收付统计
$t = time();
$tk = mktime(0,0,0,date("m",$t),1,date("Y",$t));
$tj=mktime(23,59,59,date("m",$t),date("t"),date("Y",$t));
$j=date("Y-m-d",$tj);
$k=date("Y-m-d",$tk);

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($j." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]' ";
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
		  
			
				
				if($classinfo[classtype]==1){
					$yueshou=$yueshou+$row[acmoney];
				}else{
					$yuefu=$yuefu+$row[acmoney];
				}

		
				
				} ?>
				
				<?php
//年收付统计
$t = time();
$tk = mktime(0,0,0,1,1,date("Y",$t));
$tj=mktime(23,59,59,12,31,date("Y",$t));
$j=date("Y-m-d",$tj);
$k=date("Y-m-d",$tk);

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($j." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]' ";
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
		  
			
				
				if($classinfo[classtype]==1){
					$nianshou=$nianshou+$row[acmoney];
				}else{
					$nianfu=$nianfu+$row[acmoney];
				}

		
				
				} ?>
				
				<?php
//前日
$k=date("Y-m-d",strtotime('-1 day'));

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($k." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]'";
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
		  
			
				
				if($classinfo[classtype]==1){
					$qianrishou=$qianrishou+$row[acmoney];
				}else{
					$qianrifu=$qianrifu+$row[acmoney];
				}

		
				
				}  ?>
				
				<?php
//前周收付统计

$k=date("Y-m-d",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-14,date("Y")));
$j=date("Y-m-d",mktime(23,59,59,date("m"),date("d")-date("w")+7-14,date("Y")));

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($j." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]'";
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
		  
			
				
				if($classinfo[classtype]==1){
					$qianzhoushou=$qianzhoushou+$row[acmoney];
				}else{
					$qianzhoufu=$qianzhoufu+$row[acmoney];
				}

		
				
				} ?>

<?php
//前月收付统计
$t = time();
$tk = mktime(0,0,0,date("m",$t)-1,1,date("Y",$t));
$tj=mktime(23,59,59,date("m",$t)-1,date("t",$t3),date("Y",$t));
$j=date("Y-m-d",$tj);
$k=date("Y-m-d",$tk);

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($j." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]' ";
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
		  
			
				
				if($classinfo[classtype]==1){
					$qianyueshou=$qianyueshou+$row[acmoney];
				}else{
					$qianyuefu=$qianyuefu+$row[acmoney];
				}

		
				
				} ?>
				
			
				
				
				
				<?php
//前一年收付统计
$n=date("Y")-1;
$j="$n-12-31";
$k="$n-01-01";

$sqltime=" actime >".strtotime($k." 0:0:0")." and actime <".strtotime($j." 23:59:59");
$query_sql = "SELECT * FROM jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]' ";
$query=mysql_query($query_sql);
              
              		while($row = mysql_fetch_array($query)){
              		$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
		  
			
				if($classinfo[classtype]==1){
					$qiannianshou=$qiannianshou+$row[acmoney];
				}else{
					$qiannianfu=$qiannianfu+$row[acmoney];
				}

				
				} ?>
				
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
document.getElementById("tongji").innerHTML="<?='总共收入<font color=blue> '.$income.'</font> 总共支出 <font color=red>'.$spending.'</font>'?>"
document.getElementById("ri1").innerHTML="<?=$rishou ?>"
document.getElementById("ri2").innerHTML="<?=$rifu ?>"
document.getElementById("sri").innerHTML="<?=$rishouru-$rifu ?>"
document.getElementById("zhou1").innerHTML="<?=$zhoushou ?>"
document.getElementById("zhou2").innerHTML="<?=$zhoufu ?>"
document.getElementById("szhou").innerHTML="<?=$zhoushou-$zhoufu ?>"
document.getElementById("yue1").innerHTML="<?=$yueshou ?>"
document.getElementById("yue2").innerHTML="<?=$yuefu ?>"
document.getElementById("syue").innerHTML="<?=$yueshou-$yuefu ?>"
document.getElementById("nian1").innerHTML="<?=$nianshou ?>"
document.getElementById("nian2").innerHTML="<?=$nianfu ?>"
document.getElementById("snian").innerHTML="<?=$nianshou-$nianfu ?>"
document.getElementById("qianri1").innerHTML="<?=$qianrishou ?>"
document.getElementById("qianri2").innerHTML="<?=$qianrifu ?>"
document.getElementById("sqianri").innerHTML="<?=$qianrishou-$qianrifu ?>"
document.getElementById("qianzhou1").innerHTML="<?=$qianzhoushou ?>"
document.getElementById("qianzhou2").innerHTML="<?=$qianzhoufu ?>"
document.getElementById("sqianzhou").innerHTML="<?=$qianzhoushou-$qianzhoufu ?>"
document.getElementById("qianyue1").innerHTML="<?=$qianyueshou ?>"
document.getElementById("qianyue2").innerHTML="<?=$qianyuefu ?>"
document.getElementById("sqianyue").innerHTML="<?=$qianyueshou-$qianyuefu ?>"
document.getElementById("qiannian1").innerHTML="<?=$qiannianshou ?>"
document.getElementById("qiannian2").innerHTML="<?=$qiannianfu ?>"
document.getElementById("sqiannian").innerHTML="<?=$qiannianshou-$qiannianfu ?>"
</script>

<?php
    include_once("xiamian.php");
?>