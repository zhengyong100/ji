<?php
include_once("header.php");
?>
<?php
session_start();
unset($_SESSION['user_shell']);
//echo '<script>alert("恭喜您，注销成功！记得坚持养成良好的记账习惯哦！~"); window.location.href=document.referrer; </script>';
echo '<script>alert("恭喜您，注销成功！记得坚持养成良好的记账习惯哦！~"); window.location.href="index.php"; </script>';
?>
<?php
include_once("footer.php");
?>