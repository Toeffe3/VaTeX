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
      $stmt = $db->prepare('SELECT * FROM vatex.rooms WHERE `created` = "'.$date.'" ORDER BY `created` LIMIT 1');
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $code = $stmt->fetch()['code'];

      if(mkdir($code)) {

        $template = "\\title{Room: ".$code."}\n\\author{".$_POST['email']."}\n\n\\documentclass[12pt,a4paper]{article}\n\n\\begin{document}\n\n\\maketitle\n\\newpage\n\n\\section{Header}\n\\subsection{Paragraph}\n\\text{Welcome}\n\\end{document}\n";
        file_put_contents($code."/main.tex", $template);

        $msg = file_get_contents("../assets/mailtemplate/code.html");
        $msg = str_replace("@@email", $_POST["email"], $msg);
        $msg = str_replace("@@code", $code, $msg);

        mail($_POST["email"], "VaTeX Room code", $msg, "From:vatex@victorvejlgaard.com \r\nMIME-Version: 1.0\r\nContent-type: text/html\r\n");

        header('Location: http://vatex.victorvejlgaard.com/?join=');

      } else echo 'Server could not create a room - no mail sent!';
    }   else echo 'Error generating code - no mail sent!';
  }     else echo 'Error - no mail sent!';
