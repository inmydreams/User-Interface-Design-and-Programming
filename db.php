<?php
$conn = mysql_connect('','','');
mysql_query("SET NAMES UTF8");
    if(!$conn){
    die('Neįmanona prisijungti'. mysql_error());
    }

    $db_selected = mysql_select_db('login', $conn);
    if(!$db_selected){
    die('Duomenų bazė nerasta'. mysql_error());
    }
?>