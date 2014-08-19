<header ng-controller="HeaderController">
  <?php
    echo $this->Html->link($this->Html->image("http://static-twplan.appspot.com/images/logo_2.png", array('id' => 'logo')), '/index', array('escape' => false));
  ?>

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
          <li><?php echo $this->Html->link('Groups', '/groups', array('class' => 'navlink')); ?></li>
          <li><?php echo $this->Html->link('Saved', '/plans', array('class' => 'navlink')); ?></li>
          <li><?php echo $this->Html->link('Scripts', '/user_scripts', array('class' => 'navlink')); ?></li>
        </ul>
    </div>
    </nav>
</header>