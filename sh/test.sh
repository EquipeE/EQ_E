#!/bin/sh
 
AZUL='\033[34;1m'
AMARELO='\033[33;1m'
RESET='\033[0m'

printf "$AZUL------------------- Suite de testes --------------------\n$RESET"
printf "\n$AZUL---------- Cadastro ---------$RESET\n"

printf "\n$AZUL Nome muito longo:$RESET\n"
nome=`openssl rand -hex 150`
email="`openssl rand -hex 25`@gmail.com"
printf "Nome: $nome\nEmail: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "nome=$nome&email=$email&senha=Senha@123" localhost/EQ_E/html/cadastro.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Email válido muito longo:$RESET\n"
nome=`openssl rand -hex 10`
email="`openssl rand -hex 150`@gmail.com"
printf "Nome: $nome\nEmail: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "nome=$nome&email=$email&senha=Senha@123" localhost/EQ_E/html/cadastro.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Email inválido muito longo:$RESET\n"
nome=`openssl rand -hex 10`
email=`openssl rand -hex 150`
printf "Nome: $nome\nEmail: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "nome=$nome&email=$email&senha=Senha@123" localhost/EQ_E/html/cadastro.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Inserção nula:$RESET\n"
nome=''
email=''
printf "Nome: $nome\nEmail: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "nome=$nome&email=$email&senha=Senha@123" localhost/EQ_E/html/cadastro.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Email inválido:$RESET\n"
nome=`openssl rand -hex 10`
email=`openssl rand -hex 25`
printf "Nome: $nome\nEmail: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "nome=$nome&email=$email&senha=Senha@123" localhost/EQ_E/html/cadastro.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL SQL Injection:$RESET\n"
nome="'', '', ''); DROP DATABASE mredes --"
email="`openssl rand -hex 25`@gmail.com"
printf "curl %s\n" "$curl_opts"
printf "Nome: $nome\nEmail: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "nome=$nome&email=$email&senha=Senha@123" localhost/EQ_E/html/cadastro.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Cadastro válido:$RESET\n"
nome=`openssl rand -hex 10`
email_valido="`openssl rand -hex 25`@gmail.com"
printf "Nome: $nome\nEmail: $email_valido\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "nome=$nome&email=$email_valido&senha=Senha@123" localhost/EQ_E/html/cadastro.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"


printf "\n$AZUL--------- Login ---------$RESET\n"


printf "\n$AZUL Email que não existe:$RESET\n"
email=`openssl rand -hex 40`
printf "Email: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "email=$email&senha=Senha@123" localhost/EQ_E/html/login.php`
printf "\n"

printf "\n$AZUL SQL Injection:$RESET\n"
email="'', '', ''); DROP DATABASE mredes --"
printf "Email: $email\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "email=$email&senha=Senha@123" localhost/EQ_E/html/login.php`
printf "\n"

printf "\n$AZUL Senha errada:$RESET\n"
printf "Email: $email_valido\nSenha: Senha@1231\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -X POST -d "email=$email_valido&senha=Senha@1231" localhost/EQ_E/html/login.php`
printf "\n"

printf "\n$AZUL Senha e email corretos:$RESET\n"
printf "Email: $email_valido\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -c tmp_cookie.txt -X POST -d "email=$email_valido&senha=Senha@123" localhost/EQ_E/html/login.php`
printf "\n"

printf "\n$AZUL Login como admin:$RESET\n"
printf "Email: a@a.com\nSenha: Senha@123\n"
printf "$AMARELO%s $RESET" `curl -b first_cookie.txt -c admin_cookie.txt -X POST -d "email=a@a.com&senha=Senha@123" localhost/EQ_E/html/login.php`
printf "\n"


printf "\n$AZUL--------- Comentário ---------$RESET\n"


printf "\n$AZUL Comentando em post que não existe:$RESET\n"
post='AAAA'
comentario=`openssl rand -hex 1000`
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Comentário muito longo:$RESET\n"
post=2
comentario=`openssl rand -hex 35000`
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Comentario sem estar logado:$RESET\n"
post=2
comentario=`openssl rand -hex 1000`
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL SQL Injection:$RESET\n"
post="'', '', ''); DROP DATABASE mredes --"
comentario=`openssl rand -hex 1000`
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL XSS:$RESET\n"
post=2
comentario='<script>alert(1)</script>'
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Post nulo:$RESET\n"
post=''
comentario=`openssl rand -hex 1000`
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Comentário nulo:$RESET\n"
post=2
comentario=''
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

printf "\n$AZUL Post e comentário nulos:$RESET\n"
post=''
comentario=''
printf "Post: $post\nComentario: $comentario\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "post_id=$post&comment=$comentario" localhost/EQ_E/php/comentarios/add_comment.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"


printf "\n$AZUL--------- Tela de admin ---------$RESET\n"


printf "\n$AZUL Adicionando post sem estar logado:$RESET\n"
titulo='teste'
conteudo='aa'
imagem='@./img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post sem estar logado:$RESET\n"
id=5
titulo='teste'
conteudo='aa'
imagem='@./img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Deletando post sem estar logado:$RESET\n"
id=5
printf "Id=$id\n"
printf "$AMARELO%s $RESET" `curl -X POST -d "id=$id" localhost/EQ_E/php/posts/delete_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post logado, mas sem ser admin:$RESET\n"
titulo='teste'
conteudo='aa'
imagem='@./img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post logado, mas sem ser admin:$RESET\n"
id=5
titulo='teste'
conteudo='aa'
imagem='@./img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Deletando post logado, mas sem ser admin:$RESET\n"
id=5
printf "Id=$id\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -d "id=$id" localhost/EQ_E/php/posts/delete_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com titulo repetido:$RESET\n"
titulo='Post 4'
conteudo='aa'
imagem='@./img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com titulo muito longo:$RESET\n"
titulo=`openssl rand -hex 75`
conteudo='aa'
imagem='@./img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com titulo nulo:$RESET\n"
titulo=''
conteudo='aa'
imagem='@./img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com conteudo muito longo:$RESET\n"
titulo='aaaaa'
conteudo=`openssl rand -hex 35000`
imagem='@./img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com conteudo vazio:$RESET\n"
titulo='aaaaab'
conteudo=''
imagem='@./img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com shell script ao invés de imagem:$RESET\n"
titulo='bbbbb'
conteudo='a'
imagem='@./test.sh'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com arquivo php ao invés de imagem:$RESET\n"
titulo='ccccc'
conteudo='a'
imagem='@./html/login.php'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com binário ao invés de imagem:$RESET\n"
titulo='ddddd'
conteudo='a'
imagem='@/bin/sh'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com id inexistente:$RESET\n"
id='AAAAAA'
titulo='Post 4'
conteudo='aa'
imagem='@./img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com titulo repetido:$RESET\n"
id=5
titulo='Post 4'
conteudo='aa'
imagem='@./img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com titulo muito longo:$RESET\n"
id=5
titulo=`openssl rand -hex 75`
conteudo='aa'
imagem='@./img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com titulo nulo:$RESET\n"
titulo=''
conteudo='aa'
imagem='@./img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com conteudo muito longo:$RESET\n"
id=2
titulo='aaaaa'
conteudo=`openssl rand -hex 35000`
imagem='@./img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com conteudo vazio:$RESET\n"
id=1
titulo='aaaaab'
conteudo=''
imagem='@./img/art2.png'
printf "Id:$id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com shell script ao invés de imagem:$RESET\n"
id=3
titulo='bbbbb'
conteudo='a'
imagem='@./test.sh'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com arquivo php ao invés de imagem:$RESET\n"
id=4
titulo='ccccc'
conteudo='a'
imagem='@./html/login.php'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com binário ao invés de imagem:$RESET\n"
id=5
titulo='ddddd'
conteudo='a'
imagem='@/bin/sh'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Deletando post com id inexistente:$RESET\n"
id='AAAAAAAAAAAAA'
printf "Id: $id\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -d "id=$id" localhost/EQ_E/php/posts/delete_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

rm admin_cookie.txt
rm tmp_cookie.txt
