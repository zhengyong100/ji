<?php
    include_once("shangmian.php");
?>

<?php
$income=0;
$spending=0;
?>
<script type="text/javascript"> 
function GetCurrentStyle(obj, prop) {       
   if(obj.currentStyle) {          
      return obj.currentStyle[prop];       
   }        
   else if(window.getComputedStyle) {                 
      return window.getComputedStyle(obj,null)[prop];       
   }        
   return null;     
}
window.onload=function(){
  var show=document.getElementById("show");
  var hide=document.getElementById("hide");
  var bt=document.getElementById("btn");
  bt.onclick=function(evt){
    if(GetCurrentStyle(hide,"display")=="none"){
      hide.style.display="block";
      bt.value="隐藏";
    }
    else{
      hide.style.display="none";
      bt.value="显示导入格式";
    }
     var e = evt || window.event;    
     window.event?e.cancelBubble=true:e.stopPropagation();     
  } 
  document.onclick=function(){
    hide.style.display="none";
	bt.value="显示导入格式";
  }
}
</script> 
<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr>
        <td bgcolor="#EBEBEB">　导出导入</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">
      <form id="addform" action="daochuru.php?action=import" method="post" enctype="multipart/form-data">
	  <input type="button" id="btn" value="显示导入格式" class="btn btn-default" ><br/><br/>
	  <div id="hide" style="display:none">
	  			用文本复制以下内容保存为csv后缀名<br/>
			或excel导出csv格式文件，格式必须如下：<br/><br/>
			分类,收支,金额,时间,备注<br/>
			车费,支出,35,2015-11-30 05:15,打的<br/>
			工资,收入,22,2015-11-30 05:16,工作<br/><br/>
		 </div>
		 <p>请选择要导入的CSV文件：<br/><br/>
		 <input type="file" name="file"><br/><br/><input type="submit" class="btn btn-default" value="导入CSV"><br/><br/>
         <input type="button" class="btn btn-default" id="exportCSV" value="导出全部记账CSV" onClick="window.location.href='daochuru.php?action=export'"></p>
      </form>
         </form>        </td>
      </tr>

    </table>
	
	
	<table align="center" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" class='table table-striped table-bordered'>
      <tr>
        <td align="left" valign="middle" bgcolor="#EBEBEB" style="color: #666666;">注意：按查询导出推荐使用Chrome、Firefox、Safari</td>
      </tr>
    </table>

 <script language="javascript">
var daochu = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv=Content-Type content="text/html; charset=utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><style> .xl24{mso-style-parent:style0;font-size:10.0pt;text-align:center;border:.5pt solid windowtext;white-space:normal;}.xl25{mso-style-parent:style0;font-size:10.0pt;text-align:center;border-top:.5pt solid windowtext;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl26{mso-style-parent:style0;font-size:10.0pt;mso-number-format:"Short Date";text-align:center;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:.5pt solid windowtext;white-space:normal;}.xl27{mso-style-parent:style0;font-size:10.0pt;text-align:center;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl28{mso-style-parent:style0;font-size:10.0pt;text-align:left;width:200pt;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl29{mso-style-parent:style0;font-size:10.0pt;text-align:center;width:54pt;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl30{mso-style-parent:style0;font-size:10.0pt;text-align:center;width:96pt;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;} </style></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr>
        <td bgcolor="#EBEBEB">　按查询导出</td>
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
  <td align='left' bgcolor='#EBEBEB'>　查询结果&nbsp;<font id='tongji'></font>　　<input type='button' onclick='daochu(excel)' value='导出搜索结果为xls excel文件' class='btn btn-default'></td>
  </tr>
</table>

 <table id='excel' class='table table-striped' width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3'>
                <tr>
                <th width='120' class=xl24 bgcolor='#EBEBEB'>分类</th>
                <th width='50' class=xl25 bgcolor='#EBEBEB'>金额</th>
                <th width='90' class=xl25 bgcolor='#EBEBEB'>收支</th>
                <th width='150' class=xl25 bgcolor='#EBEBEB'>时间</th>
                <th width='60' class=xl25 bgcolor='#EBEBEB'>备注</th>
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
	echo "</tr>";
}
				echo "</table>";
				
				
				
				
			  
		  }
		  ?>
		  

</div>
	
	
<script language="javascript">
document.getElementById("tongji").innerHTML="<?='总共收入<font color=blue> '.$income.'</font> 总共支出 <font color=red>'.$spending.'</font>'?>"
</script>

<?php
    include_once("xiamian.php");
?>
