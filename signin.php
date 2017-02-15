<?php
session_start();
?>
<?php
    if(isset($_POST['submit'])){
    include("db.php");

    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $sql = mysql_query("SELECT * FROM user WHERE username='".$username."'");
    if($data=mysql_fetch_array($sql) AND $data["password"] == MD5($password)){
    $_SESSION["id"] = $data["id"];
    $_SESSION["username"] = $data["username"];
    $_SESSION["email"] = $data["email"];
    $_SESSION["password"] =$data["password"];
    
    $sql1 = mysql_query("UPDATE user SET last_login=NOW() WHERE username='".$data["username"]."'");
    
        header("Location: user.php?=$_SESSION[username]");
    }
    else{
    $error= 'Neteisingas vartotojo vardas arba slaptažodis';
    }
    }
?>
                     
<!DOCTYPE html>
<html>
    <body>
        <link href="style.css" rel="stylesheet" type="text/css">
            <meta charset="utf-8" lang="lt">
                <span id="error"><?php echo ((isset($error) && $error != '') ? $error : ''); ?></span>
                    <form action="signin.php" method="post">
                    	<span id="login">
                    		<div id="login-box">
                    			<div id="label">Prisijungti</div>
                    				<div class="input">
                    					<input type="text" name="username" placeholder="Vartotojo vardas">
      								</div>
      								<div class="input">
        								<input type="password" name="password" placeholder="Slaptažodis">
      								</div>
      								<div class="link">
          								<a href="forgot.php">Pamiršau slaptažodį</a>
          								<a href="signup.php">Registruotis</a>
      								</div>
      								<div class="button">
       							 		<input type="submit" id="submit" name="submit" value="Prisijungti">
      								</div>
    						</div>
  						</span>
					</form>
    </body>
</html>
