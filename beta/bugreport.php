<?php session_start(); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="scripts/onload.js"></script>
<title>Bug Report</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="icon" href="images/favicon.ico" type="image/x-icon" />

<script type="application/javascript">
	function validateBugReport() {
		if ($("#page").val().length == 0) {
			alert("Please fill out the \"Which page were you using?\" box");
			return false;
		}
		else if ($("#bugnature").val().length <= 5) {
			alert("Please fill out the \"Can you explain the bug?\" box");
			return false;
		}
		else {
			debugger;
			$("#bugreportform").submit();
			return true;
		}
	}
</script>

</head>

<body>
  <?php include "header.php" ?>
  <div id="container">
    <h1>Bug Report</h1>
    <p>Thanks for taking the time to submit a bug report while TWplan is still in beta. You can reach Syntex (Matt) directly via PM on the <a href="http://forum.tribalwars.net/member.php?90426-syntexgrid">TW Forum</a> or via Skype at <i>syntexgrid</i>.</p>
    <form id="bugreportform" action="storebugreport.php" method="post">
      <table>
        <tr><td><b>Which page were you using? (If planner, specify which step)</b></td><td><input type="text" id="page" name="page" /></td></tr>
        <tr><td><b>If an error message appeared, paste it here.</b></td><td><textarea id="errormsg" name="errormsg"></textarea></td></tr>
        <tr><td><b>Can you explain the bug?</b></td><td><textarea id="bugnature" name="bugnature"></textarea></td></tr>
        <tr><td><b>What browser & version are you using?</b></td><td><input type="text" id="browser" name="browser" /></td></tr>
        <tr><td><b>Were you able to replicate the problem?</b></td><td><input type="text" id="replicate" name="replicate" /></td></tr>
        <tr><td><b>Your Skype address (if you are okay with being contacted).</b></td><td><input type="text" id="skype" name="skype" /></tr>
      </table>
        <input type="hidden" name="user" value="<?php echo (isset($_SESSION["username"]) ? $_SESSION["username"] : "Anonymous"); ?>" />
        <input type="hidden" name="world" value="<?php echo (isset($_SESSION["world"]) ? $_SESSION["world"] : "Anonymous"); ?>" /><br />
    </form>
         <button onClick="validateBugReport()">Submit</button>

    <p>Thanks for your help! Sorry for any inconvenience posed.</p>
    
    </div>
  <?php include "footer.php" ?>
</body>

</html>