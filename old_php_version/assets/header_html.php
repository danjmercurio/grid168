<?php
require_once ('db_connect.inc.php'); // include the database connection
if(isset($_POST['search'])){
    $search = $_POST['search'];
}
if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$username = $_SESSION['myusername'];

function getebayid($id){
    $e_query = sprintf("SELECT ebayid FROM ebayitems where id='$id';");
    $e_result = mysql_query($e_query)or fwrite($fh, "Line 1768");
    $ebayid = '';
    while($e_row = mysql_fetch_array($e_result)) {
	$ebayid = $e_row['ebayid'];
    }
    return $ebayid;
}


?>
<!DOCTYPE html>
<html>
	<head>
	  <title>Grid168</title>
	  <link href="assets/application_rev1.css" media="screen" rel="stylesheet" type="text/css" />
          <!--
	  <script src="assets/application.js" type="text/javascript"></script>
          <link href="http://grid168-old.herokuapp.com/assets/application-1123cf56eefa73c43ee93ae89b1c9853.css" media="screen" rel="stylesheet" type="text/css" />
          -->          
          <script src="assets/application.js" type="text/javascript"></script>
	<script type="text/javascript" src="assets/datetimepicker.js">          
	  <meta content="authenticity_token" name="csrf-param" />
<meta content="uDogkcjRuKkH/j4YMP9RorM3GO1sPwtxBuAy9bp0ZdA=" name="csrf-token" />
	</head>
	<body>
		<div id="container">
			<div id="header">
				<span id="name"><h2><b>Grid 168</b></h2></span>
					<span id="menu_links">
						<?php if($username == 'micheal'){echo '<a href="deals.php?all=1">All Potentials</a> | ';}else{echo '<a href="deals.php?my=1">My Potentials</a> | ';} ?>
				                <?php if($username == 'micheal'){echo '<a href="outlets.php?all=1">Media Outlets</a> | ';}else{echo '<a href="outlets.php?my=1">Media Outlets</a> | ';} ?>
						<a href="outlets.php?new=1">New Media Outlet</a> | 
						<a href="programmer.php?new=1">New Programmer</a>						
						<?php if($username == 'micheal'){echo ' | <a href="accounts.php">Edit Accounts</a> ';} ?>
					</span>
					<!--
					<span id="outlet_dropdown"><b>Media Outlet</b>
						<form accept-charset="UTF-8" action="/" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="uDogkcjRuKkH/j4YMP9RorM3GO1sPwtxBuAy9bp0ZdA=" /></div>
							<input id="outlet_id" name="outlet_id" type="hidden" />
						  <input data-autocomplete="/home/autocomplete_outlet_name" data-id-element="#outlet_id" id="name" name="name" type="text" value="" />
						  <input name="commit" type="submit" value="Go" />
</form>					</span>
					-->
				        
					<span id="logout"><a href="logout.php" data-method="delete" rel="nofollow">Log Out</a></span>
			</div>
<?
echo "haaaelal2";
exit();
?>
