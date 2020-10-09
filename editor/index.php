<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  set_include_path('..');
  session_start();
  include_once "dbcon.php";

  if(!empty($_SESSION["room"]) && !empty($_SESSION["ref"])) {

    include_once "editor/editor.php";

  } else {

    header("Location: http://vatex.victorvejlgaard.com");

  }
