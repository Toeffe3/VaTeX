<?php
  session_start();

  if(!empty($_SESSION["room"])) {

    $PATH = "../../roomdata/".$_SESSION["room"];
    $log = exec("pdflatex -no-file-line-error -interaction=nonstopmode -output-directory=".$PATH." ".$PATH."/main.tex");
    echo $log."\n".file_get_contents($PATH."/main.log");

  } else echo "Cannot compile";
