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
$programmer_name = $programmer_type = $programmer_firstname = $programmer_lastname = $programmer_phone = $programmer_email = $programmer_description = '';

if($_POST['programmer_type']){
    $programmer_type = $_POST['programmer_type'];
}


if(isset($_GET['edit']) || isset($_GET['show'])){
    $programmerid = '';
    if($_GET['edit']){
        $programmerid = $_GET['edit'];
    }else{
        $programmerid = $_GET['show'];
    }
    if($programmerid > 0){
        //echo "X".$outletid;
        $sql = sprintf("select * from g_programmers where id = ('%s') and username = ('%s')", $programmerid, $username);
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)) {
            $programmer_name = $row['programmer_name'];
            $programmer_type = $row['programmer_type'];
            $programmer_firstname = $row['programmer_firstname'];
            $programmer_lastname = $row['programmer_lastname'];
            //$programmer_phone = $row['programmer_phone'];
            $programmer_email = $row['programmer_email'];            
            $programmer_description = $row['programmer_description'];
        }
    }
}        

if((isset($_POST['new'])) || (isset($_POST['edit']))){
    if($_POST['programmer_name']){
        $programmer_name = $_POST['programmer_name'];
        #echo $programmer_name."dsa";
        #exit();
    }else{
        $error = 1;
        $error_msg = 'Programmer cannot be blank<br>';
    }
    if($_POST['programmer_type']){
        $programmer_type = $_POST['programmer_type'];
        #echo $programmer_type."dsa";
        #exit();
    }else{
        $error = 1;
        $error_msg = 'Customer Type cannot be blank<br>';
    }
    
    if($_POST['programmer_firstname']){
        $programmer_firstname = $_POST['programmer_firstname'];
    }else{
        $error = 1;
        $error_msg .= 'First Name cannot be blank<br>';
    }
    if($_POST['programmer_lastname']){
        $programmer_lastname = $_POST['programmer_lastname'];
    }else{
        $error = 1;
        $error_msg .= 'Last Name cannot be blank<br>';
    }
    if($_POST['programmer_email']){
        $programmer_email = $_POST['programmer_email'];
    }else{
        $error = 1;
        $error_msg .= 'Email cannot be blank<br>';
    }
    if($_POST['programmer_phone']){
        $programmer_phone = $_POST['programmer_phone'];
    }
    #else{
    #    $error = 1;
    #    $error_msg .= 'Phone cannot be blank<br>';
    #}
    if($_POST['programmer_description']){
        $programmer_description = $_POST['programmer_description'];
    }
}
if(isset($_POST['new'])){
    if(!$error){
        $createdat = date('m/d/Y');
        $baseQuery = "INSERT INTO `g_programmers` (`username`,`programmer_name`,`programmer_type`, `programmer_firstname`, `programmer_lastname`, `programmer_email`, `programmer_description`, `createdat`) VALUES('%s','%s','%s','%s','%s','%s','%s','%s');";
        $result = mysql_query(sprintf($baseQuery,
          $username,
          mysql_real_escape_string($_POST['programmer_name']),
          mysql_real_escape_string($_POST['programmer_type']),          
          mysql_real_escape_string($_POST['programmer_firstname']),
          mysql_real_escape_string($_POST['programmer_lastname']),
          mysql_real_escape_string($_POST['programmer_email']),
          mysql_real_escape_string($_POST['programmer_description']),
          $createdat
        )) or die(mysql_error());
        $orderId = mysql_insert_id();
        
        $programmer_name = $programmer_type = $programmer_firstname = $programmer_lastname = $programmer_phone = $programmer_email = $programmer_description = '';
        
        $error_msg = 'New programmer created successfully';        
        #header("location:outlets.php?msg=1");
        #exit();
    }else{
        //$error_msg = ''.$error_msg.'</div>';        
    }
}    
if(isset($_POST['edit'])){
    #$real_editid = $_POST['edit']/4121;
    $real_editid = $_POST['edit'];
    
    if(!$error){
        $result = mysql_query("UPDATE `g_programmers` SET `programmer_name` = '$programmer_name',
                              `programmer_type` = '$programmer_type',
                              `programmer_firstname` = '$programmer_firstname',
                              `programmer_lastname` = '$programmer_lastname',
                              `programmer_email` = '$programmer_email',                              
                              `programmer_description` = '$programmer_description'                                                            
                              WHERE `id` = '$real_editid' and username='$username'") or mysql_error();
        
        #$outlet_name = $outlet_firstname = $outlet_lastname = $outlet_phone = '';
        #$outlet_dma = $outlet_type = $outlet_subs = $outlet_description = '';
        #$error_msg = "New Outlet submited successfully";
        $error_msg = 'Programmer updated successfully';        
        #header("location:outlets.php?msg=1");
        #exit();
    }else{
        //$error_msg = ''.$error_msg.'</div>';        
    }
}    

    
if(strlen($error_msg) > 0){
        $error_msg = '<div id="error_explanation">'.$error_msg.'</div>';
}

$programmer_type_selecthtml = '<select name="programmer_type">';
if($programmer_type == 'DRTV'){
    $programmer_type_selecthtml .= '<option value="DRTV" selected>DRTV</option>';
}else{
    $programmer_type_selecthtml .= '<option value="DRTV">DRTV</option>';    
}
if($programmer_type == 'General'){
    $programmer_type_selecthtml .= '<option value="General" selected>General</option>';
}else{
    $programmer_type_selecthtml .= '<option value="General">General</option>';    
}
if($programmer_type == 'Home shopping'){
    $programmer_type_selecthtml .= '<option value="Home shopping" selected>Home shopping</option>';
}else{
    $programmer_type_selecthtml .= '<option value="Home shopping">Home shopping</option>';    
}
if($programmer_type == 'Paid Religion'){
    $programmer_type_selecthtml .= '<option value="Paid Religion" selected>Paid Religion</option>';
}else{
    $programmer_type_selecthtml .= '<option value="Paid Religion">Paid Religion</option>';    
}
if($programmer_type == 'Programmer'){
    $programmer_type_selecthtml .= '<option value="Programmer" selected>Programmer</option>';
}else{
    $programmer_type_selecthtml .= '<option value="Programmer">Programmer</option>';    
}
$programmer_type_selecthtml .= '
</select>';


if(isset($_GET['show'])){

echo '<div id="content">
		  	<p class="notice"></p>
			  <p class="alert"></p>
				<form accept-charset="UTF-8" action="outlets.php" class="new_outlet" id="new_outlet" method="post">
                                '.$error_msg.'
                                <div style="margin:0;padding:0;display:inline">
                                </div>
	<div class="field">
			<label for="outlet_company_name">Programmer</label><br />
			<B>'.$programmer_name.'</B>
	</div>
	<div class="field">
			<label for="outlet_company_name">Customer Type</label><br />
			'.$programmer_type_selecthtml.'
	</div>
	<div class="field">
		<label for="outlet_first_name">First name</label><br/>
                <B>'.$programmer_firstname.'</B>
	</div>
	<div class="field">
		<label for="outlet_last_name">Last name</label><br/>
                <B>'.$programmer_lastname.'</B>
	</div>
	<div class="field">
		<label for="outlet_phone_number">Email</label><br/>
                <B>'.$programmer_email.'</B>
	</div>
	<div class="field">
		<label for="outlet_description">Description</label><br />
                <B>'.$programmer_description.'</B>                
	</div>
	<div class="actions">
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
				<form accept-charset="UTF-8" action="programmer.php" class="new_outlet" id="new_outlet" method="post">
                                '.$error_msg.'
                                <div style="margin:0;padding:0;display:inline">
                                <input name="edit" type="hidden" value="'.$editid.'" />
                                </div>
	<div class="field">
			<label for="outlet_company_name">Programmer</label><br />
			<input id="programmer_name" name="programmer_name" size="30" type="text" value="'.$programmer_name.'"/>
	</div>
	<div class="field">
			<label for="outlet_company_name">Customer Type</label><br />
			'.$programmer_type_selecthtml.'
	</div>
	<div class="field">
		<label for="outlet_first_name">First name</label><br/>
		<input id="programmer_firstname" name="programmer_firstname" size="30" type="text" value="'.$programmer_firstname.'" />
	</div>
	<div class="field">
		<label for="outlet_last_name">Last name</label><br/>
		<input id="programmer_lastname" name="programmer_lastname" size="30" type="text" value="'.$programmer_lastname.'" />
	</div>
	<div class="field">
		<label for="outlet_phone_number">Email</label><br/>
		<input id="programmer_email" name="programmer_email" size="30" type="text" value="'.$programmer_email.'" />
	</div>
	<div class="field">
		<label for="outlet_description">Description</label><br />
		<textarea cols="40" id="programmer_description" name="programmer_description" rows="20">'.$programmer_description.'</textarea>
	</div>
	<input id="count_sub_channel" name="count_sub_channel" type="hidden" value="0" />
	<div class="actions">
		<input class="submit_outlet" name="commit" type="submit" value="Update" />
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
				<form accept-charset="UTF-8" action="programmer.php" class="new_outlet" id="new_outlet" method="post">
                                '.$error_msg.'
                                <div style="margin:0;padding:0;display:inline">
                                <input name="new" type="hidden" value="1" />
                                </div>
	<div class="field">
			<label for="outlet_company_name">Programmer</label><br />
			<input id="programmer_name" name="programmer_name" size="30" type="text" value="'.$programmer_name.'"/>
	</div>
	<div class="field">
			<label for="outlet_company_name">Customer Type</label><br />
			'.$programmer_type_selecthtml.'
	</div>
	<div class="field">
		<label for="outlet_first_name">First name</label><br/>
		<input id="programmer_firstname" name="programmer_firstname" size="30" type="text" value="'.$programmer_firstname.'" />
	</div>
	<div class="field">
		<label for="outlet_last_name">Last name</label><br/>
		<input id="programmer_lastname" name="programmer_lastname" size="30" type="text" value="'.$programmer_lastname.'" />
	</div>
	<div class="field">
		<label for="outlet_phone_number">Email</label><br/>
		<input id="programmer_email" name="programmer_email" size="30" type="text" value="'.$programmer_email.'" />
	</div>
	<div class="field">
		<label for="outlet_description">Description</label><br />
		<textarea cols="40" id="programmer_description" name="programmer_description" rows="20">'.$programmer_description.'</textarea>
	</div>
	<input id="count_sub_channel" name="count_sub_channel" type="hidden" value="0" />
	<div class="actions">
		<input class="submit_outlet" name="commit" type="submit" value="Create Programmer" />
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
echo 'No programmer selected';
exit();

