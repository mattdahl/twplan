<?php
  
  session_start();
  
  if (!isset($_SESSION["username"])) {
    return true;
  }
  
  $username = urlencode(rawurldecode($_SESSION["username"]));
  $world = $_SESSION["world"];
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
  
  mysql_select_db("players", $con);
  $query = "SELECT `playerid` FROM `players`.`en" . $world . "` WHERE `username` = '$username'";
  $result = mysql_query($query, $con);
  
  if (!$result) {
    echo "Are you sure you have an account on W" . $world . "? The database cannot find your username.";
    return true;
  }
  
  $resultarray = mysql_fetch_array($result);
  
  if (!$resultarray) {
    echo "Are you sure you have an account on W" . $world . "? The database cannot find your username.";
    return true;
  }
  
  $pid = $resultarray["playerid"];
  
  mysql_select_db("villages", $con);
  $query = "SELECT name, xcoord, ycoord, villageid FROM `villages`.`en" . $world . "` WHERE `playerid` = '$pid' ORDER BY `name` ASC";
  $result = mysql_query($query, $con);
  
  echo "<p>Create a new group.</p>  
  
  <h2>Group Name</h2> <input type=\"text\" id=\"groupname\" /><br />
    
  <h2>Mass Village Select</h2>
      <p>Enter coordinates in bulk, via a list or a simple copy and paste from a TW overview screen; coordinates will be parsed out.</p>
      <textarea id=\"villagecoordsbulk\" style=\"float:left\"></textarea>
      
      <button onClick=\"addVillagesToGroupBulk()\" style=\"margin-left:2%;\">Add Villages to Group</button>
      <h2 style=\"clear:left\"><br />Single Village Select</h2>";
  
  echo "<table id=\"villages\"><tr><th style=\"display:none\"><!--Checkbox--></th><th>Village Name</th><th>Coordinates</th><th>Continent</th><th>Add Village to Group</th></tr>";
  
  $sql_array = array();
  
  while ($row = mysql_fetch_array($result))
    array_push($sql_array, $row);
  
  foreach ($sql_array as $row) {
    $vid = $row["villageid"];
    $continent = "K" . substr($row["ycoord"], 0, 1) . substr($row["xcoord"], 0, 1);
    echo "
      <tr id=\"" . $vid . "r\" style=\"height:10px;\"><td style=\"display:none\"><input type=\"checkbox\" id=\"" . $vid . "\" name=\"selectedVillages[]\" /></td>
        <td class=\"villagename\" id=\"" . $vid . "n\">" . urldecode($row["name"]) . "</td>
        <td class=\"coordsearch\" id=\"" . $vid . "c\">" . $row["xcoord"] . "|" . $row["ycoord"] . "</td>
        <td id=\"" . $vid . "k\">" . $continent . "</td>
        <td><button id=\"" . $vid . "b\" onClick=\"addVillageToGroup(this.id); return false;\">Add Village</button></td>
      </tr>";
  }
  
  echo "</table>
      <br />
  <h2>Villages in Group</h2>
  <form id=\"sendgroupinfo\" action=\"\" method=\"post\"><table id=\"villagesingroup\"><tr><th style=\"display:none\"><!--Hidden Checkbox--></th><th>Village Name</th><th>Coordinates</th><th>Continent</th><th>Remove Village from Group</th></tr></table>
  <br />
  <input id=\"submitvillageinfo\" type=\"submit\" onClick=\"doesGroupExist(); return false;\" value=\"Save Group\" /></form>";
?>