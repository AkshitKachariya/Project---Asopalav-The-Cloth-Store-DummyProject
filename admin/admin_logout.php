<?php
include('../db_con.php');

session_start();

if (session_destroy()) {
    header('location:admin_login.php');
    die;
}
