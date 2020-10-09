<?php
  $code = $_SESSION["room"];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="icon" href="../assets/VaTeX-pink-ico.png">
    <link rel="stylesheet" href="../assets/editor.css">
    <link rel="stylesheet" href="../assets/Lib/KaTeX/katex.min.css">
    <script defer src="../assets/Lib/KaTeX/katex.min.js"></script>
  </head>
  <body>
    <div id="menu">
    </div>
    <div id="input">
      <textarea name="rawtex" cols="120%" rows="50vh" autofocus autocomplete><?php echo file_get_contents("../roomdata/".$code."/main.tex"); ?></textarea>
    </div>
    <div id="preview">
      <textarea name="outtex" disabled></textarea>
    </div>
    <div id="compiled">
      <embed src="../roomdata/<?php echo $code?>/main.pdf" width="800px" height="2100px" />
    </div>
    <script type="text/javascript">
      let lin = document.getElementsByName("rawtex")[0];
      let out = document.getElementsByName("outtex")[0];

      let datapackage = {
        chars: [],
        position: [],
        id: 0,
      }

      lin.onkeydown = function(evt) {
        if(!datapackage.position[0]) datapackage.position[0] = evt.target.selectionStart;
        datapackage.position[1] = evt.target.selectionStart;
        datapackage.position[2] = evt.target.textLength;
        datapackage.chars.push(evt.keyCode);
        datapackage.text = String.fromCharCode(...datapackage.chars);
        datapackage.id = Date.now();
        console.log(evt, evt.target);
        console.log(datapackage);
      }

      let rct = setInterval(function() {
        if(datapackage.id && Date.now() > datapackage.id + 2000) {
          let xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              out.innerHTML = xhttp.responseText;
              document.getElementById("compiled").children[0].src = document.getElementById("compiled").children[0].src;
              datapackage.id = 0;
              datapackage.chars = [];
              datapackage.position = [];
            }
          };
          xhttp.open("get", "compile/request-compile.php", true);
          xhttp.send();
        }
      }, 2000);

    </script>
  </body>
</html>
