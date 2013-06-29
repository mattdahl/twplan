<?php
  
    session_start();

    $name = $_POST["planname"];
    $username = $_SESSION["username"];
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("users", $con);
    
    
    $find = "SELECT `savedData` FROM `users`.`userinfo` WHERE `username` = '$username'";
    $found = mysql_query($find, $con);
    $foundarray = mysql_fetch_array($found);
    $savedData = json_decode($foundarray["savedData"], true);
    
    $planID = "";
    $landingDate = "";
    $landingTime = "";
    for ($i = 0; $i < count($savedData[2]); $i++) {
        if ($savedData[2][$i] == $name) {
            $planID = $savedData[3][$i];
            $landingDate = $savedData[0][$i];
            $landingTime = $savedData[1][$i];
            break;
        }
    }

    $find = "SELECT * FROM `users`.`$planID`";
    $found = mysql_query($find, $con);
 
  $s = "<h2>Attack Plan Landing on " . $landingDate . " at " . $landingTime . "</h2><br /><table><tr><th>Village</th><th>Target</th><th>Slowest Unit</th><th>Attack Type</th><th>Traveling Time</th><th>Launch Time</th><th>Time Remaining</th><th>Delete</th></tr><tbody>";    
    $now = time();

    while ($foundarray = mysql_fetch_array($found)) {
      $launch = $foundarray["ltms"];
      $diff = $launch - $now;
      $s .= "<tr>
                <td>" . $foundarray["village"] . "</td>
                <td>" . $foundarray["target"] . "</td>
                <td>" . $foundarray["slowUnit"] . "</td>
                <td>" . $foundarray["attackType"] . "</td>
                <td>" . $foundarray["travelTime"] . "</td>
                <td>" . $foundarray["launchTime"] . "</td>
                <td abbr=\"" . $diff . "\" class=\"countdown\"></td>
                <td><a href=\"#\"><img onClick=\"deleteCommand('" . $name . "', '" . $foundarray["village"] . "', '" . $foundarray["target"] . "')\" src=\"images/delete.png\" /></a></td>
        ";
    }
    
  $s .= "</tbody></table><br /><h2>Delete This Plan</h2>Delete <a href=\"#\"><img onClick=\"deletePlan();\" src=\"images/delete.png\" /></a>";
    
    echo $s;
?>