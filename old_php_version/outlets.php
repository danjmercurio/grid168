<?php
session_start();
if(!$_SESSION['myusername']){
header("location:main_login.php?err=2");
}
require_once ('header_html.php'); // include the database connection
$username = $_SESSION['myusername'];

$error = 0;
$error_msg = '';
$msg = '';

$outlet_name = $typeid = $dmaid = $outlet_timezone = $outlet_programming = '';
$outlet_subs = $outlet_overair = $outlet_totalhomes = '';
$outlet_firstname = $outlet_lastname = $outlet_email = $outlet_description = '';

$count = 0;
if(isset($_GET['edit']) || isset($_GET['display'])){
    $outletid = '';
    //if($_GET['edit'] > 411233){
    //    $outletid = $_GET['edit']/411234;
    //}
    //if($_GET['display'] > 411233){
    //    $outletid = $_GET['display']/411234;
    //}
    if($_GET['edit'] > 0){
        $outletid = $_GET['edit'];
    }
    if($_GET['display'] > 0){
        $outletid = $_GET['display'];
    }
    
    if($outletid > 0){
        //echo "X".$outletid;
        $sql = sprintf("select * from g_outlets where id = ('%s') AND username = ('%s')", $outletid, $username);
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)) {
            $outlet_name = $row['outlet_name'];
            $typeid = $row['outlet_type'];
            $dmaid = $row['outlet_dma'];
            $outlet_timezone = $row['outlet_timezone'];
            $outlet_programming = $row['outlet_programming'];
            
            $outlet_subs = $row['outlet_subs'];
            $outlet_overair = $row['outlet_overair'];
            $outlet_totalhomes = $row['outlet_totalhomes'];
            
            $outlet_firstname = $row['outlet_firstname'];
            $outlet_lastname = $row['outlet_lastname'];
            $outlet_email = $row['outlet_email'];
            $outlet_description = $row['outlet_description'];
        }
    }
}        

$typetext = '';
$type_select = '<select id="outlet_type" name="outlet_type">
                <option value="">None</option>';
$s_query = sprintf("SELECT * FROM g_mediatype ORDER BY id ASC;");
$s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
while($s_row = mysql_fetch_array($s_result)) {
    if($_POST['outlet_type'] == $s_row['id']){
        $type_select .= '<option value="'.$s_row['id'].'" selected>'.$s_row['mediatype'].'</option>"';
    }elseif($typeid == $s_row['id']){
        #$dmatext = $s_row['dmatext'];
        $type_select .= '<option value="'.$s_row['id'].'" selected>'.$s_row['mediatype'].'</option>"';
    }else{
        $type_select .= '<option value="'.$s_row['id'].'">'.$s_row['mediatype'].'</option>"';
    }
}
$type_select .= '</select>';

$dmatext = '';
$dma_select = '<select id="outlet_dma" name="outlet_dma">
                <option value="">None</option>';
$s_query = sprintf("SELECT * FROM g_dma ORDER BY id ASC;");
$s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
while($s_row = mysql_fetch_array($s_result)) {
    if($_POST['outlet_dma'] == $s_row['dmaid']){
        $dma_select .= '<option value="'.$s_row['dmaid'].'" selected>'.$s_row['dmatext'].'</option>"';
    }elseif($dmaid == $s_row['dmaid']){
        $dmatext = $s_row['dmatext'];
        $dma_select .= '<option value="'.$s_row['dmaid'].'" selected>'.$s_row['dmatext'].'</option>"';
    }else{
        $dma_select .= '<option value="'.$s_row['dmaid'].'">'.$s_row['dmatext'].'</option>"';
    }
}
$dma_select .= '</select>';


$timezone_select = '<select id="outlet_timezone" name="outlet_timezone">';

$vartimezone = 'Atlantic (GMT-04:00)';
if($_POST['outlet_timezone'] == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}elseif($outlet_timezone == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}else{
    $timezone_select .= '<option value="'.$vartimezone.'">'.$vartimezone.'</option>';
}
$vartimezone = 'Eastern (GMT-05:00)';
if($_POST['outlet_timezone'] == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}elseif($outlet_timezone == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}else{
    $timezone_select .= '<option value="'.$vartimezone.'">'.$vartimezone.'</option>';
}
$vartimezone = 'Central (GMT-06:00)';
if($_POST['outlet_timezone'] == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}elseif($outlet_timezone == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}else{
    $timezone_select .= '<option value="'.$vartimezone.'">'.$vartimezone.'</option>';
}
$vartimezone = 'Mountain (GMT-07:00)';
if($_POST['outlet_timezone'] == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}elseif($outlet_timezone == $vartimezone){
    $timezone_select .= '<option value="'.$vartimezone.'" selected>'.$vartimezone.'</option>';
}else{
    $timezone_select .= '<option value="'.$vartimezone.'">'.$vartimezone.'</option>';
}
$timezone_select .= '</select>';


if(isset($_GET['d'])){
        if($_GET['d'] > 0){
            #$outletid = $_GET['d']/411234;
            $outletid = $_GET['d'];
            
            $sql = sprintf("delete from g_outlets where id = ('%s') AND username = ('%s')", $outletid, $username );
            $result = mysql_query($sql);
            $error_msg = 'Outlet successfully removed<br>';            
        }
}
if(isset($_GET['delete'])){
        if($_GET['delete'] > 0){
            #$outletid = $_GET['d']/411234;
            $offerid = $_GET['delete'];
             
            $sql = sprintf("delete from g_offers where id = ('%s') AND username = ('%s')", $offerid, $username );
            $result = mysql_query($sql);
            $error_msg = 'Offer successfully removed<br>';            
        }
}        

if((isset($_POST['new'])) || (isset($_POST['edit']))){
    if($_POST['outlet_name']){
        $outlet_name = $_POST['outlet_name'];
        #echo $outlet_name."dsa";
        #exit();
    }else{
        $error = 1;
        $error_msg = 'Media Outlet Name cannot be blank<br>';
    }
    if($_POST['outlet_type']){
        $outlet_type = $_POST['outlet_type'];
    }else{
        $error = 1;
        $error_msg .= 'Type required<br>';
    }
    if($_POST['outlet_dma']){
        $outlet_dma = $_POST['outlet_dma'];
    }else{
        $error = 1;
        $error_msg .= 'Market required<br>';
    }
    if($_POST['outlet_timezone']){
        $outlet_timezone = $_POST['outlet_timezone'];
    }else{
        $error = 1;
        $error_msg .= 'Time Zone required<br>';
    }
    if($_POST['outlet_subs']){
        $outlet_subs = $_POST['outlet_subs'];
    }else{
        #$error = 1;
        #$error_msg .= 'MVPD Subscriptions value required (at least enter 0)<br>';
    }
    if($_POST['outlet_overair']){
        $outlet_overair = $_POST['outlet_overair'];
    }else{
        #$error = 1;
        #$error_msg .= 'Over the Air Homes value required (at least enter 0)<br>';
    }
    if($_POST['outlet_totalhomes']){
        $outlet_totalhomes = $_POST['outlet_totalhomes'];
    }else{
        #$error = 1;
        #$error_msg .= 'Total Homes value required (at least enter 0)<br>';
    }
    if($_POST['outlet_firstname']){
        $outlet_firstname = $_POST['outlet_firstname'];
    }else{
        $error = 1;
        $error_msg .= 'First Name cannot be blank<br>';
    }
    if($_POST['outlet_lastname']){
        $outlet_lastname = $_POST['outlet_lastname'];
    }else{
        $error = 1;
        $error_msg .= 'Last Name cannot be blank<br>';
    }
    if($_POST['outlet_email']){
        $outlet_phone = $_POST['outlet_email'];
    }
    if($_POST['outlet_programming']){
        $outlet_programming = $_POST['outlet_programming'];
    }
    if($_POST['outlet_description']){
        $outlet_description = $_POST['outlet_description'];
    }
}
if(isset($_POST['new'])){
    if(!$error){
        $createdat = date('n/j/Y');#date('m/d/Y');
        $baseQuery = "INSERT INTO `g_outlets` (`outlet_name`, `outlet_firstname`, `outlet_lastname`, `outlet_email`, `outlet_programming`, `outlet_dma`, `outlet_type`, `outlet_timezone`, `outlet_subs`, `outlet_overair`, `outlet_totalhomes`, `outlet_description`, `createdat`,`username`) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');";
        $result = mysql_query(sprintf($baseQuery,
          mysql_real_escape_string($_POST['outlet_name']),
          mysql_real_escape_string($_POST['outlet_firstname']),
          mysql_real_escape_string($_POST['outlet_lastname']),
          mysql_real_escape_string($_POST['outlet_email']),
          mysql_real_escape_string($_POST['outlet_programming']),
          mysql_real_escape_string($_POST['outlet_dma']),
          mysql_real_escape_string($_POST['outlet_type']),
          mysql_real_escape_string($_POST['outlet_timezone']),
          mysql_real_escape_string($_POST['outlet_subs']),
          mysql_real_escape_string($_POST['outlet_overair']),
          mysql_real_escape_string($_POST['outlet_totalhomes']),
          mysql_real_escape_string($_POST['outlet_description']),
          $createdat,
          $username
        )) or die(mysql_error());
        $orderId = mysql_insert_id();
        
        $outlet_name = $outlet_firstname = $outlet_lastname = $outlet_phone = '';
        $outlet_dma = $outlet_type = $outlet_subs = $outlet_description = '';
        
        #$error_msg = "New Outlet submited successfully";
        $error_msg = 'New Outlet submited successfully';        
        #header("location:outlets.php?msg=1");
        #exit();
    }else{
        //$error_msg = ''.$error_msg.'</div>';        
    }
}    
if(isset($_POST['edit'])){
    #$real_editid = $_POST['edit']/411234;
    $real_editid = $_POST['edit'];
    
    if(!$error){
        $result = mysql_query("UPDATE `g_outlets` SET `outlet_name` = '$outlet_name',
                              `outlet_firstname` = '$outlet_firstname',
                              `outlet_lastname` = '$outlet_lastname',
                              `outlet_email` = '$outlet_email',
                              `outlet_programming` = '$outlet_programming',
                              `outlet_dma` = $outlet_dma,
                              `outlet_type` = '$outlet_type',
                              `outlet_timezone` = '$outlet_timezone',
                              `outlet_subs` = '$outlet_subs',
                              `outlet_overair` = '$outlet_overair',
                              `outlet_totalhomes` = '$outlet_totalhomes',
                              `outlet_description` = '$outlet_description'                                                            
                              WHERE `id` = '$real_editid' AND username = '$username'") or mysql_error();
        
        #$outlet_name = $outlet_firstname = $outlet_lastname = $outlet_phone = '';
        #$outlet_dma = $outlet_type = $outlet_subs = $outlet_description = '';
        
        #$error_msg = "New Outlet submited successfully";
        $error_msg = 'Outlet updated successfully';        
        #header("location:outlets.php?msg=1");
        #exit();
    }else{
        //$error_msg = ''.$error_msg.'</div>';        
    }
}    

    
if(strlen($error_msg) > 0){
        $error_msg = '<div id="error_explanation">'.$error_msg.'</div>';
}

if(isset($_GET['display'])){
    #$outletid = 411234 * $outletid; # some random multiplier
    #$coded_outletid = $_GET['display']; # some random multiplier
    $outletid = $_GET['display']; # some random multiplier    
echo '<div id="content">
		  	<p class="notice"></p>
			  <p class="alert"></p>
<div id="outlet_info">
    <span class="name">'.$outlet_name.'</span>
    <span class="dma">Market:'.$dmatext.'</span>
    <span class="subs">'.number_format($outlet_subs,0).' MVPD subscribers </span>
    <span class="subs">'.number_format($outlet_overair,0).' Over the Air Homes </span>
    <span class="subs">'.number_format($outlet_totalhomes,0).' Total Homes </span>
    <a href="offers.php?new='.$outletid.'">new offer</a> 
    | <a href="outlets.php?edit='.$outletid.'">edit</a> |
    <a href="outlets.php?d='.$outletid.'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">delete</a>
</div>
<table id="table_outlet_show" class="tablesorter">
	<thead>
		<tr>
			<th>Programmer</th>
			<th>Dollar amount</th>
			<th>Created at</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>';
        //if($_GET['display'] > 411233){
        //    $outletid = $_GET['display']/411234;
        //    $coded_outletid = $_GET['display'];
        //}
        if($_GET['display'] > 0){
            $outletid = $_GET['display'];
            #$coded_outletid = $_GET['display'];
        }
        
        #echo "outletid".$outletid;
        if($outletid > 0){
            #echo "X".$outletid;
            $sql = sprintf("select * from g_offers where outletid = ('%s') AND username = ('%s')", $outletid, $username);
            $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)) {
                $offerid = $row['id'] * 411234;
                $offerid = $row['id'];                 
                $outlet_name = $row['outlet_name'];
                $programmer_ids = $row['programmer_ids'];
                $asql = sprintf("select programmer_name from g_programmers where id = ('%s')", $programmer_ids);
                $aresult = mysql_query($asql);
                $programmer_name = '';
                while($arow = mysql_fetch_array($aresult)) {
                    $programmer_name = $arow['programmer_name'];
                }
                echo "<tr><td>".$programmer_name."</td><td>$".$row['offer_dollar_amount']."</td><td>".$row['createdat']."</td><td><a href=\"offers.php?edit=".$offerid."&outletid=".$outletid."\">Edit</a> | <a href=\"offers.php?display=".$offerid."&outletid=".$outletid."\">Display</a> | <a href=\"outlets.php?delete=".$offerid."\" data-confirm=\"Are you sure?\" data-method=\"delete\" rel=\"nofollow\">Delete</a></td></tr>";
            }
        }
echo '
        </tbody>
        </table>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';
exit();
}

if( (isset($_GET['edit'])) || (isset($_POST['edit'])) ){
    if($_GET['edit']>0){
        $editid = $_GET['edit'];
    }
    if($_POST['edit']>0){
        $editid = $_POST['edit'];
    }
echo '<div id="content">
		  	<p class="notice"></p>
			  <p class="alert"></p>
				<form accept-charset="UTF-8" action="outlets.php" class="new_outlet" id="new_outlet" method="post">
                                '.$error_msg.'
                                <div style="margin:0;padding:0;display:inline">
                                <input name="edit" type="hidden" value="'.$editid.'" />
                                </div>
	<div class="field">
			<label for="outlet_company_name">Media Outlet </label><br />
			<input id="outlet_name" name="outlet_name" size="30" type="text" value="'.$outlet_name.'"/>
	</div>
	<div class="field">
		<label for="outlet_type">Type</label>
                '.$type_select.'
	</div>
	<div class="field">
		<label for="outlet_dma">Market</label>
                '.$dma_select.'
	</div>
	<div class="field">
		<label for="outlet_dma">Time Zone</label>
                '.$timezone_select.'
	</div>
	<div class="field">
		<label for="outlet_programming">Programming</label><br/>
		<input id="outlet_programming" name="outlet_programming" size="30" type="text" value="'.$outlet_programming.'" />
	</div>
        <script>
function sum() 
{
    
    var result=0;
    var txtFirstNumberValue = document.getElementById("txt1").value;
    var txtSecondNumberValue = document.getElementById("txt2").value;
    if (txtFirstNumberValue !="" && txtSecondNumberValue ==""){
        result = parseInt(txtFirstNumberValue);
    }else if(txtFirstNumberValue == "" && txtSecondNumberValue != ""){
        result= parseInt(txtSecondNumberValue);
    }else if (txtSecondNumberValue != "" && txtFirstNumberValue != ""){
        result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
    }
       if (!isNaN(result)) {
           document.getElementById("txt3").value = result;
       }
}
        </script>
        <h3>Households</h3>
	<div class="field">
        <table width="75%" border=0 cellspacing=1 cellpadding=5>
        <tr>
        <td>MVPD subscribers&nbsp;
        </td>
        <td><input id="txt1" name="outlet_subs" size="60" type="text" value="'.$outlet_subs.'" onkeyup="sum();"/>
        </td>
        </tr><tr>
        <td>Over the air homes&nbsp;
        </td>
        <td><input id="txt2" name="outlet_overair" size="60" type="text" value="'.$outlet_overair.'" onkeyup="sum();"/>
        </td>
        </tr><tr>
        <td>Total homes&nbsp;
        </td>
        <td>
        <input id="txt3" name="outlet_totalhomes" size="60" type="text" value="'.$outlet_totalhomes.'"/>
        </td>
        </tr>
        </table>
	</div>
	<div class="field">
		<label for="outlet_first_name">First name</label><br/>
		<input id="outlet_first_name" name="outlet_firstname" size="30" type="text" value="'.$outlet_firstname.'" />
	</div>
	<div class="field">
		<label for="outlet_last_name">Last name</label><br/>
		<input id="outlet_lastname" name="outlet_lastname" size="30" type="text" value="'.$outlet_lastname.'" />
	</div>
	<div class="field">
		<label for="outlet_last_name">Email</label><br/>
		<input id="outlet_email" name="outlet_email" size="30" type="text" value="'.$outlet_email.'" />
	</div>
	<div class="field">
		<label for="outlet_description">Description</label><br />
		<textarea cols="40" id="outlet_description" name="outlet_description" rows="20">'.$outlet_description.'</textarea>
	</div>
	<input id="count_sub_channel" name="count_sub_channel" type="hidden" value="0" />
	<div class="actions">
		<input class="submit_outlet" name="commit" type="submit" value="Submit" /> <input name="cancel" type="submit" value="Cancel" />
	</div>
</form>
			</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';

exit();
}


if( (isset($_GET['new'])) || (isset($_POST['new'])) ){
    
echo '<div id="content">
		  	<p class="notice"></p>
			  <p class="alert"></p>
				<form accept-charset="UTF-8" action="outlets.php" class="new_outlet" id="new_outlet" method="post">
                                '.$error_msg.'
                                <div style="margin:0;padding:0;display:inline">
                                <input name="new" type="hidden" value="1" />
                                </div>
	<div class="field">
			<label for="outlet_company_name">Media Outlet</label><br />
			<input id="outlet_name" name="outlet_name" size="30" type="text" value="'.$outlet_name.'"/>
	</div>
	<div class="field">
		<label for="outlet_type">Type</label>
                '.$type_select.'
	</div>
	<div class="field">
		<label for="outlet_dma">Market</label>
                '.$dma_select.'
	</div>
	<div class="field">
		<label for="outlet_dma">Time Zone</label>
                '.$timezone_select.'
	</div>
	<div class="field">
		<label for="outlet_programming">Programming</label><br/>
		<input id="outlet_programming" name="outlet_programming" size="30" type="text" value="'.$outlet_programming.'" />
	</div>

        <script>
function sum() 
{
    
    var result=0;
    var txtFirstNumberValue = document.getElementById("txt1").value;
    var txtSecondNumberValue = document.getElementById("txt2").value;
    if (txtFirstNumberValue !="" && txtSecondNumberValue ==""){
        result = parseInt(txtFirstNumberValue);
    }else if(txtFirstNumberValue == "" && txtSecondNumberValue != ""){
        result= parseInt(txtSecondNumberValue);
    }else if (txtSecondNumberValue != "" && txtFirstNumberValue != ""){
        result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
    }
       if (!isNaN(result)) {
           document.getElementById("txt3").value = result;
       }
}
        </script>
        <h3>Households</h3>
	<div class="field">
        <table width="75%" border=0 cellspacing=1 cellpadding=5>
        <tr>
        <td>MVPD subscribers&nbsp;
        </td>
        <td><input id="txt1" name="outlet_subs" size="60" type="text" value="'.$outlet_subs.'" onkeyup="sum();"/>
        </td>
        </tr><tr>
        <td>Over the air homes&nbsp;
        </td>
        <td><input id="txt2" name="outlet_overair" size="60" type="text" value="'.$outlet_overair.'" onkeyup="sum();"/>
        </td>
        </tr><tr>
        <td>Total homes&nbsp;
        </td>
        <td>
        <input id="txt3" name="outlet_totalhomes" size="60" type="text" value="'.$outlet_totalhomes.'"/>
        </td>
        </tr>
        </table>
	</div>
	<div class="field">
		<label for="outlet_first_name">First name</label><br/>
		<input id="outlet_first_name" name="outlet_firstname" size="30" type="text" value="'.$outlet_firstname.'" />
	</div>
	<div class="field">
		<label for="outlet_last_name">Last name</label><br/>
		<input id="outlet_lastname" name="outlet_lastname" size="30" type="text" value="'.$outlet_lastname.'" />
	</div>
	<div class="field">
		<label for="outlet_last_name">Email</label><br/>
		<input id="outlet_email" name="outlet_email" size="30" type="text" value="'.$outlet_email.'" />
	</div>
	<div class="field">
		<label for="outlet_description">Description</label><br />
		<textarea cols="40" id="outlet_description" name="outlet_description" rows="20">'.$outlet_description.'</textarea>
	</div>
	<input id="count_sub_channel" name="count_sub_channel" type="hidden" value="0" />
	<div class="actions">
		<input class="submit_outlet" name="commit" type="submit" value="Submit" /> <input name="cancel" type="submit" value="Cancel" />
	</div>
</form>
			</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';

exit();
}

if(isset($_GET['my'])){
    echo '
    <div id="content">
                            <p class="notice"></p>
                              <p class="alert"></p>
                              '.$error_msg.'
                                    <h1>Media outlets</h1>
    <table id="table_outlet" class="tablesorter">
            <thead>
                    <tr>
                            <th>Name</th>
                            <th>Offers</th>
                            <th>MVPD Subs</th>
                            <th>Over Air</th>
                            <th>Total Homes</th>                            
                            <th>Market</th>
                            <th>Media Type</th>
                            <th>Created at</th>
                            <th>Action</th>
                    </tr>
            </thead>
            <tbody>';
        
    $s_query = sprintf("SELECT * FROM g_outlets WHERE username='$username' ORDER BY id ASC;");
    $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
    while($s_row = mysql_fetch_array($s_result)) {
        $count++;
        $coded_outletid = 411234 * $s_row['id']; # some random multiplier
        $outletid = $s_row['id'];
        $dmaval = $s_row['outlet_dma'];
        $t_query = sprintf("SELECT * FROM g_dma WHERE dmaid = '$dmaval';");
        $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
        $dmatext = '';
        while($t_row = mysql_fetch_array($t_result)) {
            $dmatext = $t_row['dmatext'];
        }
        $typeid = $s_row['outlet_type'];
        $t_query = sprintf("SELECT * FROM g_mediatype WHERE id = '$typeid';");
        $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
        $typetext = '';
        while($t_row = mysql_fetch_array($t_result)) {
            $typetext = $t_row['mediatype'];
        }
        
        $offercount = 0;
        
        $sql = sprintf("select * from g_offers WHERE outletid = '$outletid'");
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)) {
            $offercount++;
        }
        
        echo '<tr><td>'.$s_row['outlet_name'].'</td><td>'.$offercount.'</td><td>'.number_format($s_row['outlet_subs'],0).'</td><td>'.number_format($s_row['outlet_overair'],0).'</td><td>'.number_format($s_row['outlet_totalhomes'],0).'</td><td>'.$dmatext.'</td><td>'.$typetext.'</td><td>'.$s_row['createdat'].'</td>
            <td>
            <a href="offers.php?new='.$outletid.'">new offer</a> | <a href="outlets.php?display='.$outletid.'">display</a> | <a href="outlets.php?edit='.$outletid.'">edit</a> | <a href="outlets.php?d='.$outletid.'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">delete</a>
            </td>
            </tr>';
            
    }
    echo '
            </tbody>
    </table>';
    
    if($count<1){
        echo "<BR><BR>&nbsp;&nbsp;&nbsp;<B>No outlets are created.</B><BR><BR>";
    }
    
    echo ' 
    <br/>
    <a href="outlets.php?new=1">Create a new media outlet</a><BR>
                            </div>
                            <div id="footer">
                            </div>
                    </div>
            </body>
    </html>
    ';
}

if((isset($_GET['all'])) && $username == 'micheal'){
    echo '
    <div id="content">
                            <p class="notice"></p>
                              <p class="alert"></p>
                              '.$error_msg.'
                                    <h1>Media outlets</h1>
    <table id="table_outlet" class="tablesorter">
            <thead>
                    <tr>
                            <th>Name</th>
                            <th>Offers</th>
                            <th>MVPD Subs</th>
                            <th>Over Air</th>
                            <th>Total Homes</th>                            
                            <th>Market</th>
                            <th>Media Type</th>
                            <th>Created at</th>
                            <th>User Name</th>                            
                            <th>Action</th>
                    </tr>
            </thead>
            <tbody>';
        
    $s_query = sprintf("SELECT * FROM g_outlets ORDER BY id ASC;");
    $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
    while($s_row = mysql_fetch_array($s_result)) {
        $count++;
        $coded_outletid = 411234 * $s_row['id']; # some random multiplier
        $outletid = $s_row['id'];
        $usersname = $s_row['username'];
        $dmaval = $s_row['outlet_dma'];
        $t_query = sprintf("SELECT * FROM g_dma WHERE dmaid = '$dmaval';");
        $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
        $dmatext = '';
        while($t_row = mysql_fetch_array($t_result)) {
            $dmatext = $t_row['dmatext'];
        }
        $typeid = $s_row['outlet_type'];
        $t_query = sprintf("SELECT * FROM g_mediatype WHERE id = '$typeid';");
        $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
        $typetext = '';
        while($t_row = mysql_fetch_array($t_result)) {
            $typetext = $t_row['mediatype'];
        }
        
        $offercount = 0;
        
        $sql = sprintf("select * from g_offers WHERE outletid = '$outletid'");
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)) {
            $offercount++;
        }
        
        echo '<tr><td>'.$s_row['outlet_name'].'</td><td>'.$offercount.'</td><td>'.number_format($s_row['outlet_subs'],0).'</td><td>'.number_format($s_row['outlet_overair'],0).'</td><td>'.number_format($s_row['outlet_totalhomes'],0).'</td><td>'.$dmatext.'</td><td>'.$typetext.'</td><td>'.$s_row['createdat'].'</td><td>'.$s_row['username'].'</td>
            <td>';
        if($usersname == 'micheal'){
            echo '<a href="offers.php?new='.$outletid.'">new offer</a> | <a href="outlets.php?display='.$outletid.'">display</a> | <a href="outlets.php?edit='.$outletid.'">edit</a> | <a href="outlets.php?d='.$outletid.'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">delete</a>
            </td>
            </tr>';
        }else{
            //'<a href="outlets.php?display='.$outletid.'">display</a> | <a href="outlets.php?d='.$outletid.'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">delete</a>
            echo '<a href="outlets.php?d='.$outletid.'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">delete</a>            
            </td>
            </tr>';
        }
    }
    echo '
            </tbody>
    </table>';
    
    if($count<1){
        echo "<BR><BR>&nbsp;&nbsp;&nbsp;<B>No outlets are created.</B><BR><BR>";
    }
    
    echo ' 
    <br/>
    <a href="outlets.php?new=1">Create a new media outlet</a><BR>
                            </div>
                            <div id="footer">
                            </div>
                    </div>
            </body>
    </html>
    ';
}

exit();

