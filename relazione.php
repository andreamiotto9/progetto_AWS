<?php
require "index.php";
session_start();

if (!isset($_SESSION['username']) || $_SESSION['password'] !== true) {
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pagina Protetta</title>
</head>
<body>
    <h1 class="testo1">RELAZIONE PROGETTO AWS</h1>
    <div class="container_div">
        <h2 class="testo2">STEP 1</h2>
        <h3 class="testo3">installare docker</h3>
        <h4 class="testo">1. sudo apt update</h4>
        <h4 class="testo">2. sudo apt upgrade</h4>
        <h4 class="testo">3. sudo apt install -y docker.io</h4>

    </div>
    <div class="container_div">
        <h2 class="testo2">STEP 2</h2>
        <h3 class="testo3">aggiungere e configurare nginx</h3>
        <h4 class="testo">1.  sudo nano docker-compose.yml</h4>
        <h4 class="testo">2. aggiungere il seguente codice al docker-compose.yml
            <br>version: "3.9"
            <br>services:
                <br>nginx:
                <br>image: nginx:latest
                <br> container_name: nginx-container
                <br>ports:
                <br>- 80:80</h4>
        <h4 class="testo">3. docker-compose up -d</h4>
        <h4 class="testo">4.  creazione del certificato SSL <br>sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ~/ssl/key.pem -out ~/ssl/cert.pem</h4>
        <h4 class="testo">5.  connesione a nginx <br>sudo docker run -d --name proxyapp --network docker-project_default -p 443:443 -e DOMAIN=*.compute-1.amazonaws.com -e TARGET_PORT=80 -e TARGET_HOST=docker-project-nginx-1 -e SSL_PORT=443 -v ~/ssl:/etc/nginx/certs --restart unless-stopped fsouza/docker-ssl-proxy</h4>

    </div>
    <div class="container_div">
        <h2 class="testo2">STEP 3</h2>
        <h3 class="testo3">aggiungere e configurare PHP</h3>
        <h4 class="testo">1. mkdir ~/docker-project/php_code</h4>
        <h4 class="testo">2. git clone https://github.com/andreamiotto9/progetto_AWS ~/docker-project/php_code/</h4>
        <h4 class="testo">3. sudo nano Dockerfile</h4>
        <h4 class="testo">4. aggiungere il seguente codice al Dockerfile
            <br>FROM php:7.0-fpm
            <br>RUN docker-php-ext-install mysqli pdo pdo_mysql
            <br>RUN docker-php-ext-enable mysqli
        </h4>
        <h4 class="testo">5. collegare nginx a php
            sudo nano ~/docker-project/nginx/default.conf
        </h4>
        <h4 class="testo">6 aggiungere questo codice a default.conf
            <br>server {  
                <br> listen 80 default_server;  
                <br> root /var/www/html;  
                <br> index index.html index.php;  
                <br>  
                <br> charset utf-8;  
                <br>  
                <br> location / {  
                <br>  try_files $uri $uri/ /index.php?$query_string;  
                <br> }  
                <br>  
                <br> location = /favicon.ico { access_log off; log_not_found off; }  
                <br> location = /robots.txt { access_log off; log_not_found off; }  
                <br>  
                <br> access_log off;  
                <br> error_log /var/log/nginx/error.log error;  
                <br>  
                <br> sendfile off;  
                <br>  
                <br> client_max_body_size 100m;  
                <br>  
                <br> location ~ .php$ {  
                <br>  fastcgi_split_path_info ^(.+.php)(/.+)$;  
                <br>  fastcgi_pass php:9000;  
                <br>  fastcgi_index index.php;  
                <br>  include fastcgi_params;  
                <br>  fastcgi_read_timeout 300;  
                <br>  fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;  
                <br>  fastcgi_intercept_errors off;  
                <br>  fastcgi_buffer_size 16k;  
                <br>  fastcgi_buffers 4 16k;  
                <br> }  
                <br>  
                <br> location ~ /.ht {  
                <br>  deny all;  
                <br> }  
                <br>}
                
        </h4>

        <h4 class="testo">7. tornare nel docker-compose.yml e aggiungere
            <br>volumes:
         <br>- ./php_code/:/var/www/html/
        <br>php:
        <br>build: ./php_code/
        <br>expose:
        <br>- 9000
        <br>volumes:
            <br>- ./php_code/:/var/www/html/
        </h4>
        <h4 class="testo">8. sudo docker-compose up -d
        </h4>

    </div>
    <div class="container_div">
        <h2 class="testo2">STEP 4</h2>
        <h3 class="testo3">aggiungere e configurare mariaDB</h3>
        <h4 class="testo">1. aggiungi il seguente codice al file docker-compose.yml
            <br>db:    
            <br>  image: mariadb  
            <br>  volumes: 
            <br>    - mysql-data:/var/lib/mysql
            <br>  environment:  
            <br>    MYSQL_ROOT_PASSWORD: mariadb
            <br>    MYSQL_DATABASE: AWS
            <br>
            <br>volumes:
            <br>  mysql-data:
        </h4>
        <h4 class="testo">2. sudo docker-compose up -d</h4>
        <h4 class="testo">3.<br> <img src="creazione db.png" alt="" class="img"></h4>
        <h4 class="testo">risultato: <br> <img src="risultato db.png" alt="" class="img"></h4>
        

    </div>
    
    <a href="logout.php">Logout</a>
</body>
</html>
