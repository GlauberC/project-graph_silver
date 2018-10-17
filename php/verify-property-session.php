<?php
$input = $_GET["txt"];

session_start();
$_SESSION['properties'] = $input;
?>