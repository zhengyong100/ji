<?php
    include_once("shangmian.php");
?>
<script type="text/javascript">  
          var checkall=document.getElementsByName("del_id[]");  
            function select(){                          //全选  
                for(var $i=0;$i<checkall.length;$i++){  
                    checkall[$i].checked=true;  
                }  
            }  
            function fanselect(){                        //反选  
                for(var $i=0;$i<checkall.length;$i++){  
                    if(checkall[$i].checked){  
                        checkall[$i].checked=false;  
                    }else{  
                        checkall[$i].checked=true;  
                    }  
                }  
            }           
            function noselect(){                          //全不选  
                for(var $i=0;$i<checkall.length;$i++){  
                    checkall[$i].checked=false;  
                }  
            }  
			
        </script>
		
		<script>
		window.onload=function() {
var oTxt1=document.getElementById('zhuan');
var oBtn1=document.getElementById('zhuan1');
oBtn1.onclick=function() {
location.href="xiugai.php?p="+oTxt1.value+"";
}
}
</script>
		
		
 <!-- 记住选择页js <script language="javascript" type="text/javascript">  
    function save() {  
        selectIndex = document.getElementById("tiao").selectedIndex;  
        document.cookie = 'selectIndex =' + selectIndex;  
    }  
    window.onload = function () {  
        var cooki = document.cookie;  
        if (cooki != "") {  
            cooki = "{\"" + cooki + "\"}";  
            cooki = cooki.replace(/\s*/g, "").replace(/=/g, '":"').replace(/;/g, '","');  
            var json = eval("(" + cooki + ")"); //将coolies转成json对象  
            document.getElementById("tiao").options[json.selectIndex].selected = true;  
        }  
        else  
            save();  
    }  
</script> -->


<?php

 if ($_GET[ok]) {
               
                //针对$ok被激活后的处理：
                $shij=strtotime("$_GET[shijian]");
                $sql = "update jizhang_account set acmoney='".$_GET[jine]."',acremark='".$_GET[beizhu]."',actime='".$shij."' where acid='".$_GET[id]."' and jiid='".$_SESSION[uid]."'";
                $result = mysql_query($sql);
                if ($result)
                    echo("<script type='text/javascript'>alert('修改成功！');history.go(-2);</script>");
                else
                    echo("<script type='text/javascript'>alert('修改失败！');history.go(-2);</script>");
                             
            }else{
				 if ($_GET[id]) {
				$sql = "select * from jizhang_account where acid='".$_GET[id]."' and jiid='".$_SESSION[uid]."'";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                
                $sql2="select * from jizhang_account_class where classid= '".$row[acclassid]."' and ufid='".$_SESSION[uid]."'";
				$classquery=mysql_query($sql2);
				$classinfo = mysql_fetch_array($classquery);
				
				
				echo "<table align='left' width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr>
        <td bgcolor='#EBEBEB'>　账目修改</td>
      </tr>
      <tr>
        <td bgcolor='#FFFFFF'>
   <form method=get action=''>
<INPUT TYPE='hidden' name='id' value=".$row[acid].">
金额：<input type=text name='jine' value=".$row[acmoney]."><br /><br />
账目分类：".$classinfo[classname]."<br /><br />
收入/支出：";
if($classinfo[classtype]==1){
   echo '收入';
   $income=$income+$row[acmoney];
    }else{
   echo '支出';
   $spending=$spending+$row[acmoney];
   }

echo "<br /><br />
时间：<input rows='1' cols='20' name='shijian' value='".date('Y-m-d H:i',$row[actime])."'> <br /><br />
备注：<input type=text name='beizhu' value=".$row[acremark]."><br /><br />
　<input type=submit name=ok value='提交' class='btn btn-default'>
   </form>		</td>
      </tr>
    </table>";
				
			}

 }
?>


<?php

if($_POST[Submit]){ 
echo "";
}else{
    if ($conn) {
mysql_select_db("jizhang");
        if (!$_GET[id]) {
            //$result = mysql_query("select * from jizhang");

//每页显示的数
$pagesize = 10;

//确定页数 p 参数
$p = $_GET['p']?$_GET['p']:1;

//数据指针
$offset = ($p-1)*$pagesize;

//查询本页显示的数据
$query_sql = "SELECT * FROM jizhang_account where jiid='$_SESSION[uid]' ORDER BY actime DESC LIMIT  $offset , $pagesize";

$query=mysql_query($query_sql);


//echo $query_sql;

            echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                <th bgcolor='#EBEBEB'>账目</th>
                <th bgcolor='#EBEBEB'>收支</th>
                <th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>时间</th>
                <th bgcolor='#EBEBEB'>备注</th>
                <th bgcolor='#EBEBEB'><form action='shanchu.php' method='post'><a href='javascript:select()'>全选</a> | <a href='javascript:fanselect()'>反选</a> | <a href='javascript:noselect()'>不选</a> <input type='submit' name='shanchu' value='删除'/></th>
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
                echo "<td align='left' bgcolor='#FFFFFF'><a href=xiugai.php?id=".$row['acid'].">编辑</a> <a href=shanchu.php?id=".$row['acid'].">删除</a>
				<input name='del_id[]' type='checkbox' id='del_id[]' value=".$row['acid']." /></td>";
                echo "</tr>";
            }
         echo "</table>";


echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr><td align='left' width='100%' bgcolor='#FFFFFF'>";
//分页代码
//计算总数
$count_result = mysql_query("SELECT count(*) as count FROM jizhang_account where jiid='$_SESSION[uid]'");
$count_array = mysql_fetch_array($count_result);

//计算总的页数
$pagenum=ceil($count_array['count']/$pagesize);
echo "<ul class='pagination'>";
echo '<li class="disabled"><a href="#">共',$count_array['count'],'条 <span id="total" style="display:none">',$pagenum,'</span></a></li>'; //后面共几页

if ($pagenum > 1) {
    for($i=1;$i<$pagenum;$i++) {
        if($i==$p) {
            echo "<span id='pagingText' style='display:none'>$i</span>";
    }
}
}

/* echo "<select name='tiao' id='tiao' style='height:18px' onchange='self.location.href=options[selectedIndex].value;onchange=save()'>";
echo "<option value='xiugai.php?p=1'>跳转</option>";
if ($pagenum > 1) {
    for($i=1;$i<=$pagenum;$i++) {
        
            echo "<option value='xiugai.php?p=$i'>$i</option>";
    }
}
echo "</select>"; */

//循环输出各页数目及连接	echo ' <a href="xiugai.php?p=',$i-1,'">上一页</a>';

 //echo " <li><a href='xiugai.php?p=1'>首页</a></li>";
  //echo "<li><a href='xiugai.php?p=$pagenum'>尾页</a></li>";
if ($pagenum > 1) {
    for($i=1;$i<=$pagenum;$i++) {
        if($i==$p) {
			if($i!=1){
            echo '<li><a href="xiugai.php?p=',$i-1,'">&laquo;</a></li>';
			}
        } 
    }
}

if ($pagenum > 1) {
    for($i=1;$i<$pagenum;$i++) {
        if($i==$p) {
            echo '<li><a href="xiugai.php?p=',$i+1,'">&raquo;</a></li>';
    }
}
}

echo "</ul>";
echo "<ul class='pagination' id='pagingDiv'><ul/>";
echo "</td>";
// echo "<td align='right' width='10%' bgcolor='#FFFFFF'><input type='text' name='zhuan' id='zhuan' style='width:35px'/> <input type='submit' name='go' id='go' value='go' /></td>"; //跳转页面


				echo "</form>";
		echo "</table>";
		/*echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>";
		echo "<tr><td align='left' bgcolor='#FFFFFF'><ul class='pagination' id='pagingDiv'><ul/></td></tr>";
		echo "</table>"; */


        }
		
		}
        //显示列表的内容
       
}
?>

   <script language="javascript">  
    //首先获取当前的总页数，一般是后台传递过来的，这里假定40页。  
    var total = document.getElementById("total").innerHTML;  
    //id="pagingDiv"的div通过pagingConstruct函数构造，比如加载网页是第1页的 
	var url= window.location.href;
var index = +url.substring(url.lastIndexOf('=') + 1);
if (index > 0){
    pagingConstruct(index);
}else {
	pagingConstruct(1);
}

    //形式参数paging是指当前页  
    function pagingConstruct(paging){  
        //先更新一下行内文本  
        document.getElementById("pagingText").innerHTML = paging;  
        var pagingDivInnerHTML = "";  
        //这里是加载省略号的flag  
        var isHiddenExist = 0; 
        //从第1页读到第40页。  
        for (var i = 1; i <= total; i++) {  
            //如果读到当前页，就仅仅加载一个文本，不放链接  
            if (i == paging) {  
                pagingDivInnerHTML += "<li class='active'><a href='#'>" + i + "</a></li>";  
            }  
            else {  
                //如果是页首，中间页，页尾，当前页的前后三页则不省略。 
				//if (i < 4 || i < (paging + 3) && i > (paging - 3)|| i > (total / 2 - 2) && i < (total / 2 + 2) || i > (total - 1)) { 
                if (i < 2 || i < (paging + 4) && i > (paging - 4) || i > (total - 1)) {  
                    pagingDivInnerHTML += "<li><a href='xiugai.php?p=" + i + "' onclick='pagingConstruct(" + i + ")'>" + i + "</a></li>";  
                    isHiddenExist = 0;  
                }  
                //否则就构造...  
                else {  
                    if (isHiddenExist == 0) {  
                        pagingDivInnerHTML += "";  //引号里面放这个<li><a href='#'>...</a></li>显示...
                        isHiddenExist = 1;  
                    }  
                }  
            }  
        }  
        //把构造的内容放上去pagingDiv  
        document.getElementById("pagingDiv").innerHTML = pagingDivInnerHTML;  
    }  
</script> 

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr>
        <td bgcolor="#EBEBEB">　查询修改</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">
<form id="form1" name="form1" method="post" action="">
          选择分类：
            <select name="classid" id="classid"  style="height:26px;">
              <option value="quan">全部分类</option>
              <option value="sr">收入--</option>
			  <?php
			  	$sqlshouru="select * from jizhang_account_class where ufid='$_SESSION[uid]' and classtype='1'";
				$queryshouru=mysql_query($sqlshouru);
				while($rowshouru = mysql_fetch_array($queryshouru)){
					echo "<option value='$rowshouru[classid]'>------$rowshouru[classname]</option>";
				}
			  ?>
		<option value="zc">支出--</option>
				<?php
			  	$sqlzhichu="select * from jizhang_account_class where ufid='$_SESSION[uid]' and classtype='2'";
				$queryzhichu=mysql_query($sqlzhichu);
				while($rowzhichu = mysql_fetch_array($queryzhichu)){
					echo "<option value='$rowzhichu[classid]'>------$rowzhichu[classname]</option>";
				}
			  ?>
            </select><br /><br />
          日期：从 <input type="date" name="time1" id="time1"  style="height:26px;width:115px;" /> 到 <input type="date" name="time2" id="time2"  style="height:23px;width:115px;" /> 
        <br /><br />
        备注：<input type="text" name="beizhu" id="beizhu" /><br /><br />

        <input type="submit" name="Submit" value="查询" class="btn btn-default"/><br /><br />
        
        
        </form>        </td>
      </tr>

    </table>     

		  <?php
		
		  	if(!$_POST[Submit]){  
		  		
				 include_once("xiamian.php");
				exit();
				
		  	}

		  ?>
		  
		  
		  
		  <?php if($_POST[Submit]){
						  	//只查询备注
			if($_POST[classid]=="quan" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]<>""){
 				 $a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
 				 $sql="select * from jizhang_account where acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			}
			//什么都没填
			if($_POST[classid]=="quan" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]==""){
				$sql="select * from jizhang_account where jiid='$_SESSION[uid]' ORDER BY actime ASC";
			}
			//只查询分类
			if($_POST[classid]<>"quan" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]==""){
				$sqlclassid="acclassid=".$_POST[classid];
				$sql="select * from jizhang_account where ".$sqlclassid." and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			}
			
			//只查询分类收
			if($_POST[classid]=="zc" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]==""){
				
				$sql="select * from jizhang_account where zhifu='2' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			}
			if($_POST[classid]=="sr" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]==""){
				
				$sql="select * from jizhang_account where zhifu='1' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			}
			//只查询分类支
		
			//只查询日期
			if($_POST[classid]=="quan" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]==""){
				
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");
				$sql="select * from jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			if($_POST[classid]=="quan" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]==""){
				
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");
				$sql="select * from jizhang_account where ".$sqltime." and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			//------------------------------
			//查询分类，日期，备注
			if($_POST[classid]<>"" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]<>""){
			$a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
				$sqlclassid="acclassid=".$_POST[classid];
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");

				$sql="select * from jizhang_account where ".$sqlclassid." and ".$sqltime." and acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			//----------------------------------------
			//查询收支，备注
			if($_POST[classid]=="sr" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]<>""){
			$type="1";
				$a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
				

				$sql="select * from jizhang_account where zhifu='$type' and acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			if($_POST[classid]=="zc" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]<>""){
			$type="2";
				$a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
				

				$sql="select * from jizhang_account where zhifu='$type' and acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			
			//查询收支，日期
			if($_POST[classid]=="sr" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]==""){
			$type="1";
				
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");

				$sql="select * from jizhang_account where zhifu='$type' and ".$sqltime." and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			if($_POST[classid]=="zc" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]==""){
			$type="2";
				
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");

				$sql="select * from jizhang_account where zhifu='$type' and ".$sqltime." and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			//查询收支，日期，备注
			if($_POST[classid]=="sr" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]<>""){
			$type="1";
			$a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
				
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");

				$sql="select * from jizhang_account where zhifu='$type' and ".$sqltime." and acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			if($_POST[classid]=="zc" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]<>""){
			$type="2";
			$a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
				
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");

				$sql="select * from jizhang_account where zhifu='$type' and ".$sqltime." and acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			
			//查询日期，备注
			if($_POST[classid]=="quan" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]<>""){
			$a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
								$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");

				$sql="select * from jizhang_account where ".$sqltime." and acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			
			
			//--------------------------------------
			//查询分类，备注
			if($_POST[classid]<>"quan" && $_POST[classid]<>"sr" && $_POST[classid]<>"zc" && $_POST[time1]=="" && $_POST[time2]=="" && $_POST[beizhu]<>""){
			$a="%";
 				 $b =$_POST[beizhu];
 				 $c=$a.$b.$a;
				$sqlclassid="acclassid=".$_POST[classid];

				$sql="select * from jizhang_account where ".$sqlclassid." and acremark like '$c' and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			
			//查询分类，日期
			if($_POST[classid]<>"quan" && $_POST[classid]<>"sr" && $_POST[classid]<>"zc" && $_POST[time1]<>"" && $_POST[time2]<>"" && $_POST[beizhu]==""){
			
				$sqlclassid="acclassid=".$_POST[classid];
				$sqltime=" actime >".strtotime($_POST[time1]." 0:0:0")." and actime <".strtotime($_POST[time2]." 23:59:59");

				$sql="select * from jizhang_account where ".$sqlclassid." and ".$sqltime." and jiid='$_SESSION[uid]' ORDER BY actime ASC";
			
			}
			
			
			echo "
				<table align='left' width='100%' height='20' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
  <tr>
  <td align='left' bgcolor='#EBEBEB'>　查询结果&nbsp;<font id='tongji'></font></td>
  </tr>
</table>
<form action='shanchu.php' method='post'>
 <table id='excel' class='table table-striped' width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3'>
                <tr>
                <th bgcolor='#EBEBEB'>分类</th>
                <th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>收支</th>
                <th bgcolor='#EBEBEB'>时间</th>
                <th bgcolor='#EBEBEB'>备注</th>
				<th bgcolor='#EBEBEB'><a href='javascript:select()'>全选</a> | <a href='javascript:fanselect()'>反选</a> | <a href='javascript:noselect()'>不选</a> <input type='submit' name='shanchu' value='删除'/></th>
                </tr>
				";
			
			
			$query=mysql_query($sql);
			while($row = mysql_fetch_array($query)){
				$sql="select * from jizhang_account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
				$classquery=mysql_query($sql);
				$classinfo = mysql_fetch_array($classquery);
				echo "<tr>";
 if($classinfo[classtype]==1){
                echo "<td align='left' class='xl26' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $classinfo['classname'] . "</font></td>";
                echo "<td align='left' class='xl29' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acmoney'] . "</font></td>";
                echo "<td align='left' class='xl27' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>收入</font></td>";
                echo "<td align='left' class='xl30' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".date("Y-m-d",$row[actime])."</font></td>";
                echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>". $row[acremark] ."</font></td>";
$income=$income+$row[acmoney];
                }else{
                echo "<td align='left' class='xl26' bgcolor='#FFFFFF'><font color='red'>" . $classinfo['classname'] . "</font></td>";
                echo "<td align='left' class='xl29' bgcolor='#FFFFFF'><font color='red'>" . $row['acmoney'] . "</font></td>";
                echo "<td align='left' class='xl27' bgcolor='#FFFFFF'><font color='red'>支出</font></td>";
               echo "<td align='left' class='xl30' bgcolor='#FFFFFF'><font color='red'>".date("Y-m-d",$row[actime])."</font></td>";
               echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>". $row[acremark] ."</font></td>";
$spending=$spending+$row[acmoney];    
			}
		  echo "<td align='left' bgcolor='#FFFFFF'><a href=xiugai.php?id=".$row['acid'].">编辑</a> <a href=shanchu.php?id=".$row['acid'].">删除</a>
				<input name='del_id[]' type='checkbox' id='del_id[]' value=".$row['acid']." /></td>"; 
	echo "</tr>";
}
				echo "</table></form>
				";
				
			  
		  }
		  ?>
</div>
	
	
<script language="javascript">
document.getElementById("tongji").innerHTML="<?='总共收入<font color=blue> '.$income.'</font> 总共支出 <font color=red>'.$spending.'</font>'?>"
</script>

 

<?php
    include_once("xiamian.php");
?>