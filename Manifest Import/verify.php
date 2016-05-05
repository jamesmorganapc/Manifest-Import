<?php

	$engfile='export.'.$_POST["depot"];

	$scotfile='expscot.'.$_POST["depot"];

if (file_exists($engfile)) {
    $engdb = dbase_open($engfile, 0);
    if ($engdb) {
	    $engrecCnt = dbase_numrecords($engdb);
    }
    $scotdb = dbase_open($scotfile, 0);
    if ($scotdb) {
	    $scotrecCnt = dbase_numrecords($scotdb);
    }
    echo '<table class="verify-output">';
    echo '<tr>';
    echo '<th>English File Date</th><th>English Records</th><th>Scottish File Date</th><th>Scottish Records</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>'. date ("d-M-Y H:i:s", filemtime($engfile)).'</td><td align="center">'.$engrecCnt.'</td><td>'. date ("d-M-Y H:i:s", filemtime($scotfile)).'</td><td align="center">'.$scotrecCnt.'</td>';
    echo '</tr>';
    echo '</table>';
}
?>