<?php ?>
<script type="text/javascript">
  function remuser(btn) {
    elem = document.getElementById('rem-user');
    elem.style.borderColor = "black";
    btn.style.borderColor = "black";
    username = elem.value;
    username = username.replace(/^[^A-z]+/,'');
    username = username.replace(/[^A-z0-9ÆØÅæøåµ\-\_\#\ ]/g,'');
    username = username.replace(/(\ )+|(\#)+|(\-)+|(\_)+/g,'$1$2$3$4');
    elem.value = username;
    if(username && username.length >= 3 && username.length <= 16) {
      var d = new Date();
      d.setTime(d.getTime() + (365*86400000));
      d = d.toUTCString()
      document.cookie = "username="+username+";expires="+d+";path=/";
      elem.style.borderColor = "green";
      btn.style.borderColor = "green";
    } else {
      elem.style.borderColor = "red";
      btn.style.borderColor = "red";
    }
  }

  function submitfnc(form) {
    var d = new Date();
    d.setTime(d.getTime() + (365*86400000));
    d = d.toUTCString()
    code = document.getElementsByName('join')[0].value;
    recentse = JSON.parse('<?php echo !empty($_COOKIE['recents'])?rawurldecode($_COOKIE['recents']):'{}'; ?>');

    recentsj = [];
    cook = {};
    for (var k of Object.keys(recentse)) recentsj.push(recentse[k]);
    recentsj.push(code);
    recents = recentsj.filter(function(elem, index, self) { return index === self.indexOf(elem); });
    recents.forEach((item, i) => { cook[i] = item; });

    document.cookie = "recents="+encodeURIComponent(JSON.stringify(recents))+";expires="+d+";path=/";
    form.submit();
  }
</script>

<div id="title">
  <h1>Welcome to <img src="assets/VaTeX-pink.png" alt="VaTeX" height="60"></h1>
</div>

<div id="actions">
  <div class="action">
    <div class="subgrid">
      <h2>Join room</h2>
      <form action="?ref=main" method="post">
        <input type="text" name="name" placeholder="Name" value="<?php echo $_COOKIE["username"]?>" id="rem-user" autocomplete="off" />
        <input type="button" value="Remember" onclick="remuser(this)" /><br>
        <input type="text" name="join" placeholder="Code" onkeydown="event.key=='Enter'?this.parentElement.submit():0;" />
        <input type="button" value="Join room" onclick="submitfnc(this.parentElement)"/>
      </form>
      <div class="infobox">
        You can use any name, just make sure your collaborators knows how you are! Use 'Remember' to always use current name.
      </div>

    </div>
    <div class="subgrid" id="recents">
      <div class="recent">
        <span>Recents <i>(If you have a 'Remember'ed username)</i> </span>
      </div>
      <?php
        if(!empty($_COOKIE['recents']) && !empty($_COOKIE['username'])) {
          $recents = json_decode(rawurldecode($_COOKIE['recents']), true);

          for ($i=0; $i < 3; $i++) {
            if(isset($recents[$i])) {
              $stmt = $db->prepare('SELECT * FROM vatex.rooms WHERE code = "'.$recents[$i].'"');
              $stmt->execute();

              if($stmt->rowCount() > 0)
                echo '<div class="recent" onclick="window.location.href=\'?join='.$recents[$i].'\'"><span>'.$recents[$i].'</span></div></a>';
            }
          }
        }
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
