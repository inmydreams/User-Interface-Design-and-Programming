<?php
    session_start();
    include ("db.php");
    if(isset($_POST['submit'])){
        $fields = [
            'Vartotojo id' => $_SESSION['id'],
            'El. paštas' => $_SESSION['email'],
            'Pranešimas' => $_POST['message']
        ];
        
        foreach($fields as $field =>$data){
            if(empty($data)){
                $error= ''.$field.' laukelis neužpildytas';
            }
            
            $subject = 'Naujas pranešimas';
            $to = 'karolinak93@gmail.com';
            $message = ''.$_POST['message'].'';
            $id=''.$_SESSION['id'].'';
            $sender = ''.$_SESSION['email'].'';
            $headers = "From: $sender";
            }
            if(empty($error)){
                mail($to, $subject, $message, $headers);
                $sql = "INSERT INTO messages (user_id, message)
                VALUES ('$id', '$message')";
                if(mysql_query($sql)){
                $message="Išsiųsta";
                }
                else{
                    echo mysql_error();
                }
            }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sveiki | &nbsp;<?php echo ''.$_SESSION['username'].''; ?></title>
        <meta charset="utf-8" lang="lt">
    </head>
    <body>
        <link href="style3.css" rel="stylesheet" type="text/css">
        <meta charset="utf-8" lang="lt">
        <span id="error"><?php echo ((isset($error) && $error != '') ? $error : ''); ?></span>
        <span id="message"><?php echo ((isset($message) && $message != '') ? $message : ''); ?></span>
        <div class="menu">
                <label>Vartotojo vardas:<?php echo ''.$_SESSION['username'].''; ?></label>
                <a href="logout.php">Atsijungti</a>
                <a href="edit.php?=<?php echo ''.$_SESSION['username'].''; ?>">Redaguoti profilį</a>
            </div>
                    <form action="user.php?=<?php echo ''.$_SESSION['username'].''; ?>" method="post">
                    	<span id="contact">
                    		<div id="contact-box">
                    			<div id="label">Susisiekite su mumis</div>
                    				<div class="input">
                    					<textarea name="message"></textarea>
      								</div>
      								<span class="button">
       							 		<input type="submit" id="submit" name="submit" value="Siųsti">
      								</span>
    						</div>
  						</span>
					</form>
    </body>
</html>