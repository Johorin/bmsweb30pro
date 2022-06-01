<?php
require_once '../function/dbprocess.php';

$selectSql = "SELECT * FROM userinfo WHERE user='{$user}' AND password='{$pass}'";
?>