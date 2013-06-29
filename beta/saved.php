<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="scripts/onload.js"></script>
<script type="text/javascript" src="scripts/script.js"></script>
<title>Saved Plans</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
</head>
<body>
<?php include "header.php" ?>

<div id="container">
    <h1>Your Saved Plans</h1>
    <p>Select a saved plan you want to access.</p>
        <?php
            $username = $_SESSION["username"];
  
            $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
            mysql_select_db("users", $con);
            $find = "SELECT `savedData` FROM `users`.`userinfo` WHERE `username` = '$username'";
            $found = mysql_query($find, $con);
            $foundarray = mysql_fetch_array($found);
            $savedData = json_decode($foundarray["savedData"], true);
            
            if ($savedData[0] == null) {
                echo "It seems you have no plans saved in TWplan's database on W" . $_SESSION["world"] . "! Create a plan and then elect to save it before trying to view it here.";
            }
            else {
                $plannames = $savedData[2];
              $s = "<select id=\"chooseplan\" onChange=\"displayPlan(this.value)\"> <option>Choose a plan...</option>";
                for ($i = 0; $i < count($plannames); $i++)
                    $s .= "<option>" . $plannames[$i] . "</option>";
                $s .= "</select>";
                echo $s;
            }

            ?>
  
  <div id="savedplandisplay"></div>
</div>

<?php include "footer.php" ?>
</body>
</html>