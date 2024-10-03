#!/bin/sh
IP=localhost
PORTA=80

mkdir -p ../img/posts/
[ -e ../index.php ] && rm ../index.php 
[ -e ../html/blog.php ] && rm ../html/blog.php

chown apache:apache ../ ../html/ ../img/posts/ ../txt # Dando permissão de escrita nas pastas corretas. Comente essa linha em Windows.

curl -b first_cookie.txt -c admin_cookie.txt -X POST "$IP:$PORTA/EQ_E/html/login.php" --data-raw "email=a@a.com&senha=Senha@123" 

curl -b admin_cookie.txt -F "titulo=Stallman's Momentary Lapse of Reason" -F 'imagem=@../img/art1.png' -F 'conteudo=<../txt/interjection.txt' "$IP:$PORTA/EQ_E/php/posts/add_post.php"
curl -b admin_cookie.txt -F "titulo=História chocante acontece na USP" -F 'imagem=@../img/art2.png' -F "conteudo=<../txt/usp.txt" "$IP:$PORTA/EQ_E/php/posts/add_post.php"
curl -b admin_cookie.txt -F "titulo=O Monólogo" -F 'imagem=@../img/art3.png' -F "conteudo=<../txt/truth.txt" "$IP:$PORTA/EQ_E/php/posts/add_post.php"
curl -b admin_cookie.txt -F "titulo=Post 4" -F 'imagem=@../img/art4.png' -F "conteudo=<../txt/ratinho.txt" "$IP:$PORTA/EQ_E/php/posts/add_post.php"
curl -b admin_cookie.txt -F "titulo=Just as the founding fathers intended." -F 'imagem=@../img/art1.png' -F 'conteudo=<../txt/founding_fathers.txt' "$IP:$PORTA/EQ_E/php/posts/add_post.php"

rm admin_cookie.txt
