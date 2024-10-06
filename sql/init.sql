DROP DATABASE IF EXISTS mredes;
CREATE DATABASE mredes;
USE mredes;

CREATE TABLE Usuarios(
    id INT AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha CHAR(64) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE Posts(
    id INT AUTO_INCREMENT,
    titulo VARCHAR(100) NOT NULL UNIQUE,
    imagem VARCHAR(100) NOT NULL,
    conteudo TEXT NOT NULL,
    FULLTEXT(titulo, conteudo),
    PRIMARY KEY(id)
);

CREATE TABLE Comentarios(
    id INT AUTO_INCREMENT,
    id_post INT NOT NULL,
    id_usuario INT NOT NULL,
    conteudo TEXT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_post) REFERENCES Posts(id),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id)
);

INSERT INTO Usuarios VALUES (NULL, 'a', 'a@a.com', 'a2ca37fe6fdc490b8f7ce841e1701a169d2b1697c6b5b5c63f94abb8f9b6d6dd'); -- Senha 'Senha@123'
