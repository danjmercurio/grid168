<?php
session_start();
if(!$_SESSION['myusername']){
header("location:main_login.php?err=2");
}
require_once ('header_html.php'); // include the database connection
$username = $_SESSION['myusername'];
if($username == 'micheal'){
    
}else{
    echo "Not available";
    exit();
}

$error = 0;
$error_msg = '';

if(isset($_GET['delete'])){
        if($_GET['delete'] > 0){
            $offerid = $_GET['delete'];
            $sql = sprintf("delete from g_admin_members where member_id = '%s'", $offerid);
            $result = mysql_query($sql);
            $error_msg = 'User account successfully removed<br>';            
        }
}

$usersname = $password = '';
if((isset($_POST['new'])) || (isset($_POST['edit']))){
    if($_POST['username']){
        $usersname = $_POST['username'];
    }else{
        $error = 1;
        $error_msg = 'User Name cannot be blank<br>';
    }
    if($_POST['password']){
        $password = $_POST['password'];
    }else{
        $error = 1;
        $error_msg .= 'Password cannot be blank<br>';
    }
}
if(isset($_POST['new'])){
    if(!$error){
        $createdat = date('m/d/Y');
        $baseQuery = "INSERT INTO `g_admin_members` (`username`,`password`) VALUES('%s','%s');";
        $result = mysql_query(sprintf($baseQuery,
          mysql_real_escape_string($_POST['username']),
          mysql_real_escape_string($_POST['password'])
        )) or die(mysql_error());
        $orderId = mysql_insert_id();
        $error_msg = 'New User Account submited successfully';        
    }else{
    }
}    
    
if(strlen($error_msg) > 0){
        $error_msg = '<div id="error_explanation">'.$error_msg.'</div>';
}


    echo '
    <div id="content">
                            <p class="notice"></p>
                              <p class="alert"></p>
                              '.$error_msg.'
                                    <h3>User Accounts</h3>
    <table id="table_outlet" class="tablesorter">
            <thead>
                    <tr>
                            <th>User Name</th>
                            <th>Password</th>
                            <th>Delete</th>
                    </tr>
            </thead>
            <tbody>';
        
    $s_query = sprintf("SELECT * FROM g_admin_members ORDER BY member_id ASC;");
    $s_result = mysql_query($s_query) or fwrite($fh, "Line 136");

    while($s_row = mysql_fetch_array($s_result)) {
        if($s_row['username'] == 'micheal'){
            echo '<tr><td>'.$s_row['username'].'</td><td>'.$s_row['password'].'</td><td></td></tr>';
        }else{
            echo '<tr><td>'.$s_row['username'].'</td><td>'.$s_row['password'].'</td><td><a href="accounts.php?delete='.$s_row['member_id'].'" data-confirm="Are you sure?" data-method="delete" rel="nofollow">delete</a></td></tr>';
        }
    }
    echo '
            </tbody>
    </table>';
    
    echo ' 
    <br/>
        <form accept-charset="UTF-8" action="accounts.php" class="edit_offer" id="edit_offer_13" method="post">
        <div style="margin:0;padding:0;display:inline">
            <input name="new" type="hidden" value="1" /><br>
            User Name&nbsp;<input name="username" type="text" maxlength=30/>&nbsp;&nbsp;
            &nbsp;Password&nbsp;<input name="password" type="text" maxlength=30/>&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="commit" style="" type="submit" value="Create User Account" />
        </div>
        </form>
                    </div>
            </body>
    </html>
    ';


exit();

