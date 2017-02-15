<?php
    include("db.php");

    if(isset($_POST['submit'])){        
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password1=$_POST['password1'];
    $name=$_POST['name'];
    $surname=$_POST['surname'];
    $dob=$_POST['dob'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $zip=$_POST['zip'];
    $email=$_POST['email'];
    $telephone=$_POST['telephone'];
    $gender=$_POST['gender'];

	$fields =[
	'Vartotojo vardas' => $username,
	'Slaptažodis' => $password,
	'Pakartokite slaptažodį' => $password1,
	'Vardas' => $name,
	'Pavardė' => $surname,
	'Adresas' => $address,
	'Gimimo data' => $dob,
	'Miestas' => $city,
	'Pašto indeksas' => $zip,
	'El. paštas' => $email,
	'Telefono nr.' => $telephone	
	];
        
    if (!isset($gender)) {
        $error = "Pasirinkite lytį";
    }
        
    date_default_timezone_set('Europe/Vilnius');

    $newDate = date("Y F j", strtotime($dob));
    
if (time() < strtotime('+18 years', strtotime($newDate))) {
   $error='Esate per jaunas';
}

    foreach($fields as $field =>$data){
            if($data=''){
                $error='Laukelis '.$field.' neužpildytas';
            }
        }

    if ((strlen($username))<3){
    	$error='Vartotojo vardas turi būti netrumpesnis nei 3 simboliai';
    }
    
    if((strlen($password)<6)) {
        $error='Slaptažodis turi būti netrumpesnis nei 6 simboliai';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error='El. paštas nėra tinkamas';
    } 
    else {
        $usernameandemail = mysql_query("SELECT * FROM user WHERE username='".$username."' OR email='".$email."'");
        $numrows=mysql_num_rows($usernameandemail);
        if($numrows==1){
            $error='Esate užsiregistravęs';
        }
    }
        if(!isset($_POST["check"])){
            $error='Sutikite su sąlygomis';
        }
    
        if ($password!=$password1){
            $error='Slaptažodžiai nesutampa';
        }
        
        if(empty($error)){
        $insert = "INSERT INTO user(
        username, 
        password, 
        name, 
        surname, 
        dob, 
        address, 
        city, 
        zip, 
        email, 
        telephone,
        gender) 
        VALUES (
        '".$username."', 
        MD5('".$password."'), 
        '".$name."', 
        '".$surname."',
        '".$dob."',
        '".$address."',
        '".$city."',
        '".$zip."',
        '".$email."',
        '".$telephone."',
        '".$gender."')";
        }
            if($sql=mysql_query($insert)){
            	$message= 'Registracija sekminga, galite prisijungti';
            }
            else{
            	echo mysql_error();
            }
            
        }
    
?>
<!DOCTYPE html>
<html>
    <body>
        <link href="style1.css" rel="stylesheet" type="text/css">
            <meta charset="utf-8" lang="lt">
                <span id="error"><?php echo ((isset($error) && $error != '') ? $error : ''); ?></span>
                <span id="message"><?php echo ((isset($message) && $message != '') ? $message : ''); ?></span>
                    <form action="signup.php" method="post" enctype="multipart/form-data">
                    	<span id="signup">
                            <table>
                                <th colspan="3">
                                    <div id="label">Registracija</div>
                                </th>
                              <tr>
                                <td><div id="input"><input type="text" name="username" placeholder="Vartotojo vardas"></div></td>
                                <td><div id="input"><input type="password" name="password" placeholder="Slaptažodis"></div></td>
                                <td><div id="input"><input type="password" name="password1" placeholder="Pakartokite slaptažodį"></div></td>
                              </tr>
                              <tr>
                                <td><div id="input"><input type="text" name="name" placeholder="Vardas"></div></td>
                                <td><div id="input"><input type="text" name="surname" placeholder="Pavardė"></div></td>
                                <td><div id="input"><input type="date" name="dob" placeholder="Gimimo data"></div></td>
                              </tr>
                              <tr>
                                <td>
                                    <div id="radio">
                                    <label><input type="radio" name="gender" value="moteris" >Moteris</label>
                                    <label><input type="radio" name="gender" value="vyras" >Vyras</label>
                                    </div>
                                </td>
                                <td><div id="input"><input type="text" name="address" placeholder="Adresas"></div></td>
                                <td><div id="city">
                                    <select name="city">
                                        <?php 
                                        $result = mysql_query("SELECT id, city FROM `cities`");
                                        while($row = mysql_fetch_array($result)){
                                        echo "<option value='" .$row[id]. "'>" .$row[city]. "</option>";
                                        };
                                        ?>
                                    </select>
                                </div></td>
                                </tr>
                              <tr>
                                <td><div id="input"><input type="text" name="zip" placeholder="Pašto indeksas"></div></td>
                                <td><div id="input"><input type="email" name="email" placeholder="El. paštas"></div></td>
                                <td><div id="input"><input type="tel" name="telephone" placeholder="Telefono numeris"></div></td>
                              </tr>
                                <tr>
                                    <td colspan="2"><span id="checkbox"><label><input type="checkbox" name="check"> Sutinku su naudojimosi sąlygomis </label></span></td>
                                    <td><span id="button"><input type="submit" name="submit" value="Patvirtinti"></span></td>
                                </tr>
                            </table>
    						           </span>
					          </form>
    </body>
</html>
