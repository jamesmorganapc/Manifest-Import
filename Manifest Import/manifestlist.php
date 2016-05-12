
<?php include("../config.php"); ?>
<style>

body {
    font-family: Calibri;
    margin: auto;
    background-color: #ffffff;
    size: 12px;
    align: center;
}
</style>
<div align="center">
<table cellpadding="5px">
<tr style="cursor: pointer;">
<thead>
<th align="center">Depot</th><th align="center">English File Date</th><th align="center">Scottish File Date</th><th align="center">English Imported</th><th align="center">Scottish Imported</th><th align="center">English Duplicate</th><th align="center">Scottish Duplicate</th><th align="center">Importing Progress</th><th align="center">Extra Information</th></tr>
</thead>
<tbody>
<?php
$hubdata_conn = odbc_connect('live-db-01-hubdata','APCOvernight','ja88a');
if (!$hubdata_conn)
   {die("Connection Failed: " . $hubdata_conn);}

$sql = "SELECT number, name FROM depots where sageacctno != '' and delivdep = 1 order by 1 asc";
$go = odbc_exec($hubdata_conn, $sql);

$ftp_server = "77.93.131.59";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

$login = ftp_login($ftp_conn, 'DEPOT 100', '2465747899200');

ftp_pasv($ftp_conn, true);

while ($array=odbc_fetch_array($go)) {
    $depot = $array['number'];
    $var = strlen($depot);
	if ($var == 1) {
		$depot = '00'.$depot;
	} elseif ($var == 2) {
		$depot = '0'.$depot;
	} else {
		$depot = $depot;
	}
    $englocal_file = 'UPLOADS/export.'.$depot;
    $lastmodified = date ("d/m/Y H:i:s.", filemtime($englocal_file));
    if($lastmodified == '01/01/1970 01:00:00.') {
        $lastmodified='Never';
    }
    $engserver_file = '/UPLOADS/export.'.$depot;

    $scotserver_file = '/UPLOADS/expscot.'.$depot;
	
    $engbuff = ftp_mdtm($ftp_conn, $engserver_file);
    $scotbuff = ftp_mdtm($ftp_conn, $scotserver_file);
    if($scotbuff <> '-1') {
        $scotdate=date("d-M-Y H:i:s", $scotbuff);
    } else {
        $scotdate='N/A';
    }
    $filedate= date ("d-m-Y", $engbuff);

    if ($filedate != date("d-m-Y")) {
       $color='#FF8000';
    } else {
       $color='#3D8B37';
    }
    
	
	echo '<tr style="background-color: '.$color.';"ondblclick="depimport('.$array['number'].');"><td align="center"><div>'.$depot = $array['number'].'</div></td><td align="center"><div>'.date ("d-m-Y H:i:s", $engbuff).'</div></td><td align="center"><div>'.$scotdate.'</div></td><td align="center"><div>0</div></td><td align="center"><div>0</div></td><td align="center"><div>0</div></td><td align="center"><div>0</div></td><td align="center"><div>Older File</div></td><td>Last Imported '.$lastmodified.'</td></tr>';
}
ftp_close($ftp_conn);
?>
</tbody>
</table>
</div>