<?php
session_start();
if(!$_SESSION['myusername']){
header("location:main_login.php?err=2");
}

require_once ('header_html.php'); // include the database connection
$username = $_SESSION['myusername'];
$id = 1;

$error = 0;
$error_msg = '';

function format_phone($phone)
{
    $phone = preg_replace("/[^0-9]/", "", $phone);

    if(strlen($phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
    elseif(strlen($phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
    else
        return $phone;
}

$outlet_name = $outlet_firstname = $outlet_lastname = $outlet_phone = '';
$dmatext = $dmaid = $outlet_dma = $typeid = $outlet_typeid = $outlet_type = $outlet_description = '';
$outletid = $coded_outletid = '';
$offer_dollar_amount = $hourly_rate = $weekly_rate = $monthly_rate = $yearly_rate = '';
$programmer_ids = '';
$weekly_hours = $monthly_hours = $yearly_hours = 0;
$coded_outletid = $outletid = $offerid = $offernote = $offernotetwo = $availabledate = '';
$programmer_displaytext = $percentselected = '';
$offerid = 2;

$latenight = $overnights = $earlymorning = $daytime = $totalpercent = 0;
$localprimetime = $eveningnews = $nationalprimetime = $latenews = 0;

$latenight_hours = $overnights_hours = $earlymorning_hours = $daytime_hours = 0;
$localprimetime_hours = $eveningnews_hours = $nationalprimetime_hours = $latenews_hours = 0;

$latenight_cost = $overnights_cost = $earlymorning_cost = $daytime_cost = $total_cost = 0;
$localprimetime_cost = $eveningnews_cost = $nationalprimetime_cost = $latenews_cost = '';

$outlet_timezone = $outlet_subs = $outlet_overair = $outlet_totalhomes = $outlet_programming = $availabledate = '';

$createdat = date('n/j/Y');
$updatedat = $createdat;

$hourstext = '<div style="padding-left: 427px">
		<input id="all_week" name="all_week" type="checkbox" value="yes" /> 24 hours
	</div>';
if(isset($_GET['display'])){
    $hourstext = '';
}

if($_POST['programmer_ids']> 0.00){
    $programmer_ids = $_POST['programmer_ids'];
}

if((isset($_GET['new'])) || (isset($_POST['new'])) || (isset($_GET['display'])) || (isset($_GET['edit'])) || (isset($_POST['edit']))){
    #echo "NEWNEW";
    //if($_GET['new'] > 411233){
    //    $outletid = $_GET['new']/411234;
    //    $coded_outletid = $_GET['new'];
    //}
    //if($_POST['new'] > 411233){
    //    $outletid = $_GET['new']/411234;
    //    $coded_outletid = $_GET['new'];
    //}
    //if($_POST['outletid'] > 411233){
    //    $outletid = $_POST['outletid']/411234;
    //    $coded_outletid = $_POST['outletid'];
    //}
    
    if($_GET['new'] > 0){
        $outletid = $_GET['new'];
    }
    if($_POST['new'] > 0){
        $outletid = $_POST['new'];
    }
    if($_POST['outletid'] > 0){
        $outletid = $_POST['outletid'];
    }
    if($_GET['outletid'] > 0){
        $outletid = $_GET['outletid'];
    }
    if(isset($_POST['offerid'])){
        $offerid = $_POST['offerid'];
    }
    if($outletid < 1){
        echo "No outlet available";
        exit();
    }
    if($outletid > 0){
        #echo "PP";
        #echo $outletid;
        //echo "X".$outletid;
        $sql = sprintf("select * from g_outlets where id = ('%s')", $outletid);
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)) {
            $outlet_name = $row['outlet_name'];
            //$outlet_firstname = $row['outlet_firstname'];
            //$outlet_lastname = $row['outlet_lastname'];
            //$outlet_phone = $row['outlet_phone'];
            $dmaid = $row['outlet_dma'];
            $outlet_typeid = $row['outlet_type'];
            //$typeid = $row['outlet_type'];
            
            $outlet_timezone = $row['outlet_timezone'];
            
            $outlet_subs = $row['outlet_subs'];
            $outlet_overair = $row['outlet_overair'];
            $outlet_totalhomes = $row['outlet_totalhomes'];
            $outlet_programming = $row['outlet_programming'];
            
            //$outlet_description = $row['outlet_description'];
        }
        
        #$s_query = sprintf("SELECT * FROM g_dma ORDER BY id ASC;");
        $sql = sprintf("select * from g_dma where dmaid = ('%s')", $dmaid);
        $g_result = mysql_query($sql);
        while($g_row = mysql_fetch_array($g_result)) {
            $dmatext = $g_row['dmatext'];
        }
        
        $sql = sprintf("select * from g_mediatype where id = ('%s')", $outlet_typeid);
        $g_result = mysql_query($sql);
        while($g_row = mysql_fetch_array($g_result)) {
            $outlet_type = $g_row['mediatype'];
        }
        
        #echo "YY".$dmaid."XX".$dmatext;
        #$offer_dollar_amount = $hourly_rate = $weekly_rate = $monthly_rate = $yearly_rate = '0.00';
        #$programmer_ids = '';
    }
}

if(isset($_GET['edit']) or isset($_GET['display'])){
    #$offerid = $_GET['edit']/411234; #4523574
    #$outletid = $_GET['outletid']/411234;
    $offerid = $_GET['edit']; #4523574
    $outletid = $_GET['outletid'];
    if(isset($_GET['display'])){
        $offerid = $_GET['display']; 
    }
    
    #$offerid = 411234 * $offerid; # some random multiplier
    if($offerid < 1){
        echo "No offer available";
        exit();
    }
    
    $t_query = sprintf("SELECT * FROM g_offers WHERE `id`=$offerid;");
    $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
    while($t_row = mysql_fetch_array($t_result)) {
        $programmer_ids = $t_row['programmer_ids'];
        $offer_dollar_amount = $t_row['offer_dollar_amount'];
        $hourly_rate = $t_row['hourly_rate'];
        $weekly_rate = $t_row['weekly_rate'];
        $monthly_rate = $t_row['monthly_rate'];
        $yearly_rate = $t_row['yearly_rate'];
        $programmer_ids = $t_row['programmer_ids'];
        $weekly_hours = $t_row['weekly_hours'];
        $monthly_hours = $t_row['monthly_hours'];
        $yearly_hours = $t_row['yearly_hours'];
        $totalhours = $t_row['monday_00.00'] + $t_row['monday_00.30'] + $t_row['tuesday_00.00'] + $t_row['tuesday_00.30'] + $t_row['wednesday_00.00'] + $t_row['wednesday_00.30'] + $t_row['thursday_00.00'] + $t_row['thursday_00.30'] + $t_row['friday_00.00'] + $t_row['friday_00.30'] + $t_row['saturday_00.00'] + $t_row['saturday_00.30'] + $t_row['sunday_00.00'] + $t_row['sunday_00.30'] + $t_row['monday_01.00'] + $t_row['monday_01.30'] + $t_row['tuesday_01.00'] + $t_row['tuesday_01.30'] + $t_row['wednesday_01.00'] + $t_row['wednesday_01.30'] + $t_row['thursday_01.00'] + $t_row['thursday_01.30'] + $t_row['friday_01.00'] + $t_row['friday_01.30'] + $t_row['saturday_01.00'] + $t_row['saturday_01.30'] + $t_row['sunday_01.00'] + $t_row['sunday_01.30'] + $t_row['monday_02.00'] + $t_row['monday_02.30'] + $t_row['tuesday_02.00'] + $t_row['tuesday_02.30'] + $t_row['wednesday_02.00'] + $t_row['wednesday_02.30'] + $t_row['thursday_02.00'] + $t_row['thursday_02.30'] + $t_row['friday_02.00'] + $t_row['friday_02.30'] + $t_row['saturday_02.00'] + $t_row['saturday_02.30'] + $t_row['sunday_02.00'] + $t_row['sunday_02.30'] + $t_row['monday_03.00'] + $t_row['monday_03.30'] + $t_row['tuesday_03.00'] + $t_row['tuesday_03.30'] + $t_row['wednesday_03.00'] + $t_row['wednesday_03.30'] + $t_row['thursday_03.00'] + $t_row['thursday_03.30'] + $t_row['friday_03.00'] + $t_row['friday_03.30'] + $t_row['saturday_03.00'] + $t_row['saturday_03.30'] + $t_row['sunday_03.00'] + $t_row['sunday_03.30'] + $t_row['monday_04.00'] + $t_row['monday_04.30'] + $t_row['tuesday_04.00'] + $t_row['tuesday_04.30'] + $t_row['wednesday_04.00'] + $t_row['wednesday_04.30'] + $t_row['thursday_04.00'] + $t_row['thursday_04.30'] + $t_row['friday_04.00'] + $t_row['friday_04.30'] + $t_row['saturday_04.00'] + $t_row['saturday_04.30'] + $t_row['sunday_04.00'] + $t_row['sunday_04.30'] + $t_row['monday_05.00'] + $t_row['monday_05.30'] + $t_row['tuesday_05.00'] + $t_row['tuesday_05.30'] + $t_row['wednesday_05.00'] + $t_row['wednesday_05.30'] + $t_row['thursday_05.00'] + $t_row['thursday_05.30'] + $t_row['friday_05.00'] + $t_row['friday_05.30'] + $t_row['saturday_05.00'] + $t_row['saturday_05.30'] + $t_row['sunday_05.00'] + $t_row['sunday_05.30'] + $t_row['monday_06.00'] + $t_row['monday_06.30'] + $t_row['tuesday_06.00'] + $t_row['tuesday_06.30'] + $t_row['wednesday_06.00'] + $t_row['wednesday_06.30'] + $t_row['thursday_06.00'] + $t_row['thursday_06.30'] + $t_row['friday_06.00'] + $t_row['friday_06.30'] + $t_row['saturday_06.00'] + $t_row['saturday_06.30'] + $t_row['sunday_06.00'] + $t_row['sunday_06.30'] + $t_row['monday_07.00'] + $t_row['monday_07.30'] + $t_row['tuesday_07.00'] + $t_row['tuesday_07.30'] + $t_row['wednesday_07.00'] + $t_row['wednesday_07.30'] + $t_row['thursday_07.00'] + $t_row['thursday_07.30'] + $t_row['friday_07.00'] + $t_row['friday_07.30'] + $t_row['saturday_07.00'] + $t_row['saturday_07.30'] + $t_row['sunday_07.00'] + $t_row['sunday_07.30']
        + $t_row['monday_08.00'] + $t_row['monday_08.30'] + $t_row['tuesday_08.00'] + $t_row['tuesday_08.30'] + $t_row['wednesday_08.00'] + $t_row['wednesday_08.30'] + $t_row['thursday_08.00'] + $t_row['thursday_08.30'] + $t_row['friday_08.00'] + $t_row['friday_08.30'] + $t_row['saturday_08.00'] + $t_row['saturday_08.30'] + $t_row['sunday_08.00'] + $t_row['sunday_08.30'] + $t_row['monday_09.00'] + $t_row['monday_09.30'] + $t_row['tuesday_09.00'] + $t_row['tuesday_09.30'] + $t_row['wednesday_09.00'] + $t_row['wednesday_09.30'] + $t_row['thursday_09.00'] + $t_row['thursday_09.30'] + $t_row['friday_09.00'] + $t_row['friday_09.30'] + $t_row['saturday_09.00'] + $t_row['saturday_09.30'] + $t_row['sunday_09.00'] + $t_row['sunday_09.30'] + $t_row['monday_10.00'] + $t_row['monday_10.30'] + $t_row['tuesday_10.00'] + $t_row['tuesday_10.30'] + $t_row['wednesday_10.00'] + $t_row['wednesday_10.30'] + $t_row['thursday_10.00'] + $t_row['thursday_10.30'] + $t_row['friday_10.00'] + $t_row['friday_10.30'] + $t_row['saturday_10.00'] + $t_row['saturday_10.30'] + $t_row['sunday_10.00'] + $t_row['sunday_10.30'] + $t_row['monday_11.00'] + $t_row['monday_11.30'] + $t_row['tuesday_11.00'] + $t_row['tuesday_11.30'] + $t_row['wednesday_11.00'] + $t_row['wednesday_11.30'] + $t_row['thursday_11.00'] + $t_row['thursday_11.30'] + $t_row['friday_11.00'] + $t_row['friday_11.30'] + $t_row['saturday_11.00'] + $t_row['saturday_11.30'] + $t_row['sunday_11.00'] + $t_row['sunday_11.30'] + $t_row['monday_12.00'] + $t_row['monday_12.30'] + $t_row['tuesday_12.00'] + $t_row['tuesday_12.30'] + $t_row['wednesday_12.00'] + $t_row['wednesday_12.30'] + $t_row['thursday_12.00'] + $t_row['thursday_12.30'] + $t_row['friday_12.00'] + $t_row['friday_12.30'] + $t_row['saturday_12.00'] + $t_row['saturday_12.30'] + $t_row['sunday_12.00'] + $t_row['sunday_12.30'] + $t_row['monday_13.00'] + $t_row['monday_13.30'] + $t_row['tuesday_13.00'] + $t_row['tuesday_13.30'] + $t_row['wednesday_13.00'] + $t_row['wednesday_13.30'] + $t_row['thursday_13.00'] + $t_row['thursday_13.30'] + $t_row['friday_13.00'] + $t_row['friday_13.30'] + $t_row['saturday_13.00'] + $t_row['saturday_13.30'] + $t_row['sunday_13.00'] + $t_row['sunday_13.30'] + $t_row['monday_14.00'] + $t_row['monday_14.30'] + $t_row['tuesday_14.00'] + $t_row['tuesday_14.30'] + $t_row['wednesday_14.00'] + $t_row['wednesday_14.30'] + $t_row['thursday_14.00'] + $t_row['thursday_14.30'] + $t_row['friday_14.00'] + $t_row['friday_14.30'] + $t_row['saturday_14.00'] + $t_row['saturday_14.30'] + $t_row['sunday_14.00'] + $t_row['sunday_14.30'] + $t_row['monday_15.00'] + $t_row['monday_15.30'] + $t_row['tuesday_15.00'] + $t_row['tuesday_15.30'] + $t_row['wednesday_15.00'] + $t_row['wednesday_15.30'] + $t_row['thursday_15.00'] + $t_row['thursday_15.30'] + $t_row['friday_15.00'] + $t_row['friday_15.30'] + $t_row['saturday_15.00'] + $t_row['saturday_15.30'] + $t_row['sunday_15.00'] + $t_row['sunday_15.30']
        + $t_row['monday_16.00'] + $t_row['monday_16.30'] + $t_row['tuesday_16.00'] + $t_row['tuesday_16.30'] + $t_row['wednesday_16.00'] + $t_row['wednesday_16.30'] + $t_row['thursday_16.00'] + $t_row['thursday_16.30'] + $t_row['friday_16.00'] + $t_row['friday_16.30'] + $t_row['saturday_16.00'] + $t_row['saturday_16.30'] + $t_row['sunday_16.00'] + $t_row['sunday_16.30'] + $t_row['monday_17.00'] + $t_row['monday_17.30'] + $t_row['tuesday_17.00'] + $t_row['tuesday_17.30'] + $t_row['wednesday_17.00'] + $t_row['wednesday_17.30'] + $t_row['thursday_17.00'] + $t_row['thursday_17.30'] + $t_row['friday_17.00'] + $t_row['friday_17.30'] + $t_row['saturday_17.00'] + $t_row['saturday_17.30'] + $t_row['sunday_17.00'] + $t_row['sunday_17.30'] + $t_row['monday_18.00'] + $t_row['monday_18.30'] + $t_row['tuesday_18.00'] + $t_row['tuesday_18.30'] + $t_row['wednesday_18.00'] + $t_row['wednesday_18.30'] + $t_row['thursday_18.00'] + $t_row['thursday_18.30'] + $t_row['friday_18.00'] + $t_row['friday_18.30'] + $t_row['saturday_18.00'] + $t_row['saturday_18.30'] + $t_row['sunday_18.00'] + $t_row['sunday_18.30'] + $t_row['monday_19.00'] + $t_row['monday_19.30'] + $t_row['tuesday_19.00'] + $t_row['tuesday_19.30'] + $t_row['wednesday_19.00'] + $t_row['wednesday_19.30'] + $t_row['thursday_19.00'] + $t_row['thursday_19.30'] + $t_row['friday_19.00'] + $t_row['friday_19.30'] + $t_row['saturday_19.00'] + $t_row['saturday_19.30'] + $t_row['sunday_19.00'] + $t_row['sunday_19.30'] + $t_row['monday_20.00'] + $t_row['monday_20.30'] + $t_row['tuesday_20.00'] + $t_row['tuesday_20.30'] + $t_row['wednesday_20.00'] + $t_row['wednesday_20.30'] + $t_row['thursday_20.00'] + $t_row['thursday_20.30'] + $t_row['friday_20.00'] + $t_row['friday_20.30'] + $t_row['saturday_20.00'] + $t_row['saturday_20.30'] + $t_row['sunday_20.00'] + $t_row['sunday_20.30'] + $t_row['monday_21.00'] + $t_row['monday_21.30'] + $t_row['tuesday_21.00'] + $t_row['tuesday_21.30'] + $t_row['wednesday_21.00'] + $t_row['wednesday_21.30'] + $t_row['thursday_21.00'] + $t_row['thursday_21.30'] + $t_row['friday_21.00'] + $t_row['friday_21.30'] + $t_row['saturday_21.00'] + $t_row['saturday_21.30'] + $t_row['sunday_21.00'] + $t_row['sunday_21.30'] + $t_row['monday_22.00'] + $t_row['monday_22.30'] + $t_row['tuesday_22.00'] + $t_row['tuesday_22.30'] + $t_row['wednesday_22.00'] + $t_row['wednesday_22.30'] + $t_row['thursday_22.00'] + $t_row['thursday_22.30'] + $t_row['friday_22.00'] + $t_row['friday_22.30'] + $t_row['saturday_22.00'] + $t_row['saturday_22.30'] + $t_row['sunday_22.00'] + $t_row['sunday_22.30'] + $t_row['monday_23.00'] + $t_row['monday_23.30'] + $t_row['tuesday_23.00'] + $t_row['tuesday_23.30'] + $t_row['wednesday_23.00'] + $t_row['wednesday_23.30'] + $t_row['thursday_23.00'] + $t_row['thursday_23.30'] + $t_row['friday_23.00'] + $t_row['friday_23.30'] + $t_row['saturday_23.00'] + $t_row['saturday_23.30'] + $t_row['sunday_23.00'] + $t_row['sunday_23.30'];
        $totalhours = $totalhours/2;
        $percentselected = $totalhours/168;
        $percentselected = 100 * round($percentselected,3);
        $offernote = $t_row['offernote'];
        $offernotetwo = $t_row['offernotetwo'];
        $availabledate = $t_row['availabledate'];
        #$latenight = 0;
        $r_query = sprintf("SELECT * FROM g_rates_new ORDER BY `id` ASC;");
        $r_result = mysql_query($r_query) or fwrite($fh, "Line 136");
        while($r_row = mysql_fetch_array($r_result)) {
            #$latenight = 10;
            if($r_row['id'] % 2 == 0){
                $end = '30';
            }else{
                $end = '00';
            }
            $ratehour = '00';
            if($r_row['id'] == 1){
                if($t_row['monday_'.$ratehour.'.'.$end]){$latenight += $r_row['mon'];$latenight_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$latenight += $r_row['tue'];$latenight_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$latenight += $r_row['wed'];$latenight_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$latenight += $r_row['thurs'];$latenight_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$latenight += $r_row['fri'];$latenight_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$latenight += $r_row['sat'];$latenight_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$latenight += $r_row['sun'];$latenight_hours += 1;}                        
            }
            if($r_row['id'] == 2){
                if($t_row['monday_'.$ratehour.'.'.$end]){$latenight += $r_row['mon'];$latenight_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$latenight += $r_row['tue'];$latenight_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$latenight += $r_row['wed'];$latenight_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$latenight += $r_row['thurs'];$latenight_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$latenight += $r_row['fri'];$latenight_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$latenight += $r_row['sat'];$latenight_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$latenight += $r_row['sun'];$latenight_hours += 1;}                        
            }
            $ratehour = '23';
            if($r_row['id'] == 48){
                if($t_row['monday_'.$ratehour.'.'.$end]){$latenight += $r_row['mon'];$latenight_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$latenight += $r_row['tue'];$latenight_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$latenight += $r_row['wed'];$latenight_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$latenight += $r_row['thurs'];$latenight_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$latenight += $r_row['fri'];$latenight_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$latenight += $r_row['sat'];$latenight_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$latenight += $r_row['sun'];$latenight_hours += 1;}                        
            }
            
            $ratehour = '01';
            if($r_row['id'] == 3){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            if($r_row['id'] == 4){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            $ratehour = '02';
            if($r_row['id'] == 5){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            if($r_row['id'] == 6){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            $ratehour = '03';
            if($r_row['id'] == 7){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            if($r_row['id'] == 8){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            $ratehour = '04';
            if($r_row['id'] == 9){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            if($r_row['id'] == 10){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            $ratehour = '05';
            if($r_row['id'] == 11){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }
            if($r_row['id'] == 12){
                if($t_row['monday_'.$ratehour.'.'.$end]){$overnights += $r_row['mon'];$overnights_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$overnights += $r_row['tue'];$overnights_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$overnights += $r_row['wed'];$overnights_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$overnights += $r_row['thurs'];$overnights_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$overnights += $r_row['fri'];$overnights_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$overnights += $r_row['sat'];$overnights_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$overnights += $r_row['sun'];$overnights_hours += 1;}                        
            }

            $ratehour = '06';
            if($r_row['id'] == 13){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }
            if($r_row['id'] == 14){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }
            $ratehour = '07';
            if($r_row['id'] == 15){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }
            if($r_row['id'] == 16){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }
            $ratehour = '08';
            if($r_row['id'] == 17){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }
            if($r_row['id'] == 18){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }
            $ratehour = '09';
            if($r_row['id'] == 19){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }
            if($r_row['id'] == 20){
                if($t_row['monday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['mon'];$earlymorning_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['tue'];$earlymorning_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['wed'];$earlymorning_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['thurs'];$earlymorning_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['fri'];$earlymorning_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sat'];$earlymorning_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$earlymorning += $r_row['sun'];$earlymorning_hours += 1;}                        
            }

            $ratehour = '10';
            if($r_row['id'] == 21){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            if($r_row['id'] == 22){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            $ratehour = '11';
            if($r_row['id'] == 23){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            if($r_row['id'] == 24){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            $ratehour = '12';
            if($r_row['id'] == 25){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            if($r_row['id'] == 26){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            $ratehour = '13';
            if($r_row['id'] == 27){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            if($r_row['id'] == 28){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            $ratehour = '14';
            if($r_row['id'] == 29){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            if($r_row['id'] == 30){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            $ratehour = '15';
            if($r_row['id'] == 31){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            if($r_row['id'] == 32){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            $ratehour = '16';
            if($r_row['id'] == 33){
                if($t_row['monday_'.$ratehour.'.'.$end]){$daytime += $r_row['mon'];$daytime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$daytime += $r_row['tue'];$daytime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$daytime += $r_row['wed'];$daytime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$daytime += $r_row['thurs'];$daytime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$daytime += $r_row['fri'];$daytime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$daytime += $r_row['sat'];$daytime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$daytime += $r_row['sun'];$daytime_hours += 1;}                        
            }
            
            if($r_row['id'] == 34){
                if($t_row['monday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['mon'];$eveningnews_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['tue'];$eveningnews_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['wed'];$eveningnews_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['thurs'];$eveningnews_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['fri'];$eveningnews_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sat'];$eveningnews_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sun'];$eveningnews_hours += 1;}
                #echo "XXX".$eveningnews;
                #echo "YYY".$eveningnews_hours;
            }
            $ratehour = '17';
            if($r_row['id'] == 35){
                if($t_row['monday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['mon'];$eveningnews_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['tue'];$eveningnews_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['wed'];$eveningnews_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['thurs'];$eveningnews_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['fri'];$eveningnews_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sat'];$eveningnews_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sun'];$eveningnews_hours += 1;}                        
            }
            if($r_row['id'] == 36){
                if($t_row['monday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['mon'];$eveningnews_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['tue'];$eveningnews_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['wed'];$eveningnews_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['thurs'];$eveningnews_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['fri'];$eveningnews_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sat'];$eveningnews_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sun'];$eveningnews_hours += 1;}                        
            }
            $ratehour = '18';
            if($r_row['id'] == 37){
                if($t_row['monday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['mon'];$eveningnews_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['tue'];$eveningnews_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['wed'];$eveningnews_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['thurs'];$eveningnews_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['fri'];$eveningnews_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sat'];$eveningnews_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sun'];$eveningnews_hours += 1;}                        
            }
            if($r_row['id'] == 38){
                if($t_row['monday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['mon'];$eveningnews_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['tue'];$eveningnews_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['wed'];$eveningnews_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['thurs'];$eveningnews_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['fri'];$eveningnews_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sat'];$eveningnews_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$eveningnews += $r_row['sun'];$eveningnews_hours += 1;}                        
            }
            
            $ratehour = '19';
            if($r_row['id'] == 39){
                if($t_row['monday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['mon'];$localprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['tue'];$localprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['wed'];$localprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['thurs'];$localprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['fri'];$localprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['sat'];$localprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['sun'];$localprimetime_hours += 1;}                        
            }
            if($r_row['id'] == 40){
                if($t_row['monday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['mon'];$localprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['tue'];$localprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['wed'];$localprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['thurs'];$localprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['fri'];$localprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['sat'];$localprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$localprimetime += $r_row['sun'];$localprimetime_hours += 1;}                        
            }

            $ratehour = '20';
            if($r_row['id'] == 41){
                if($t_row['monday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['mon'];$nationalprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['tue'];$nationalprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['wed'];$nationalprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['thurs'];$nationalprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['fri'];$nationalprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sat'];$nationalprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sun'];$nationalprimetime_hours += 1;}                        
            }
            if($r_row['id'] == 42){
                if($t_row['monday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['mon'];$nationalprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['tue'];$nationalprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['wed'];$nationalprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['thurs'];$nationalprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['fri'];$nationalprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sat'];$nationalprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sun'];$nationalprimetime_hours += 1;}                        
            }
            $ratehour = '21';
            if($r_row['id'] == 43){
                if($t_row['monday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['mon'];$nationalprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['tue'];$nationalprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['wed'];$nationalprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['thurs'];$nationalprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['fri'];$nationalprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sat'];$nationalprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sun'];$nationalprimetime_hours += 1;}                        
            }
            if($r_row['id'] == 44){
                if($t_row['monday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['mon'];$nationalprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['tue'];$nationalprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['wed'];$nationalprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['thurs'];$nationalprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['fri'];$nationalprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sat'];$nationalprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sun'];$nationalprimetime_hours += 1;}                        
            }
            $ratehour = '22';
            if($r_row['id'] == 45){
                if($t_row['monday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['mon'];$nationalprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['tue'];$nationalprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['wed'];$nationalprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['thurs'];$nationalprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['fri'];$nationalprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sat'];$nationalprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sun'];$nationalprimetime_hours += 1;}                        
            }
            if($r_row['id'] == 46){
                if($t_row['monday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['mon'];$nationalprimetime_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['tue'];$nationalprimetime_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['wed'];$nationalprimetime_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['thurs'];$nationalprimetime_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['fri'];$nationalprimetime_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sat'];$nationalprimetime_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$nationalprimetime += $r_row['sun'];$nationalprimetime_hours += 1;}                        
            }
            $ratehour = '23';
            if($r_row['id'] == 47){
                if($t_row['monday_'.$ratehour.'.'.$end]){$latenews += $r_row['mon'];$latenews_hours += 1;}
                if($t_row['tuesday_'.$ratehour.'.'.$end]){$latenews += $r_row['tue'];$latenews_hours += 1;}
                if($t_row['wednesday_'.$ratehour.'.'.$end]){$latenews += $r_row['wed'];$latenews_hours += 1;}
                if($t_row['thursday_'.$ratehour.'.'.$end]){$latenews += $r_row['thurs'];$latenews_hours += 1;}
                if($t_row['friday_'.$ratehour.'.'.$end]){$latenews += $r_row['fri'];$latenews_hours += 1;}
                if($t_row['saturday_'.$ratehour.'.'.$end]){$latenews += $r_row['sat'];$latenews_hours += 1;}
                if($t_row['sunday_'.$ratehour.'.'.$end]){$latenews += $r_row['sun'];$latenews_hours += 1;}                        
            }
            
            //if($r_row['id'] = 2){
            //    if($t_row['monday_00.'.$end]){$latenight += $r_row['mon'];}
            //    if($t_row['tuesday_00.'.$end]){$latenight += $r_row['tue'];}
            //    if($t_row['wednesday_00.30']){$latenight += $r_row['wed'];}
            //    if($t_row['thursday_00.30']){$latenight += $r_row['thurs'];}
            //    if($t_row['friday_00.30']){$latenight += $r_row['fri'];}
            //    if($t_row['saturday_00.30']){$latenight += $r_row['sat'];}
            //    if($t_row['sunday_00.30']){$latenight += $r_row['sun'];}                        
            //}
        }
        
        #$overnights_cost = ($overnights * $outlet_subs * $offer_dollar_amount) / 12 ;
        $latenight_cost_tmp_tmp = round(($latenight * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $latenight_cost_tmp = number_format($latenight_cost_tmp_tmp,2);
        $latenight_cost = '$'.$latenight_cost_tmp;
        
        $overnights_cost_tmp_tmp = round(($overnights * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $overnights_cost_tmp = number_format($overnights_cost_tmp_tmp,2);
        $overnights_cost = '$'.$overnights_cost_tmp;
        
        $earlymorning_cost_tmp_tmp = round(($earlymorning * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $earlymorning_cost_tmp = number_format($earlymorning_cost_tmp_tmp,2);
        $earlymorning_cost = '$'.$earlymorning_cost_tmp;
        
        $daytime_cost_tmp_tmp = round(($daytime * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $daytime_cost_tmp = number_format($daytime_cost_tmp_tmp,2);
        $daytime_cost = '$'.$daytime_cost_tmp;
        
        $localprimetime_cost_tmp_tmp = round(($localprimetime * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $localprimetime_cost_tmp = number_format($localprimetime_cost_tmp_tmp,2);
        $localprimetime_cost = '$'.$localprimetime_cost_tmp;
        
        $eveningnews_cost_tmp_tmp = round(($eveningnews * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $eveningnews_cost_tmp = number_format($eveningnews_cost_tmp_tmp,2);
        $eveningnews_cost = '$'.$eveningnews_cost_tmp;

        $localprimetime_cost_tmp_tmp = round(($localprimetime * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $localprimetime_cost_tmp = number_format($localprimetime_cost_tmp_tmp,2);
        $localprimetime_cost = '$'.$localprimetime_cost_tmp;

        $nationalprimetime_cost_tmp_tmp = round(($nationalprimetime * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $nationalprimetime_cost_tmp = number_format($nationalprimetime_cost_tmp_tmp,2);
        $nationalprimetime_cost = '$'.$nationalprimetime_cost_tmp;
        
        $latenews_cost_tmp_tmp = round(($latenews * $outlet_totalhomes * $offer_dollar_amount)/52,2);
        $latenews_cost_tmp = number_format($latenews_cost_tmp_tmp,2);
        $latenews_cost = '$'.$latenews_cost_tmp;

        //$total_cost = $latenight_cost_tmp + $overnights_cost_tmp + $earlymorning_cost_tmp + $daytime_cost_tmp + $localprimetime_cost_tmp + $eveningnews_cost_tmp + $nationalprimetime_cost_tmp + $latenews_cost_tmp;
        $total_cost_tmp = $latenight_cost_tmp_tmp + $overnights_cost_tmp_tmp + $earlymorning_cost_tmp_tmp + $daytime_cost_tmp_tmp + $localprimetime_cost_tmp_tmp + $eveningnews_cost_tmp_tmp + $nationalprimetime_cost_tmp_tmp + $latenews_cost_tmp_tmp;
        #$total_cost_tmp = $earlymorning_cost_tmp + $daytime_cost_tmp;
        #$total_cost_tmp = $earlymorning_cost_tmp;
        
        $total_cost = '$'.number_format($total_cost_tmp,2);
        
        #$overnights = round($overnights,2);
        
        $latenight = $latenight * 100;
        $latenight = round($latenight,3);
        $overnights = $overnights * 100;
        $overnights = round($overnights,3);
        $earlymorning = $earlymorning * 100;
        $earlymorning = round($earlymorning,3);
        $daytime = $daytime * 100;
        $daytime = round($daytime,3);
        $localprimetime = $localprimetime * 100;
        $localprimetime = round($localprimetime,3);
        $eveningnews = $eveningnews * 100;
        $eveningnews = round($eveningnews,3);
        $nationalprimetime = $nationalprimetime * 100;
        $nationalprimetime = round($nationalprimetime,3);
        $latenews = $latenews * 100;
        $latenews = round($latenews,3);

        $totalpercent = $latenight + $overnights + $earlymorning + $daytime + $totalpercent + $localprimetime + $eveningnews + $nationalprimetime + $latenews;
        $totalpercent = round($totalpercent,2);

        if($latenight_hours > 0){
            $latenight_hours = $latenight_hours/2;
        }
        if($overnights_hours > 0){
            $overnights_hours = $overnights_hours/2;
        }
        if($earlymorning_hours > 0){
            $earlymorning_hours = $earlymorning_hours/2;
        }
        if($daytime_hours > 0){
            $daytime_hours = $daytime_hours/2;
        }
        if($localprimetime_hours > 0){
            $localprimetime_hours = $localprimetime_hours/2;
        }
        if($eveningnews_hours > 0){
            $eveningnews_hours = $eveningnews_hours/2;
        }
        if($nationalprimetime_hours > 0){
            $nationalprimetime_hours = $nationalprimetime_hours/2;
        }
        if($latenews_hours > 0){
            $latenews_hours = $latenews_hours/2;
        }
        #$overnights_cost = $overnights * $outlet_subs * $offer_dollar_amount ;
        #$overnights_cost = ($r_row['mon'] * $outlet_subs * $offer_dollar_amount) / 12 ;
    }
    
    $sql = sprintf("select * from g_programmers WHERE `id`=$programmer_ids;");
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
        $programmer_displaytext = $row['programmer_name']."<br>
                                  Email: ".$row['programmer_email']."<br>
                                  Phone: ".format_phone($row['programmer_phone'])."<br>";
    }
    
}

#$programmers_select = '<select id="offer_programmer_ids" multiple="multiple" name="programmer_ids">';
$programmers_select = '<select id="offer_programmer_ids" name="programmer_ids">';

$sql = sprintf("select * from g_programmers WHERE username = '$username' ORDER BY id ASC");
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
    if($row['id'] == $programmer_ids){
        $programmers_select .= '<option value="'.$row['id'].'" selected="selected">'.$row['programmer_name'].'</option>';
    }else{
        $programmers_select .= '<option value="'.$row['id'].'">'.$row['programmer_name'].'</option>';
    }
}
$programmers_select .= '</select>';




function printArray($array){
     foreach ($array as $key => $value){
        echo "$key => $value";
        if(is_array($value)){ //If $value is an array, print it as well!
            printArray($value);
        }  
    } 
}    

if((isset($_POST['new'])) || (isset($_POST['edit']))){
    if($_POST['offer_dollar_amount']> 0.00){
        $offer_dollar_amount = $_POST['offer_dollar_amount'];
        #echo $offer_dollar_amount."dsa";
        #exit();
    }else{
        $error = 1;
        $error_msg = 'Dollar amount * cannot be blank<br>';
    }
    #offer[hourly_rate]
    
    #echo "SS".$_POST['offer']['hourly_rate'];
    if($_POST['offer']['hourly_rate']> 0.00){
        $hourly_rate = $_POST['offer']['hourly_rate'];
    }else{
        $error = 1;
        $error_msg .= 'Hourly rate must be calculated<br>';
    }
    if($_POST['offer']['weekly_offer']> 0.00){
        $weekly_rate = $_POST['offer']['weekly_offer'];
    }else{
        $error = 1;
        $error_msg .= 'Weekly rate must be calculated<br>';
    }
    if($_POST['offer']['monthly_offer']> 0.00){
        $monthly_rate = $_POST['offer']['monthly_offer'];
    }else{
        $error = 1;
        $error_msg .= 'Monthly rate must be calculated<br>';
    }
    if($_POST['offer']['yearly_offer']> 0.00){
        $yearly_rate = $_POST['offer']['yearly_offer'];
    }else{
        $error = 1;
        $error_msg .= 'Yearly rate must be calculated<br>';
    }
    $weekly_hours = $monthly_hours = $yearly_hours = '';
    if($_POST['offer']['total_hours']> 0.00){
        $weekly_hours = $_POST['offer']['total_hours'];
        $monthly_hours = 4*$weekly_hours;
        $yearly_hours = 52*$weekly_hours;
    }else{
        $error = 1;
        $error_msg .= 'Weekly hours must be calculated<br>';
        $error_msg .= 'Monthly hours must be calculated<br>';
        $error_msg .= 'Yearly hours must be calculated<br>';
    }
    
    
#new=1&outletid=21&offerid=2&offer_dollar_amount=1&cell%5Bmonday_00.00%5D=1&cell%5Btuesday_00.00%5D=&cell%5Bwednesday_00.00%5D=&cell%5Bthursday_00.00%5D=&cell%5Bfriday_00.00%5D=&cell%5Bsaturday_00.00%5D=&cell%5Bsunday_00.00%5D=&cell%5Bmonday_00.30%5D=&cell%5Btuesday_00.30%5D=1&cell%5Bwednesday_00.30%5D=1&cell%5Bthursday_00.30%5D=1&cell%5Bfriday_00.30%5D=1&cell%5Bsaturday_00.30%5D=1&cell%5Bsunday_00.30%5D=1&cell%5Bmonday_01.00%5D=&cell%5Btuesday_01.00%5D=&cell%5Bwednesday_01.00%5D=&cell%5Bthursday_01.00%5D=&cell%5Bfriday_01.00%5D=&cell%5Bsaturday_01.00%5D=&cell%5Bsunday_01.00%5D=&cell%5Bmonday_01.30%5D=&cell%5Btuesday_01.30%5D=&cell%5Bwednesday_01.30%5D=&cell%5Bthursday_01.30%5D=&cell%5Bfriday_01.30%5D=&cell%5Bsaturday_01.30%5D=&cell%5Bsunday_01.30%5D=&cell%5Bmonday_02.00%5D=&cell%5Btuesday_02.00%5D=&cell%5Bwednesday_02.00%5D=&cell%5Bthursday_02.00%5D=&cell%5Bfriday_02.00%5D=&cell%5Bsaturday_02.00%5D=&cell%5Bsunday_02.00%5D=&cell%5Bmonday_02.30%5D=&cell%5Btuesday_02.30%5D=&cell%5Bwednesday_02.30%5D=&cell%5Bthursday_02.30%5D=&cell%5Bfriday_02.30%5D=&cell%5Bsaturday_02.30%5D=&cell%5Bsunday_02.30%5D=&cell%5Bmonday_03.00%5D=&cell%5Btuesday_03.00%5D=&cell%5Bwednesday_03.00%5D=&cell%5Bthursday_03.00%5D=&cell%5Bfriday_03.00%5D=&cell%5Bsaturday_03.00%5D=&cell%5Bsunday_03.00%5D=&cell%5Bmonday_03.30%5D=&cell%5Btuesday_03.30%5D=&cell%5Bwednesday_03.30%5D=&cell%5Bthursday_03.30%5D=&cell%5Bfriday_03.30%5D=&cell%5Bsaturday_03.30%5D=&cell%5Bsunday_03.30%5D=&cell%5Bmonday_04.00%5D=&cell%5Btuesday_04.00%5D=&cell%5Bwednesday_04.00%5D=&cell%5Bthursday_04.00%5D=&cell%5Bfriday_04.00%5D=&cell%5Bsaturday_04.00%5D=&cell%5Bsunday_04.00%5D=&cell%5Bmonday_04.30%5D=&cell%5Btuesday_04.30%5D=&cell%5Bwednesday_04.30%5D=&cell%5Bthursday_04.30%5D=&cell%5Bfriday_04.30%5D=&cell%5Bsaturday_04.30%5D=&cell%5Bsunday_04.30%5D=&cell%5Bmonday_05.00%5D=&cell%5Btuesday_05.00%5D=&cell%5Bwednesday_05.00%5D=&cell%5Bthursday_05.00%5D=&cell%5Bfriday_05.00%5D=&cell%5Bsaturday_05.00%5D=&cell%5Bsunday_05.00%5D=&cell%5Bmonday_05.30%5D=&cell%5Btuesday_05.30%5D=&cell%5Bwednesday_05.30%5D=&cell%5Bthursday_05.30%5D=&cell%5Bfriday_05.30%5D=&cell%5Bsaturday_05.30%5D=&cell%5Bsunday_05.30%5D=&cell%5Bmonday_06.00%5D=&cell%5Btuesday_06.00%5D=&cell%5Bwednesday_06.00%5D=&cell%5Bthursday_06.00%5D=&cell%5Bfriday_06.00%5D=&cell%5Bsaturday_06.00%5D=&cell%5Bsunday_06.00%5D=&cell%5Bmonday_06.30%5D=&cell%5Btuesday_06.30%5D=&cell%5Bwednesday_06.30%5D=&cell%5Bthursday_06.30%5D=&cell%5Bfriday_06.30%5D=&cell%5Bsaturday_06.30%5D=&cell%5Bsunday_06.30%5D=&cell%5Bmonday_07.00%5D=&cell%5Btuesday_07.00%5D=&cell%5Bwednesday_07.00%5D=&cell%5Bthursday_07.00%5D=&cell%5Bfriday_07.00%5D=&cell%5Bsaturday_07.00%5D=&cell%5Bsunday_07.00%5D=&cell%5Bmonday_07.30%5D=&cell%5Btuesday_07.30%5D=&cell%5Bwednesday_07.30%5D=&cell%5Bthursday_07.30%5D=&cell%5Bfriday_07.30%5D=&cell%5Bsaturday_07.30%5D=&cell%5Bsunday_07.30%5D=&cell%5Bmonday_08.00%5D=&cell%5Btuesday_08.00%5D=&cell%5Bwednesday_08.00%5D=&cell%5Bthursday_08.00%5D=&cell%5Bfriday_08.00%5D=&cell%5Bsaturday_08.00%5D=&cell%5Bsunday_08.00%5D=&cell%5Bmonday_08.30%5D=&cell%5Btuesday_08.30%5D=&cell%5Bwednesday_08.30%5D=&cell%5Bthursday_08.30%5D=&cell%5Bfriday_08.30%5D=&cell%5Bsaturday_08.30%5D=&cell%5Bsunday_08.30%5D=&cell%5Bmonday_09.00%5D=&cell%5Btuesday_09.00%5D=&cell%5Bwednesday_09.00%5D=&cell%5Bthursday_09.00%5D=&cell%5Bfriday_09.00%5D=&cell%5Bsaturday_09.00%5D=&cell%5Bsunday_09.00%5D=&cell%5Bmonday_09.30%5D=&cell%5Btuesday_09.30%5D=&cell%5Bwednesday_09.30%5D=&cell%5Bthursday_09.30%5D=&cell%5Bfriday_09.30%5D=&cell%5Bsaturday_09.30%5D=&cell%5Bsunday_09.30%5D=&cell%5Bmonday_10.00%5D=&cell%5Btuesday_10.00%5D=&cell%5Bwednesday_10.00%5D=&cell%5Bthursday_10.00%5D=&cell%5Bfriday_10.00%5D=&cell%5Bsaturday_10.00%5D=&cell%5Bsunday_10.00%5D=&cell%5Bmonday_10.30%5D=&cell%5Btuesday_10.30%5D=&cell%5Bwednesday_10.30%5D=&cell%5Bthursday_10.30%5D=&cell%5Bfriday_10.30%5D=&cell%5Bsaturday_10.30%5D=&cell%5Bsunday_10.30%5D=&cell%5Bmonday_11.00%5D=&cell%5Btuesday_11.00%5D=&cell%5Bwednesday_11.00%5D=&cell%5Bthursday_11.00%5D=&cell%5Bfriday_11.00%5D=&cell%5Bsaturday_11.00%5D=&cell%5Bsunday_11.00%5D=&cell%5Bmonday_11.30%5D=&cell%5Btuesday_11.30%5D=&cell%5Bwednesday_11.30%5D=&cell%5Bthursday_11.30%5D=&cell%5Bfriday_11.30%5D=&cell%5Bsaturday_11.30%5D=&cell%5Bsunday_11.30%5D=&cell%5Bmonday_12.00%5D=&cell%5Btuesday_12.00%5D=&cell%5Bwednesday_12.00%5D=&cell%5Bthursday_12.00%5D=&cell%5Bfriday_12.00%5D=&cell%5Bsaturday_12.00%5D=&cell%5Bsunday_12.00%5D=&cell%5Bmonday_12.30%5D=&cell%5Btuesday_12.30%5D=&cell%5Bwednesday_12.30%5D=&cell%5Bthursday_12.30%5D=&cell%5Bfriday_12.30%5D=&cell%5Bsaturday_12.30%5D=&cell%5Bsunday_12.30%5D=&cell%5Bmonday_13.00%5D=&cell%5Btuesday_13.00%5D=&cell%5Bwednesday_13.00%5D=&cell%5Bthursday_13.00%5D=&cell%5Bfriday_13.00%5D=&cell%5Bsaturday_13.00%5D=&cell%5Bsunday_13.00%5D=&cell%5Bmonday_13.30%5D=&cell%5Btuesday_13.30%5D=&cell%5Bwednesday_13.30%5D=&cell%5Bthursday_13.30%5D=&cell%5Bfriday_13.30%5D=&cell%5Bsaturday_13.30%5D=&cell%5Bsunday_13.30%5D=&cell%5Bmonday_14.00%5D=&cell%5Btuesday_14.00%5D=&cell%5Bwednesday_14.00%5D=&cell%5Bthursday_14.00%5D=&cell%5Bfriday_14.00%5D=&cell%5Bsaturday_14.00%5D=&cell%5Bsunday_14.00%5D=&cell%5Bmonday_14.30%5D=&cell%5Btuesday_14.30%5D=&cell%5Bwednesday_14.30%5D=&cell%5Bthursday_14.30%5D=&cell%5Bfriday_14.30%5D=&cell%5Bsaturday_14.30%5D=&cell%5Bsunday_14.30%5D=&cell%5Bmonday_15.00%5D=&cell%5Btuesday_15.00%5D=&cell%5Bwednesday_15.00%5D=&cell%5Bthursday_15.00%5D=&cell%5Bfriday_15.00%5D=&cell%5Bsaturday_15.00%5D=&cell%5Bsunday_15.00%5D=&cell%5Bmonday_15.30%5D=&cell%5Btuesday_15.30%5D=&cell%5Bwednesday_15.30%5D=&cell%5Bthursday_15.30%5D=&cell%5Bfriday_15.30%5D=&cell%5Bsaturday_15.30%5D=&cell%5Bsunday_15.30%5D=&cell%5Bmonday_16.00%5D=&cell%5Btuesday_16.00%5D=&cell%5Bwednesday_16.00%5D=&cell%5Bthursday_16.00%5D=&cell%5Bfriday_16.00%5D=&cell%5Bsaturday_16.00%5D=&cell%5Bsunday_16.00%5D=&cell%5Bmonday_16.30%5D=&cell%5Btuesday_16.30%5D=&cell%5Bwednesday_16.30%5D=&cell%5Bthursday_16.30%5D=&cell%5Bfriday_16.30%5D=&cell%5Bsaturday_16.30%5D=&cell%5Bsunday_16.30%5D=&cell%5Bmonday_17.00%5D=&cell%5Btuesday_17.00%5D=&cell%5Bwednesday_17.00%5D=&cell%5Bthursday_17.00%5D=&cell%5Bfriday_17.00%5D=&cell%5Bsaturday_17.00%5D=&cell%5Bsunday_17.00%5D=&cell%5Bmonday_17.30%5D=&cell%5Btuesday_17.30%5D=&cell%5Bwednesday_17.30%5D=&cell%5Bthursday_17.30%5D=&cell%5Bfriday_17.30%5D=&cell%5Bsaturday_17.30%5D=&cell%5Bsunday_17.30%5D=&cell%5Bmonday_18.00%5D=&cell%5Btuesday_18.00%5D=&cell%5Bwednesday_18.00%5D=&cell%5Bthursday_18.00%5D=&cell%5Bfriday_18.00%5D=&cell%5Bsaturday_18.00%5D=&cell%5Bsunday_18.00%5D=&cell%5Bmonday_18.30%5D=&cell%5Btuesday_18.30%5D=&cell%5Bwednesday_18.30%5D=&cell%5Bthursday_18.30%5D=&cell%5Bfriday_18.30%5D=&cell%5Bsaturday_18.30%5D=&cell%5Bsunday_18.30%5D=&cell%5Bmonday_19.00%5D=&cell%5Btuesday_19.00%5D=&cell%5Bwednesday_19.00%5D=&cell%5Bthursday_19.00%5D=&cell%5Bfriday_19.00%5D=&cell%5Bsaturday_19.00%5D=&cell%5Bsunday_19.00%5D=&cell%5Bmonday_19.30%5D=&cell%5Btuesday_19.30%5D=&cell%5Bwednesday_19.30%5D=&cell%5Bthursday_19.30%5D=&cell%5Bfriday_19.30%5D=&cell%5Bsaturday_19.30%5D=&cell%5Bsunday_19.30%5D=&cell%5Bmonday_20.00%5D=&cell%5Btuesday_20.00%5D=&cell%5Bwednesday_20.00%5D=&cell%5Bthursday_20.00%5D=&cell%5Bfriday_20.00%5D=&cell%5Bsaturday_20.00%5D=&cell%5Bsunday_20.00%5D=&cell%5Bmonday_20.30%5D=&cell%5Btuesday_20.30%5D=&cell%5Bwednesday_20.30%5D=&cell%5Bthursday_20.30%5D=&cell%5Bfriday_20.30%5D=&cell%5Bsaturday_20.30%5D=&cell%5Bsunday_20.30%5D=&cell%5Bmonday_21.00%5D=&cell%5Btuesday_21.00%5D=&cell%5Bwednesday_21.00%5D=&cell%5Bthursday_21.00%5D=&cell%5Bfriday_21.00%5D=&cell%5Bsaturday_21.00%5D=&cell%5Bsunday_21.00%5D=&cell%5Bmonday_21.30%5D=&cell%5Btuesday_21.30%5D=&cell%5Bwednesday_21.30%5D=&cell%5Bthursday_21.30%5D=&cell%5Bfriday_21.30%5D=&cell%5Bsaturday_21.30%5D=&cell%5Bsunday_21.30%5D=&cell%5Bmonday_22.00%5D=&cell%5Btuesday_22.00%5D=&cell%5Bwednesday_22.00%5D=&cell%5Bthursday_22.00%5D=&cell%5Bfriday_22.00%5D=&cell%5Bsaturday_22.00%5D=&cell%5Bsunday_22.00%5D=&cell%5Bmonday_22.30%5D=&cell%5Btuesday_22.30%5D=&cell%5Bwednesday_22.30%5D=&cell%5Bthursday_22.30%5D=&cell%5Bfriday_22.30%5D=&cell%5Bsaturday_22.30%5D=&cell%5Bsunday_22.30%5D=&cell%5Bmonday_23.00%5D=&cell%5Btuesday_23.00%5D=&cell%5Bwednesday_23.00%5D=&cell%5Bthursday_23.00%5D=&cell%5Bfriday_23.00%5D=&cell%5Bsaturday_23.00%5D=&cell%5Bsunday_23.00%5D=&cell%5Bmonday_23.30%5D=&cell%5Btuesday_23.30%5D=&cell%5Bwednesday_23.30%5D=&cell%5Bthursday_23.30%5D=&cell%5Bfriday_23.30%5D=&cell%5Bsaturday_23.30%5D=&cell%5Bsunday_23.30%5D=&offer%5Bhourly_rate%5D=23.71&offer%5Btotal_hours%5D=3.5&offer%5Bweekly_offer%5D=82.98&offer%5Bmonthly_hours%5D=0&offer%5Bmonthly_offer%5D=331.92&offer%5Byearly_hours%5D=0&offer%5Byearly_offer%5D=3983.06&programmer_ids=8&offernote=&url=&commit=    
    //if($_POST['monthly_hours']> 0.00){
    //    $monthly_hours = $_POST['monthly_hours'];
    //}else{
    //    $error = 1;
    //    $error_msg .= 'Monthly hours must be calculated<br>';
    //}
    
    //if($_POST['offer']['monthly_offer']> 0.00){
    //    $monthly_hours = $_POST['offer']['monthly_offer'];
    //}else{
    //    $error = 1;
    //    $error_msg .= 'Monthly hours must be calculated<br>';
    //}
    //if($_POST['offer']['yearly_offer']> 0.00){
    //    $yearly_hours = $_POST['offer']['yearly_offer'];
    //}else{
    //    $error = 1;
    //    $error_msg .= 'Yearly hours must be calculated<br>';
    //}
    if($_POST['availabledate']){
        $availabledate = $_POST['availabledate'];
    }
    if($_POST['offernote']){
        $offernote = $_POST['offernote'];
    }
    if($_POST['offernotetwo']){
        $offernotetwo = $_POST['offernotetwo'];
    }
    if($_POST['programmer_ids']> 0.00){
        $programmer_ids = $_POST['programmer_ids'];
    }else{
        $error = 1;
        $error_msg .= 'A programmer must be selected<br>';
    }
}
if(isset($_POST['edit'])){
    if(!$error){
    //echo "editttttt";
//echo "monday".$_POST['monday_00.00'];
//echo "Tues".$_POST['monday_00.00'];
//echo "Tues".$_POST['cell[monday_00.00]'];
//echo "s".$_POST['cell']['monday_00.00'];
//
//foreach ($_POST['cell'] as $i => $value) {
//    echo "CArrayData[$i] is $value<br />";
//}
//foreach ($_POST['offer'] as $i => $value) {
//    echo "OArrayData[$i] is $value<br />";
//}
        $offerid = $_POST['edit'];
    
        #$times = array('00.00','00.30','01.00');
        $timeend = array('00','30');
        $hours = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
        #$hours = array('00','01');
        $days = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
        #$days = array('monday','tuesday');
        $sql_string = '';
        
        foreach($hours as $hourval) {
            foreach($days as $dayval) {
                foreach($timeend as $timeendval) {
                    $daytime = $dayval."_".$hourval.".".$timeendval;
                    $sql_string .= "`".$daytime."`=";
                    if($_POST['cell'][$daytime]){
                        $sql_string .= 1;
                    }else{
                        $sql_string .= 0;
                    }
                    if(($hourval == '23') && ($timeendval == '30') && ($dayval == 'sunday')){
                        #$sql_string .= ", ";
                    }else{
                        $sql_string .= ", ";
                    }
                    #echo "`".$dayval."_".$hourval.".".$timeendval."` tinyint(1) DEFAULT NULL,<BR>";
                    #$sql_string .= "`".$daytime."`=";
                }
            }
        }
        
        //foreach($times as $timeval) {
        //    foreach($days as $dayval) {
        //        #print $dayval."_".$timeval;
        //        $daytime = $dayval."_".$timeval;
        //        $sql_string .= "`".$daytime."`=";
        //        $sql_string .= $_POST['cell'][$daytime];
        //        if($dayval !== 'sunday'){
        //            $sql_string .= ", ";
        //        }
        //    }
        //}
        //#UPDATE g_offers SET monday_00.00=1, tuesday_00.00=1, saturday_00.00=1, sunday_00.00=1 WHERE id='1'
        #print $sql_string;
        
        $s_query = sprintf("UPDATE g_offers SET $sql_string WHERE id='$offerid';");
        //#$s_query = sprintf("UPDATE offertable SET monday_00.00=".$_POST['cell']['monday_00.00']." WHERE id='$id';");
        $s_result = mysql_query($s_query);
        $s_query = sprintf("UPDATE g_offers SET offer_dollar_amount='$offer_dollar_amount', hourly_rate = '$hourly_rate', weekly_rate = '$weekly_rate', monthly_rate = '$monthly_rate', yearly_rate = '$yearly_rate' WHERE id='$offerid';");
        $s_result = mysql_query($s_query);
        $s_query = sprintf("UPDATE g_offers SET weekly_hours = '$weekly_hours', monthly_hours = '$monthly_hours', yearly_hours = '$yearly_hours', programmer_ids='$programmer_ids', updatedat='$updatedat', offernote='$offernote', offernotetwo='$offernotetwo', availabledate='$availabledate' WHERE id='$offerid';");
        $s_result = mysql_query($s_query);
        
        #$offer_dollar_amount = $hourly_rate = $weekly_rate = $monthly_rate = $yearly_rate = '0.00';
    }
}


if(isset($_POST['new'])){
    if(!$error){
        $baseQuery = "INSERT INTO `g_offers` (`username`,`outletid`,`offer_dollar_amount`,`createdat`,`offernote`,`offernotetwo`,`availabledate`) VALUES('%s','%s','%s','%s','%s','%s','%s');";
        $result = mysql_query(sprintf($baseQuery,$username,$outletid,$offer_dollar_amount,$createdat,$offernote,$offernotetwo,$availabledate)) or die(mysql_error());
        
        $offerid = mysql_insert_id();
        #$offer_dollar_amount = '';
    
        $timeend = array('00','30');
        $hours = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
        $days = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
        $sql_string = '';
        
        foreach($hours as $hourval) {
            foreach($days as $dayval) {
                foreach($timeend as $timeendval) {
                    $daytime = $dayval."_".$hourval.".".$timeendval;
                    $sql_string .= "`".$daytime."`=";
                    if($_POST['cell'][$daytime]){
                        $sql_string .= 1;
                    }else{
                        $sql_string .= 0;
                    }
                    if(($hourval == '23') && ($timeendval == '30') && ($dayval == 'sunday')){
                        #$sql_string .= ", ";
                    }else{
                        $sql_string .= ", ";
                    }
                    #echo "`".$dayval."_".$hourval.".".$timeendval."` tinyint(1) DEFAULT NULL,<BR>";
                    #$sql_string .= "`".$daytime."`=";
                }
            }
        }
        
        //foreach($times as $timeval) {
        //    foreach($days as $dayval) {
        //        #print $dayval."_".$timeval;
        //        $daytime = $dayval."_".$timeval;
        //        $sql_string .= "`".$daytime."`=";
        //        $sql_string .= $_POST['cell'][$daytime];
        //        if($dayval !== 'sunday'){
        //            $sql_string .= ", ";
        //        }
        //    }
        //}
        //#UPDATE g_offers SET monday_00.00=1, tuesday_00.00=1, saturday_00.00=1, sunday_00.00=1 WHERE id='1'
        #print $sql_string;
        $s_query = sprintf("UPDATE g_offers SET $sql_string WHERE id='$offerid';");
        //#$s_query = sprintf("UPDATE offertable SET monday_00.00=".$_POST['cell']['monday_00.00']." WHERE id='$id';");
        $s_result = mysql_query($s_query);
        
        $s_query = sprintf("UPDATE g_offers SET offer_dollar_amount='$offer_dollar_amount', hourly_rate = '$hourly_rate', weekly_rate = '$weekly_rate', monthly_rate = '$monthly_rate', yearly_rate = '$yearly_rate' WHERE id='$offerid';");
        $s_result = mysql_query($s_query);
        $s_query = sprintf("UPDATE g_offers SET weekly_hours = '$weekly_hours', monthly_hours = '$monthly_hours', yearly_hours = '$yearly_hours', programmer_ids='$programmer_ids', offernote='$offernote', offernotetwo='$offernotetwo', availabledate='$availabledate' WHERE id='$offerid';");
        $s_result = mysql_query($s_query);
        
        #$error_msg = "New Outlet submited successfully";
        $error_msg = 'New Offer submited successfully';
        unset($_POST['new']);
        #header("location:outlets.php?msg=1");
        #exit();
    }else{
        //$error_msg = ''.$error_msg.'</div>';        
    }
}    

if(strlen($error_msg) > 0){
        $error_msg = '<div id="error_explanation">'.$error_msg.'</div>';
}

$grossratetext = '';

$ratetext = '<div class="details_div">
		Average Hourly Rate: <span id=\'hourly_rate\'>'.$hourly_rate.'</span>
		<input id="offer_hourly_rate" name="offer[hourly_rate]" type="hidden" value="'.$hourly_rate.'" />
		<div class="rate">
			<table>
				<tr>
					<th>Offer</th>
					<th>hours</th>
					<th>rate</th>
				</tr>
				<tr>
					<td>Weekly</td>
					<td>
							<span id="weekly_hours">'.$weekly_hours.'</span>
							<input id="offer_total_hours" name="offer[total_hours]" type="hidden" value="'.$weekly_hours.'" />
					</td>
					<td>
						<span id="weekly_rate">$'.number_format($weekly_rate,2).'</span>
						<input id="offer_weekly_offer" name="offer[weekly_offer]" type="hidden" value="'.$weekly_rate.'" />
					</td>
				</tr>

				<tr>
					<td>Monthly</td>
					<td>
						<span id="monthly_hours">'.$monthly_hours.'</span>
                                                <input id="offer_monthly_òffer" name="offer[monthly_òffer]" type="hidden" value="'.$monthly_hours.'" />
					</td>
					<td>
						<span id="monthly_rate">$'.number_format($monthly_rate,2).'</span>
						<input id="offer_monthly_offer" name="offer[monthly_offer]" type="hidden" value="'.$monthly_rate.'" />
					</td>
				</tr>

				<tr>
					<td>Yearly</td>
					<td>
						<span id="yearly_hours">'.$yearly_hours.'</span>
                                                <input id="offer_yearly_hours" name="offer[yearly_hours]" type="hidden" value="'.$yearly_hours.'" />                                                
					</td>
					<td>
						<span id="yearly_rate">$'.number_format($yearly_rate,2).'</span>
						<input id="offer_yearly_offer" name="offer[yearly_offer]" type="hidden" value="'.$yearly_rate.'" />
					</td>
				</tr>
			</table>


			<div>
				<a href="#" id="calculate"><img alt="Calculate" src="assets/calculate.png" /></a>
				<a href="#" id="reset"><img alt="Reset" src="assets/reset.png" /></a>
			</div>
			<hr/>

		</div> <!-- end rate div -->
                '.$programmers_select.'&nbsp;&nbsp;
		<a href="programmer.php?new=1">Add a Programmer</a>
		<br/>
                <B>Add a Note to Gross Rate Worksheet</B>:<br/>
                <textarea rows="4" cols="75" name="offernote">'.$offernote.'</textarea>
		<br/>
                <B>Add a Note after Dayparts</B>:<br/>
                <textarea rows="4" cols="75" name="offernotetwo">'.$offernotetwo.'</textarea>
		<br/>                
                <B>Available Date</B>:<br/>
                <input id="availabledate" name="availabledate" type="text" width=100 value="'.$availabledate.'">';
		$ratetext .= "<a href=\"javascript:NewCal('availabledate','mmddyyyy')\">";
		$ratetext .= '<img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>		
			<hr/></input>
		<input type="hidden" name="url" value="" />
		<input name="commit" style="" type="submit" value="" />
		<a href="#" onclick="displayError(); return false;" style="display:none;"><img alt="Submit" src="assets/submit-9f7b3f6cfaf02581ab70f78c033e8bc8.png" /></a>
			<hr/>
	</div> <!-- end details_div -->';
        
        



if( (isset($_GET['new'])) || (isset($_POST['new'])) ){
echo '
    <div id="content">
    <p class="notice"></p>
      <p class="alert"></p>
        <form accept-charset="UTF-8" action="offers.php" class="edit_offer" id="edit_offer_13" method="post">
        '.$error_msg.'
        <div style="margin:0;padding:0;display:inline">
        <input name="new" type="hidden" value="1" />
        <input name="outletid" type="hidden" value="'.$outletid.'" />
        <input name="offerid" type="hidden" value="'.$offerid.'" />        
        </div>
	<div class="outlet_info">
                <h3><b>'.$outlet_name.'</b></h3>        
		<div class="outlet_link">
				<a href="outlets.php?edit='.$outletid.'">edit</a> |
				<a href="outlets.php?new=1">new</a>
		</div>
		<div class="outlet_field">
			Market: '.$dmatext.'
		</div>
		<div class="outlet_field">
			Subs: <span id="subs">'.number_format($outlet_totalhomes,0).'</span>
		</div>
	</div> <!-- end div outlet_info -->

	<div>
		Dollar amount *: $
		<input id="offer_dollar_amount" name="offer_dollar_amount" size="30" type="text" value="'.$offer_dollar_amount.'" />
	</div>
        <!--
	<a href="/offers/13/notes">Show notes</a>
        -->
	<div style="padding-left: 427px">
		<input id="all_week" name="all_week" type="checkbox" value="yes" /> 24 hours
	</div>
	<div class="hours_div">
		<table class="table" id="form_table">
			<tr>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
				<th>Saturday</th>
				<th>Sunday</th>
			</tr>';
//echo "HERE".$offerid;
    $t_query = sprintf("SELECT `g_rates_new`.`ratehour`, `g_rates_new`.`ampm`, `g_rates_new`.`mon`, `g_rates_new`.`tue`, `g_rates_new`.`wed`, `g_rates_new`.`thurs`, `g_rates_new`.`fri`, `g_rates_new`.`sat`, `g_rates_new`.`sun`, `g_offers`.* FROM g_rates_new,g_offers WHERE `g_offers`.`id`=$offerid ORDER BY `g_rates_new`.`id` ASC;");
    //$t_query = sprintf("SELECT * FROM g_rates_new ORDER BY id ASC;");
    $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
    while($t_row = mysql_fetch_array($t_result)) {
#echo '<!--<tr>';
echo '<tr>';
        $ratehour = $t_row['ratehour'];
        //$ratehour_withdot = preg_replace('/:/', '.', $ratehour);
        $ratehour_withdot = $ratehour;        
        $ratehour_nodot = preg_replace('/[^\da-z]/i', '', $ratehour);
        if($t_row['ampm'] !== 'AM'){
            //$ratehour .= "PM";
        }
        $monclickcell = $tueclickcell = $wedclickcell = $thursclickcell = $friclickcell = $satclickcell = $sunclickcell = '';
        $monval = $tueval = $wedval = $thursval = $frival = $satval = $sunval = '';
        $daytime = "monday_".$ratehour_withdot;
/*        
        if($t_row[$daytime]>0){
            $monclickcell = 'clicked_cell';
            $monval = 1;
        }
        $daytime = "tuesday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $tueclickcell = 'clicked_cell';
            $tueval = 1;
        }
        $daytime = "wednesday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $wedclickcell = 'clicked_cell';
            $wedval = 1;
        }
        $daytime = "thursday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $thursclickcell = 'clicked_cell';
            $thursval = 1;
        }
        $daytime = "friday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $friclickcell = 'clicked_cell';
            $frival = 1;
        }
        $daytime = "saturday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $satclickcell = 'clicked_cell';
            $satval = 1;
        }
        $daytime = "sunday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $sunclickcell = 'clicked_cell';
            $sunval = 1;
        }
*/        
        #$dayandtime = 'monday_'.$ratehour;
        #echo $t_row[$dayandtime];
        echo '
            <td><div id="hour_id_monday_'.$ratehour_nodot.'_'.$t_row['mon'].'" class="'.$monclickcell.'">
            '.$ratehour.'
            <input id="cell_monday_'.$ratehour_withdot.'" name="cell[monday_'.$ratehour_withdot.']" type="hidden" value="'.$monval.'" />
            </div></td>
            <td><div id="hour_id_tuesday_'.$ratehour_nodot.'_'.$t_row['tue'].'" class="'.$tueclickcell.'">
               '.$ratehour.'
               <input id="cell_tuesday_'.$ratehour_withdot.'" name="cell[tuesday_'.$ratehour_withdot.']" type="hidden" value="'.$tueval.'" />
            </div></td>
            <td><div id="hour_id_wednesday_'.$ratehour_nodot.'_'.$t_row['wed'].'" class="'.$wedclickcell.'">
            '.$ratehour.'
            <input id="cell_wednesday_'.$ratehour_withdot.'" name="cell[wednesday_'.$ratehour_withdot.']" type="hidden" value="'.$wedval.'" />
            </div></td>
            <td><div id="hour_id_thursday_'.$ratehour_nodot.'_'.$t_row['thurs'].'" class="'.$thursclickcell.'">
            '.$ratehour.'
            <input id="cell_thursday_'.$ratehour_withdot.'" name="cell[thursday_'.$ratehour_withdot.']" type="hidden" value="'.$thursval.'" />
            </div></td>
            <td><div id="hour_id_friday_'.$ratehour_nodot.'_'.$t_row['fri'].'" class="'.$friclickcell.'">
            '.$ratehour.'
            <input id="cell_friday_'.$ratehour_withdot.'" name="cell[friday_'.$ratehour_withdot.']" type="hidden" value="'.$frival.'" />
            </div></td>
            <td><div id="hour_id_saturday_'.$ratehour_nodot.'_'.$t_row['sat'].'" class="'.$satclickcell.'">
            '.$ratehour.'
            <input id="cell_saturday_'.$ratehour_withdot.'" name="cell[saturday_'.$ratehour_withdot.']" type="hidden" value="'.$satval.'" />
            </div></td>
            <td><div id="hour_id_sunday_'.$ratehour_nodot.'_'.$t_row['sun'].'" class="'.$sunclickcell.'">
            '.$ratehour.'
            <input id="cell_sunday_'.$ratehour_withdot.'" name="cell[sunday_'.$ratehour_withdot.']" type="hidden" value="'.$sunval.'" />
            </div></td>
            ';
#echo '</tr>-->';
echo '</tr>';
    }

echo '                
		</table>
	</div>
        '.$ratetext.'
</form>
<div class="clr">&nbsp;</div>
			</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';

exit();
    
}else{
    $outletlink = '<a href="outlets.php?edit='.$outletid.'">edit</a> | <a href="outlets.php?new=1">new</a>';
    $dollaramounttext = '<input id="offer_dollar_amount" name="offer_dollar_amount" size="30" type="text" value="'.$offer_dollar_amount.'" />';
    
    $display = 1;
    if(isset($_GET['display'])){
        $outletlink = '';
        $dollaramounttext = $offer_dollar_amount;
//	<h3>Rate</h3>
//	Hours: '.$totalhours.' <br>
//	% Selected: '.$percentselected.' <br>        
//	Hour rate: $'.$hourly_rate.'<br>
//	Weekly rate: $'.number_format($weekly_rate,2).'<br>
//	Monthly rate: $'.number_format($monthly_rate,2).'<br>
//	Yearly rate: $'.number_format($yearly_rate,2).'<br>
//        <hr></hr>
        $weeklyhours = $totalhours;
        $monthlyhours = $totalhours * 4;
        $yearlyhours = $totalhours * 52;
        $MVPDSubscriberRate = $MVPDOTA = $FULLTIMEEQ = '';
        if($outlet_totalhomes > 0){
            if($outlet_subs > 0){
               #$MVPDSubscriberRate = number_format(($outlet_subs/$outlet_totalhomes)*$hourly_rate,2);
               $MVPDSubscriberRate = '$'.number_format($outlet_subs*$offer_dollar_amount,2);
            }
            if($outlet_overair > 0){
               #$MVPDOTA = number_format(($outlet_overair/$outlet_totalhomes)*$hourly_rate,2);
	       $MVPDOTA = '$'.number_format($outlet_overair*$offer_dollar_amount,2);
            }
	    if($totalpercent>0){
		$FULLTIMEEQ = '$'.number_format($offer_dollar_amount/$totalpercent,2);
		#$offer_dollar_amount = 0.215;
		#$FULLTIMEEQ = $offer_dollar_amount." ".$totalpercent." = ".($offer_dollar_amount*$totalpercent/100);
		#$FULLTIMEEQ = ($offer_dollar_amount*$totalpercent/100);
		$FULLTIMEEQ = '$'.number_format($offer_dollar_amount/$totalpercent,2);
		#$FULLTIMEEQ = $offer_dollar_amount." ".$totalpercent;
	    }
        }
        
        $grossratetext = '
                <b><h3>Gross Rate Worksheet</h3></b>
                <table border=0 cellpadding=0 cellspacing=0 width="80%">
                <tr><td>24/7 MVPD Sub Estimate</td><td>$'.$dollaramounttext.'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>                
                <tr><td>Half Hour Rate</td><td>$'.number_format($hourly_rate/2,2).'</td><td>&nbsp;</td><td>Hour Rate</td><td>$'.$hourly_rate.'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td>MVPD Subscriber Rate</td><td>$'.$MVPDSubscriberRate.'</td><td>&nbsp;</td><td>MVPD-OTA Sub Rate:</td><td>$'.$MVPDOTA.'</td><td>&nbsp;</td><td>Total Homes 24/7 Rate</td><td>$'.$hourly_rate.'</td></tr>
                <tr><td>Weekly Hours</td><td>'.$weeklyhours.'</td><td>&nbsp;</td><td>Monthly Hours</td><td>'.$monthlyhours.'</td><td>&nbsp;</td><td>Yearly Hours</td><td>'.$yearlyhours.'</td></tr>
                <tr><td>Weekly Rate</td><td>$'.number_format($weekly_rate,2).'</td><td>&nbsp;</td><td>Monthly Rate</td><td>$'.number_format($monthly_rate,2).'</td><td>&nbsp;</td><td>Yearly Rate:</td><td>$'.number_format($yearly_rate,2).'</td></tr>
                </table><BR>';
	$grossratetext = '';		
        #if($offernote){
        #    $grossratetext .= $offernote.'<br><BR>';
        #}
	
        $ratetext = '
        <table width=35% border=0 padding="0" text-align="left">
        <tbody>
	<!--
        <tr><td>MVPD subscriber</td><td style="align:left"></td></tr>
	<tr><td>over the air homes</td style="text-align:left"><td></td></tr>
	<tr><td>Total subs / homes</td style="text-align:left"><td></td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	-->
        <tr><td>Twenty-four hour sub/home est.</td><td>$'.$dollaramounttext.'</td></tr>
	<tr><td>Half Hour Rate (Avg.)</td><td><b>$'.number_format($hourly_rate/2,2).'</b></td></tr>
	<tr><td>Hour Rate (Avg.)</td><td><b>$'.$hourly_rate.'</b></td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>Subs Annual Rate</td><td>'.$MVPDSubscriberRate.'</td></tr>
	<tr><td>OTA Annual Rate</td><td>'.$MVPDOTA.'</td></tr>
	<tr><td>Full Time Equivalent:</td><td>'.$FULLTIMEEQ.'</td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>Weekly Hours</td><td>'.$weeklyhours.'</td></tr>
	<tr><td>Monthly Hours</td><td>'.$monthlyhours.'</td></tr>
	<tr><td>Yearly Hours</td><td>'.$yearlyhours.'</td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>Weekly Rate</td><td><b>$'.number_format($weekly_rate,2).'</b></td></tr>
	<tr><td>Monthly Rate</td><td><b>$'.number_format($monthly_rate,2).'</b></td></tr>
	<tr><td>Yearly Rate</td><td><b>$'.number_format($yearly_rate,2).'</b></td></tr>
        </tbody>
        </table>';
        if($offernote){
            $ratetext .= '<BR>'.$offernote.'<BR>';
        }

	
        $overnights_rate = $latenight_rate = $latenews_rate = $nationalprimetime_rate = $localprimetime_rate = $eveningnews_rate = $daytime_rate = $earlymorning_rate ='';
        $hours_d = $overnights_hours_d = $latenight_hours_d = $latenews_hours_d = $nationalprimetime_hours_d = $localprimetime_hours_d = $eveningnews_hours_d = $daytime_hours_d = $earlymorning_hours_d = '';
	
        if($totalhours > 0){
            if($earlymorning_hours>0){
                #$earlymorning_rate = '$'.number_format( ($earlymorning_hours/$totalhours)*$hourly_rate,2);
		$earlymorning_rate = '$'.number_format( ($earlymorning_cost_tmp_tmp/$earlymorning_hours),2);
		$earlymorning_hours_d = round($earlymorning_hours/7,2);
            }
            if($daytime_hours>0){
                #$daytime_rate = '$'.number_format( ($daytime_hours/$totalhours)*$hourly_rate,2);
		$daytime_rate = '$'.number_format( ($daytime_cost_tmp_tmp/$daytime_hours),2);
		$daytime_hours_d = round($daytime_hours/7,2);
            }
            if($eveningnews_hours>0){
                #$eveningnews_rate = '$'.number_format( ($eveningnews_hours/$totalhours)*$hourly_rate,2);
		$eveningnews_rate = '$'.number_format( ($eveningnews_cost_tmp_tmp/$eveningnews_hours),2);
		$eveningnews_hours_d = round($eveningnews_hours/7,2);
            }
            if($localprimetime_hours>0){
                #$localprimetime_rate = '$'.number_format( ($localprimetime_hours/$totalhours)*$hourly_rate,2);
		$localprimetime_rate = '$'.number_format( ($localprimetime_cost_tmp_tmp/$localprimetime_hours),2);
		$localprimetime_hours_d = round($localprimetime_hours/7,2);
            }
            if($nationalprimetime_hours>0){
                #$nationalprimetime_rate = '$'.number_format( ($nationalprimetime_hours/$totalhours)*$hourly_rate,2);
		$nationalprimetime_rate = '$'.number_format( ($nationalprimetime_cost_tmp_tmp/$nationalprimetime_hours),2);
		$nationalprimetime_hours_d = round($nationalprimetime_hours/7,2);
            }
            if($latenews_hours>0){
                #$latenews_rate = '$'.number_format( ($latenews_hours/$totalhours)*$hourly_rate,2);
		$latenews_rate = '$'.number_format( ($latenews_cost_tmp_tmp/$latenews_hours),2);
		$latenews_hours_d = round($latenews_hours/7,2);
            }
            if($latenight_hours>0){
                #$latenight_rate = '$'.number_format( ($latenight_hours/$totalhours)*$hourly_rate,2);
		$latenight_rate = '$'.number_format( ($latenight_cost_tmp_tmp/$latenight_hours),2);
		$latenight_hours_d = round($latenight_hours/7,2);
            }
            if($overnights_hours>0){
                #$overnights_rate = '$'.number_format( ($overnights_hours/$totalhours)*$hourly_rate,2);
		$overnights_rate = '$'.number_format( ($overnights_cost_tmp_tmp/$overnights_hours),2);
		$overnights_hours_d = round($overnights_hours/7,2);
            }
        }
	$hours_d = $overnights_hours_d + $latenight_hours_d + $latenews_hours_d + $nationalprimetime_hours_d + $localprimetime_hours_d + $eveningnews_hours_d + $daytime_hours_d + $earlymorning_hours_d;	
	$hours_d = round($hours_d,1);
	
        $ratetext .= '
        <!-- <hr></hr>
	<h3>Dayparts</h3> -->
        <table width=80% border=0 padding="0" text-align="left">
        <tbody>
        <tr text-align="left">
                <th style="text-align:left">&nbsp;</th>
                <th style="text-align:left;border-bottom: 1px solid #AAA">Time Period&nbsp;</th>
                <th style="text-align:left;border-bottom: 1px solid #AAA">Daily Hours&nbsp;</th>		
                <th style="text-align:left;border-bottom: 1px solid #AAA">Audience&nbsp;</th>
                <th style="text-align:left;border-bottom: 1px solid #AAA">Gross Hour Rate&nbsp;</th>
                <th style="text-align:left;border-bottom: 1px solid #AAA">Weekly Hours&nbsp;</th>
                <th style="text-align:left;border-bottom: 1px solid #AAA">Gross Weekly rate&nbsp;</th>
        </tr>
        <tr><td>Early morning:</td><td>6.00am - 10.00am</td><td>'.$earlymorning_hours_d.'</td><td>'.number_format($earlymorning,1).'%</td><td>'.$earlymorning_rate.'</td><td>'.$earlymorning_hours.'</td><td>'.$earlymorning_cost.'</td></tr>
        <tr><td>Daytime:</td><td>10.00am - 4.30pm</td><td>'.$daytime_hours_d.'</td><td>'.number_format($daytime,1).'%</td><td>'.$daytime_rate.'</td><td>'.$daytime_hours.'</td><td>'.$daytime_cost.'</td></tr>
        <tr><td>Evening News:</td><td>4.30pm - 7.00pm</td><td>'.$eveningnews_hours_d.'</td><td>'.number_format($eveningnews,1).'%</td><td>'.$eveningnews_rate.'</td><td>'.$eveningnews_hours.'</td><td>'.$eveningnews_cost.'</td></tr>
        <tr><td>Local prime time:</td><td>7.00pm - 8.00pm</td><td>'.$localprimetime_hours_d.'</td><td>'.number_format($localprimetime,1).'%</td><td>'.$localprimetime_rate.'</td><td>'.$localprimetime_hours.'</td><td>'.$localprimetime_cost.'</td></tr>
        <tr><td>National prime time:</td><td>8.00pm - 11.00pm</td><td>'.$nationalprimetime_hours_d.'</td><td>'.number_format($nationalprimetime,1).'%</td><td>'.$nationalprimetime_rate.'</td><td>'.$nationalprimetime_hours.'</td><td>'.$nationalprimetime_cost.'</td></tr>
        <tr><td>Late news:</td><td>11.00pm - 11.30pm</td><td>'.$latenews_hours_d.'</td><td>'.number_format($latenews,1).'%</td><td>'.$latenews_rate.'</td><td>'.$latenews_hours.'</td><td>'.$latenews_cost.'</td></tr>
        <tr><td>Late night:</td><td>11.30pm - 1.00am</td><td>'.$latenight_hours_d.'</td><td>'.number_format($latenight,1).'%</td><td>'.$latenight_rate.'</td><td>'.$latenight_hours.'</td><td>'.$latenight_cost.'</td></tr>
        <tr><td>Overnights:</td><td>1.00am - 6.00am</td><td style="text-align:left;border-bottom: 1px solid #AAA">'.$overnights_hours_d.'</td><td style="text-align:left;border-bottom: 1px solid #AAA">'.number_format($overnights,1).'%</td><td style="text-align:left;border-bottom: 1px solid #AAA">'.$overnights_rate.'</td><td style="text-align:left;border-bottom: 1px solid #AAA">'.$overnights_hours.'</td><td style="text-align:left;border-bottom: 1px solid #AAA">'.$overnights_cost.'</td></tr>
        <tr><td><b>Total Worksheet Gross Rate</b></td><td>Total&nbsp;</td><td><b>'.$hours_d.'</b></td><td><b>'.number_format($totalpercent,1).'%</b></td><td>$'.$hourly_rate.'</td><td><b>'.$totalhours.'</b></td><td><b>'.$total_cost.'</b></td></tr>
        </tbody>
        </table>
        <BR>
        <!--<hr></hr>-->';
        if($offernotetwo){
            $ratetext .= $offernotetwo;
            $ratetext .= '<br><BR>';
        }
    }
$editoffer = '';
$ppsched = $gfw = '';     
if( (isset($_GET['display'])) ){
    $editoffer = '<b><a href="offers.php?edit='.$offerid.'&outletid='.$outletid.'">edit offer</a></b>&nbsp;&nbsp;<b><a href="offers.php?display='.$offerid.'&outletid='.$outletid.'&noheader=1" target=_blank>Print View</a></b><BR>';
    $gfw = '<table border=0 cellspacing=0 cellpadding=0 width="80%" text-align="center">
    <tr>
    <td align="left">&nbsp;</td>
    <td align="center"><h3>Grid 168 Programming Financial Worksheet</h3></td>
    <td align="right" style="text-align:left;">Bid prepared by:<BR><img src="http://www.rankbestoftv.org/acrossplatformslogo.jpg" width="280"></td>
    </tr>
    <tr height="10">
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" style="text-align:left;"></td>
    </tr>
    
    </table>';
    $ppsched = '<table border=0 cellspacing=0 cellpadding=0 width="100%" text-align="left"><tr><td><h3>Proposed Programming Schedule</h3></td></tr></table>';
}else{
    $editoffer = '';
    $gfw = '<table border=0 cellspacing=0 cellpadding=0 width="100%" text-align="center"><tr><td align="center">&nbsp;</td></tr></table>';
}

if(isset($_GET['noheader'])){
    
}else{
echo '
    <div id="content">
    <p class="notice"></p>
      <p class="alert"></p>
        <form accept-charset="UTF-8" action="offers.php" class="edit_offer" id="edit_offer_13" method="post">
        '.$error_msg.'
        <div style="margin:0;padding:0;display:inline">
        <input name="edit" type="hidden" value="'.$offerid.'" />
        <input name="outletid" type="hidden" value="'.$outletid.'" />
                               '.$editoffer.'        
        </div>
        <hr></hr>';
}

if( (isset($_GET['display'])) ){
echo '
	<div class="outlet_info">
                '.$gfw.'
		<div class="outlet_field" style="font-size:16px;line-height:20px;"><b>Media Outlet: '.$outlet_name.'</b></div>                        
		<div class="outlet_field" style="font-size:16px;line-height:20px;"><b>Market: '.$dmatext.'</b></div>
                <div class="outlet_field">Media Type: '.$outlet_type.'</div>		
		<div class="outlet_field">MVPD subs: <span id="subs">'.number_format($outlet_subs,0).'</span></div>
                <div class="outlet_field">Over the air subs: <span id="subs">'.number_format($outlet_overair,0).'</span></div>
                <div class="outlet_field" style="font-size:16px;line-height:20px;"><b>Total Homes: <span id="subs">'.number_format($outlet_totalhomes,0).'</span></b></div>
                <div class="outlet_field">Timezone: '.$outlet_timezone.'</div>
                <div class="outlet_field">Available Date: '.$availabledate.'</div>
                <!--<div class="outlet_field">Programming: '.$outlet_programming.'</div>-->
                '.$grossratetext.'
	</div> <!-- end div outlet_info -->
	';
}else{
    
echo '<div class="outlet_info">
                <h3><b>'.$outlet_name.'</b></h3>        
		<div class="outlet_link">
				<a href="outlets.php?edit='.$outletid.'">edit</a> |
				<a href="outlets.php?new=1">new</a>
		</div>
		<div class="outlet_field">
			Market: '.$dmatext.'
		</div>
		<div class="outlet_field">
			Subs: <span id="subs">'.number_format($outlet_totalhomes,0).'</span>
		</div>
	</div> <!-- end div outlet_info -->

	<div>
		Dollar amount *: $
		<input id="offer_dollar_amount" name="offer_dollar_amount" size="30" type="text" value="'.$offer_dollar_amount.'" />
	</div>
	<div style="padding-left: 427px">
		<input id="all_week" name="all_week" type="checkbox" value="yes" /> 24 hours
	</div>';
}

echo     $ratetext.'
	<div class="hours_div">
        '.$ppsched.'
		<table class="table" id="form_table">
			<tr>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
				<th>Saturday</th>
				<th>Sunday</th>
			</tr>';
    $t_query = sprintf("SELECT `g_rates_new`.`ratehour`, `g_rates_new`.`ampm`, `g_rates_new`.`mon`, `g_rates_new`.`tue`, `g_rates_new`.`wed`, `g_rates_new`.`thurs`, `g_rates_new`.`fri`, `g_rates_new`.`sat`, `g_rates_new`.`sun`, `g_offers`.* FROM g_rates_new,g_offers WHERE `g_offers`.`id`=$offerid ORDER BY `g_rates_new`.`id` ASC;");
    //$t_query = sprintf("SELECT * FROM g_rates_new ORDER BY id ASC;");
    $t_result = mysql_query($t_query) or fwrite($fh, "Line 136");
    while($t_row = mysql_fetch_array($t_result)) {
#echo '<!--<tr>';
echo '<tr>';
        $ratehour = $t_row['ratehour'];
        //$ratehour_withdot = preg_replace('/:/', '.', $ratehour);
        $ratehour_withdot = $ratehour;        
        $ratehour_nodot = preg_replace('/[^\da-z]/i', '', $ratehour);
        if($t_row['ampm'] !== 'AM'){
            //$ratehour .= "PM";
        }
        $monclickcell = $tueclickcell = $wedclickcell = $thursclickcell = $friclickcell = $satclickcell = $sunclickcell = '';
        $monval = $tueval = $wedval = $thursval = $frival = $satval = $sunval = '';
        $daytime = "monday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $monclickcell = 'clicked_cell';
            $monval = 1;
        }
        $daytime = "tuesday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $tueclickcell = 'clicked_cell';
            $tueval = 1;
        }
        $daytime = "wednesday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $wedclickcell = 'clicked_cell';
            $wedval = 1;
        }
        $daytime = "thursday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $thursclickcell = 'clicked_cell';
            $thursval = 1;
        }
        $daytime = "friday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $friclickcell = 'clicked_cell';
            $frival = 1;
        }
        $daytime = "saturday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $satclickcell = 'clicked_cell';
            $satval = 1;
        }
        $daytime = "sunday_".$ratehour_withdot;
        if($t_row[$daytime]>0){
            $sunclickcell = 'clicked_cell';
            $sunval = 1;
        }
        
        #$dayandtime = 'monday_'.$ratehour;
        #echo $t_row[$dayandtime];
        echo '
            <td><div id="hour_id_monday_'.$ratehour_nodot.'_'.$t_row['mon'].'" class="'.$monclickcell.'">
            '.$ratehour.'
            <input id="cell_monday_'.$ratehour_withdot.'" name="cell[monday_'.$ratehour_withdot.']" type="hidden" value="'.$monval.'" />
            </div></td>
            <td><div id="hour_id_tuesday_'.$ratehour_nodot.'_'.$t_row['tue'].'" class="'.$tueclickcell.'">
               '.$ratehour.'
               <input id="cell_tuesday_'.$ratehour_withdot.'" name="cell[tuesday_'.$ratehour_withdot.']" type="hidden" value="'.$tueval.'" />
            </div></td>
            <td><div id="hour_id_wednesday_'.$ratehour_nodot.'_'.$t_row['wed'].'" class="'.$wedclickcell.'">
            '.$ratehour.'
            <input id="cell_wednesday_'.$ratehour_withdot.'" name="cell[wednesday_'.$ratehour_withdot.']" type="hidden" value="'.$wedval.'" />
            </div></td>
            <td><div id="hour_id_thursday_'.$ratehour_nodot.'_'.$t_row['thurs'].'" class="'.$thursclickcell.'">
            '.$ratehour.'
            <input id="cell_thursday_'.$ratehour_withdot.'" name="cell[thursday_'.$ratehour_withdot.']" type="hidden" value="'.$thursval.'" />
            </div></td>
            <td><div id="hour_id_friday_'.$ratehour_nodot.'_'.$t_row['fri'].'" class="'.$friclickcell.'">
            '.$ratehour.'
            <input id="cell_friday_'.$ratehour_withdot.'" name="cell[friday_'.$ratehour_withdot.']" type="hidden" value="'.$frival.'" />
            </div></td>
            <td><div id="hour_id_saturday_'.$ratehour_nodot.'_'.$t_row['sat'].'" class="'.$satclickcell.'">
            '.$ratehour.'
            <input id="cell_saturday_'.$ratehour_withdot.'" name="cell[saturday_'.$ratehour_withdot.']" type="hidden" value="'.$satval.'" />
            </div></td>
            <td><div id="hour_id_sunday_'.$ratehour_nodot.'_'.$t_row['sun'].'" class="'.$sunclickcell.'">
            '.$ratehour.'
            <input id="cell_sunday_'.$ratehour_withdot.'" name="cell[sunday_'.$ratehour_withdot.']" type="hidden" value="'.$sunval.'" />
            </div></td>
            ';
#echo '</tr>-->';
echo '</tr>';
    }
echo '                
		</table>
	</div>
</form>
<div class="clr">&nbsp;</div>
			</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';

exit();
    
}


