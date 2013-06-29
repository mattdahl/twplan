<header>
  <a href="index.php"><img id="logo" width="500" height="150" src="http://static-twplan.appspot.com/images/logo5.png" /></a>
  <?php
    if (isset($_SESSION["isTest"]) && $_SESSION["isTest"] == true)
        session_destroy();
		
	include("scripts/lastupdated.php");
    
    if (isset($_SESSION["username"])) {
      echo  "<div id=\"welcome\">Welcome <span id=\"username\">" . rawurldecode($_SESSION["username"]) . "</span> | World:
           <select id=\"worldselect\" onChange=\"changeWorld()\">
      <option>W19</option>
      <option>W30</option>
      <option>W38</option>
      <option>W42</option>
      <option>W46</option>
      <option>W48</option>
      <option>W56</option>
      <option>W58</option>
      <option>W59</option>
      <option>W60</option>
      <option>W61</option>
      <option>W63</option>
      <option>W64</option>
      <option>W65</option>
      <option>W66</option>
      <option>W67</option>
      <option>W68</option>
      <option>W69</option>

      </select>
                                                             
      <br /><span id=\"lastupdatetext\">Last updated " . getLastUpdated() . "h ago.</span></div>";
	}
  ?>
  <nav>
    <ul id="topnavbar">
        <li><a class="navlink" href="index.php">Home</a></li>
        <li><a class="navlink" href="news.php">News</a></li>
        <li id="plannavbaritem"><a class="navlink" href="plan.php">Plan</a></li>
        <li style="width: 110px"><a class="navlink" style="width: 110px" href="bugreport.php">Bug Report</a></li>
        <?php
        if (isset($_SESSION["username"]))
          echo "<li style=\"width: 80px\"><a class=\"navlink\" href=\"settings.php\">Settings</a></li>
		  		<li><a class=\"navlink\" href=\"http://forum.tribalwars.net/showthread.php?260468-TWplan-The-mass-attack-planner-you-ve-been-waiting-for\">Help</a></li>
		  		<li style=\"width: 80px\"><a class=\"navlink\" style=\"width: 80px\" href=\"logout.php\">Logout</a></li>";
        else
          echo
            "<li><a class=\"navlink\" href=\"http://forum.tribalwars.net/showthread.php?260468-TWplan-The-mass-attack-planner-you-ve-been-waiting-for\">Help</a></li>
			<li><a class=\"navlink\" href=\"login.php\">Login</a></li>";
      ?>
    </ul>
    <div id="dropdownmenu" style="visibility:hidden">
    	<ul>
        	<li><a class="navlink" href="groups.php">Groups</a></li>
        	<li><a class="navlink" href="saved.php">Saved</a></li>
        	<li><a class="navlink" href="generateScript.php">Script</a></li>
        </ul>
    </div>
    </nav>
    <!--<div id="headerbottomborder"></div>
    <li><a class=\"navlink\" href=\"saved.php\">Saved</a></li>
               <li><a class=\"navlink\" href=\"groups.php\">Groups</a></li>
              <li><a class=\"navlink\" href=\"settings.php\">Settings</a></li>
    -->
</header>