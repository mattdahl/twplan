<?php
  if (isset($_GET["id"]) && strlen($_GET["id"]) == 26)
    session_id($_GET["id"]);
  session_start();
  ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TWplan</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="scripts/slider.js"></script>
<script src="scripts/onload.js"></script>
<link rel="icon" href="images/favicon.ico" type="image/x-icon" />

<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />

  
<script type="text/javascript"> /* Google Analytics */

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34224555-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
<?php include "header.php" ?>

<div id="container">
  <noscript>It looks like you have Javascript turned off! TWplan requires Javascript functionality to work. Please turn it on :)</noscript>
   <h3>It's Finally Here.</h3>
  <h2 style="text-align:center;">The Tribalwars mass attack planner you've been waiting for.</h2>
  <br />
  <hr class="slideshowhr" />
  <div id="slideshow">
        <div id="slideshowWindow">
            <div class="slide"><img src="http://static-twplan.appspot.com/images/slideshow2/slide1.png" /></div>
            <div class="slide"><img src="http://static-twplan.appspot.com/images/slideshow2/slide2.png" /></div>
            <div class="slide"><img src="http://static-twplan.appspot.com/images/slideshow2/slide3.png" /></div>
            <div class="slide"><img src="http://static-twplan.appspot.com/images/slideshow2/slide4.png" /></div>
            <div class="slide"><img src="http://static-twplan.appspot.com/images/slideshow2/slide5.png" /></div>
            <div class="slide"><img src="http://static-twplan.appspot.com/images/slideshow2/slide6.png" /></div>
        </div>
  </div>
  <hr class="slideshowhr" />
  <div id="latestnewscontainer">
    <h1>Latest News</h1>
      <div class="latestnews" style="margin-right:2%">
      	<img src="images/icon1.png" />
        <p><b>5/6/13</b> &nbsp; Today saw a massive graphical overhaul for the entire TWplan website. This upgrade was designed to faciliate increased user experience, and reflects a more sophisticated interface. <a href="news.php">Read more... </a> </p> 
      </div>
      <div class="latestnews">
      	<img src="images/icon1.png" />
        <p><b>4/27/13</b> &nbsp; Unveiled today is a new launching Javascript script for easy deployment of TWplan-generated commands, right from the rally point without any extra clicks. <a href="news.php">Read more... </a> </p> 
      </div>
  </div>

  <?php
  
  if (isset($_SESSION["username"])) {
  if ($_SESSION["username"] == "syntexgrid") {
    echo "Admin Tools:";
  $str = "<input type=\"text\" id=\"alias\" /> <br /> <input type=\"submit\" value=\"Pseudo Login\" onClick=\"window.location = 'protected/override.php?fake=' + $('#alias').val() + '&world=62'\" />";
    echo $str;
  echo "<form action=\"protected/loadvillages.php\" method=\"get\">
            <input name=\"world\" type=\"text\" />
            <input value=\"Load Villages\" type=\"submit\" />
            </form>

      <form action=\"protected/loadplayers.php\" method=\"get\">
              <input name=\"world\" type=\"text\" />
              <input value=\"Load Players\" type=\"submit\" />
            </form>";
  }
  }
   
  
  ?>
    
</div>


</body>

<?php include "footer.php" ?>

</html>