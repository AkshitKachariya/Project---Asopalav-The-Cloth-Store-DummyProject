<?php

error_reporting(0);
session_start();
    
if (!$_SESSION['admin_login']) {
    header("Location: admin_login.php");
}
