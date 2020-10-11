<?php
  // error_reporting(E_ALL);
  // ini_set('display_errors', '1');

  session_start();
  include_once "dbcon.php";

  if(!isset($_GET["invalid_code"]) && !empty($_REQUEST["join"])) {

    $stmt = $db->prepare('SELECT * FROM vatex.rooms WHERE code = "'.$_REQUEST["join"].'"');
    $stmt->execute();

    if($stmt->rowCount() == 0) {

      $ck = json_decode(rawurldecode($_COOKIE["recents"]), true);
      $key = array_search($_REQUEST["join"], $ck);
      $e = print_r($ck, true);
      unset($ck[$key]);
      setcookie("recents", json_encode($ck));
      header('Location: http://vatex.victorvejlgaard.com/?invalid_code='.$_REQUEST["join"]);

    } else {

      $_SESSION["room"] = $_REQUEST["join"];
      $_SESSION["ref"] = empty($_GET["ref"])?"url":$_GET["ref"];
      header('Location: http://vatex.victorvejlgaard.com/editor');

    }

  }

  include_once "header.php";
  include_once "access.php";
  include_once "footer.php";

  $conn = null;
  if(isset($ck)) unset($ck);
