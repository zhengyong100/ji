<?php
    include_once("shangmian.php");
?>
<table align="center" width="640" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="40" height="25">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="40" height="85">&nbsp;</td>
    <td align="left" valign="top">
	<?php
		//查询当前分类信息
		$sql="select * from jizhang_account_class where classid='$_GET[classid]' and ufid='$_SESSION[uid]'";
		$query=mysql_query($sql);
		$cuclass = mysql_fetch_array($query);
		//执行操作--修改分类名称
		if($_GET[Submit]){
			$sql="update jizhang_account_class set classname= '$_GET[classname2]' where classid='$_GET[classid]' and ufid='$_SESSION[uid]'";
			$query=mysql_query($sql);
			if($query){
				echo "分类名称修改成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=fenlei.php'>";
				exit();
			}else{
				echo "修改分类名称，执行数据库操作时失败！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=fenlei.php'>";
				exit();
			}
		}
		//执行操作--转移分类
		if($_GET[Submit2]){
			$sql="select * from jizhang_account where acclassid= '$_GET[classid]' and jiid='$_SESSION[uid]'";
			$query=mysql_query($sql);
			while($row = mysql_fetch_array($query)){
				$sql="update jizhang_account set acclassid= '$_GET[toclassid]' where acid= '$row[acid]' and jiid='$_SESSION[uid]'";
				mysql_query($sql);
			}
			echo "转移完成，你可以查询此分类下是否还有记录，已确认是否全部转移成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=fenlei.php'>";
			exit();
		}
		//执行操作--删除分类
		if($_GET[Submit3]){
			$sql="select * from jizhang_account where acclassid='$_GET[classid]' and jiid='$_SESSION[uid]'";
			$query=mysql_query($sql);
			if($row=mysql_fetch_array($query)){
				echo "<font color='red'>无法删除！在此分类下有账目，请将账目转移到其他分类。</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=fenlei.php'>";
				exit();
			}else{
				$sql="delete from jizhang_account_class where classid=".$_GET[classid];
				if(mysql_query($sql))
					echo "分类删除成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=fenlei.php'>";
				else
					echo "<font color='red'>删除失败！从数据库中删除时返回失败！</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=fenlei.php'>";
				exit();
			}
		}
		//根据操作判断要显示内容
		if($_GET[type]=="1")
		{ 
	?>
	<table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><form id="form1" name="form1" method="get" action="">
          <label>将[<font color="red"><?php echo $cuclass[classname]; ?></font>]修改为
            <input name="classname2" type="text" id="classname2" value="<?php echo $cuclass[classname]; ?>" />
            </label>
          <label>
          <input type="submit" name="Submit" value="修改" />
          </label>
          <input name="classid" type="hidden" id="classid" value="<?php echo $_GET[classid]; ?>" />
        </form>
        </td>
      </tr>
    </table>
	<?php
		}elseif($_GET[type]=="2"){
	?>
      <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><form id="form2" name="form2" method="get" action="">将[<font color="red"><?=$cuclass[classname]?></font>]
            <label>转移到
            <select name="toclassid" id="toclassid">
			  <?php
			  	$sql="select * from jizhang_account_class where classtype=$cuclass[classtype] and ufid='$_SESSION[uid]'";
				$query=mysql_query($sql);
				while($row = mysql_fetch_array($query)){
					echo "<option value='$row[classid]'>$row[classname]</option>";
				}
			  ?>
            </select>
            </label>
            <label>
            <input type="submit" name="Submit2" value="转移" />
            </label>
            <input name="classid" type="hidden" id="classid" value="<?=$_GET[classid]?>" />
          </form>
          </td>
        </tr>
      </table>
	  <?php
	 	}elseif($_GET[type]=="3"){
	  ?>
      <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>删除前请将此分类转移到其他分类，否则无法删除</td>
        </tr>
        <tr>
          <td><form id="form3" name="form3" method="get" action="">
            <label>
              <input type="submit" name="Submit3" value="删除" />
              </label>
            <input name="classid" type="hidden" id="classid" value="<?=$_GET[classid]?>" />
          </form>
          </td>
        </tr>
      </table>
	  <?php
	  	}else{
			echo "参数错误！";
		}
	  ?>
    </td>
  </tr>
</table>
<?php
    include_once("xiamian.php");
?>