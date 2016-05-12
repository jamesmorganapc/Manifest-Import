<style type="text/css">
.block {
    padding-top: 10px;
}
.block table {
    border: none;
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
    font-family: Calibri;
    size: 12px;
}

.block-scrollable {
    overflow-y: scroll;
    height: 200px;
}
.block-scrollable td {
    font-family: Calibri;
    padding: 0,0,0,0;
    background-color: #ffffff;
    size: 12px;
    align: center;
}
.block-scrollable-th {
    font-family: Calibri;
    padding: 0,0,0,0;
    background-color: #ffffff;
    size: 12px;
    align: center;
}
.block-scrollable-td {
    font-family: Calibri;
    padding: 0,0,0,0;
    background-color: #ffffff;
    size: 12px;
    align: center;
}

.verify {
    border-radius: 8px;
    font-family: Calibri;
    size: 12px;
}
.verify-output {
    padding-left: 0px;
}
.verify-output td{
    font-family: Calibri;
    padding: 0,0,0,0;
    background-color: #ffffff;
    size: 12px;
    align: center;
}
.verify-output th{
    font-family: Calibri;
    padding: 0,0,0,0;
    background-color: #ffffff;
    size: 12px;
    align: center;
}
.man {
    background-color: #FF7F24;
}
</style>
 <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>  
<script type="text/javascript">
    function depimport(depot) {
    var depot;
        alert("Depot "+depot+" has been imported");
    }
</script> 
  <script type="text/javascript">
  $(function() {
    $("a[data-popup]").live('click', function(e) {
        window.open($(this)[0].href);
        // Prevent the link from actually being followed
        e.preventDefault();
    });
});
               $(document).ready(function(){
                    $("#button").click(function(){
                          var depot=$("#depot").val();
                          
                          $.ajax({
                              type:"post",
                              url:"verify.php",
                              data:"depot="+depot,
                              success:function(data){
                                 $("#output").html(data);
                              }
 
                          });
 
                    });
               });
    </script>
<?php

include("../config.php");
$sql = "SELECT number, name FROM depots where sageacctno != '' and delivdep = 1 order by 1 asc";
$go = odbc_exec($hubdata_conn, $sql);


if (!is_logged_in()) {
        header("Location: ../login.php");
die;     
}   

include("../_top2.php");

?>

<h1>Consignment Import & Export</h1>
<h2>Verify Manifest List</h2>
<div class="block">

<table>
<tr><td>Select Depot:</td>
<td>
<select name="depot" id="depot">
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
odbc_close($hubdata_conn);
?>
</select>
</td><td><input type="button" id="button" class="verify" name="submit" value="Verify"></td>

</tr>

</table>

<div class="verify-output" id="output"></div>
</div>

<h2><a style="color: #e31836;" href="manifestlist.php" data-popup="true">Display Manifest List</a></h2>
<?php

include("../_bot.php");

?>