<?php

$servername = "172.18.0.3";
$username = "andrea";
$password = "password";
$dbname = "your_docker_project";

$conn = new mysqli($servername,$username,$password,$dbname);
//i dati devono essere scritti in questo ordine
if($conn -> error){
    echo 'errore di connessione';

}else{
    header("Location: login.php");
    
}
?>
