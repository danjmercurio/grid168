<?php
require_once ('db_connect.inc.php'); // include the database connection
session_start();
$tbl_name="g_admin_members"; // Table name
// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$redirurl   = '';
if(isset($_POST['redirurl'])){
    $redirurl   = $_POST['redirurl'];
}

$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
#echo "<BR>".$sql;
$result=mysql_query($sql);
#echo "<BR>dir";

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
//echo "myusername".$myusername;
//echo "myusername".$mypassword;
//echo "<BR> ".$sql;
//echo "count";
//echo $count;
#exit();

if($count==1){
//echo "sss ";    
// Register $myusername, $mypassword and redirect to file "login_success.php"
#echo "CC";
#echo $count;
ini_set('session.gc_maxlifetime',12*60*60); 
ini_set('session.gc_probability',0); 
ini_set('session.gc_divisor',1);
//echo "dddd ";    

//    session_register(myusername);
$_SESSION['myusername'] = $myusername;
//    session_register(mypassword);
$_SESSION['mypassword'] = $mypassword;
//echo "red ";    
    if($redirurl){
        header("location:".$redirurl);
    }else{
//echo "reed ".$_SESSION['myusername'];
        if($myusername == 'micheal'){
            header("location:deals.php?all=1");
        }else{
            header("location:deals.php?my=1");
        }
        
//echo "dsadsa ";                    
    }

}
else {
#echo "CcC";
#echo $count;

header("location:main_login.php?err=1");
exit();
//require_once ('header_html.php'); // include the database connection
//echo "<br><br><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wrong Username or Password<br><br><br><br><br>";
}
?>