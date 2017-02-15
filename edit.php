<?php
session_start();
include("db.php");
$id = $_SESSION["id"];

$sql=mysql_query("SELECT * from user where id=$id");
$user=mysql_fetch_array($sql);
$pass = $user["password"];

$passold = $_POST["passold"];
$passnew = $_POST["passnew"];
$passnew1 = $_POST["passnew1"];
$name = $_POST["name"];
$surname = $_POST["surname"];
$dob = $_POST["dob"];
$address = $_POST["address"];
$city = $_POST["city"];
$zip = $_POST["zip"];
$telephone = $_POST["telephone"];
$gender= $_POST["gender"];

if(isset($_POST['submit'])){
    if (!isset($gender)) {
        $error = "Pasirinkite lytį";
    }
    if($pass != MD5($passold)){
        $error= "Neteisingas senas slaptažodis";
    }

    if($passnew != $passnew1){
        $error= "Slaptažodžiai nesutampa";
    }
    if((strlen($passnew))<6) {
        $error= "Slaptažodis turi būti netrumpesnis nei 6 simboliai";
    }
    
    date_default_timezone_set('Europe/Vilnius');
    
    $newDate = date("Y F j", strtotime($dob));
    
    if (time() < strtotime('+18 years', strtotime($dob))) {
        $error= 'Esate per jaunas';
    }
    
    $fields =[
	'Senas slaptažodis' => $_POST['passold'],
    'Naujas slaptažodis' => $_POST['passnew'],
	'Pakartokite naują slaptažodį' => $_POST['passnew1'],
	'Vardas' => $_POST['name'],
	'Pavardė' => $_POST['surname'],
	'Adresas' => $_POST['address'],
	'Gimimo data' => $_POST['dob'],
	'Miestas' => $_POST['city'],
	'Pašto indeksas' => $_POST['zip'],
	'Telefono nr.' => $_POST['telephone']	
	];
    
    foreach($fields as $field =>$data){
            if($data=''){
                $error= ''.$field.' laukelis neužpildytas';
            }
        }
        
    if(empty($error)){
    $update = ("UPDATE user SET password=MD5('$passnew'), name='$name', surname='$surname', dob='$dob', address='$address', city='$city', zip='$zip', telephone='$telephone', gender='$gender' WHERE id='$id'");
    mysql_query($update);
    $message= "Pakeista";
    header("Refresh:3");
	}
}
?>
<!DOCTYPE html>
<html>
    <body>
        <link href="style2.css" rel="stylesheet" type="text/css">
            <meta charset="utf-8" lang="lt">
                <span id="error"><?php echo ((isset($error) && $error != '') ? $error : ''); ?></span>
                <span id="message"><?php echo ((isset($message) && $message != '') ? $message : ''); ?></span>
                    <form action="edit.php?=<?php echo ''.$_SESSION['username'].''; ?>" method="post" enctype="multipart/form-data">
                    	<span id="edit">
                            <table>
                                <th colspan="3"><div id="label">Redaguoti</div></th>
                              <tr>
                                <td><div id="input"><input type="password" name="passold" placeholder="Senas slaptažodis"></div></td>
                                <td><div id="input"><input type="password" name="passnew" placeholder="Naujas slaptažodis"></div></td>
                                <td><div id="input"><input type="password" name="passnew1" placeholder="Pakartokite naują slaptažodį"></div></td>
                              </tr>
                              <tr>
                                <td><div id="input"><input type="text" name="name" placeholder="Įveskite vardą" value="<?php echo $user['name'];?>"></div></td>
                                <td><div id="input"><input type="text" name="surname" placeholder="Įveskite pavardę" value="<?php echo $user['surname'];?>"></div></td>
                                <td><div id="input"><input type="date" name="dob" placeholder="Pasirinkti gimimo datą" value="<?php echo $user['dob']; ?>"></div></td>
                              </tr>
                              <tr>
                                  <td>
                                    <div id="radio">
                                    <?php $female=($user['gender']=='moteris'? "checked='checked'":"");
                                            $male=($user['gender']=='vyras'? "checked='checked'":"");?>
                                    <label><input type="radio" name="gender" value="moteris" <?php echo $female; ?>>Moteris</label>
                                    <label><input type="radio" name="gender" value="vyras" <?php echo $male;?>>Vyras</label>
                                    </div>
                                </td>
                                <td><div id="input"><input type="text" name="address" placeholder="Įveskite adresą" value="<?php echo $user['address']; ?>"></div></td>
                                <td><div id="city">
                                    <select name="city">
                                        <?php 
                                        $result = mysql_query("SELECT id, city FROM `cities`");
                                        while($row = mysql_fetch_array($result)){
                                        $selected = ($row[id] == $user['city'] ? "selected='selected'" : "" );
                                        echo "<option value='" . $row[id] . "'" . $selected . ">" . $row[city] . "</option>";
                                        };
                                        ?>
                                    </select>
                                    </div></td>
                                </tr>
                              <tr>
                                  <td><div id="input"><input type="text" name="zip" placeholder="Įveskite pašto indeksą" value="<?php echo $user['zip']; ?>"></div></td>
                                <td><div id="input"><input type="tel" name="telephone" placeholder="Įveskite telefono numerį" value="<?php echo $user['telephone']; ?>"></div></td>
                            </tr>
                                <tr>
                                    <td colspan="3"><span id="button"><input type="submit" name="submit" value="Išsaugoti"></span></td>
                                </tr>
                            </table>
    						</span>
					</form>
    </body>
</html>