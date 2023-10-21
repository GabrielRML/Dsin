CREATE DATABASE LABORATORIO;

CREATE TABLE STATUS (
	CODSTATUS INT NOT NULL AUTO_INCREMENT,
    NOME VARCHAR(30),
    ATIVO VARCHAR(1) DEFAULT('S'),
    
    CONSTRAINT PK_STATUS PRIMARY KEY (CODSTATUS)
);

CREATE TABLE HOSPEDEIRO (
	CODHOSPEDEIRO INT NOT NULL AUTO_INCREMENT,
    NOME VARCHAR (100) NOT NULL,
    IDADE INT NOT NULL,
    SEXO INT NOT NULL,
    PESO DECIMAL(5,2) NOT NULL,
    ALTURA DECIMAL(5,2) NOT NULL,
    TIPO_SANGUINEO VARCHAR(3) NOT NULL,
    CODSTATUS INT NOT NULL,
    
    CONSTRAINT PK_HOSPEDEIRO PRIMARY KEY (CODHOSPEDEIRO),
    CONSTRAINT FK_HOSPEDEIRO_STATUS FOREIGN KEY (CODSTATUS) REFERENCES STATUS(CODSTATUS)
);

CREATE TABLE GOSTO_MUSICAL (
	CODGENERO INT NOT NULL AUTO_INCREMENT,
    GENERO VARCHAR(30) NOT NULL,
    DESCRICAO VARCHAR(100),
    FORCA INT(3) DEFAULT(0),
    VELOCIDADE INT(3) DEFAULT(0),
    INTELIGENCIA INT(3) DEFAULT(0),
    ATIVO VARCHAR(1) DEFAULT('S'),
    
    CONSTRAINT PK_GOSTO_MUSICAL PRIMARY KEY (CODGENERO)
);

CREATE TABLE HOSPEDEIRO_GOSTO_MUSICAL (
	CODHOSPEDEIRO INT NOT NULL,
    CODGENERO INT NOT NULL,
    
    CONSTRAINT PK_HOSPEDEIRO_GOSTO_MUSICAL PRIMARY KEY (CODHOSPEDEIRO, CODGENERO),
    CONSTRAINT FK_HOSPEDEIRO_GOSTO_MUSICAL_HOSPEDEIRO FOREIGN KEY (CODHOSPEDEIRO) REFERENCES HOSPEDEIRO(CODHOSPEDEIRO),
    CONSTRAINT FK_HOSPEDEIRO_GOSTO_MUSICAL_GOSTO_MUSICAL FOREIGN KEY (CODGENERO) REFERENCES GOSTO_MUSICAL(CODGENERO)
);

CREATE TABLE JOGO (
	CODJOGO INT NOT NULL AUTO_INCREMENT,
    NOME VARCHAR(100) NOT NULL,
    DESCRICAO VARCHAR(100),
    FORCA INT(3) DEFAULT(0),
    VELOCIDADE INT(3) DEFAULT(0),
    INTELIGENCIA INT(3) DEFAULT(0),
    ATIVO VARCHAR(1) DEFAULT('S'),
    
    CONSTRAINT PK_JOGO PRIMARY KEY (CODJOGO)
);

CREATE TABLE HOSPEDEIRO_JOGO (
	CODHOSPEDEIRO INT NOT NULL,
    CODJOGO INT NOT NULL,
    
    CONSTRAINT PK_HOSPEDEIRO_JOGO PRIMARY KEY (CODHOSPEDEIRO, CODJOGO),
    CONSTRAINT FK_HOSPEDEIRO_JOGO_HOSPEDEIRO FOREIGN KEY (CODHOSPEDEIRO) REFERENCES HOSPEDEIRO(CODHOSPEDEIRO),
    CONSTRAINT FK_HOSPEDEIRO_JOGO_JOGO FOREIGN KEY (CODJOGO) REFERENCES JOGO(CODJOGO)
);

CREATE TABLE ESPORTE (
	CODESPORTE INT NOT NULL AUTO_INCREMENT,
    NOME VARCHAR(100) NOT NULL,
    DESCRICAO VARCHAR(100),
    FORCA INT(3) DEFAULT(0),
    VELOCIDADE INT(3) DEFAULT(0),
    INTELIGENCIA INT(3) DEFAULT(0),
    ATIVO VARCHAR(1) DEFAULT('S'),
    
    CONSTRAINT PK_ESPORTE PRIMARY KEY (CODESPORTE)
);

CREATE TABLE HOSPEDEIRO_ESPORTE (
	CODHOSPEDEIRO INT NOT NULL,
    CODESPORTE INT NOT NULL,
    
    CONSTRAINT PK_HOSPEDEIRO_ESPORTE PRIMARY KEY (CODHOSPEDEIRO, CODESPORTE),
    CONSTRAINT FK_HOSPEDEIRO_ESPORTE_HOSPEDEIRO FOREIGN KEY (CODHOSPEDEIRO) REFERENCES HOSPEDEIRO(CODHOSPEDEIRO),
    CONSTRAINT FK_HOSPEDEIRO_ESPORTE_ESPORTE FOREIGN KEY (CODESPORTE) REFERENCES ESPORTE(CODESPORTE)
);

CREATE TABLE PATOS (
	CODPATO INT NOT NULL AUTO_INCREMENT,
    NOME VARCHAR(100) NOT NULL,
    DESCRICAO VARCHAR(100),
    FORCA INT(3) DEFAULT(0),
    VELOCIDADE INT(3) DEFAULT(0),
    INTELIGENCIA INT(3) DEFAULT(0),
    POSSUI_CHIP VARCHAR(1) DEFAULT('S'),
    CODSTATUS INT NOT NULL,
    
    CONSTRAINT PK_DUCK PRIMARY KEY (CODPATO),
    CONSTRAINT FK_DUCK_STATUS FOREIGN KEY (CODSTATUS) REFERENCES STATUS(CODSTATUS)
);

INSERT INTO STATUS (CODSTATUS,NOME) VALUES ('1', 'ELIMINADO', 'S'), ('2', 'NÂO ELIMINADO', 'S');

INSERT INTO ESPORTE (NOME, DESCRICAO, FORCA, VELOCIDADE, INTELIGENCIA, ATIVO) VALUES
    ('Futebol', 'Esporte de equipe que envolve chutar uma bola no gol', 10, 8, 6, 'S'),
    ('Basquete', 'Esporte de equipe jogado com uma bola em uma quadra', 8, 9, 7, 'S'),
    ('Vôlei', 'Esporte de equipe jogado em uma quadra dividida por uma rede', 7, 8, 7, 'S'),
    ('Luta', 'Esporte individual que envolve combate corpo a corpo', 9, 6, 6, 'S'),
    ('Atletismo', 'Esporte que envolve corrida, saltos e arremessos', 10, 9, 7, 'S'),
    ('eSports', 'Competições de videogame entre jogadores profissionais', 5, 6, 8, 'S');
    
INSERT INTO GOSTO_MUSICAL (GENERO, DESCRICAO, FORCA, VELOCIDADE, INTELIGENCIA, ATIVO) VALUES
    ('Pop', 'Gênero musical popular com canções cativantes', 7, 7, 6, 'S'),
    ('Rock', 'Gênero musical com influências de guitarra e bateria', 8, 7, 7, 'S'),
    ('Pagode', 'Gênero musical brasileiro com batucada e pandeiro', 6, 7, 6, 'S'),
    ('Sertanejo', 'Gênero musical country brasileiro com duplas', 7, 6, 6, 'S'),
    ('Hip-Hop/Rap', 'Gênero musical com rimas e batidas rítmicas', 8, 8, 7, 'S'),
    ('Eletrônica', 'Gênero musical com batidas eletrônicas e sintetizadores', 7, 9, 7, 'S'),
    ('Funk', 'Gênero musical brasileiro com ritmos dançantes', 7, 8, 6, 'S'),
    ('Metal', 'Gênero musical pesado com guitarras distorcidas', 9, 7, 7, 'S');
    
INSERT INTO JOGO (NOME, DESCRICAO, FORCA, VELOCIDADE, INTELIGENCIA, ATIVO) VALUES
    ('Counter-Strike', 'Jogo de tiro em primeira pessoa com equipes', 8, 8, 7, 'S'),
    ('Minecraft', 'Jogo de construção e exploração em mundo aberto', 6, 7, 8, 'S'),
    ('Fortnite', 'Battle royale com construção de estruturas', 7, 8, 7, 'S'),
    ('The Witcher', 'Jogo de RPG de ação baseado em fantasia', 8, 7, 8, 'S'),
    ('Valorant', 'Jogo de tiro tático em equipe', 7, 8, 7, 'S'),
    ('Assassin''s Creed', 'Jogo de ação e aventura histórica', 7, 7, 8, 'S'),
    ('World of Warcraft', 'MMORPG de mundo aberto e fantasia', 7, 6, 8, 'S'),
    ('FIFA', 'Jogo de futebol com times e jogadores reais', 8, 7, 7, 'S'),
    ('League of Legends', 'Jogo MOBA de batalha em equipe', 7, 8, 8, 'S'),
    ('Dota', 'Jogo MOBA com estratégia e heróis únicos', 8, 8, 8, 'S'),
    ('Rocket League', 'Futebol com carros em alta velocidade', 7, 9, 7, 'S');