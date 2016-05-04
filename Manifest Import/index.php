<style type="text/css">
.block {
    padding-top: 10px;
    }

.block td {
    font-family: Calibri;
    size: 12px;
}

.block option {
    font-family: Calibri;
    size: 12px;
}

.block select {
    width: 350px;
}

.verify {
    border-radius: 8px;
    font-family: Calibri;
    size: 12px;
}
</style>
<?php

include("../config.php");
$sql = "SELECT number, name FROM depots where sageacctno != '' and delivdep = 1 order by 1 asc";
$go = odbc_exec($hubdata_conn, $sql);
auditWebUser(0);

if (!is_logged_in()) {
        header("Location: ../login.php");
die;     
}   

include("../_top2.php");

?>

<h1>Consignment Import & Export</h1>

<h2>Verify Manifest List</h2>
<div class="block">
<form action="read.php" method="POST">
<table>
<tr><td>Select Depot:</td>
<td>
<select name="depot">
<?php
while ($array=odbc_fetch_array($go)) {
    $name = $array['name'];
	$dep = $array['number'];
	$var = strlen($dep);
	if ($var == 1) {
		$dep = '00'.$dep;
	} elseif ($var == 2) {
		$dep = '0'.$dep;
	} else {
		$dep = $dep;
	}
	
		echo '<option value="'.$dep.'">'.$dep.' - '.$name.'</option>';
}
?>
</select>
</td><td><input type="submit" class="verify" name="submit" value="Verify"></td>

</tr>
</table>
</form>
</div>
<?

include("../_bot.php");

?>