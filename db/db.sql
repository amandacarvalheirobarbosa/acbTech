CREATE DATABASE acbTechDB;

CREATE TABLE IF NOT EXISTS tab_produto(
  id_produto int NOT NULL AUTO_INCREMENT,
  id_categoria int,
  nome varchar(100) NOT NULL,
  preco decimal(10, 2) NOT NULL,
  estoque int NOT NULL,

  created datetime NOT NULL,
  modified datetime DEFAULT NULL,
  deleted datetime DEFAULT NULL,
  PRIMARY KEY (id_produto),
  FOREIGN KEY (id_categoria) REFERENCES tab_categoria(id_categoria)
);

CREATE TABLE IF NOT EXISTS tab_categoria(
  id_categoria int NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,

  created datetime NOT NULL,
  modified datetime DEFAULT NULL,
  deleted datetime DEFAULT NULL,
  PRIMARY KEY (id_categoria)
);

/* INSERT INTO tab_produto (id_categoria, nome, preco, estoque) VALUES ();
INSERT INTO tab_produto (id_categoria, nome, preco, estoque) VALUES ();
INSERT INTO tab_produto (id_categoria, nome, preco, estoque) VALUES ();
INSERT INTO tab_produto (id_categoria, nome, preco, estoque) VALUES (); */

/* INSERT INTO tab_categoria (nome) VALUES ();
INSERT INTO tab_categoria (nome) VALUES ();
INSERT INTO tab_categoria (nome) VALUES ();
INSERT INTO tab_categoria (nome) VALUES (); */