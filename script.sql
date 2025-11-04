-- create database boxup;

USE boxup;

CREATE TABLE IF NOT EXISTS usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(250) NOT NULL,
    senha VARCHAR(250) NOT NULL,
    usuario VARCHAR(250) NOT NULL,
    cpf CHAR(14) NOT NULL UNIQUE,
    email VARCHAR(250) NOT NULL UNIQUE,
    motorista BOOLEAN NOT NULL,
    preco INT NOT NULL
);

CREATE TABLE IF NOT EXISTS mudanca (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_motorista INT NOT NULL,
    objetos VARCHAR(500) NOT NULL,
    endereco_inicial VARCHAR(120) NOT NULL,
    endereco_final VARCHAR(120) NOT NULL,
    observacoes VARCHAR(120) NOT NULL,
    status INT NOT NULL DEFAULT 0,
    km INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (id_motorista) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS chat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mudanca_id INT NOT NULL,
    remetente_id INT NOT NULL,
    receptor_id INT NOT NULL,
    mensagem TEXT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mudanca_id) REFERENCES mudanca(id) ON DELETE CASCADE,
    FOREIGN KEY (remetente_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (receptor_id) REFERENCES usuario(id) ON DELETE CASCADE
);
