<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  session_start();
  include_once "dbcon.php";

  if(isset($_GET["join"])) {

    $_SESSION["room"] = $_GET["join"];
    $_SESSION["ref"] = empty($_GET["ref"])?"url":$_GET["ref"];
    header("Location: http://vatex.victorvejlgaard.com/editor");

  } else {

    include_once "header.php";
    include_once "access.php";
    include_once "footer.php";

  }

  $conn = null;
