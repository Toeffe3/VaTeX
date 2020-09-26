<?php  ?>
<div id="title">
  <h1>Welcome to VaTeX</h1>
</div>

<div id="actions">
  <div class="action">
    <div class="subgrid">
      <h2>Join room</h2>
      <form action="index.html" method="post">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="text" name="code" placeholder="Code" required>
      </form>
    </div>
    <div class="subgrid" id="recents">
      <div class="recent">
        <span>Recents</span>
      </div>
      <div class="recent">
        <span>ABCD1234</span>
      </div>
      <div class="recent">
        <span>ABCD1234</span>
      </div>
    </div>
  </div>
  <div class="action">
    <h2>Create room</h2>
    <div id="create">
      <form action="index.html" method="post">
        <input type="email" name="email" placeholder="Email" required><br>
      </form>
      <div id="createinfo">
        You will rechive a code for a room on this email address, which you can share and use to join.
      </div>
    </div>
  </div>
</div>
