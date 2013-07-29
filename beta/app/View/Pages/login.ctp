<?php

  // Redirect to TW external authentication, passing the sid by GET
  header("Location: http://www.tribalwars.net/external_auth.php?sid=" . session_id() . "&client=twplan");

?>