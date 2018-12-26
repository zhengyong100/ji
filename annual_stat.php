<?php
include_once("header.php");
?>
<div style="width:1200px;">
    <div style="width:auto;float:left;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>
                    <form id="form" name="form1" method="post" action="">
                        <select name="nian" id="nian" onchange="window.location.href='annual_stat.php?nian='+this.value;options[selectedIndex].value;onchange=save()">

                            <?php $sqlzhanghu = "SELECT * FROM ".$qianzui."account where jiid='$_SESSION[uid]' order by actime limit 1";
                            //order by actime limit 1
                            $result2 = mysqli_query($sqlzhanghu);
                            $row = mysqli_fetch_array($result2);
                            $ntjnian = date("Y",$row[actime]);
                            $ntjxz = date("Y");
                            echo "<option value='$ntjnian'>".date('Y')."</option>";
                            for ($ntjnian; $ntjnian <= $ntjxz; $ntjnian++) {
                                echo "<option value='$ntjnian'>$ntjnian</option>";
                            }
                            ?>
                        </select>
                    </form>
                </th>
            </tr>

            <?php
            //收入分类

            $shouru = array();
            $sqlshouru = "select * from ".$qianzui."account_class where ufid='$_SESSION[uid]' and classtype='1'";
            $queryshouru = mysqli_query($conn,$sqlshouru);
            while ($rowshouru = mysqli_fetch_array($queryshouru)) {
                $cid = $rowshouru['classid'];
                $shouru["$cid"] = $rowshouru['classid'];
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>$rowshouru[classname]</font></td>";
                echo "</tr>";
            }


            //支出分类
            $zhichu = array();
            $sqlshouru = "select * from ".$qianzui."account_class where ufid='$_SESSION[uid]' and classtype='2'";

            $queryshouru = mysqli_query($conn,$sqlshouru);

            while ($rowshouru = mysqli_fetch_array($queryshouru)) {
                $cid = $rowshouru['classid'];
                $zhichu["$cid"] = $rowshouru['classid'];
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>$rowshouru[classname]</font></td>";
                echo "</tr>";
            }

            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>月收入</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>月付出</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>剩余</font></td></tr>
            ";
            ?>
        </table>
    </div>



    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>一月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                if ($_GET['nian'] == "") {
                    $ntjxz = date("Y");
                } else {
                    $ntjxz = $_GET['nian'];
                }} else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-1-31";
            $k = "$ntjxz-1-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys1 = $ys1+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf1 = $yf1+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }
            if ($ys1 == "") {
                $ys1 = "0";
            }
            if ($yf1 == "") {
                $yf1 = "0";
            }
            $yz = $ys1-$yf1;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys1."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf1."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>







    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>二月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-2-28";
            $k = "$ntjxz-2-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys2 = $ys2+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf2 = $yf2+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys2 == "") {
                $ys2 = "0";
            }
            if ($yf2 == "") {
                $yf2 = "0";
            }
            $yz = $ys2-$yf2;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys2."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf2."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>



    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>三月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-3-31";
            $k = "$ntjxz-3-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys3 = $ys3+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf3 = $yf3+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys3 == "") {
                $ys3 = "0";
            }
            if ($yf3 == "") {
                $yf3 = "0";
            }
            $yz = $ys3-$yf3;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys3."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf3."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>


    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>四月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-4-30";
            $k = "$ntjxz-4-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys4 = $ys4+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf4 = $yf4+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys4 == "") {
                $ys4 = "0";
            }
            if ($yf4 == "") {
                $yf4 = "0";
            }
            $yz = $ys4-$yf4;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys4."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf4."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>

    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>五月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-5-31";
            $k = "$ntjxz-5-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys5 = $ys5+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf5 = $yf5+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys5 == "") {
                $ys5 = "0";
            }
            if ($yf5 == "") {
                $yf5 = "0";
            }
            $yz = $ys5-$yf5;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys5."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf5."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>


    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>六月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-6-30";
            $k = "$ntjxz-6-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys6 = $ys6+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf6 = $yf6+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys6 == "") {
                $ys6 = "0";
            }
            if ($yf6 == "") {
                $yf6 = "0";
            }
            $yz = $ys6-$yf6;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys6."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf6."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>



    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>七月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-7-31";
            $k = "$ntjxz-7-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys7 = $ys7+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf7 = $yf7+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys7 == "") {
                $ys7 = "0";
            }
            if ($yf7 == "") {
                $yf7 = "0";
            }
            $yz = $ys7-$yf7;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys7."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf7."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>



    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>八月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-8-31";
            $k = "$ntjxz-8-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys8 = $ys8+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf8 = $yf8+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys8 == "") {
                $ys8 = "0";
            }
            if ($yf8 == "") {
                $yf8 = "0";
            }
            $yz = $ys8-$yf8;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys8."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf8."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>


    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>九月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-9-30";
            $k = "$ntjxz-9-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys9 = $ys9+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf9 = $yf9+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys9 == "") {
                $ys9 = "0";
            }
            if ($yf9 == "") {
                $yf9 = "0";
            }
            $yz = $ys9-$yf9;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys9."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf9."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>





    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>十月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-10-31";
            $k = "$ntjxz-10-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys10 = $ys10+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf10 = $yf10+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys10 == "") {
                $ys10 = "0";
            }
            if ($yf10 == "") {
                $yf10 = "0";
            }
            $yz = $ys10-$yf10;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys10."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf10."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>




    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>十一月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-11-30";
            $k = "$ntjxz-11-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys11 = $ys11+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf11 = $yf11+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys11 == "") {
                $ys11 = "0";
            }
            if ($yf11 == "") {
                $yf11 = "0";
            }
            $yz = $ys11-$yf11;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys11."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf11."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>



    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>十二月</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-12-31";
            $k = "$ntjxz-12-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ys12 = $ys12+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $yf12 = $yf12+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ys12 == "") {
                $ys12 = "0";
            }
            if ($yf12 == "") {
                $yf12 = "0";
            }
            $yz = $ys12-$yf12;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ys12."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$yf12."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>



    <div style="width:auto;float:left;margin-left: -1px;">
        <table id="excel" width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr><th bgcolor='#EBEBEB'>小计</th></tr>
            <?php
            if ($_GET['nian'] == "") {
                $ntjxz = date("Y");
            } else {
                $ntjxz = $_GET['nian'];
            }
            $j = "$ntjxz-12-31";
            $k = "$ntjxz-1-1";
            $sqltime = " ".$qianzui."account.actime >".strtotime($k." 0:0:0")." and ".$qianzui."account.actime <".strtotime($j." 23:59:59");
            //收入分类

            //收入分类
            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =1 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $query = mysqli_query($conn,$sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                echo "<tr>";
                if (isset($s1[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$s1[$k]."</font></td>";
                    $ns = $ns+$s1[$k];
                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>0</font></td>";
                }
                echo "</tr>";
            }
            //支出分类

            $sql = "select sum(acmoney) as total,acclassid,".$qianzui."account_class.classname from ".$qianzui."account left join ".$qianzui."account_class on ".$qianzui."account.acclassid =".$qianzui."account_class.classid where ".$qianzui."account_class.classtype =2 and ".$sqltime." and jiid='$_SESSION[uid]' group by ".$qianzui."account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn,$sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                echo "<tr>";
                if (isset($s2[$k])) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>".$s2[$k]."</font></td>";
                    $nf = $nf+$s2[$k];

                } else {

                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>0</font></td>";
                }
                echo "</tr>";
            }

            if ($ns == "") {
                $ns = "0";
            }
            if ($nf == "") {
                $nf = "0";
            }
            $yz = $ns-$nf;
            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$ns."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>".$nf."</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>".$yz."</font></td></tr>
            ";
            ?>
        </table>
    </div>


</div>
<script language="javascript" type="text/javascript">
    function save() {
        selectIndex = document.getElementById("nian").selectedIndex;
        document.cookie = 'selectIndex =' + selectIndex;
    }
    window.onload = function () {
        var cooki = document.cookie;
        if (cooki != "") {
            cooki = "{\"" + cooki + "\"}";
            cooki = cooki.replace(/\s*/g, "").replace(/=/g, '":"').replace(/;/g, '","');
            var json = eval("(" + cooki + ")"); //将coolies转成json对象
            document.getElementById("nian").options[json.selectIndex].selected = true;
        } else
            save();
    }
</script>
<?php
include_once("footer.php");
?>