<?php
session_start();
if(!$_SESSION['myusername']){
header("location:main_login.php?err=2");
}
require_once ('header_html.php'); // include the database connection
$username = $_SESSION['myusername'];

if(isset($_GET['delete'])){
        if($_GET['delete'] > 0){
            #$outletid = $_GET['d']/411234;
            $offerid = $_GET['delete'];
            
            $sql = sprintf("delete from g_offers where id = ('%s')", $offerid );
            $result = mysql_query($sql);
            $error_msg = 'Offer successfully removed<br>';            
        }
        $_GET['my'] = 1;
}

if(strlen($error_msg) > 0){
        $error_msg = '<div id="error_explanation">'.$error_msg.'</div>';
}

$count = 0;
if(isset($_GET['my'])){
    
echo '
<div id="content">
		  	<p class="notice"></p>
			  <p class="alert"></p>
                          '.$error_msg.'
				<h1>My Potentials</h1>
<table id="table_my_deals" class="tablesorter">
	<thead>
		<tr>
			<th class="header">Company name</th>
			<th class="header">Offer amount</th>
			<th class="header">Outlet</th>
			<th class="header">Type</th>
			<th class="header">Subscribers</th>
			<th class="header">Hours</th>
			<th class="header">Market</th>
			<th class="header">Created</th>
			<th class="header">Updated</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>';

    $t_query = sprintf("SELECT * FROM g_offers WHERE outletid != '' AND username = '$username' ORDER BY `id` DESC;");
    $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
    while($t_row = mysql_fetch_array($t_result)) {
        $count++;
        $programmer_ids = $t_row['programmer_ids'];
        $outletid = $t_row['outletid'];
        $offerid = $t_row['id'];
        $createdat = $t_row['createdat'];
        $updatedat = $t_row['updatedat'];
        $totalhours = $t_row['monday_00.00'] + $t_row['monday_00.30'] + $t_row['tuesday_00.00'] + $t_row['tuesday_00.30'] + $t_row['wednesday_00.00'] + $t_row['wednesday_00.30'] + $t_row['thursday_00.00'] + $t_row['thursday_00.30'] + $t_row['friday_00.00'] + $t_row['friday_00.30'] + $t_row['saturday_00.00'] + $t_row['saturday_00.30'] + $t_row['sunday_00.00'] + $t_row['sunday_00.30'] + $t_row['monday_01.00'] + $t_row['monday_01.30'] + $t_row['tuesday_01.00'] + $t_row['tuesday_01.30'] + $t_row['wednesday_01.00'] + $t_row['wednesday_01.30'] + $t_row['thursday_01.00'] + $t_row['thursday_01.30'] + $t_row['friday_01.00'] + $t_row['friday_01.30'] + $t_row['saturday_01.00'] + $t_row['saturday_01.30'] + $t_row['sunday_01.00'] + $t_row['sunday_01.30'] + $t_row['monday_02.00'] + $t_row['monday_02.30'] + $t_row['tuesday_02.00'] + $t_row['tuesday_02.30'] + $t_row['wednesday_02.00'] + $t_row['wednesday_02.30'] + $t_row['thursday_02.00'] + $t_row['thursday_02.30'] + $t_row['friday_02.00'] + $t_row['friday_02.30'] + $t_row['saturday_02.00'] + $t_row['saturday_02.30'] + $t_row['sunday_02.00'] + $t_row['sunday_02.30'] + $t_row['monday_03.00'] + $t_row['monday_03.30'] + $t_row['tuesday_03.00'] + $t_row['tuesday_03.30'] + $t_row['wednesday_03.00'] + $t_row['wednesday_03.30'] + $t_row['thursday_03.00'] + $t_row['thursday_03.30'] + $t_row['friday_03.00'] + $t_row['friday_03.30'] + $t_row['saturday_03.00'] + $t_row['saturday_03.30'] + $t_row['sunday_03.00'] + $t_row['sunday_03.30'] + $t_row['monday_04.00'] + $t_row['monday_04.30'] + $t_row['tuesday_04.00'] + $t_row['tuesday_04.30'] + $t_row['wednesday_04.00'] + $t_row['wednesday_04.30'] + $t_row['thursday_04.00'] + $t_row['thursday_04.30'] + $t_row['friday_04.00'] + $t_row['friday_04.30'] + $t_row['saturday_04.00'] + $t_row['saturday_04.30'] + $t_row['sunday_04.00'] + $t_row['sunday_04.30'] + $t_row['monday_05.00'] + $t_row['monday_05.30'] + $t_row['tuesday_05.00'] + $t_row['tuesday_05.30'] + $t_row['wednesday_05.00'] + $t_row['wednesday_05.30'] + $t_row['thursday_05.00'] + $t_row['thursday_05.30'] + $t_row['friday_05.00'] + $t_row['friday_05.30'] + $t_row['saturday_05.00'] + $t_row['saturday_05.30'] + $t_row['sunday_05.00'] + $t_row['sunday_05.30'] + $t_row['monday_06.00'] + $t_row['monday_06.30'] + $t_row['tuesday_06.00'] + $t_row['tuesday_06.30'] + $t_row['wednesday_06.00'] + $t_row['wednesday_06.30'] + $t_row['thursday_06.00'] + $t_row['thursday_06.30'] + $t_row['friday_06.00'] + $t_row['friday_06.30'] + $t_row['saturday_06.00'] + $t_row['saturday_06.30'] + $t_row['sunday_06.00'] + $t_row['sunday_06.30'] + $t_row['monday_07.00'] + $t_row['monday_07.30'] + $t_row['tuesday_07.00'] + $t_row['tuesday_07.30'] + $t_row['wednesday_07.00'] + $t_row['wednesday_07.30'] + $t_row['thursday_07.00'] + $t_row['thursday_07.30'] + $t_row['friday_07.00'] + $t_row['friday_07.30'] + $t_row['saturday_07.00'] + $t_row['saturday_07.30'] + $t_row['sunday_07.00'] + $t_row['sunday_07.30']
        + $t_row['monday_08.00'] + $t_row['monday_08.30'] + $t_row['tuesday_08.00'] + $t_row['tuesday_08.30'] + $t_row['wednesday_08.00'] + $t_row['wednesday_08.30'] + $t_row['thursday_08.00'] + $t_row['thursday_08.30'] + $t_row['friday_08.00'] + $t_row['friday_08.30'] + $t_row['saturday_08.00'] + $t_row['saturday_08.30'] + $t_row['sunday_08.00'] + $t_row['sunday_08.30'] + $t_row['monday_09.00'] + $t_row['monday_09.30'] + $t_row['tuesday_09.00'] + $t_row['tuesday_09.30'] + $t_row['wednesday_09.00'] + $t_row['wednesday_09.30'] + $t_row['thursday_09.00'] + $t_row['thursday_09.30'] + $t_row['friday_09.00'] + $t_row['friday_09.30'] + $t_row['saturday_09.00'] + $t_row['saturday_09.30'] + $t_row['sunday_09.00'] + $t_row['sunday_09.30'] + $t_row['monday_10.00'] + $t_row['monday_10.30'] + $t_row['tuesday_10.00'] + $t_row['tuesday_10.30'] + $t_row['wednesday_10.00'] + $t_row['wednesday_10.30'] + $t_row['thursday_10.00'] + $t_row['thursday_10.30'] + $t_row['friday_10.00'] + $t_row['friday_10.30'] + $t_row['saturday_10.00'] + $t_row['saturday_10.30'] + $t_row['sunday_10.00'] + $t_row['sunday_10.30'] + $t_row['monday_11.00'] + $t_row['monday_11.30'] + $t_row['tuesday_11.00'] + $t_row['tuesday_11.30'] + $t_row['wednesday_11.00'] + $t_row['wednesday_11.30'] + $t_row['thursday_11.00'] + $t_row['thursday_11.30'] + $t_row['friday_11.00'] + $t_row['friday_11.30'] + $t_row['saturday_11.00'] + $t_row['saturday_11.30'] + $t_row['sunday_11.00'] + $t_row['sunday_11.30'] + $t_row['monday_12.00'] + $t_row['monday_12.30'] + $t_row['tuesday_12.00'] + $t_row['tuesday_12.30'] + $t_row['wednesday_12.00'] + $t_row['wednesday_12.30'] + $t_row['thursday_12.00'] + $t_row['thursday_12.30'] + $t_row['friday_12.00'] + $t_row['friday_12.30'] + $t_row['saturday_12.00'] + $t_row['saturday_12.30'] + $t_row['sunday_12.00'] + $t_row['sunday_12.30'] + $t_row['monday_13.00'] + $t_row['monday_13.30'] + $t_row['tuesday_13.00'] + $t_row['tuesday_13.30'] + $t_row['wednesday_13.00'] + $t_row['wednesday_13.30'] + $t_row['thursday_13.00'] + $t_row['thursday_13.30'] + $t_row['friday_13.00'] + $t_row['friday_13.30'] + $t_row['saturday_13.00'] + $t_row['saturday_13.30'] + $t_row['sunday_13.00'] + $t_row['sunday_13.30'] + $t_row['monday_14.00'] + $t_row['monday_14.30'] + $t_row['tuesday_14.00'] + $t_row['tuesday_14.30'] + $t_row['wednesday_14.00'] + $t_row['wednesday_14.30'] + $t_row['thursday_14.00'] + $t_row['thursday_14.30'] + $t_row['friday_14.00'] + $t_row['friday_14.30'] + $t_row['saturday_14.00'] + $t_row['saturday_14.30'] + $t_row['sunday_14.00'] + $t_row['sunday_14.30'] + $t_row['monday_15.00'] + $t_row['monday_15.30'] + $t_row['tuesday_15.00'] + $t_row['tuesday_15.30'] + $t_row['wednesday_15.00'] + $t_row['wednesday_15.30'] + $t_row['thursday_15.00'] + $t_row['thursday_15.30'] + $t_row['friday_15.00'] + $t_row['friday_15.30'] + $t_row['saturday_15.00'] + $t_row['saturday_15.30'] + $t_row['sunday_15.00'] + $t_row['sunday_15.30']
        + $t_row['monday_16.00'] + $t_row['monday_16.30'] + $t_row['tuesday_16.00'] + $t_row['tuesday_16.30'] + $t_row['wednesday_16.00'] + $t_row['wednesday_16.30'] + $t_row['thursday_16.00'] + $t_row['thursday_16.30'] + $t_row['friday_16.00'] + $t_row['friday_16.30'] + $t_row['saturday_16.00'] + $t_row['saturday_16.30'] + $t_row['sunday_16.00'] + $t_row['sunday_16.30'] + $t_row['monday_17.00'] + $t_row['monday_17.30'] + $t_row['tuesday_17.00'] + $t_row['tuesday_17.30'] + $t_row['wednesday_17.00'] + $t_row['wednesday_17.30'] + $t_row['thursday_17.00'] + $t_row['thursday_17.30'] + $t_row['friday_17.00'] + $t_row['friday_17.30'] + $t_row['saturday_17.00'] + $t_row['saturday_17.30'] + $t_row['sunday_17.00'] + $t_row['sunday_17.30'] + $t_row['monday_18.00'] + $t_row['monday_18.30'] + $t_row['tuesday_18.00'] + $t_row['tuesday_18.30'] + $t_row['wednesday_18.00'] + $t_row['wednesday_18.30'] + $t_row['thursday_18.00'] + $t_row['thursday_18.30'] + $t_row['friday_18.00'] + $t_row['friday_18.30'] + $t_row['saturday_18.00'] + $t_row['saturday_18.30'] + $t_row['sunday_18.00'] + $t_row['sunday_18.30'] + $t_row['monday_19.00'] + $t_row['monday_19.30'] + $t_row['tuesday_19.00'] + $t_row['tuesday_19.30'] + $t_row['wednesday_19.00'] + $t_row['wednesday_19.30'] + $t_row['thursday_19.00'] + $t_row['thursday_19.30'] + $t_row['friday_19.00'] + $t_row['friday_19.30'] + $t_row['saturday_19.00'] + $t_row['saturday_19.30'] + $t_row['sunday_19.00'] + $t_row['sunday_19.30'] + $t_row['monday_20.00'] + $t_row['monday_20.30'] + $t_row['tuesday_20.00'] + $t_row['tuesday_20.30'] + $t_row['wednesday_20.00'] + $t_row['wednesday_20.30'] + $t_row['thursday_20.00'] + $t_row['thursday_20.30'] + $t_row['friday_20.00'] + $t_row['friday_20.30'] + $t_row['saturday_20.00'] + $t_row['saturday_20.30'] + $t_row['sunday_20.00'] + $t_row['sunday_20.30'] + $t_row['monday_21.00'] + $t_row['monday_21.30'] + $t_row['tuesday_21.00'] + $t_row['tuesday_21.30'] + $t_row['wednesday_21.00'] + $t_row['wednesday_21.30'] + $t_row['thursday_21.00'] + $t_row['thursday_21.30'] + $t_row['friday_21.00'] + $t_row['friday_21.30'] + $t_row['saturday_21.00'] + $t_row['saturday_21.30'] + $t_row['sunday_21.00'] + $t_row['sunday_21.30'] + $t_row['monday_22.00'] + $t_row['monday_22.30'] + $t_row['tuesday_22.00'] + $t_row['tuesday_22.30'] + $t_row['wednesday_22.00'] + $t_row['wednesday_22.30'] + $t_row['thursday_22.00'] + $t_row['thursday_22.30'] + $t_row['friday_22.00'] + $t_row['friday_22.30'] + $t_row['saturday_22.00'] + $t_row['saturday_22.30'] + $t_row['sunday_22.00'] + $t_row['sunday_22.30'] + $t_row['monday_23.00'] + $t_row['monday_23.30'] + $t_row['tuesday_23.00'] + $t_row['tuesday_23.30'] + $t_row['wednesday_23.00'] + $t_row['wednesday_23.30'] + $t_row['thursday_23.00'] + $t_row['thursday_23.30'] + $t_row['friday_23.00'] + $t_row['friday_23.30'] + $t_row['saturday_23.00'] + $t_row['saturday_23.30'] + $t_row['sunday_23.00'] + $t_row['sunday_23.30'];
        $totalhours = $totalhours/2;
        
        
        $sql = sprintf("select * from g_programmers WHERE `id`=$programmer_ids;");
        $result = mysql_query($sql);
        $programmer_name = '';
        while($prow = mysql_fetch_array($result)) {
            $programmer_name = $prow['programmer_name'];
        }
        $sql = sprintf("select * from g_outlets WHERE `id`=$outletid;");
        $result = mysql_query($sql);
        $outlet_subs = $outlet_name = $outlet_totalhomes = $outlet_type = $outlet_dma = '';
        while($row = mysql_fetch_array($result)) {
            $outlet_name = $row['outlet_name'];
            $outlet_subs = $row['outlet_subs'];
            $outlet_totalhomes = $row['outlet_totalhomes'];
            $outlet_type = $row['outlet_type'];
            $outlet_dma = $row['outlet_dma'];
        }
        
        $mediatype = '';
        #echo "X".$outlet_type;
        $s_query = sprintf("SELECT mediatype FROM g_mediatype WHERE id=$outlet_type;");
        $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
        while($s_row = mysql_fetch_array($s_result)) {
            $mediatype = $s_row['mediatype'];
        }
        
        $dma = '';
        #echo "X".$outlet_dma;
        $s_query = sprintf("SELECT dmatext FROM g_dma WHERE dmaid=$outlet_dma;");
        $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
        while($s_row = mysql_fetch_array($s_result)) {
            $dma = $s_row['dmatext'];
        }
        
echo '              
        <tr>';
echo '                                      
                <td><a href="programmer.php?show='.$programmer_ids.'">'.$programmer_name.'</a></td>';
        
echo '                                      
                <td>'.$t_row['offer_dollar_amount'].'</td>';
echo '                                      
                <td>'.$outlet_name.'</td>';
                
echo '
                <td>'.$mediatype.'</td>
                <td>'.number_format($outlet_totalhomes,0).'</td>
                <td>'.$totalhours.'</td>
                <td>'.$dma.'</td>
                <td>'.$createdat.'</td>
                <td>'.$updatedat.'</td>
                <td>
                        <a href="offers.php?display='.$offerid.'&outletid='.$outletid.'">Display</a> |
                        <a href="offers.php?edit='.$offerid.'&outletid='.$outletid.'">Edit</a> |                        
                        <a href="deals.php?delete='.$offerid.'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">Delete</a>
                </td>
                
                <td></td>';
echo '              
        </tr>';
    }
    
echo '
	</tbody>
</table>';

if($count<1){
    echo "<BR><BR>&nbsp;&nbsp;&nbsp;<B>No potentials are created.</B><BR><BR>";
}

echo '
<br>
<br>
<a href="programmer.php?new=1">Create a new programmer</a><br>
</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';
}

if(isset($_GET['all'])){
    
echo '
<div id="content">
		  	<p class="notice"></p>
			  <p class="alert"></p>
                          '.$error_msg.'
				<h1>All Potentials</h1>
<table id="table_my_deals" class="tablesorter">
	<thead>
		<tr>
			<th class="header">Company name</th>
			<th class="header">Offer amount</th>
			<th class="header">Outlet</th>
			<th class="header">Type</th>
			<th class="header">Subscribers</th>
			<th class="header">Hours</th>
			<th class="header">DMA</th>
			<th class="header">Created</th>
			<th class="header">Updated</th>
                        <th class="header">User Name</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>';

    $t_query = sprintf("SELECT * FROM g_offers WHERE outletid != '' ORDER BY `id` DESC;");
    $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
    while($t_row = mysql_fetch_array($t_result)) {
        $count++;
        $programmer_ids = $t_row['programmer_ids'];
        $outletid = $t_row['outletid'];
        $offerid = $t_row['id'];
        $createdat = $t_row['createdat'];
        $updatedat = $t_row['updatedat'];
        $usersname = $t_row['username'];
        $totalhours = $t_row['monday_00.00'] + $t_row['monday_00.30'] + $t_row['tuesday_00.00'] + $t_row['tuesday_00.30'] + $t_row['wednesday_00.00'] + $t_row['wednesday_00.30'] + $t_row['thursday_00.00'] + $t_row['thursday_00.30'] + $t_row['friday_00.00'] + $t_row['friday_00.30'] + $t_row['saturday_00.00'] + $t_row['saturday_00.30'] + $t_row['sunday_00.00'] + $t_row['sunday_00.30'] + $t_row['monday_01.00'] + $t_row['monday_01.30'] + $t_row['tuesday_01.00'] + $t_row['tuesday_01.30'] + $t_row['wednesday_01.00'] + $t_row['wednesday_01.30'] + $t_row['thursday_01.00'] + $t_row['thursday_01.30'] + $t_row['friday_01.00'] + $t_row['friday_01.30'] + $t_row['saturday_01.00'] + $t_row['saturday_01.30'] + $t_row['sunday_01.00'] + $t_row['sunday_01.30'] + $t_row['monday_02.00'] + $t_row['monday_02.30'] + $t_row['tuesday_02.00'] + $t_row['tuesday_02.30'] + $t_row['wednesday_02.00'] + $t_row['wednesday_02.30'] + $t_row['thursday_02.00'] + $t_row['thursday_02.30'] + $t_row['friday_02.00'] + $t_row['friday_02.30'] + $t_row['saturday_02.00'] + $t_row['saturday_02.30'] + $t_row['sunday_02.00'] + $t_row['sunday_02.30'] + $t_row['monday_03.00'] + $t_row['monday_03.30'] + $t_row['tuesday_03.00'] + $t_row['tuesday_03.30'] + $t_row['wednesday_03.00'] + $t_row['wednesday_03.30'] + $t_row['thursday_03.00'] + $t_row['thursday_03.30'] + $t_row['friday_03.00'] + $t_row['friday_03.30'] + $t_row['saturday_03.00'] + $t_row['saturday_03.30'] + $t_row['sunday_03.00'] + $t_row['sunday_03.30'] + $t_row['monday_04.00'] + $t_row['monday_04.30'] + $t_row['tuesday_04.00'] + $t_row['tuesday_04.30'] + $t_row['wednesday_04.00'] + $t_row['wednesday_04.30'] + $t_row['thursday_04.00'] + $t_row['thursday_04.30'] + $t_row['friday_04.00'] + $t_row['friday_04.30'] + $t_row['saturday_04.00'] + $t_row['saturday_04.30'] + $t_row['sunday_04.00'] + $t_row['sunday_04.30'] + $t_row['monday_05.00'] + $t_row['monday_05.30'] + $t_row['tuesday_05.00'] + $t_row['tuesday_05.30'] + $t_row['wednesday_05.00'] + $t_row['wednesday_05.30'] + $t_row['thursday_05.00'] + $t_row['thursday_05.30'] + $t_row['friday_05.00'] + $t_row['friday_05.30'] + $t_row['saturday_05.00'] + $t_row['saturday_05.30'] + $t_row['sunday_05.00'] + $t_row['sunday_05.30'] + $t_row['monday_06.00'] + $t_row['monday_06.30'] + $t_row['tuesday_06.00'] + $t_row['tuesday_06.30'] + $t_row['wednesday_06.00'] + $t_row['wednesday_06.30'] + $t_row['thursday_06.00'] + $t_row['thursday_06.30'] + $t_row['friday_06.00'] + $t_row['friday_06.30'] + $t_row['saturday_06.00'] + $t_row['saturday_06.30'] + $t_row['sunday_06.00'] + $t_row['sunday_06.30'] + $t_row['monday_07.00'] + $t_row['monday_07.30'] + $t_row['tuesday_07.00'] + $t_row['tuesday_07.30'] + $t_row['wednesday_07.00'] + $t_row['wednesday_07.30'] + $t_row['thursday_07.00'] + $t_row['thursday_07.30'] + $t_row['friday_07.00'] + $t_row['friday_07.30'] + $t_row['saturday_07.00'] + $t_row['saturday_07.30'] + $t_row['sunday_07.00'] + $t_row['sunday_07.30']
        + $t_row['monday_08.00'] + $t_row['monday_08.30'] + $t_row['tuesday_08.00'] + $t_row['tuesday_08.30'] + $t_row['wednesday_08.00'] + $t_row['wednesday_08.30'] + $t_row['thursday_08.00'] + $t_row['thursday_08.30'] + $t_row['friday_08.00'] + $t_row['friday_08.30'] + $t_row['saturday_08.00'] + $t_row['saturday_08.30'] + $t_row['sunday_08.00'] + $t_row['sunday_08.30'] + $t_row['monday_09.00'] + $t_row['monday_09.30'] + $t_row['tuesday_09.00'] + $t_row['tuesday_09.30'] + $t_row['wednesday_09.00'] + $t_row['wednesday_09.30'] + $t_row['thursday_09.00'] + $t_row['thursday_09.30'] + $t_row['friday_09.00'] + $t_row['friday_09.30'] + $t_row['saturday_09.00'] + $t_row['saturday_09.30'] + $t_row['sunday_09.00'] + $t_row['sunday_09.30'] + $t_row['monday_10.00'] + $t_row['monday_10.30'] + $t_row['tuesday_10.00'] + $t_row['tuesday_10.30'] + $t_row['wednesday_10.00'] + $t_row['wednesday_10.30'] + $t_row['thursday_10.00'] + $t_row['thursday_10.30'] + $t_row['friday_10.00'] + $t_row['friday_10.30'] + $t_row['saturday_10.00'] + $t_row['saturday_10.30'] + $t_row['sunday_10.00'] + $t_row['sunday_10.30'] + $t_row['monday_11.00'] + $t_row['monday_11.30'] + $t_row['tuesday_11.00'] + $t_row['tuesday_11.30'] + $t_row['wednesday_11.00'] + $t_row['wednesday_11.30'] + $t_row['thursday_11.00'] + $t_row['thursday_11.30'] + $t_row['friday_11.00'] + $t_row['friday_11.30'] + $t_row['saturday_11.00'] + $t_row['saturday_11.30'] + $t_row['sunday_11.00'] + $t_row['sunday_11.30'] + $t_row['monday_12.00'] + $t_row['monday_12.30'] + $t_row['tuesday_12.00'] + $t_row['tuesday_12.30'] + $t_row['wednesday_12.00'] + $t_row['wednesday_12.30'] + $t_row['thursday_12.00'] + $t_row['thursday_12.30'] + $t_row['friday_12.00'] + $t_row['friday_12.30'] + $t_row['saturday_12.00'] + $t_row['saturday_12.30'] + $t_row['sunday_12.00'] + $t_row['sunday_12.30'] + $t_row['monday_13.00'] + $t_row['monday_13.30'] + $t_row['tuesday_13.00'] + $t_row['tuesday_13.30'] + $t_row['wednesday_13.00'] + $t_row['wednesday_13.30'] + $t_row['thursday_13.00'] + $t_row['thursday_13.30'] + $t_row['friday_13.00'] + $t_row['friday_13.30'] + $t_row['saturday_13.00'] + $t_row['saturday_13.30'] + $t_row['sunday_13.00'] + $t_row['sunday_13.30'] + $t_row['monday_14.00'] + $t_row['monday_14.30'] + $t_row['tuesday_14.00'] + $t_row['tuesday_14.30'] + $t_row['wednesday_14.00'] + $t_row['wednesday_14.30'] + $t_row['thursday_14.00'] + $t_row['thursday_14.30'] + $t_row['friday_14.00'] + $t_row['friday_14.30'] + $t_row['saturday_14.00'] + $t_row['saturday_14.30'] + $t_row['sunday_14.00'] + $t_row['sunday_14.30'] + $t_row['monday_15.00'] + $t_row['monday_15.30'] + $t_row['tuesday_15.00'] + $t_row['tuesday_15.30'] + $t_row['wednesday_15.00'] + $t_row['wednesday_15.30'] + $t_row['thursday_15.00'] + $t_row['thursday_15.30'] + $t_row['friday_15.00'] + $t_row['friday_15.30'] + $t_row['saturday_15.00'] + $t_row['saturday_15.30'] + $t_row['sunday_15.00'] + $t_row['sunday_15.30']
        + $t_row['monday_16.00'] + $t_row['monday_16.30'] + $t_row['tuesday_16.00'] + $t_row['tuesday_16.30'] + $t_row['wednesday_16.00'] + $t_row['wednesday_16.30'] + $t_row['thursday_16.00'] + $t_row['thursday_16.30'] + $t_row['friday_16.00'] + $t_row['friday_16.30'] + $t_row['saturday_16.00'] + $t_row['saturday_16.30'] + $t_row['sunday_16.00'] + $t_row['sunday_16.30'] + $t_row['monday_17.00'] + $t_row['monday_17.30'] + $t_row['tuesday_17.00'] + $t_row['tuesday_17.30'] + $t_row['wednesday_17.00'] + $t_row['wednesday_17.30'] + $t_row['thursday_17.00'] + $t_row['thursday_17.30'] + $t_row['friday_17.00'] + $t_row['friday_17.30'] + $t_row['saturday_17.00'] + $t_row['saturday_17.30'] + $t_row['sunday_17.00'] + $t_row['sunday_17.30'] + $t_row['monday_18.00'] + $t_row['monday_18.30'] + $t_row['tuesday_18.00'] + $t_row['tuesday_18.30'] + $t_row['wednesday_18.00'] + $t_row['wednesday_18.30'] + $t_row['thursday_18.00'] + $t_row['thursday_18.30'] + $t_row['friday_18.00'] + $t_row['friday_18.30'] + $t_row['saturday_18.00'] + $t_row['saturday_18.30'] + $t_row['sunday_18.00'] + $t_row['sunday_18.30'] + $t_row['monday_19.00'] + $t_row['monday_19.30'] + $t_row['tuesday_19.00'] + $t_row['tuesday_19.30'] + $t_row['wednesday_19.00'] + $t_row['wednesday_19.30'] + $t_row['thursday_19.00'] + $t_row['thursday_19.30'] + $t_row['friday_19.00'] + $t_row['friday_19.30'] + $t_row['saturday_19.00'] + $t_row['saturday_19.30'] + $t_row['sunday_19.00'] + $t_row['sunday_19.30'] + $t_row['monday_20.00'] + $t_row['monday_20.30'] + $t_row['tuesday_20.00'] + $t_row['tuesday_20.30'] + $t_row['wednesday_20.00'] + $t_row['wednesday_20.30'] + $t_row['thursday_20.00'] + $t_row['thursday_20.30'] + $t_row['friday_20.00'] + $t_row['friday_20.30'] + $t_row['saturday_20.00'] + $t_row['saturday_20.30'] + $t_row['sunday_20.00'] + $t_row['sunday_20.30'] + $t_row['monday_21.00'] + $t_row['monday_21.30'] + $t_row['tuesday_21.00'] + $t_row['tuesday_21.30'] + $t_row['wednesday_21.00'] + $t_row['wednesday_21.30'] + $t_row['thursday_21.00'] + $t_row['thursday_21.30'] + $t_row['friday_21.00'] + $t_row['friday_21.30'] + $t_row['saturday_21.00'] + $t_row['saturday_21.30'] + $t_row['sunday_21.00'] + $t_row['sunday_21.30'] + $t_row['monday_22.00'] + $t_row['monday_22.30'] + $t_row['tuesday_22.00'] + $t_row['tuesday_22.30'] + $t_row['wednesday_22.00'] + $t_row['wednesday_22.30'] + $t_row['thursday_22.00'] + $t_row['thursday_22.30'] + $t_row['friday_22.00'] + $t_row['friday_22.30'] + $t_row['saturday_22.00'] + $t_row['saturday_22.30'] + $t_row['sunday_22.00'] + $t_row['sunday_22.30'] + $t_row['monday_23.00'] + $t_row['monday_23.30'] + $t_row['tuesday_23.00'] + $t_row['tuesday_23.30'] + $t_row['wednesday_23.00'] + $t_row['wednesday_23.30'] + $t_row['thursday_23.00'] + $t_row['thursday_23.30'] + $t_row['friday_23.00'] + $t_row['friday_23.30'] + $t_row['saturday_23.00'] + $t_row['saturday_23.30'] + $t_row['sunday_23.00'] + $t_row['sunday_23.30'];
        $totalhours = $totalhours/2;
        
        
        $sql = sprintf("select * from g_programmers WHERE `id`=$programmer_ids;");
        $result = mysql_query($sql);
        $programmer_name = '';
        while($prow = mysql_fetch_array($result)) {
            $programmer_name = $prow['programmer_name'];
        }
        $sql = sprintf("select * from g_outlets WHERE `id`=$outletid;");
        $result = mysql_query($sql);
        $outlet_subs = $outlet_totalhomes = $outlet_name = $outlet_type = $outlet_dma = '';
        while($row = mysql_fetch_array($result)) {
            $outlet_name = $row['outlet_name'];
            $outlet_subs = $row['outlet_subs'];
            $outlet_totalhomes = $row['outlet_totalhomes'];
            $outlet_type = $row['outlet_type'];
            $outlet_dma = $row['outlet_dma'];
        }
        
        $mediatype = '';
        #echo "X".$outlet_type;
        $s_query = sprintf("SELECT mediatype FROM g_mediatype WHERE id=$outlet_type;");
        $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
        while($s_row = mysql_fetch_array($s_result)) {
            $mediatype = $s_row['mediatype'];
        }
        
        $dma = '';
        #echo "X".$outlet_dma;
        $s_query = sprintf("SELECT dmatext FROM g_dma WHERE dmaid=$outlet_dma;");
        $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
        while($s_row = mysql_fetch_array($s_result)) {
            $dma = $s_row['dmatext'];
        }
        
echo '              
        <tr>';
echo '
                <td><a href="programmer.php?show='.$programmer_ids.'">'.$programmer_name.'</a></td>';
        
echo '                                      
                <td>'.$t_row['offer_dollar_amount'].'</td>';
echo '                                      
                <td>'.$outlet_name.'</td>';
                $editaction = '';
                if($username == $usersname){
                        $editaction = '<a href="offers.php?edit='.$offerid.'&outletid='.$outletid.'">Edit</a> |';                        
                }
                #else{
                #    $editaction = $username."Z".$usersname;
                #}
echo '
                <td>'.$mediatype.'</td>
                <td>'.number_format($outlet_totalhomes,0).'</td>                
                <td>'.$totalhours.'</td>
                <td>'.$dma.'</td>
                <td>'.$createdat.'</td>
                <td>'.$updatedat.'</td>
                <td>'.$usersname.'</td>
                <td>
                        <a href="offers.php?display='.$offerid.'&outletid='.$outletid.'">Display</a> |'.
                        $editaction.'
                        <a href="deals.php?delete='.$offerid.'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">Delete</a>
                </td>
                <td></td>';
echo '              
        </tr>';
    }
    
echo '
	</tbody>
</table>';

if($count<1){
    echo "<BR><BR>&nbsp;&nbsp;&nbsp;<B>No Potentials are created.</B><BR><BR>";
}

echo '
<br>
<br>
<a href="programmer.php?new=1">Create a new programmer</a><br>
</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';
}

exit();

