<?php
    $depot=$_POST['depot'];
	
    $ftp_server = "77.93.131.59";
	$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

	$login = ftp_login($ftp_conn, 'DEPOT 100', '2465747899200');

	ftp_pasv($ftp_conn, true);

    //English Files Below
    $englocal_file = 'UPLOADS/export.'.$depot;
	$engserver_file = '/UPLOADS/export.'.$depot;
    $get = ftp_get($ftp_conn, $englocal_file, $engserver_file, FTP_BINARY);
    $engbuff = ftp_mdtm($ftp_conn, $engserver_file);
    
    //Scottish Files Below
    $scotlocal_file = 'UPLOADS/expscot.'.$depot;
	$scotserver_file = '/UPLOADS/expscot.'.$depot;
	$get = ftp_get($ftp_conn, $scotlocal_file, $scotserver_file, FTP_BINARY);
    $scotbuff = ftp_mdtm($ftp_conn, $scotserver_file);
    ftp_close($ftp_conn);

if (file_exists($englocal_file)) {
    $engdb = dbase_open($englocal_file, 0);
    if ($engdb) {
	    $engrecCnt = dbase_numrecords($engdb);
    }
    $scotdb = dbase_open($scotlocal_file, 0);
    if ($scotdb) {
	    $scotrecCnt = dbase_numrecords($scotdb);
    }
    echo '<table class="verify-output">';
    echo '<tr>';
    echo '<th align="center">English File Date</th><th align="center">English Records</th><th align="center">Scottish File Date</th><th align="center">Scottish Records</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td align="center">'. date ("d-M-Y H:i:s", $engbuff).'</td><td align="center">'.$engrecCnt.'</td>';
    //If scottish file existed
    if ($scotrecCnt <> '') {
        echo '<td align="center">'. date ("d-M-Y H:i:s", $scotbuff).'</td><td align="center">'.$scotrecCnt.'</td>';
    } else {
        echo '<td></td><td></td>';
    }
    echo '</tr>';
    echo '</table>';
}
?>