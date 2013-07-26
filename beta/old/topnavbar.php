<nav>
<ul id="topnavbar">
    <li><a class="navlink" href="index.php">Home</a></li>
    <li><a class="navlink" href="news.php">News</a></li>
    <li><a class="navlink" style="color: #C92323;" href="plan.php">Plan</a></li>
    <?php
    if (isset($_SESSION["username"]))
      echo "<li><a class=\"navlink\" href=\"saved.php\">Saved</a></li>
           <li><a class=\"navlink\" href=\"groups.php\">Groups</a></li>
          <li><a class=\"navlink\" href=\"settings.php\">Settings</a></li>
          <li style=\"width: 110px\"><a class=\"navlink\" href=\"bugreport.php\" style=\"width: 110px\">Bug Report</a></li>
          <li><a class=\"navlink\" href=\"about.php\">About</a></li>
		  <li><a class=\"navlink\" href=\"http://forum.tribalwars.net/showthread.php?260468-TWplan-The-mass-attack-planner-you-ve-been-waiting-for\">Help</a></li>
          <li><a class=\"navlink\" href=\"logout.php\">Logout</a></li>";
    else
      echo
        "<li style=\"width: 110px\"><a class=\"navlink\" style=\"width: 110px\" href=\"bugreport.php\">Bug Report</a></li>
        <li><a class=\"navlink\" href=\"about.php\">About</a></li>
		<li><a class=\"navlink\" href=\"http://forum.tribalwars.net/showthread.php?260468-TWplan-The-mass-attack-planner-you-ve-been-waiting-for\">Help</a></li>
        <li><a class=\"navlink\" href=\"login.php\">Login</a></li>";
  ?>
</ul>
</nav>