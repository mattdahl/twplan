<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="scripts/onload.js"></script>
    <title>News</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
</head>
<body onLoad="loadLastUpdated();">
  <?php include "header.php" ?>
    
  <div id="container">
      <h1>News and Announcements</h1>
        <div id="news">
            <div class="newsbox">
      		  <img src="images/icon1.png" />
              <p><b>May 6, 2013</b><br />
                Today saw a massive graphical overhaul for the entire TWplan website. This upgrade was designed to faciliate increased user experience, and reflects a more sophisticated interface. This should be a significant step up from the rather bland layout that was left relatively unchanged since TWplan's conception last fall.<br />
                Special thanks to Phlipster for designing the new look in Photoshop and providing the inspiration for how TWplan looks today!</p>
            </div>
        	<div class="newsbox">
      		  <img src="images/icon1.png" />
              <p><b>April 27, 2013</b><br />
                Unveiled today is a new launching Javascript script for easy deployment of TWplan-generated commands, right from the rally point without any extra clicks. This will enable the user to easily work between TWplan and Tribalwars, integrating the two with this one-click script.<br />
                To create your script, visit the <a href="generateScript.php">Script</a> link under the Plan menu up top. Install the script in your quickbar; full instructions are available on that page.</p>
            </div>
            <div class="newsbox">
      		  <img src="images/icon1.png" />
              <p><b>November 9, 2012</b><br />
                I have not forgotten about TWplan - I have just been extremely busy with school the last few weeks.<br />
                Most worlds are now enabled, and you can now select the current world from the top-right dropdown box. Auto-updating of the world data will be happening shortly; I am just having some trouble scheduling the script to run.<br />
                A public release is imminent, once I clean some final things up and remove some of the testing functions.</p>
            </div>
            <div class="newsbox">
      		  <img src="images/icon1.png" />
              <p><b>October 8, 2012</b><br />
                TWplan now has been scaled to allow for use on other worlds besides W62. However, only W48, W58, and W62 have data loaded as of now. I will slowly be expanding that in the coming days. You can change your world from the World tab up top.<br />
                I still have to set up an auto-updating system for the village data, but you can now see when the data was last updated on any page, in the top-right corner.</p>
            </div>
            <div class="newsbox">
      		  <img src="images/icon1.png" />
              <p><b>October 3, 2012</b><br />
                A "back arrow" has been implemented to allow users to go back and add villages to their plan, or change their targets without having to retype everything in again. This has been requested by several people, and I am sure that it will greatly improve the user experience for everyone. <br />
                Other minor changes as of late have been the auto-fill-in when you click on an attack type when inputting villages, along with some behind-the-scenes error tracking that will make it easier for me to identify problems.</p>
            </div>
            <div class="newsbox">
      		  <img src="images/icon1.png" />
              <p><b>September 10, 2012</b><br />
                The long-awaited (or, at least, I have been longly awaiting it) saving feature has finally been implemented. This took awhile since HTML -> JSON -> SQL and vice-versa introduces bugs that are hard to find. Which means there are likely still problems! Please report any that you find. <br /> 
                There are still some things I want to add to this, like adding new commands to a saved plan and allowing the ability to re-export to the TW notebook. Without that, there's really no point to save a plan on TWplan rather than copying it to the notebook (other than having the live countdown). <br />
                Depending on how many people start saving plans, I may need to institute some sort of auto-delete mechanism to remove expired plans from the database. That should be fun to write (not).</p>
            </div>    
            <div class="newsbox">
      		  <img src="images/icon1.png" />
              <p><b>September 5, 2012</b><br />
                Some minor convenience updates have been made. All times will now be calculated in Server Time (GMT +1) in acccordance with TW standards. Additionally, you can now find the current Server Time at the bottom of all pages if you are confused. <br />
                On another note, you can now also makes changes to the landing date and time of your plan after calculating it all - no need to redo everything just to shift the time! Once the saving feature is implemented, you will not have to worry about closing the window. You will be able to access your saved plans and edit the landing information then too if need be.</p>
            </div>
            <div class="newsbox">
      		  <img src="images/icon1.png" />
                <p><b>August 23, 2012</b><br />
              Released functional, but unfinished, TWplan beta to the Agency tribe on W62. Access to TWplan is currently limited to players with W62 accounts. Agency members will serve as the initial testers to catch any prevailing bugs before TWplan is officially released. As Agency recently entered a war with a neighboring tribe, there should be a good amount of usage. It is important to test if TWplan's server can support regular use.</p>
            </div>
            <div class="newsbox">
      		  <img src="images/icon1.png" />
                <p><b>August 22, 2012</b><br />
                External authentication with the Tribalwars server set up. Users will be directed to an official Tribalwars page to enter their credentials, whereupon they will be redirected back to TWplan. TWplan will then use their username to dynamically fetch their village list for the world they have selected. <i>Coming soon:</i> login to access your saved plans on the TWplan server.</p>
            </div>
            <div class="newsbox">
      		  <img src="images/icon1.png" />
                <p><b>August 19, 2012</b><br />
                Site uploaded successfully to twplan.com<br /><br /><br /><br /><br /></p>
            </div>
        </div>
        <div id="changelog">
            <div id="changelogbox">
                <center><b>Upcoming Changes</b></center>
                <p>Here's what's coming soon for TWplan. It just keeps getting better and better.</p>
       
                <ul>
                  <li>Alarm notification to let you know when to send an attack.</li>
                  <li>Posterior editing of saved plans (adding commands, re-exporting).</li>
                  <li>Editing of groups (adding new villages).</li>
                  <li>Launch times displayed also in local timezone.</li>
                  <li><b>DONE! </b><strike>Save your plan for later access on TWplan's server</strike></li>
                  <li><b>DONE! </b><strike>Back button (allow the user to go back and add villages/targets)</strike></li>
                  <li><b>DONE! </b><strike>Allow the user to configure village groups (i.e. defense, offense) that can be called on will to be used in a plan</strike></li>
                  <li><b>DONE! </b><strike>Dynamically generated launch link for each command included in the plan</strike></li>
                </ul>
            </div>
        </div>
    </div>
    
    <?php include "footer.php" ?>
</body>
</html>