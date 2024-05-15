<?php
echo "ciao";
$servername = "db";
$username = "ignazio";
$password = "mistretta";
$dbname = "progetto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connessione al database fallita: ";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];


    $sql = "SELECT * FROM Utente WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login corretto, reindirizza all'area riservata
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        header("Location: relazione.php");
    } else {

        header("Location: login.php");
    }
}

$conn->close();
?>

