<header ng-app='HeaderModule'>
  <a href="index"><img id="logo" width="500" height="150" src="http://static-twplan.appspot.com/images/logo5.png" /></a>

  <?php
    if ($this->Session->read('Auth.User')) {
      echo $this->element('welcome');
    }
  ?>

  <nav>
    <ul id="topnavbar">
        <?php
          if ($this->Session->read('Auth.User')) {
            echo $this->element('user_header');
          }
          else {
            echo $this->element('guest_header');
          }
        ?>
    </ul>
    <div id="dropdownmenu" style="visibility:hidden">
      <ul>
          <li><a class="navlink" href="groups">Groups</a></li>
          <li><a class="navlink" href="plans">Saved</a></li>
          <li><a class="navlink" href="generateScript">Script</a></li>
        </ul>
    </div>
    </nav>
</header>