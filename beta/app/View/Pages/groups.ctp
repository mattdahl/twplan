<h1>Groups</h1>

<div id="instructions">
  <p>You can configure groups of preset lists of villages to automatically use in a plan (i.e. a group of your defense or offense villages). Select a group you want to modify, or choose to create a new group. Groups are world-specific.</p>
    <?php
          $username = $_SESSION["username"];

          $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
          mysql_select_db("users", $con);
          $find = "SELECT `savedGroupData` FROM `users`.`userinfo` WHERE `username` = '$username'";
          $found = mysql_query($find, $con);
          $foundarray = mysql_fetch_array($found);
          $savedGroupData = json_decode($foundarray["savedGroupData"], true);

          if ($savedGroupData[0] == null) {
              echo "<select id=\"choosegroup\"><option>No groups yet</option></select>";
          }
          else {
              $groupnames = $savedGroupData[0];
			$worlds = $savedGroupData[2];
            	$s = "<select id=\"choosegroup\" onChange=\"displayGroup(this.value)\"> <option>Choose a group...</option>";
			$found = false;
              for ($i = 0; $i < count($groupnames); $i++) {
				if ($worlds[$i] == $_SESSION["world"]) {
                  	$s .= "<option>" . $groupnames[$i] . "</option>";
					$found = true;
				}
			}
              $s .= "</select>";
			if ($found)
              	echo $s;
			else
				echo "<select id=\"choosegroup\"><option>No groups yet</option></select>";
          }

      ?>
      <button onClick="createGroup();">Create Group</button>
</div>
<span id="loading" style="display:none"><img src="images/loading.gif" /></span>
<div id="groupdisplay"></div>
<div id="creategroupdisplay"></div>