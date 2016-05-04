<?php

include("../config.php");

auditWebUser(0);

if (!is_logged_in()) {
        header("Location: ../login.php");
die;     
}   

include("../_top2.php");

?>
<h1>Consignment Import & Export</h1>

<h2>Verify Manifest List</h2>

<?

include("../_bot.php");

?>