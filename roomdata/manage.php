<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  //date_default_timezone_set("Europe/Copenhagen");
  date_default_timezone_set("UTC");

  include_once '../dbcon.php';
  if(isset($_GET["create"]) && !empty($_POST["email"])) {
    $date = date('Y-m-d H:i:s', time());
    $stmt = $db->prepare('INSERT INTO vatex.rooms (`admin`, `created`) VALUES ("'.$_POST["email"].'", "'.$date.'")');
    if($stmt->execute()) {
      $stmt = $db->prepare('SELECT * FROM vatex.rooms WHERE `created` = "'.$date.'"');
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $code = $stmt->fetch()['code'];

      $msg = file_get_contents("../assets/mailtemplate/code.html");
      $msg = str_replace("@@email", $_POST["email"], $msg);
      $msg = str_replace("@@code", $code, $msg);

      mail($_POST["email"], "VaTeX Room code", $msg, "From:vatex@victorvejlgaard.com \r\nMIME-Version: 1.0\r\nContent-type: text/html\r\n");
    } else {
      echo 'Error generation code - no mail sent!';
    }

  } else {
    echo 'Error';
  }
