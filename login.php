<?php
require 'index.php';
session_start();
$email = $_POST['email'];
$password = $_POST['password'];

$login = "SELECT * FROM utente WHERE username LIKE '$email' AND password LIKE '$password'";


if(($conn -> query($login)) -> num_rows > 0){

    $_SESSION['password'] = $password;
    $_SESSION['email'] = $email;
    
    echo "ciao";
    header("Location: relazione.php");
}
else{
    echo "no";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <a>email</a>
        <input type="text", name="email", required>
        <a>password</a>
        <input type="password" name="password", required>
        <input type="submit" value="login">
    </form>
</body>
</html>
