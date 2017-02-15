<?php 
    if(isset($_POST['submit'])){
    
    include("db.php");
    
    $getemail=$_POST['email'];

    if(empty($getemail)){
        die("Nenurodytas el. paštas");
    }

    if (!filter_var($getemail, FILTER_VALIDATE_EMAIL)) {
        die("$getemail nera tinkamas");
    }

    $query=mysql_query("SELECT * FROM user WHERE email='$getemail'");
    $numrows=mysql_num_rows($query);
    if($numrows==1){
        $row=mysql_fetch_assoc($query);
        $dbemail=$row['email'];
        $username=$row['username'];
        $pass=rand();
        $password=md5($pass);
        mysql_query("UPDATE user SET password='$password' WHERE email='$dbemail'");
        }
        else{
            die("Nerastas vartotojas");
        }

    $to = $dbemail;
    $subject = "Slaptažodis pakeistas";
    $message = "Sveiki, $username. Naujas slaptažodis: $pass";
    $sender = "karolinak93@gmail.com";
    $headers = "From: $sender";
    $headers .= "Reply-To: $sender";
        
    if(mail($to, $subject, $message, $headers)){
        echo ("Slaptažodis išsiųstas $dbemail");
    }
    else {
        die ("Klaida išsiunčiant el. laišką");
    }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Slaptažodžio keitimas</title>
        <meta charset="utf-8" lang="lt">
    </head>
    <body>
        <h1>Keisti slaptažodį</h1>
            <div class="change">
            <form action="forgot.php" method="post" enctype="multipart/form-data">
                <label>El. paštas:</label>
                    <input type="text" name="email" placeholder="Įveskite el.paštą">
                    <input type="submit" name="submit" value="Toliau">
            </form>
        </div>
    </body>
</html>