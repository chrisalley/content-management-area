<?php

session_start();
header("Cache-control: private"); // IE 6 Fix

require_once("data_module.php");
require_once("form.php");
require_once("page.php");
require_once("user.php");

$user = new user();
$user -> view_page();

?>