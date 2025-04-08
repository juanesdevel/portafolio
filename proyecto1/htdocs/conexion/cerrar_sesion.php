<?php
session_start();
Session_destroy();
header("location:../index.php");
?>
