<?php

$host = 'localhost';
$dbname = 'anagrafica';
$dbuser = 'root';
$dbpass = '';
$dbport = 3306;

$conn = new mysqli($host,$dbuser,$dbpass,$dbname,$dbport);
//i dati devono essere scritti in questo ordine
if($conn -> error){
    echo 'errore di connessione';

}else{
    header("Location: login.php");
    
}
?>
