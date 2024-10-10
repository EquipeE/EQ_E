#!/bin/sh
 
AZUL='\033[34;1m'
AMARELO='\033[33;1m'
ROXO='\033[35;1m'
RESET='\033[0m'
ADMIN_PASS='Senha@123'

test_case() { # test_case(char *name, char *info_str, char *cmd, char *cmd_filter, char *sql_cmd)
	printf "\n$AZUL%s:$RESET\n" "$1"
	printf "\n$ROXO%b$RESET\n" "$2"
	printf "$AMARELO%s $RESET" `eval "$3" | eval "$4"`
	[ -n "$5" ] && printf "\n\nOlhando banco...\n\n"
	mariadb "mredes" -e "$5"
	printf "\n$AZUL%s$RESET\n" "----------"
}

cmd_filter="sed -n \"/<div id='resultado.*'>/,/<\/div>/p\""

printf "$AZUL------------------- Suite de testes --------------------\n$RESET"
printf "\n$AZUL---------- Cadastro ---------$RESET\n"

sql_cmd='SELECT * FROM Usuarios ORDER BY id DESC LIMIT 3'


nome=`openssl rand -hex 150`
email="`openssl rand -hex 25`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
info_str="Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Nome muito longo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

nome=`openssl rand -hex 10`
email="`openssl rand -hex 150`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
info_str="Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Email válido muito longo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

nome=`openssl rand -hex 10`
email=`openssl rand -hex 150`
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
info_str="Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Email inválido muito longo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

nome=''
email=''
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
info_str="Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Inserção nula" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

nome=`openssl rand -hex 10`
email=`openssl rand -hex 25`
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
info_str="Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "Email inválido" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

nome="'', '', ''); DROP DATABASE mredes --"
email="`openssl rand -hex 25`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
info_str="Nome: $nome\nEmail: $email\nSenha: $ADMIN_PASS\n"
test_case "SQL Injection" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

nome=`openssl rand -hex 10`
email_valido="`openssl rand -hex 25`@gmail.com"
cmd="curl -b first_cookie.txt -X POST -d \"nome=$nome&email=$email_valido&senha=$ADMIN_PASS\" localhost/EQ_E/html/cadastro.php"
info_str="Nome: $nome\nEmail: $email_valido\nSenha: $ADMIN_PASS\n"
test_case "Cadastro válido" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"


printf "\n$AZUL--------- Login ---------$RESET\n"


email=`openssl rand -hex 40`
cmd="curl -b first_cookie.txt -X POST -d \"email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
info_str="Email: $email\nSenha: $ADMIN_PASS\n"
test_case "Email inexistente" "$info_str" "$cmd" "$cmd_filter"

email="'', '', ''); DROP DATABASE mredes --"
cmd="curl -b first_cookie.txt -X POST -d \"email=$email&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
info_str="Email: $email\nSenha: $ADMIN_PASS\n"
test_case "SQL Injection" "$info_str" "$cmd" "$cmd_filter"

cmd="curl -b first_cookie.txt -X POST -d \"email=$email_valido&senha=$ADMIN_PASS.1\" localhost/EQ_E/html/login.php"
info_str="Email: $email_valido\nSenha: $ADMIN_PASS.1\n"
test_case "Senha errada" "$info_str" "$cmd" "$cmd_filter"

cmd="curl -b first_cookie.txt -c tmp_cookie.txt -X POST -d \"email=$email_valido&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
info_str="Email: $email_valido\nSenha: $ADMIN_PASS\n"
test_case "Login correto" "$info_str" "$cmd" "$cmd_filter"

cmd="curl -b first_cookie.txt -c admin_cookie.txt -X POST -d \"email=a@a.com&senha=$ADMIN_PASS\" localhost/EQ_E/html/login.php"
info_str="Email: a@a.com\nSenha: $ADMIN_PASS\n"
test_case "Login como admin" "$info_str" "$cmd" "$cmd_filter"


printf "\n$AZUL--------- Comentário ---------$RESET\n"

sql_cmd='SELECT * FROM Comentarios ORDER BY id DESC LIMIT 3'

post='AAAA'
comentario=`openssl rand -hex 250`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "Comentário em post inexistente" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

post=2
comentario=`openssl rand -hex 35000`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "Comentário muito longo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

post=2
comentario=`openssl rand -hex 250`
cmd="curl -L -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "Comentário sem estar logado" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

post="'', '', ''); DROP DATABASE mredes --"
comentario=`openssl rand -hex 250`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "SQL Injection" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

post=2
comentario='<script>alert(1)</script>'
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "XSS" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

post=''
comentario=`openssl rand -hex 250`
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "Post nulo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

post=2
comentario=''
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "Comentário nulo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

post=''
comentario=''
cmd="curl -L -b tmp_cookie.txt -X POST -d \"comment=$comentario\" localhost/EQ_E/html/post.php?id=$post"
info_str="Post: $post\nComentario: $comentario\n"
test_case "Post e comentário nulos" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"


printf "\n$AZUL--------- Tela de admin ---------$RESET\n"

sql_cmd='SELECT * FROM Posts ORDER BY id DESC LIMIT 2'

titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf \"%s%s\" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post sem estar logado" "$info_str" "$cmd" "cat" "$sql_cmd"

id=5
titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \"id=$id\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post sem estar logado" "$info_str" "$cmd" "cat" "$sql_cmd"

id=5
cmd="curl -L -X POST -d \"id=$id\" localhost/EQ_E/html/admin.php?op=delete"
info_str="Id=$id\n"
test_case "Deletando post sem estar logado" "$info_str" "$cmd" "cat" "$sql_cmd"

titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -b tmp_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post logado, mas sem ser admin" "$info_str" "$cmd" "cat" "$sql_cmd"

id=5
titulo='teste'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -b tmp_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \"id=$id\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post logado, mas sem ser admin" "$info_str" "$cmd" "cat" "$sql_cmd"

id=5
cmd="curl -L -b tmp_cookie.txt -X POST -d \"id=$id\" localhost/EQ_E/html/admin.php?op=delete"
info_str="Id=$id\n"
test_case "Deletando post logado, mas sem ser admin" "$info_str" "$cmd" "cat" "$sql_cmd"

titulo='Post 4'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com título repetido" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo=`openssl rand -hex 75`
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com titulo muito longo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo=''
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com titulo nulo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo='aaaaa'
conteudo=`openssl rand -hex 35000`
imagem='@../img/art2.png'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com conteudo muito longo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo='aaaaab'
conteudo=''
imagem='@../img/art2.png'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com conteúdo vazio" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo='bbbbb'
conteudo='a'
imagem='@./test.sh'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com shell script ao invés de imagem" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo='ccccc'
conteudo='a'
imagem='@../html/login.php'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com arquivo php ao invés de imagem" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo='ddddd'
conteudo='a'
imagem='@/bin/sh'
cmd="curl -L -b admin_cookie.txt -X POST -F \"titulo=$titulo\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=add"
info_str="Titulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Adicionando post com binário ao invés de imagem" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id='AAAAAA'
titulo='Post 4'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com id inexistente" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id=5
titulo='Post 4'
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com titulo repetido" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id=5
titulo=`openssl rand -hex 75`
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com título muito longo:" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

titulo=''
conteudo='aa'
imagem='@../img/art2.png'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com título nulo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id=2
titulo='aaaaa'
conteudo=`openssl rand -hex 35000`
imagem='@../img/art2.png'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com conteúdo muito longo" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id=1
titulo='aaaaab'
conteudo=''
imagem='@../img/art2.png'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id:$id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com conteúdo vazio" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id=3
titulo='bbbbb'
conteudo='a'
imagem='@./test.sh'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com shell script ao invés de imagem" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id=4
titulo='ccccc'
conteudo='a'
imagem='@../html/login.php'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com arquivo php ao invés de imagem" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id=5
titulo='ddddd'
conteudo='a'
imagem='@/bin/sh'
cmd="curl -b admin_cookie.txt -X POST -F \"id=$id\" -F \"titulo=$titulo\" -F \"id=$id\" -F \"conteudo=$conteudo\" -F \`printf "%s%s" \"imagem=\" $imagem\` localhost/EQ_E/html/admin.php?op=update"
info_str="Id: $id\nTitulo: $titulo\nConteudo: $conteudo\nImagem:$imagem\n"
test_case "Atualizando post com binário ao invés de imagem" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

id='AAAAAAAAAAAAA'
cmd="curl -b admin_cookie.txt -X POST -d \"id=$id\" localhost/EQ_E/html/admin.php?op=delete"
info_str="Id: $id\n"
test_case "Deletando post com id inexistente" "$info_str" "$cmd" "$cmd_filter" "$sql_cmd"

printf "\n$AZUL--------- Busca ---------$RESET\n"

cmd="curl localhost/EQ_E/html/search.php"
test_case "Busca vazia" "" "$cmd" "cat"

busca='AAAAAAAAAAAAAAAAAAAAAAAAAAAA'
cmd="curl localhost/EQ_E/html/search.php?busca=$busca"
info_str="Busca: $busca\n"
test_case "Buscando termo que não existe" "$info_str" "$cmd" "cat"

busca='<script>alert(1)</script>'
cmd="curl --get --data-urlencode 'busca=$busca' localhost/EQ_E/html/search.php"
info_str="Busca: $busca\n"
test_case "XSS" "$info_str" "$cmd" "cat"

busca='); DROP DATABASE mredes --'
cmd="curl --get --data-urlencode 'busca=$busca' localhost/EQ_E/html/search.php"
info_str="Busca: $busca\n"
test_case "SQL Injection" "$info_str" "$cmd" "cat"

busca='USP'
cmd="curl localhost/EQ_E/html/search.php?busca=$busca"
info_str="Busca: $busca\n"
test_case "Busca correta" "$info_str" "$cmd" "cat"

printf "\n$AZUL--------- Calculadora ---------$RESET\n"

consumo=20
autonomia=3
orcamento=100
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo sem local" "$info_str" "$cmd" "$cmd_filter"

consumo=
autonomia=3
orcamento=100
local='vento'
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo sem consumo" "$info_str" "$cmd" "$cmd_filter"

consumo=20
autonomia=
orcamento=100
local='vento'
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo sem autonomia" "$info_str" "$cmd" "$cmd_filter"

consumo=20
autonomia=3
orcamento=
local='vento'
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo sem orçamento" "$info_str" "$cmd" "$cmd_filter"

consumo=-69.6969
autonomia=3
orcamento=100
local="vento"
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo com consumo negativo e fracionário" "$info_str" "$cmd" "$cmd_filter"

consumo='As armas e os barões assinalados'
autonomia=3
orcamento=100
local="vento"
cmd="curl -X POST --data-urlencode 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo com consumo não-numérico" "$info_str" "$cmd" "$cmd_filter"

consumo=20
autonomia=-24.91
orcamento=100
local="vento"
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo com autonomia negativa e fracionária" "$info_str" "$cmd" "$cmd_filter"

consumo=20
autonomia='Que da ocidental praia lusitana'
orcamento=100
local="vento"
cmd="curl -X POST --data-urlencode 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo com autonomia não-numérica" "$info_str" "$cmd" "$cmd_filter"

consumo=20
autonomia=3
orcamento=-69.69
local="vento"
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo com orçamento negativo e fracionário" "$info_str" "$cmd" "$cmd_filter"

consumo=20
autonomia=3
orcamento='Por mares nunca dantes navegados'
local="vento"
cmd="curl -X POST --data-urlencode 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo com orçamento não-numérico" "$info_str" "$cmd" "$cmd_filter"

consumo=20
autonomia=3
orcamento=100000
local=9
cmd="curl -X POST -d 'consumo=$consumo&autonomia=$autonomia&orcamento=$orcamento&local=$local' localhost/EQ_E/html/resultado.php"
info_str="Consumo: $consumo\nAutonomia: $autonomia\nOrçamento: $orcamento\nLocal: $local\n"
test_case "Cálculo com local setado, mas não aceito" "$info_str" "$cmd" "$cmd_filter"

rm admin_cookie.txt
rm tmp_cookie.txt
