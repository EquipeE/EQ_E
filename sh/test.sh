#!/bin/sh
 
AZUL='\033[34;1m'
AMARELO='\033[33;1m'
RESET='\033[0m'
ADMIN_PASS='Senha@123'

test_case() { # test_case(char *name, char *cmd, char *cmd_filter)
	printf "\n$AZUL $1: $RESET\n"
	printf "$AMARELO%s $RESET" `eval "$2" | eval "$3"`
}

cmd_filter="sed -n \"/<div id='resultado.*'>/,/<\/div>/p\""

printf "$AZUL------------------- Suite de testes --------------------\n$RESET"
printf "\n$AZUL---------- Cadastro ---------$RESET\n"


nome=`openssl rand -hex 150`
email="`openssl rand -hex 25`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
printf "Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Nome muito longo" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

nome=`openssl rand -hex 10`
email="`openssl rand -hex 150`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
printf "Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Email válido muito longo" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

nome=`openssl rand -hex 10`
email=`openssl rand -hex 150`
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
printf "Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Email inválido muito longo" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

nome=''
email=''
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
printf "Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Inserção nula" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

nome=`openssl rand -hex 10`
email=`openssl rand -hex 25`
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
printf "Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Email inválido" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

nome="'', '', ''); DROP DATABASE mredes --"
email="`openssl rand -hex 25`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
printf "Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "SQL Injection" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"

nome=`openssl rand -hex 10`
email_valido="`openssl rand -hex 25`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email_valido&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
printf "Nome: $nome\nEmail: $email_valido\nSenha: $ADMIN_PASS\n"
test_case "Cadastro válido" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3"


printf "\n$AZUL--------- Login ---------$RESET\n"


email=`openssl rand -hex 40`
cmd="curl -b first_cookie.txt -X POST -d \"email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
printf "\n\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Email inexistente" "$cmd" "$cmd_filter"

email="'', '', ''); DROP DATABASE mredes --"
cmd="curl -b first_cookie.txt -X POST -d \"email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
printf "\n\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "SQL Injection" "$cmd" "$cmd_filter"

cmd="curl -b first_cookie.txt -X POST -d \"email=$email_valido&senha=$ADMIN_PASS.1\" localhost/EQ_E/html/login.php"
printf "\n\nEmail: $email_valido\nSenha: $ADMIN_PASS.1\n"
test_case "Senha errada" "$cmd" "$cmd_filter"

cmd="curl -b first_cookie.txt -X POST -d \"email=$email_valido&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
printf "\n\nEmail: $email_valido\nSenha: $ADMIN_PASS\n"
test_case "Login correto" "$cmd" "$cmd_filter"

cmd="curl -b first_cookie.txt -X POST -d \"email=a@a.com&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
printf "\n\nEmail: a@a.com\nSenha: $ADMIN_PASS\n"
test_case "Login como admin" "$cmd" "$cmd_filter"


printf "\n$AZUL--------- Comentário ---------$RESET\n"


post='AAAA'
comentario=`openssl rand -hex 1000`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "Comentário em post inexistente" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

post=2
comentario=`openssl rand -hex 35000`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "Comentário muito longo" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

post=2
comentario=`openssl rand -hex 1000`
cmd="curl -L -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "Comentário sem estar logado" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

post="'', '', ''); DROP DATABASE mredes --"
comentario=`openssl rand -hex 1000`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "SQL Injection" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

post=2
comentario='<script>alert(1)</script>'
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "XSS" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

post=''
comentario=`openssl rand -hex 1000`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "Post nulo" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

post=2
comentario=''
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "Comentário nulo" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"

post=''
comentario=''
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
printf "Post: $post\nComentario: $comentario\n"
test_case "Post e comentário nulos" "$cmd" "$cmd_filter"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3"


printf "\n$AZUL--------- Tela de admin ---------$RESET\n"


titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf \"%s%s\" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post sem estar logado" "$cmd" "cat"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

id=5
titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \"id=$id\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post sem estar logado" "$cmd" "cat"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

id=5
cmd="curl -L -X POST -d \"id=$id\" localhost/EQ_E/html/admin.php?op=delete"
printf "Id=$id\n"
test_case "Deletando post sem estar logado" "$cmd" "cat"
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post logado, mas sem ser admin:$RESET\n"
titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b tmp_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post logado, mas sem ser admin:$RESET\n"
id=5
titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
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
imagem='@../img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com titulo muito longo:$RESET\n"
titulo=`openssl rand -hex 75`
conteudo='aa'
imagem='@../img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com titulo nulo:$RESET\n"
titulo=''
conteudo='aa'
imagem='@../img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com conteudo muito longo:$RESET\n"
titulo='aaaaa'
conteudo=`openssl rand -hex 35000`
imagem='@../img/art2.png'
printf "Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/add_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Adicionando post com conteudo vazio:$RESET\n"
titulo='aaaaab'
conteudo=''
imagem='@../img/art2.png'
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
imagem='@../img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com titulo repetido:$RESET\n"
id=5
titulo='Post 4'
conteudo='aa'
imagem='@../img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com titulo muito longo:$RESET\n"
id=5
titulo=`openssl rand -hex 75`
conteudo='aa'
imagem='@../img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com titulo nulo:$RESET\n"
titulo=''
conteudo='aa'
imagem='@../img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com conteudo muito longo:$RESET\n"
id=2
titulo='aaaaa'
conteudo=`openssl rand -hex 35000`
imagem='@../img/art2.png'
printf "Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
printf "$AMARELO%s $RESET" `curl -b admin_cookie.txt -X POST -F "id=$id" -F "titulo=$titulo" -F "conteudo=$conteudo" -F \`printf "%s%s" "imagem=" $imagem\` localhost/EQ_E/php/posts/update_post.php`
printf "\n\nOlhando banco...\n\n"
mariadb "mredes" -e "SELECT * FROM Posts ORDER BY id DESC LIMIT 2"

printf "\n$AZUL Atualizando post com conteudo vazio:$RESET\n"
id=1
titulo='aaaaab'
conteudo=''
imagem='@../img/art2.png'
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
