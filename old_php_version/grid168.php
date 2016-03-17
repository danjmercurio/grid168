<?php
session_start();
if(!$_SESSION['myusername']){
header("location:main_login.php?err=2");
}

require_once ('header_html.php'); // include the database connection

$id = 1;
if(isset($_POST['edit'])){
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
    $id = $_POST['edit'];

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
    $s_query = sprintf("UPDATE g_offers SET $sql_string WHERE id='$id';");
    //#$s_query = sprintf("UPDATE offertable SET monday_00.00=".$_POST['cell']['monday_00.00']." WHERE id='$id';");
    $s_result = mysql_query($s_query);
}

echo '
    <div id="content">
    <p class="notice"></p>
      <p class="alert"></p>
        <form accept-charset="UTF-8" action="grid168.php" class="edit_offer" id="edit_offer_13" method="post">
        <div style="margin:0;padding:0;display:inline">
        <input name="edit" type="hidden" value="1" />
        </div>
	<div class="outlet_info">
		<div class="outlet_field">
			Verizon FiOS
		</div>
		<div class="outlet_link">
				<a href="/outlets/9/edit?offer_id=13">edit</a> |
				<a href="/outlets/new">new</a>
		</div>
		<div class="outlet_field">
			DMA: New York
		</div>
		<div class="outlet_field">
			Subs: <span id="subs">5,700,000</span>
		</div>
	</div> <!-- end div outlet_info -->

	<div>
		Dollar amount *: $
		<input id="offer_dollar_amount" name="offer[dollar_amount]" size="30" type="text" value="0.41" />
	</div>
	<a href="/offers/13/notes">Show notes</a>
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

    $t_query = sprintf("SELECT `g_rates`.`ratehour`, `g_rates`.`ampm`, `g_rates`.`mon`, `g_rates`.`tue`, `g_rates`.`wed`, `g_rates`.`thurs`, `g_rates`.`fri`, `g_rates`.`sat`, `g_rates`.`sun`, `g_offers`.* FROM g_rates,g_offers WHERE `g_offers`.`id`=$id ORDER BY `g_rates`.`id` ASC;");
    //$t_query = sprintf("SELECT * FROM g_rates ORDER BY id ASC;");
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
    
    
#echo '
echo '<!--
				<tr>
						<td>
            <td><div id="hour_id_monday_0000_0.005804" class="">
            00:00
            <input id="cell_monday_00.00" name="cell[monday_00.00]" value="0" type="hidden">
            </div></td>
            
                                    <div id="hour_id_monday_0000_0.005803501695927" class="clicked_cell">
                                            00:00
                                            <input id="cell_monday_00.00" name="cell[monday_00.00]" type="hidden" value="1" />
                                    </div>

						</td>
						<td>
								<div id="hour_id_tuesday_0000_0.003593688659782" class="clicked_cell">
									00:00
									<input id="cell_tuesday_00.00" name="cell[tuesday_00.00]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_wednesday_0000_0.003600048751262" class="clicked_cell">
									00:00
									<input id="cell_wednesday_00.00" name="cell[wednesday_00.00]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_thursday_0000_0.005216123178556" class="clicked_cell">
									00:00
									<input id="cell_thursday_00.00" name="cell[thursday_00.00]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_friday_0000_0.004142067779147" class="clicked_cell">
									00:00
									<input id="cell_friday_00.00" name="cell[friday_00.00]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_saturday_0000_0.00367861478438" class="clicked_cell">
									00:00
									<input id="cell_saturday_00.00" name="cell[saturday_00.00]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_sunday_0000_0.0062283526079" class="clicked_cell">
									00:00
									<input id="cell_sunday_00.00" name="cell[sunday_00.00]" type="hidden" value="1" />
								</div>
						</td>
				</tr>
				<tr>
						<td>
								<div id="hour_id_monday_0030_0.005803501695927" class="clicked_cell">
									00:30
									<input id="cell_monday_00.30" name="cell[monday_00.30]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_tuesday_0030_0.003593688659782" class="clicked_cell">
									00:30
									<input id="cell_tuesday_00.30" name="cell[tuesday_00.30]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_wednesday_0030_0.003600048751262" class="clicked_cell">
									00:30
									<input id="cell_wednesday_00.30" name="cell[wednesday_00.30]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_thursday_0030_0.005216123178556" class="clicked_cell">
									00:30
									<input id="cell_thursday_00.30" name="cell[thursday_00.30]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_friday_0030_0.004142067779147" class="clicked_cell">
									00:30
									<input id="cell_friday_00.30" name="cell[friday_00.30]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_saturday_0030_0.00367861478438" class="clicked_cell">
									00:30
									<input id="cell_saturday_00.30" name="cell[saturday_00.30]" type="hidden" value="1" />
								</div>
						</td>
						<td>
								<div id="hour_id_sunday_0030_0.0062283526079" class="clicked_cell">
									00:30
									<input id="cell_sunday_00.30" name="cell[sunday_00.30]" type="hidden" value="1" />
								</div>
						</td>
				</tr>
                -->
		</table>
	</div>
	<div class="details_div">
		Average Hourly Rate: <span id=\'hourly_rate\'>390.15</span>
		<input id="offer_hourly_rate" name="offer[hourly_rate]" type="hidden" value="390.15" />
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
							<span id="weekly_hours">77.0</span>
							<input id="offer_total_hours" name="offer[total_hours]" type="hidden" value="77.0" />
					</td>
					<td>
						<span id="weekly_rate">$30041.71</span>
						<input id="offer_weekly_offer" name="offer[weekly_offer]" type="hidden" value="30041.71" />
					</td>
				</tr>

				<tr>
					<td>Monthly</td>
					<td>
						<span id="monthly_hours">308.0</span>
					</td>
					<td>
						<span id="monthly_rate">$120166.85</span>
						<input id="offer_monthly_offer" name="offer[monthly_offer]" type="hidden" value="120166.85" />
					</td>
				</tr>

				<tr>
					<td>Yearly</td>
					<td>
						<span id="yearly_hours">4004.0</span>
					</td>
					<td>
						<span id="yearly_rate">$1442002.26</span>
						<input id="offer_yearly_offer" name="offer[yearly_offer]" type="hidden" value="1442002.26" />
					</td>
				</tr>
			</table>


			<div>
				<a href="#" id="calculate"><img alt="Calculate" src="assets/calculate-7f8f2173ed007c7f3977cf8209e276c7.png" /></a>
				<a href="#" id="reset"><img alt="Reset" src="assets/reset-1b10736c4656962c7b01dfdb0fa128ae.png" /></a>
			</div>
			<hr/>

		</div> <!-- end rate div -->
		<select id="offer_programmer_ids" multiple="multiple" name="offer[programmer_ids][]"><option value="8" selected="selected">America\'s Value Channel</option>
<option value="9">Shepherd\'s Chapel</option>
<option value="10">Gem Shopping Network </option>
<option value="11">International Programmer</option>
<option value="12">Arise News </option></select><br/>
		<a href="/programmers/new?back_url=http%3A%2F%2Fgrid168-old.herokuapp.com%2Foutlets%2F9%2Foffers%2F13%2Fedit">Add Programmer</a>
		<br/>

		<input type="hidden" name="url" value="" />
		<input name="commit" style="" type="submit" value="" />
		<a href="#" onclick="displayError(); return false;" style="display:none;"><img alt="Submit" src="assets/submit-9f7b3f6cfaf02581ab70f78c033e8bc8.png" /></a>
	</div> <!-- end details_div -->
</form>
<div class="clr">&nbsp;</div>

			</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>';

#echo phpinfo();
exit();

#echo date("h");
#echo "B".date("h");
#echo date('l jS \of F Y h:i:s A');
$errmsg = '';
function getmarketname($mktid){
    $s_query = sprintf("SELECT name FROM markets where mktid='$mktid';");
    $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");
    while($s_row = mysql_fetch_array($s_result)) {
        $name = $s_row['name'];
    }
    return $name;
}

function convdate($yy,$mm,$dd){
    if($yy < 100){
        $yy += 2000;
    }
    if($mm < 10){
        $mm = "0".$mm;
    }
    if($dd < 10){
        $dd = "0".$dd;
    }
    return $mm."/".$dd."/".$yy;
}

if(isset($_POST['id']) || isset($_GET['id'])){
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    if($_POST['platform'] == 2){
        if($_POST['checked'] > 1){    
            $s_query = sprintf("UPDATE stations_log SET checked=2 WHERE id='$id';");
        }
        if($_POST['checked'] < 2){    
            $s_query = sprintf("UPDATE stations_log SET checked=1 WHERE id='$id';");
        }
        $s_result = mysql_query($s_query);
    }
    echo "id".$id;
    if(($_POST['platform'] == 7) || ($_GET['platform'] == 7)){
        echo "XXX".$id;
        if(($_POST['checked'] > 1) || ($_GET['checked'] > 1)){
            $s_query = sprintf("UPDATE operatorchannels_log SET checked=2 WHERE id='$id';");
            echo "YYY".$id;
        }
        if($_POST['checked'] < 2){
            $s_query = sprintf("UPDATE operatorchannels_log SET checked=1 WHERE id='$id';");
            echo "ZZZ".$id;
        }
        $s_result = mysql_query($s_query);
    }
    
    #echo "DSA";
    if($_POST['platform'] == 5){
        #echo "AAA";
        if($_POST['checked'] > 1){
            #echo "B";
            $s_query = sprintf("UPDATE networkstations_log SET checked=2 WHERE id='$id';");
        }
        if($_POST['checked'] < 2){
            #echo "C";
            $s_query = sprintf("UPDATE networkstations_log SET checked=1 WHERE id='$id';");
        }
        #echo "D";        
        $s_result = mysql_query($s_query);
    }
}

if(isset($_GET['maxlimit'])){
    if($_GET['maxlimit'] > 1){    
        $s_query = sprintf("UPDATE admin_members SET maxlimit=2;");
    }
    if($_GET['maxlimit'] < 2){
        $s_query = sprintf("UPDATE admin_members SET maxlimit=1;");
    }
    $s_result = mysql_query($s_query);
}

#    $LIMIT = 'LIMIT 0,5';

$URLSELF = '';
$platform_ddhtml = '<select name="platform" style="width: 170px;" id="platform">';
if(isset($_POST['platform']) || isset($_GET['platform'])){
    if(($_POST['platform'] == 1) || ($_GET['platform'] == 1)){
        $URLSELF .= 'platform=1';
        $platform_ddhtml .= '<option value="1" selected>&nbsp;Markets</option>';
    }else{
        $platform_ddhtml .= '<option value="1">&nbsp;Markets</option>';
    }
    if(($_POST['platform'] == 6) || ($_GET['platform'] == 6)){
        $URLSELF .= 'platform=6';
        $platform_ddhtml .= '<option value="6" selected>&nbsp;Operator</option>';
    }else{
        $platform_ddhtml .= '<option value="6">&nbsp;Operator</option>';
    }
    if(($_POST['platform'] == 7) || ($_GET['platform'] == 7)){
        $URLSELF .= 'platform=7';
        $platform_ddhtml .= '<option value="7" selected>&nbsp;Station Detail</option>';
    }else{
        $platform_ddhtml .= '<option value="7">&nbsp;Station Detail</option>';
    }
    
    //if(($_POST['platform'] == 2) || ($_GET['platform'] == 2)){
    //    $URLSELF .= 'platform=2';
    //    $platform_ddhtml .= '<option value="2" selected>&nbsp;Station Detail</option>';
    //}else{
    //    $platform_ddhtml .= '<option value="2">&nbsp;Station Detail</option>';
    //}
    //if(($_POST['platform'] == 3) || ($_GET['platform'] == 3)){
    //    $URLSELF .= 'platform=3';
    //    $platform_ddhtml .= '<option value="3" selected>&nbsp;Channels</option>';
    //}else{
    //    $platform_ddhtml .= '<option value="3">&nbsp;Channels</option>';
    //}
    
    if(($_POST['platform'] == 4) || ($_GET['platform'] == 4)){
        $URLSELF .= 'platform=4';
        $platform_ddhtml .= '<option value="4" selected>&nbsp;Networks</option>';
    }else{
        $platform_ddhtml .= '<option value="4">&nbsp;Networks</option>';
    }
    if(($_POST['platform'] == 5) || ($_GET['platform'] == 5)){
        $URLSELF .= 'platform=5';
        $platform_ddhtml .= '<option value="5" selected>&nbsp;Network Detail</option>';
    }else{
        $platform_ddhtml .= '<option value="5">&nbsp;Network Detail</option>';
    }
    
    
}else{
    $platform_ddhtml .= '<option value="1">&nbsp;Markets</option>';
    $platform_ddhtml .= '<option value="6">&nbsp;Operator</option>';
    $platform_ddhtml .= '<option value="7">&nbsp;Station Detail</option>';            
    $platform_ddhtml .= '<option value="4">&nbsp;Networks</option>';
    $platform_ddhtml .= '<option value="5">&nbsp;Network Detail</option>';
}
$platform_ddhtml .= '</select>';

define('SECONDS_PER_DAY', 86400);
$today = date('d');
$tomonth = date('m');
$toyear = date('Y');
$toyear_small = date('y');
if(isset($_POST['today'])){$today = $_POST['today'];$URLSELF .= '&today='.$_POST['today'];}
elseif(isset($_GET['today'])){$today = $_GET['today'];$URLSELF .= '&today='.$_GET['today'];}

if(isset($_POST['tomonth'])){$tomonth = $_POST['tomonth'];$URLSELF .= '&tomonth='.$_POST['tomonth'];}
elseif(isset($_GET['tomonth'])){$tomonth = $_GET['tomonth'];$URLSELF .= '&tomonth='.$_GET['tomonth'];}

if(isset($_POST['toyear'])){$toyear = $_POST['toyear'];$toyear_small = $_POST['toyear'] - 2000;$URLSELF .= '&toyear='.$_POST['toyear'];}
elseif(isset($_GET['toyear'])){$toyear = $_GET['toyear'];$toyear_small = $_GET['toyear'] - 2000;$URLSELF .= '&toyear='.$_GET['toyear'];}

$fromday = date('d', time() - 7 * SECONDS_PER_DAY);
$frommonth = date('m', time() - 7 * SECONDS_PER_DAY);
$fromyear = date('Y', time() - 7 * SECONDS_PER_DAY);
$fromyear_small = date('y');
if(isset($_POST['fromday'])){$fromday = $_POST['fromday'];$URLSELF .= '&fromday='.$_POST['fromday'];}
elseif(isset($_GET['fromday'])){$fromday = $_GET['fromday'];$URLSELF .= '&fromday='.$_GET['fromday'];}

if(isset($_POST['frommonth'])){$frommonth = $_POST['frommonth'];$URLSELF .= '&frommonth='.$_POST['frommonth'];}
elseif(isset($_GET['frommonth'])){$frommonth = $_GET['frommonth'];$URLSELF .= '&frommonth='.$_GET['frommonth'];}

if(isset($_POST['fromyear'])){$fromyear = $_POST['fromyear'];$fromyear_small = $_POST['fromyear'] - 2000;$URLSELF .= '&fromyear='.$_POST['fromyear'];}
elseif(isset($_GET['fromyear'])){$fromyear = $_GET['fromyear'];$fromyear_small = $_GET['fromyear'] - 2000;$URLSELF .= '&fromyear='.$_GET['fromyear'];}

$AVAIL = 0;
if(isset($_POST['avail'])){$AVAIL = $_POST['avail'];}
elseif(isset($_GET['avail'])){$AVAIL = $_GET['avail'];}

$REVIEWED = 1;
if(isset($_POST['reviewed'])){$REVIEWED = $_POST['reviewed'];}
elseif(isset($_GET['reviewed'])){$REVIEWED = $_GET['reviewed'];}
#else{$URLSELF .= '&reviewed=1';}
#echo "X".$REVIEWED;

$LIMITHTML = '';
$AVAILHTML_0 = '';
$AVAILHTML_1 = '';
$AVAILHTML_2 = '';
$REVIEWEDHTML_0 = $REVIEWEDHTML_1 = '';

$LIMIT = '';
$e_query = sprintf("SELECT * FROM admin_members;");
$e_result = mysql_query($e_query);
while($e_row = mysql_fetch_array($e_result)) {
    if($e_row['maxlimit'] > 1){
        $LIMIT = 'LIMIT 0,100';
        $LIMITHTML = '&nbsp;&nbsp;<a href="networkschecker.php?search=1&maxlimit=1&'.$URLSELF.'">Set No Max.</a>';
        if($AVAIL == 0){
            $AVAILHTML_0 = 'Changes';
            $AVAILHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=1&'.$URLSELF.'" alt="Added Only" title="Added Only">A</a>';
            $AVAILHTML_2 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=2&'.$URLSELF.'" alt="Unavailable Only" title="Unavailable Only">U</a>';
        }
        if($AVAIL == 1){
            $AVAILHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=0&'.$URLSELF.'" alt="All Changes" title="All Changes" >Changes</a>';
            $AVAILHTML_1 = 'A';
            $AVAILHTML_2 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=2&'.$URLSELF.'" alt="Unavailable Only" title="Unavailable Only">U</a>';
        }
        if($AVAIL == 2){
            $AVAILHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=0&'.$URLSELF.'" alt="All Changes" title="All Changes" >Changes</a>';
            $AVAILHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=1&'.$URLSELF.'" alt="Added Only" title="Added Only">A</a>';
            $AVAILHTML_2 = 'U';
        }
        //if($REVIEWED != 0){
        //    $REVIEWEDHTML_0 = 'Reviewed';
        //    $REVIEWEDHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=0&reviewed=0&'.$URLSELF.'" alt="Never Reviewed" title="Never Reviewed">N</a>';
        //}else{
        //    $REVIEWEDHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=0&reviewed=1&'.$URLSELF.'" alt="Reviewed" title="Reviewed">Reviewed</a>';
        //    $REVIEWEDHTML_1 = 'N';
        //}
    }else{
        $LIMIT = '';
        $LIMITHTML = '&nbsp;&nbsp;<a href="networkschecker.php?search=1&maxlimit=2&'.$URLSELF.'">Set Max. 100 results</a>';
        if($AVAIL == 0){
            $AVAILHTML_0 = 'Changes';
            $AVAILHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=1&avail=1&'.$URLSELF.'" alt="Added Only" title="Added Only">A</a>';
            $AVAILHTML_2 = '<a href="networkschecker.php?search=1&maxlimit=1&avail=2&'.$URLSELF.'" alt="Unavailable Only" title="Unavailable Only">U</a>';
            //if($REVIEWED != 0){
            //    $REVIEWEDHTML_0 = 'Reviewed';
            //    $REVIEWEDHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=0&'.$URLSELF.'" alt="Never Reviewed" title="Never Reviewed">N</a>';
            //}else{
            //    $REVIEWEDHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=0&'.$URLSELF.'" alt="Reviewed" title="Reviewed">Reviewed</a>';
            //    $REVIEWEDHTML_1 = 'N';
            //}
        }
        if($AVAIL == 1){
            $AVAILHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=1&avail=0&'.$URLSELF.'" alt="All Changes" title="All Changes" >Changes</a>';
            $AVAILHTML_1 = 'A';
            $AVAILHTML_2 = '<a href="networkschecker.php?search=1&maxlimit=1&avail=2&'.$URLSELF.'" alt="Unavailable Only" title="Unavailable Only">U</a>';
            //if($REVIEWED != 0){
            //    $REVIEWEDHTML_0 = 'Reviewed';
            //    $REVIEWEDHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=1&'.$URLSELF.'" alt="Never Reviewed" title="Never Reviewed">N</a>';
            //}else{
            //    $REVIEWEDHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=1&'.$URLSELF.'" alt="Reviewed" title="Reviewed">Reviewed</a>';
            //    $REVIEWEDHTML_1 = 'N';
            //}
        }
        if($AVAIL == 2){
            $AVAILHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=1&avail=0&'.$URLSELF.'" alt="All Changes" title="All Changes" >Changes</a>';
            $AVAILHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=1&avail=1&'.$URLSELF.'" alt="Added Only" title="Added Only">A</a>';
            $AVAILHTML_2 = 'U';
            //if($REVIEWED != 0){
            //    $REVIEWEDHTML_0 = 'Reviewed';
            //    $REVIEWEDHTML_1 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=2&'.$URLSELF.'" alt="Never Reviewed" title="Never Reviewed">N</a>';
            //}else{
            //    $REVIEWEDHTML_0 = '<a href="networkschecker.php?search=1&maxlimit=2&avail=2&'.$URLSELF.'" alt="Reviewed" title="Reviewed">Reviewed</a>';
            //    $REVIEWEDHTML_1 = 'N';
            //}
        }
    }
}


$resulthtml = '';
$searchterm = '';
$rescount = 0;
if(isset($_POST['search']) || isset($_GET['search'])){
    if($_POST['searchterm']){
        $searchterm = $_POST['searchterm'];
    }
    
    //$datesql = 'WHERE';
    //$datesql .= ' ( '.$fromyear_small.' <= year AND year <= '.$toyear_small.')';    
    //$datesql .= ' AND ( '.$frommonth.' <= month AND month <= '.$tomonth.')';    
    //$datesql .= ' AND ( '.$fromday.' <= day AND day <= '.$today.')';

            //if($startyear > $data->{yearsold}){next;}
            //if($endyear < $data->{yearsold}){next;}
            //if($startyear == $data->{yearsold})
            //{
            //    if($startmonth > $data->{monthsold}){next;}                
            //}
            //if($endyear == $data->{yearsold})
            //{
            //    if($endmonth < $data->{monthsold}){next;}                
            //}
            //if($startyear == $data->{yearsold})
            //{
            //    if($startmonth == $data->{monthsold})
            //    {
            //            if($startday > $data->{daysold}){next;}                
            //    }                
            //}
            //if($endyear == $data->{yearsold})
            //{
            //    if($endmonth == $data->{monthsold})
            //    {
            //            if($endday < $data->{daysold}){next;}                
            //    }                
            //}

    if(($_POST['platform'] == 1) || ($_GET['platform'] == 1)){
        $e_query = sprintf("SELECT * FROM markets_log ORDER BY id DESC $LIMIT;");
        $e_result = mysql_query($e_query);
        //echo $e_query;
        $resulthtml = "<table width=\"800\" border =\"0\" cellpadding=\"0\" cellspacing =\"0\">";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>MarketID</B>&nbsp;</td><td width=\"110\" align=\"middle\"><B>Name</B>&nbsp;</td><td width=\"300\">  <B>Changes</B>&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:3px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        
        while($e_row = mysql_fetch_array($e_result)) {
            if($fromyear_small > $e_row['year']){
                    continue;
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth > $e_row['month']){
                    continue;
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth < $e_row['month']){
                    continue;
                }                
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth == $e_row['month'])
                {
                        if($fromday > $e_row['day']){continue;}               
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth == $e_row['month'])
                {
                    if($today < $e_row['day']){
                        continue;
                    }                
                }                
            }
            //echo "FYS".$fromyear_small;
            //echo "FM".$frommonth;
            //echo "FD".$fromday;
            //echo "TYS".$fromyear_small;
            //echo "TM".$tomonth;
            //echo "TD".$today;
            
            $marketname = getmarketname($e_row['mktid']);
            if($searchterm){
                if (stripos($marketname,$searchterm) !== false) {
                }else{
                    continue;
                }
            }
            
            $tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);            
            $resulthtml .= "<tr><td width=\"80\">".$tempdate."&nbsp;</td>";
            #$resulthtml .= "<tr><td width=\"80\">".$e_row['year']."-".$e_row['month']."-".$e_row['day']."&nbsp;</td>
            $resulthtml .= "<td width=\"80\" align=\"middle\"><a href=\"http://www.rabbitears.info/market.php?mktid=".$e_row['mktid']."\" target=_blank>".$e_row['mktid']."</a>&nbsp;<td width=\"160\" align=\"middle\">".$marketname."&nbsp;</td>";
            $resulthtml .= "<td width=\"300\">".$e_row['text']."</td>";                         
            $resulthtml .= '<td>&nbsp';
            $resulthtml .= '<!--<form name="formlink" method="post" action="networkschecker.php">';
            $resulthtml .= "<input type=\"hidden\" name=\"platform\" value=2>";
            $resulthtml .= "<input type=\"hidden\" name=\"today\" value=".$today.">";
            $resulthtml .= "<input type=\"hidden\" name=\"tomonth\" value=".$tomonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"toyear\" value=".$toyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromday\" value=".$fromday.">";
            $resulthtml .= "<input type=\"hidden\" name=\"frommonth\" value=".$frommonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromyear\" value=".$fromyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"search\" value=1>";            
            $resulthtml .= "<input type=\"hidden\" name=\"mktid\" value=".$e_row['mktid']."><input type=\"submit\" name=\"viewstations\" value=\">>\">";                    
            $resulthtml .= "</form> --!>";
            $resulthtml .= "&nbsp;<a href='networkschecker.php?search=1&platform=2&today=".$today."&tomonth=".$tomonth."&toyear=".$toyear."&fromday=".$fromday."&frommonth=".$frommonth."&fromyear=".$fromyear."&mktid=".$e_row['mktid']."' target=_blank>  >> </a></td>";
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:2px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
            #echo $resulthtml;
            #exit();
            $rescount++;
        }
        $resulthtml .= "</table>";
    }
    if(($_POST['platform'] == 2) || ($_GET['platform'] == 2)){        
        //echo "here";
        //exit();
        if(($_POST['mktid']) || ($_GET['mktid'])){
            if($_POST['mktid']){
                $mktid = $_POST['mktid'];
            }elseif($_GET['mktid']){
                $mktid = $_GET['mktid'];
            }
            $e_query = sprintf("SELECT * FROM operators_log WHERE mktid = ('%s') ORDER BY id DESC $LIMIT;",$mktid);
        }else{
            $e_query = sprintf("SELECT * FROM operators_log ORDER BY id DESC $LIMIT;");
        }
        $e_result = mysql_query($e_query);
        #echo $e_query;
        $resulthtml = "<table width=\"800\" border =\"0\" cellpadding=\"0\" cellspacing =\"0\">";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>MarketID</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Name</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Station</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>Display</B>&nbsp;</td><td width=\"40\"><B>Reviewed</B>&nbsp;</td><td width=\"300\"> <B>Changes</B>&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        while($e_row = mysql_fetch_array($e_result)) {
            if($fromyear_small > $e_row['year']){
                    continue;
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth > $e_row['month']){
                    continue;
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth < $e_row['month']){
                    continue;
                }                
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth == $e_row['month'])
                {
                        if($fromday > $e_row['day']){continue;}               
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth == $e_row['month'])
                {
                    if($today < $e_row['day']){
                        continue;
                    }                
                }                
            }
            
            $marketname = getmarketname($e_row['mktid']);
            $stationhtml = '';
            if($e_row['station']){
                $stationhtml = "<a href=\"http://www.rabbitears.info/market.php?request=station_search&callsign=".$e_row['station']."#station\" target=_blank>".$e_row['station']."</a>";
            }else{
                $stationhtml = $e_row['station'];
            }
            
            
            #$tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            $tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            $resulthtml .= "<tr><td width=\"80\">".$tempdate."&nbsp;</td>
            <td width=\"40\" align=\"middle\"><a href=\"http://www.rabbitears.info/market.php?mktid=".$e_row['mktid']."\" target=_blank>".$e_row['mktid']."</a>&nbsp;</td><td width=\"160\" align=\"middle\">".$marketname."&nbsp;</td><td width=\"80\" align=\"middle\">".$stationhtml."</a>&nbsp;</td><td width=\"80\" align=\"middle\">".$e_row['displaych']."</a>&nbsp;</td>";
            $resulthtml .= '<td width=\"40\"><form name="form1" method="post" action="networkschecker.php">';
            $resulthtml .= "<input type=\"hidden\" name=\"platform\" value=2>";
            $resulthtml .= "<input type=\"hidden\" name=\"today\" value=".$today.">";
            $resulthtml .= "<input type=\"hidden\" name=\"tomonth\" value=".$tomonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"toyear\" value=".$toyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromday\" value=".$fromday.">";
            $resulthtml .= "<input type=\"hidden\" name=\"frommonth\" value=".$frommonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromyear\" value=".$fromyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"search\" value=1>";            
            $resulthtml .= "<input type=\"hidden\" name=\"id\" value=".$e_row['id'].">";            
            if($e_row['checked'] > 1){
                $resulthtml .= '&nbsp;<input class="yesbtn" type="submit" name="yesno" value="Yes">';        
                $resulthtml .= "<input type=\"hidden\" name=\"checked\" value=1>";
            }else{
                $resulthtml .= '&nbsp;<input class="nobtn" type="submit" name="yesno" value="No">';        
                $resulthtml .= "<input type=\"hidden\" name=\"checked\" value=2>";
            }
            
            $resulthtml .= "</form></td>";
            $resulthtml .= "<td width=\"300\">  ".$e_row['text']."&nbsp;</td>";
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
            $rescount++;
//if(isset($_POST['today'])){$today = $_POST['today'];}
//if(isset($_POST['tomonth'])){$tomonth = $_POST['tomonth'];}
//if(isset($_POST['toyear'])){$toyear = $_POST['toyear'];$toyear_small = $_POST['toyear'] - 2000;}
//$fromday = date('d', time() - 7 * SECONDS_PER_DAY);
//$frommonth = date('m', time() - 7 * SECONDS_PER_DAY);
//$fromyear = date('Y', time() - 7 * SECONDS_PER_DAY);
//$fromyear_small = date('y');
//if(isset($_POST['fromday'])){$fromday = $_POST['fromday'];}
//if(isset($_POST['frommonth'])){$frommonth = $_POST['frommonth'];}
//if(isset($_POST['fromyear'])){$fromyear = $_POST['fromyear'];$fromyear_small = $_POST['fromyear'] - 2000;}
            
        }
        $resulthtml .= "</table>";
    }
    
    
    
    if(($_POST['platform'] == 6) || ($_GET['platform'] == 6)){
        $e_query = sprintf("SELECT * FROM operators_log ORDER BY id DESC $LIMIT;");
        $e_result = mysql_query($e_query);
        #echo $e_query;
        $resulthtml = "<table width=\"800\" border =\"0\" cellpadding=\"0\" cellspacing =\"0\">";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>MarketID</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Name</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Operator</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Station</B>&nbsp;</td><td width=\"260\"><B>Changes</B>&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        while($e_row = mysql_fetch_array($e_result)) {
            if($fromyear_small > $e_row['year']){
                    continue;
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth > $e_row['month']){
                    continue;
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth < $e_row['month']){
                    continue;
                }                
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth == $e_row['month'])
                {
                        if($fromday > $e_row['day']){continue;}               
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth == $e_row['month'])
                {
                    if($today < $e_row['day']){
                        continue;
                    }                
                }                
            }
            $marketname = getmarketname($e_row['mktid']);
            if($searchterm){
                if (stripos($marketname,$searchterm) !== false) {
                    //echo 'true';
                }elseif (stripos($e_row['operator'],$searchterm) !== false) {
                    //echo 'true';
                }elseif (stripos($e_row['station'],$searchterm) !== false) {
                    //echo 'true';
                }elseif (stripos($e_row['text'],$searchterm) !== false) {
                    //echo 'true';
                }else{
                    continue;
                }
            }
            

            $operatorhtml = '';
            if($e_row['operator']>0){
                $operatorhtml = "<a href=\"http://www.rabbitears.info/search.php?request=network_search&network=".$e_row['operator']."\" target=_blank>".$e_row['operator']."</a>";
            }else{
                $operatorhtml = $e_row['operator'];
            }
            $stationhtml = '';
            if($e_row['stationid']>0){
                $stationhtml = "<a href=\"http://www.rabbitears.info/market.php?request=station_search&callsign=".$e_row['stationid']."#station\" target=_blank>".$e_row['station']."</a>";
            }else{
                $stationhtml = $e_row['station'];
            }
            
            $tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            $resulthtml .= "<tr><td width=\"80\">".$tempdate."&nbsp;</td>
            <td width=\"40\" align=\"middle\"><a href=\"http://www.rabbitears.info/market.php?mktid=".$e_row['mktid']."\" target=_blank>".$e_row['mktid']."</a>&nbsp;</td>
            <td width=\"80\" align=\"middle\">".$marketname."</a>&nbsp;</td>
            <td width=\"80\" align=\"middle\">".$operatorhtml."</a>&nbsp;</td>            
            <td width=\"40\" align=\"middle\">".$stationhtml."</a>&nbsp;</td>
            <td width=\"300\">  ".$e_row['text']."&nbsp;";
            $resulthtml .= "&nbsp;<a href='networkschecker.php?search=1&platform=7&today=".$today."&tomonth=".$tomonth."&toyear=".$toyear."&fromday=".$fromday."&frommonth=".$frommonth."&fromyear=".$fromyear."&mktid=".$e_row['mktid']."' target=_blank>  >> </a></td>";
            $resulthtml .= "</td></tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
            $rescount++;
        }
        $resulthtml .= "</table>";
    }
    
    if(($_POST['platform'] == 7) || ($_GET['platform'] == 7)){
        if($_POST['massyesno'] > 0){
            #echo 'massyesno';
            $e_query = sprintf("SELECT * FROM operatorchannels_log ORDER BY id DESC $LIMIT;");
            $e_result = mysql_query($e_query);
            $rowcount = 0;
            while($e_row = mysql_fetch_array($e_result)) {
                #echo "Q".$fromyear_small."F".$e_row['year'];
                if($fromyear_small > $e_row['year']){
                        continue;
                }
                #echo "P ";            
                if($fromyear_small == $e_row['year']){
                    if($frommonth > $e_row['month']){
                        continue;
                    }                
                }
                if($toyear_small == $e_row['year']){
                    if($tomonth < $e_row['month']){
                        continue;
                    }                
                }
                #echo "T ";            
                
                if($fromyear_small == $e_row['year']){
                    if($frommonth == $e_row['month'])
                    {
                            if($fromday > $e_row['day']){continue;}               
                    }                
                }
                if($toyear_small == $e_row['year']){
                    if($tomonth == $e_row['month'])
                    {
                        if($today < $e_row['day']){
                            continue;
                        }                
                    }                
                }
                $marketname = getmarketname($e_row['mktid']);
                #$tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
                #$tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
                if($searchterm){
                    if (stripos($marketname,$searchterm) !== false) {
                        //echo 'true';
                    }elseif (stripos($e_row['station'],$searchterm) !== false) {
                        //echo 'true';
                    }elseif (stripos($e_row['text'],$searchterm) !== false) {
                        //echo 'true';
                    }else{
                        continue;
                    }
                }
                
                $id = $e_row['id'];
                #echo $id."X";
                $s_query = sprintf("UPDATE operatorchannels_log SET checked=2 WHERE id='$id';");
                $s_result = mysql_query($s_query);
            }
        }
    }
    
    if(($_POST['platform'] == 7) || ($_GET['platform'] == 7)){        
        //echo "here";
        //exit();
        #Speed up SQL
        $MONTHSQL = '';
        if($frommonth == $tomonth){
            $MONTHSQL = "WHERE month = '$tomonth'";
        }
        //$MONTHSQL = '';
        if(($_POST['mktid']) || ($_GET['mktid'])){
            if($_POST['mktid']){
                $mktid = $_POST['mktid'];
            }elseif($_GET['mktid']){
                $mktid = $_GET['mktid'];
            }
            $e_query = sprintf("SELECT DISTINCT day,month,year,mktid,station,displaychid,operator,text FROM operatorchannels_log WHERE mktid = ('%s') ORDER BY id DESC $LIMIT;",$mktid);
        }else{
            $e_query = sprintf("SELECT DISTINCT mktid,station,displaychid,operator,checked,text,day,month,year FROM operatorchannels_log $MONTHSQL ORDER BY id DESC $LIMIT;");
            //$e_query = sprintf("SELECT * FROM operatorchannels_log ORDER BY id DESC $LIMIT;");
        }
        //echo $e_query;
        $e_result = mysql_query($e_query);
        #echo $e_query;
        $resulthtml = "<table width=\"800\" border =\"0\" cellpadding=\"0\" cellspacing =\"0\">";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>MarketID</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Name</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Station</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>Display</B>&nbsp;</td><td width=\"40\"><B>Reviewed</B>&nbsp;</td><td width=\"300\"> <B>Changes</B>&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        $rowcount = 0;  
        while($e_row = mysql_fetch_array($e_result)) {
            #echo "Q".$fromyear_small."F".$e_row['year'];
            if($fromyear_small > $e_row['year']){
                    continue;
            }
            #echo "P ";            
            if($fromyear_small == $e_row['year']){
                if($frommonth > $e_row['month']){
                    continue;
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth < $e_row['month']){
                    continue;
                }                
            }
            #echo "T ";            
            
            if($fromyear_small == $e_row['year']){
                if($frommonth == $e_row['month'])
                {
                        if($fromday > $e_row['day']){continue;}               
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth == $e_row['month'])
                {
                    if($today < $e_row['day']){
                        continue;
                    }                
                }                
            }
            //echo "R ";            
            $marketname = getmarketname($e_row['mktid']);
            
            #$tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            $tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            if($searchterm){
                if (stripos($marketname,$searchterm) !== false) {
                    //echo 'true';
                }elseif (stripos($e_row['station'],$searchterm) !== false) {
                    //echo 'true';
                }elseif (stripos($e_row['text'],$searchterm) !== false) {
                    //echo 'true';
                }else{
                    continue;
                }
            }
            
            $stationhtml = '';
            if($e_row['station']){
                $stationhtml = "<a href=\"http://www.rabbitears.info/market.php?request=station_search&callsign=".$e_row['station']."#station\" target=_blank>".$e_row['station']."</a>";
            }else{
                $stationhtml = $e_row['station'];
            }
            
            $resulthtml .= "<tr><td width=\"80\">".$tempdate."&nbsp;</td>
            <td width=\"40\" align=\"middle\"><a href=\"http://www.rabbitears.info/market.php?mktid=".$e_row['mktid']."\" target=_blank>".$e_row['mktid']."</a>&nbsp;</td><td width=\"160\" align=\"middle\">".$marketname."&nbsp;</td><td width=\"80\" align=\"middle\">".$stationhtml."&nbsp;</td><td width=\"80\" align=\"middle\">".$e_row['displaychid']."</a>&nbsp;</td>";
            $resulthtml .= '<td width=\"40\"><form name="form1" method="post" action="networkschecker.php">';
            $resulthtml .= "<input type=\"hidden\" name=\"platform\" value=7>";
            $resulthtml .= "<input type=\"hidden\" name=\"today\" value=".$today.">";
            $resulthtml .= "<input type=\"hidden\" name=\"tomonth\" value=".$tomonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"toyear\" value=".$toyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromday\" value=".$fromday.">";
            $resulthtml .= "<input type=\"hidden\" name=\"frommonth\" value=".$frommonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromyear\" value=".$fromyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"searchterm\" value=".$searchterm.">";
            $resulthtml .= "<input type=\"hidden\" name=\"search\" value=1>";            
            $resulthtml .= "<input type=\"hidden\" name=\"id\" value=".$e_row['id'].">";            
            if($e_row['checked'] > 1){
                $resulthtml .= '&nbsp;<input class="yesbtn" type="submit" name="yesno" value="Yes">';        
                $resulthtml .= "<input type=\"hidden\" name=\"checked\" value=1>";
            }else{
                $resulthtml .= '&nbsp;<input class="nobtn" type="submit" name="yesno" value="No">';        
                $resulthtml .= "<input type=\"hidden\" name=\"checked\" value=2>";
            }
            $resulthtml .= "</form></td>";
            $resulthtml .= "<td width=\"300\">  ".$e_row['text']."&nbsp;</td>";
            
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
//if(isset($_POST['today'])){$today = $_POST['today'];}
//if(isset($_POST['tomonth'])){$tomonth = $_POST['tomonth'];}
//if(isset($_POST['toyear'])){$toyear = $_POST['toyear'];$toyear_small = $_POST['toyear'] - 2000;}
//$fromday = date('d', time() - 7 * SECONDS_PER_DAY);
//$frommonth = date('m', time() - 7 * SECONDS_PER_DAY);
//$fromyear = date('Y', time() - 7 * SECONDS_PER_DAY);
//$fromyear_small = date('y');
//if(isset($_POST['fromday'])){$fromday = $_POST['fromday'];}
//if(isset($_POST['frommonth'])){$frommonth = $_POST['frommonth'];}
//if(isset($_POST['fromyear'])){$fromyear = $_POST['fromyear'];$fromyear_small = $_POST['fromyear'] - 2000;}
            $rowcount++;
            $rescount++;
        }
        
        if($rowcount > 0 ){
            $resulthtml .= "<tr><td width=\"80\">&nbsp;</td>
            <td width=\"40\" align=\"middle\">&nbsp;</td><td width=\"160\" align=\"middle\">&nbsp;</td><td width=\"80\" align=\"middle\">&nbsp;</td><td width=\"80\" align=\"middle\">&nbsp;</td>";        
            $resulthtml .= '<td width=\"40\"><form name="form1" method="post" action="networkschecker.php">';
            $resulthtml .= "<input type=\"hidden\" name=\"platform\" value=7>";
            $resulthtml .= "<input type=\"hidden\" name=\"massyesno\" value=1>";        
            $resulthtml .= "<input type=\"hidden\" name=\"today\" value=".$today.">";
            $resulthtml .= "<input type=\"hidden\" name=\"tomonth\" value=".$tomonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"toyear\" value=".$toyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromday\" value=".$fromday.">";
            $resulthtml .= "<input type=\"hidden\" name=\"frommonth\" value=".$frommonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromyear\" value=".$fromyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"searchterm\" value=".$searchterm.">";
            $resulthtml .= "<input type=\"hidden\" name=\"search\" value=1>";
            $resulthtml .= '&nbsp;<input class="yesbtn" type="submit" name="yesno" value="Set All to Yes">';        
            $resulthtml .= "</form></td>";
            $resulthtml .= "<td width=\"300\"> &nbsp;</td>";
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
        }
        
        $resulthtml .= "</table>";
    }
    
    if(($_POST['platform'] == 3) || ($_GET['platform'] == 3)){
        $MONTHSQL = '';
        if($frommonth == $tomonth){
            $MONTHSQL = "WHERE month = '$tomonth'";
        }
        $e_query = sprintf("SELECT * FROM channels_log $MONTHSQL ORDER BY id DESC $LIMIT;");
        $e_result = mysql_query($e_query);
        #echo $e_query;
        $resulthtml = "<table width=\"800\" border =\"0\" cellpadding=\"0\" cellspacing =\"0\">";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>MarketID</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Name</B>&nbsp;</td><td width=\"80\" align=\"middle\"><B>Station</B>&nbsp;</td><td width=\"40\" align=\"middle\"><B>Display</B>&nbsp;</td><td width=\"260\"><B>Changes</B>&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        while($e_row = mysql_fetch_array($e_result)) {
            if($fromyear_small > $e_row['year']){
                    continue;
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth > $e_row['month']){
                    continue;
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth < $e_row['month']){
                    continue;
                }                
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth == $e_row['month'])
                {
                        if($fromday > $e_row['day']){continue;}               
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth == $e_row['month'])
                {
                    if($today < $e_row['day']){
                        continue;
                    }                
                }                
            }
            $marketname = getmarketname($e_row['mktid']);
            
            $tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            $resulthtml .= "<tr><td width=\"80\">".$tempdate."&nbsp;</td>
            <td width=\"40\" align=\"middle\"><a href=\"http://www.rabbitears.info/market.php?mktid=".$e_row['mktid']."\" target=_blank>".$e_row['mktid']."</a>&nbsp;</td>
            <td width=\"80\" align=\"middle\">".$marketname."</a>&nbsp;</td>            
            <td width=\"40\" align=\"middle\">".$e_row['station']."</a>&nbsp;</td>
            <td width=\"40\" align=\"middle\">".$e_row['displaychid']."</a>&nbsp;</td>
            <td width=\"300\">  ".$e_row['text']."&nbsp;</td>";
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
            $rescount++;
        }
        $resulthtml .= "</table>";
    }
    
    if(($_POST['platform'] == 4) || ($_GET['platform'] == 4)){
        $MONTHSQL = '';
        if($frommonth == $tomonth){
            $MONTHSQL = "WHERE month = '$tomonth'";
        }
        $e_query = sprintf("SELECT * FROM networks_log $MONTHSQL ORDER BY id DESC $LIMIT;");
        $e_result = mysql_query($e_query);
        #echo $e_query;
        $resulthtml = "<table width=\"800\" border =\"0\" cellpadding=\"0\" cellspacing =\"0\">";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"120\" align=\"middle\"><B>Network Name</B>&nbsp;</td><td width=\"300\"><B>Changes</B>&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        while($e_row = mysql_fetch_array($e_result)) {
            if($fromyear_small > $e_row['year']){
                    continue;
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth > $e_row['month']){
                    continue;
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth < $e_row['month']){
                    continue;
                }                
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth == $e_row['month'])
                {
                        if($fromday > $e_row['day']){continue;}               
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth == $e_row['month'])
                {
                    if($today < $e_row['day']){
                        continue;
                    }                
                }                
            }
            if($searchterm){
                if (stripos($e_row['network_name'],$searchterm) !== false) {
                }else{
                    continue;
                }
            }
            
            $tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            $resulthtml .= "<tr><td width=\"80\">".$tempdate."&nbsp;</td>
            <td width=\"120\" align=\"left\"><a href=\"http://www.rabbitears.info/search.php?request=network_search&network=".$e_row['network_name']."\" target=_blank>".$e_row['network_name']."&nbsp;</td>";
            #<td width=\"300\">  ".$e_row['text']."&nbsp;</td>";
            $resulthtml .= "<td width=\"300\">&nbsp".$e_row['text'];
            $resulthtml .= "&nbsp;<a href='networkschecker.php?search=1&platform=5&today=".$today."&tomonth=".$tomonth."&toyear=".$toyear."&fromday=".$fromday."&frommonth=".$frommonth."&fromyear=".$fromyear."&network_name=".$e_row['network_name']."' target=_blank>  >> </a></td>";
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
            $rescount++;
        }
        $resulthtml .= "</table>";
    }

    if(($_POST['platform'] == 5) || ($_GET['platform'] == 5)){
        $MONTHSQL = '';
        if($frommonth == $tomonth){
            $MONTHSQL = "WHERE month = '$tomonth'";
        }
        if($_POST['massyesno'] > 0){
            $e_query = sprintf("SELECT * FROM networkstations_log $MONTHSQL ORDER BY id DESC $LIMIT;");
            $e_result = mysql_query($e_query);
            $rowcount = 0;
            while($e_row = mysql_fetch_array($e_result)) {
                #echo "Q".$fromyear_small."F".$e_row['year'];
                if($fromyear_small > $e_row['year']){
                        continue;
                }
                #echo "P ";            
                if($fromyear_small == $e_row['year']){
                    if($frommonth > $e_row['month']){
                        continue;
                    }                
                }
                if($toyear_small == $e_row['year']){
                    if($tomonth < $e_row['month']){
                        continue;
                    }                
                }
                #echo "T ";            
                
                if($fromyear_small == $e_row['year']){
                    if($frommonth == $e_row['month'])
                    {
                            if($fromday > $e_row['day']){continue;}               
                    }                
                }
                if($toyear_small == $e_row['year']){
                    if($tomonth == $e_row['month'])
                    {
                        if($today < $e_row['day']){
                            continue;
                        }                
                    }                
                }
                $id = $e_row['id'];
                
                if($searchterm){
                    if (stripos($e_row['network_name'],$searchterm) !== false) {
                    }elseif(stripos($e_row['callsign'],$searchterm) !== false) {
                    }elseif(stripos($e_row['text'],$searchterm) !== false) {
                    }                
                    else{
                        continue;
                    }
                }
                if($AVAIL == 1){
                    if (stripos($e_row['text'],'Added') !== false) {
                    }else{
                        continue;
                    }
                }
                if($AVAIL == 2){
                    if (stripos($e_row['text'],'Unavail') !== false) {
                    }else{
                        continue;
                    }
                }
                
                $s_query = sprintf("UPDATE networkstations_log SET checked=2 WHERE id='$id';");
                $s_result = mysql_query($s_query);
            }
        }
    }
    
    if(($_POST['platform'] == 5) || ($_GET['platform'] == 5)){
        $MONTHSQL = '';
        if($frommonth == $tomonth){
            $MONTHSQL = "WHERE month = '$tomonth'";
        }
        if($_GET['network_name']){
            $network_name = $_GET['network_name']; 
            $e_query = sprintf("SELECT * FROM networkstations_log WHERE network_name = '$network_name' ORDER BY id DESC $LIMIT;");
        }else{
            $e_query = sprintf("SELECT * FROM networkstations_log $MONTHSQL ORDER BY id DESC $LIMIT;");
        }
        $e_result = mysql_query($e_query);
        #echo $e_query;
        $resulthtml = "<table width=\"800\" border =\"0\" cellpadding=\"0\" cellspacing =\"0\">";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        #$resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"60\" align=\"middle\"><B>Network Name</B>&nbsp;</td><td width=\"100\" align=\"middle\"><B>Display Channel</B>&nbsp;</td><td width=\"40\"><B>".$REVIEWEDHTML_0."</B>&nbsp;<B>".$REVIEWEDHTML_1."</B></td><td width=\"300\"><B>".$AVAILHTML_0."</B>&nbsp;<B>".$AVAILHTML_1."</B>&nbsp;<B>".$AVAILHTML_2."</B>&nbsp;</td>";
        $resulthtml .= "<tr><td width=\"150\"><B>Reviewed Date</B>&nbsp;</td><td width=\"60\" align=\"middle\"><B>Network Name</B>&nbsp;</td><td width=\"100\" align=\"middle\"><B>Display Channel</B>&nbsp;</td><td width=\"40\"><B>Reviewed</B>&nbsp;</td><td width=\"300\"><B>".$AVAILHTML_0."</B>&nbsp;<B>".$AVAILHTML_1."</B>&nbsp;<B>".$AVAILHTML_2."</B>&nbsp;</td>";
        $resulthtml .= "</tr>";
        $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
        $resulthtml .= "</tr>";
        while($e_row = mysql_fetch_array($e_result)) {
            if($fromyear_small > $e_row['year']){
                    continue;
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth > $e_row['month']){
                    continue;
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth < $e_row['month']){
                    continue;
                }                
            }
            if($fromyear_small == $e_row['year']){
                if($frommonth == $e_row['month'])
                {
                        if($fromday > $e_row['day']){continue;}               
                }                
            }
            if($toyear_small == $e_row['year']){
                if($tomonth == $e_row['month'])
                {
                    if($today < $e_row['day']){
                        continue;
                    }                
                }                
            }

            $stationhtml = '';
            if($e_row['callsign_num']>0){
                $stationhtml = "<a href=\"http://www.rabbitears.info/market.php?request=station_search&callsign=".$e_row['callsign_num']."#station\" target=_blank>".$e_row['callsign']."</a>";
            }else{
                $stationhtml = $e_row['callsign'];
            }
            
            if($searchterm){
                if (stripos($e_row['network_name'],$searchterm) !== false) {
                }elseif(stripos($e_row['callsign'],$searchterm) !== false) {
                }elseif(stripos($e_row['text'],$searchterm) !== false) {
                }                
                else{
                    continue;
                }
            }
            if($AVAIL == 1){
                if (stripos($e_row['text'],'Added') !== false) {
                }else{
                    continue;
                }
            }
            if($AVAIL == 2){
                if (stripos($e_row['text'],'Unavail') !== false) {
                }else{
                    continue;
                }
            }
            
            $tempdate = convdate($e_row['year'], $e_row['month'], $e_row['day']);
            $resulthtml .= "<tr><td width=\"80\">".$tempdate."&nbsp;</td>
            <td width=\"60\" align=\"left\"><a href=\"http://www.rabbitears.info/search.php?request=network_search&network=".$e_row['network_name']."\" target=_blank>".$e_row['network_name']."</a>&nbsp;</td>
            <td width=\"60\" align=\"middle\">".$stationhtml."&nbsp;</td>";
            
            $resulthtml .= '<td width=\"40\"><form name="form1" method="post" action="networkschecker.php">';
            $resulthtml .= "<input type=\"hidden\" name=\"platform\" value=5>";
            $resulthtml .= "<input type=\"hidden\" name=\"today\" value=".$today.">";
            $resulthtml .= "<input type=\"hidden\" name=\"tomonth\" value=".$tomonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"toyear\" value=".$toyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromday\" value=".$fromday.">";
            $resulthtml .= "<input type=\"hidden\" name=\"frommonth\" value=".$frommonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromyear\" value=".$fromyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"searchterm\" value=".$searchterm.">";
            $resulthtml .= "<input type=\"hidden\" name=\"search\" value=1>";            
            $resulthtml .= "<input type=\"hidden\" name=\"id\" value=".$e_row['id'].">";            
            if($e_row['checked'] > 1){
                $resulthtml .= '&nbsp;<input class="yesbtn" type="submit" name="yesno" value="Yes">';        
                $resulthtml .= "<input type=\"hidden\" name=\"checked\" value=1>";
            }else{
                $resulthtml .= '&nbsp;<input class="nobtn" type="submit" name="yesno" value="No">';        
                $resulthtml .= "<input type=\"hidden\" name=\"checked\" value=2>";
            }
            $resulthtml .= "</form></td>";
            $resulthtml .= "<td width=\"300\">  ".$e_row['text']."&nbsp;</td>";
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
            $rescount++;
        }
        if($rescount > 0 ){
            $resulthtml .= "<tr><td width=\"80\">&nbsp;</td>
            <td width=\"60\" align=\"middle\">&nbsp;</td><td width=\"60\" align=\"middle\">&nbsp;</td>";        
            $resulthtml .= '<td width=\"40\"><form name="form1" method="post" action="networkschecker.php">';
            $resulthtml .= "<input type=\"hidden\" name=\"platform\" value=5>";
            $resulthtml .= "<input type=\"hidden\" name=\"massyesno\" value=1>";        
            $resulthtml .= "<input type=\"hidden\" name=\"today\" value=".$today.">";
            $resulthtml .= "<input type=\"hidden\" name=\"tomonth\" value=".$tomonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"toyear\" value=".$toyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromday\" value=".$fromday.">";
            $resulthtml .= "<input type=\"hidden\" name=\"frommonth\" value=".$frommonth.">";
            $resulthtml .= "<input type=\"hidden\" name=\"fromyear\" value=".$fromyear.">";
            $resulthtml .= "<input type=\"hidden\" name=\"searchterm\" value=".$searchterm.">";
            $resulthtml .= "<input type=\"hidden\" name=\"search\" value=1>";
            $resulthtml .= '&nbsp;<input class="yesbtn" type="submit" name="yesno" value="Set All to Yes">';        
            $resulthtml .= "</form></td>";
            $resulthtml .= "<td width=\"300\"> &nbsp;</td>";
            $resulthtml .= "</tr>";
            $resulthtml .= "<tr><td colpsan=\"4\" style=\"height:1px;\">&nbsp;</td>";
            $resulthtml .= "</tr>";
        }
        
        $resulthtml .= "</table>";
    }
}


//echo "TEST".$_SERVER['PHP_SELF'];
//echo realpath(dirname(__FILE__));
?>
            
            
            <table style="position:relative; left:1px;" width="800" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
            <tr>
                    <td>
                        <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
                            <tr>
                                <td colspan="3"><strong><?php if($errmsg){echo $errmsg;}?></strong></td>
                            </tr>
                        </table>    
                    </td>
            </tr>
            </table>
            
            <table style="position:relative; left:1px;" width="1000" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
                    <td>
                        <form name="form1" method="post" action="networkschecker.php">
                        <input type=hidden name="search" value="1" action="networkschecker.php">
                        <table width="100%" border="0" cellpadding="3" cellspacing="4" bgcolor="#FFFFFF">
                            <tr>
                                <td colspan="3"><strong>Networks Checker</strong></td>
                            </tr>
                            <tr>
                                <td width="50"></td>
                                <td width="700" align="center">&nbsp;
                                        <?php if($platform_ddhtml){echo $platform_ddhtml;}?>&nbsp;&nbsp;&nbsp;<input type="text" name="searchterm" value="<?php if($searchterm){echo $searchterm;}?>" style="width:90px">&nbsp;&nbsp;&nbsp;From <input type="text" name="frommonth" style="width: 20px;" value="<?php echo $frommonth;?>"></input>/<input type="text" name="fromday" style="width: 20px;" value="<?php echo $fromday;?>"></input>/<input type="text" name="fromyear" style="width: 30px;" value="<?php echo $fromyear;?>"></input>&nbsp;To <input type="text" name="tomonth" style="width: 20px;" value="<?php echo $tomonth;?>"></input>/<input type="text" name="today" style="width: 20px;" value="<?php echo $today;?>"></input>/<input type="text" name="toyear" style="width: 30px;" value="<?php echo $toyear;?>"></input>&nbsp;&nbsp;&nbsp;<input type="submit" name="Submit" value="Check for Changes"><?php echo $LIMITHTML;?>
                                </td>
                                <td width="50">&nbsp;</td>
                            </tr>
                        </form>
                            <tr>
                                <td width="50">&nbsp;</td>
                                <td width="700" align="center"><?php if($resulthtml){echo $resulthtml;}?></td>
                                <td width="50">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="50">&nbsp;</td>
                                <td width="700" align="center"><?php if($rescount){echo "Total Results ".$rescount;}?></td>
                                <td width="50">&nbsp;</td>
                            </tr>
                            
                            <!--
                            <tr>
                                <td width="50">&nbsp;</td>
                                <td width="600">&nbsp;</td>
                                <td width="50">&nbsp;</td>
                            </tr>
                            -->
                            
                        <!--
                        <form name="form1" method="post" action="admin_parts.php">
                        <input type="hidden" name="current" value="1">
                            <tr>
                                <td width="138">Current</td>
                                <td width="474">&nbsp;<input type="submit" name="default" value="Set as default"> &nbsp;<input type="submit" name="remove" value="Remove"></td>
                                <td width="20">&nbsp;</td>
                            </tr>
                        
                        </form>
                        -->
                        </table>    
                    </td>
            </tr>
            </table>
            
        </div>    
<br><br><br><br><br><br><br>

