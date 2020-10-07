<?php  ?>
<script type="text/javascript">
  function remuser(btn) {
    elem = document.getElementById('rem-user');
    username = elem.value;
    username = username.replace(/[^A-zÆØÅæøåµ\-_+#]/g,'');
    username = username.replace(/ +/g,' ');
    elem.value = username;
    if(username && username.length >= 3 && username.length <= 16) {
      elem.style.borderColor = "black";
      btn.style.borderColor = "black";
    } else {
      elem.style.borderColor = "red";
      btn.style.borderColor = "red";
    }
  }
</script>

<div id="title">
  <h1>Welcome to <img src="assets/VaTeX-pink.png" alt="VaTeX" height="60"></h1>
</div>

<div id="actions">
  <div class="action">
    <div class="subgrid">
      <h2>Join room</h2>
      <form action="?join&ref=main" method="post">
        <input type="text" name="name" placeholder="Name" min="3" maxlength="16" required id="rem-user" value="<?php echo $_COOKIE[""] ?>">
        <input type="button" value="Remember" onclick="remuser(this)"><br>
        <input type="text" name="code" placeholder="Code" required>
        <input type="submit" value="Join room">
      </form>
      <div class="infobox">
        You can use any name, just make sure your collaborators knows how you are! Use 'Remember' to always use current name.
      </div>
    </div>
    <div class="subgrid" id="recents">
      <div class="recent">
        <span>Recents</span>
      </div>
      <?php
        $stmt = $db->prepare('SELECT * FROM vatex.recents');
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $recents = $stmt->fetchAll();
        for ($i=0; $i < 3; $i++)
          if(isset($recents[$i]))
            echo '<div class="recent" onclick="window.location.href=\'?join='.$recents[$i]['code'].'\'"><span>'.$recents[$i]['code'].'</span></div></a>';
      ?>
    </div>
  </div>
  <div class="action">
    <h2>Create room</h2>
    <div id="create">
      <form action="roomdata/manage.php?create" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="submit" value="Get room">
      </form>
      <div class="infobox">
        You will rechive a code for a room on this email address, <br>which you can share and use to join.
      </div>
    </div>
  </div>
</div>
