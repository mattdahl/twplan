<?php
  session_start();
  if (!isset($_SESSION["username"]))
      header("Location: http://www.twplan.com");
  if (isset($_SESSION["isTest"]) && $_SESSION["isTest"] == true)
    session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="scripts/onload.js"></script>
    <script>
     function loadSettings() {
        $.ajax({
           url:('scripts/defaultworld.php'),
           timeout: 10000,
           success: function(data) {
             debugger;
             $("#defaultworld").html(data);
           },
           error: function(jqXHR, t, e) {
             debugger;
           }
        });
       
       $.ajax({
           url:('scripts/localtimezone.php'),
           timeout: 10000,
           success: function(data) {
             debugger;
             $("#localtimezone").html(data);
           },
           error: function(jqXHR, t, e) {
             debugger;
           }
        });
     }
    </script> 
  
  
    <title>Settings</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    
</head>
<body>
  <?php include "header.php" ?>
    
  <div id="container">
      <h1>Settings</h1>
    <b>Current Settings</b> <br /> <br />
    
    <table>
      <tr>
        <td><b>Default World</b></td>
        <td><span id="defaultworld">None</span></td>
      </tr>
      <tr>
        <td><b>Local Timezone</b></td>
        <td><span id="localtimezone">None</span></td>
      </tr>
    </table>
    
    <br />
    
    <b>Make Changes</b> <br /><br />
    Set Default World:
    <form action="scripts/setdefaultworld.php" method="GET" style="display:inline">
      <select name="world">
      <option>W19</option>
      <option>W30</option>
      <option>W38</option>
      <option>W42</option>
      <option>W46</option>
      <option>W48</option>
      <option>W56</option>
      <option>W57</option>
      <option>W58</option>
      <option>W59</option>
      <option>W60</option>
      <option>W61</option>
      <option>W62</option>
      <option>W63</option>
      <option>W64</option>
      <option>W65</option>
      <option>W66</option>
      <option>W67</option>
      </select>
      <input type="submit" />
    </form> <br />
    Set Local Timezone:
    <form action="scripts/setlocaltimezone.php" method="GET" style="display:inline">
      <select name="timezone">
        <option>GMT+1 (CET)</option>
        <option>GMT+2 (EET)</option>
        <option>GMT+3 (BT)</option>
        <option>GMT+4 (ZP4)</option>
        <option>GMT+5 (ZP5)</option>
        <option>GMT+5:30 (IST)</option>
        <option>GMT+6 (ZP6)</option>
        <option>GMT+7 (CXT)</option>
        <option>GMT+8 (AWST)</option>
        <option>GMT+9 (JSP)</option>
        <option>GMT+10 (EAST)</option>
        <option>GMT+11</option>
        <option>GMT+12 (NZST)</option>
        <option>GMT-1 (WAT)</option>
        <option>GMT-2 (AT)</option>
        <option>GMT-3</option>
        <option>GMT-4 (AST)</option>
        <option>GMT-5 (EST)</option>
        <option>GMT-6 (CST)</option>
        <option>GMT-7 (MST)</option>
        <option>GMT-8 (PST)</option>
        <option>GMT-9 (AKST)</option>
        <option>GMT-10 (HST)</option>
        <option>GMT-11 (NT)</option>
      </select>
      <input type="submit" />
    </form>
  </div>
    <?php include "footer.php" ?>
</body>
</html>