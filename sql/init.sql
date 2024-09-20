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
    conteudo TEXT NOT NULL,
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