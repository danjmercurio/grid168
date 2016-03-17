<?php
//require_once ('header_html.php'); // include the database connection
unset($_POST['mypassword']);
unset($_POST['myusername']);
session_start();
#$domain =  "wolfautoparts"; // the domain name without http://www.
?>

<br><br><br>
<form name="form1" method="post" action="checklogin.php">
<input type="hidden" name="redirurl" value="<?php echo $_GET['redirurl']; ?>">        
<table style="position:relative; left:1px;" width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="4" bgcolor="#FFFFFF">
                <tr>
                <td colspan="3"><strong>Grid168 Login</strong></td>
                </tr>
                <tr>
                <td width="78">Username</td>
                <td width="6">:</td>
                <td width="294"><input name="myusername" type="text" id="myusername"></td>
                </tr>
                <tr>
                <td>Password</td>
                <td>:</td>
                <td><input name="mypassword" type="password" id="mypassword"></td>
                </tr>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" id="submit" value="Login"></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><!--<a href="autologin.php?redirurl=<?php echo $_GET['redirurl']; ?>">Auto Login</a>--></td>
                </tr>
                
            </table>
        </td>
</tr>
</table>
</form>

<br><br><br><br><br><br><br>
