<?php
  global $db;
  try {
    $pass = file_get_contents('pass', true);
    $db = new PDO('mysql:localhost;dbname=vatex', 'vatex', $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pass = "";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>
