<?php
require 'index.php';
session_start();
$email = $_POST['email'];
$password = $_POST['password'];

$login = "SELECT * FROM clienti WHERE Email LIKE '$email' AND Password LIKE '$password'";


if(($conn -> query($login)) -> num_rows > 0){

    $_SESSION['password'] = $password;
    $_SESSION['email'] = $email;
    header("location: member.php");

    //file_get_content legge il contenuto di un file
    //$html_biblioteca = file_get_contents('home_biblioteca.html');
    //echo $html_biblioteca;
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
