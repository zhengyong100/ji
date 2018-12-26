<?php
session_start();
if (isset($_SESSION['user_shell'])) {
    echo "<script language='javascript' type='text/javascript'>window.location.href='add.php'</script>";
} else
{
    echo "<script language='javascript' type='text/javascript'>window.location.href='login.php'</script>";
}
?>