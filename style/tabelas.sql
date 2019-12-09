CREATE TABLE modelo (
	modelo_id int PRIMARY KEY AUTO_INCREMENT,
    nome	varchar(40) NOT null,
    qtd_passageiros int(3) not null,
    ano_fabricacao int(4) not null,
    ano_modelo int(4) not null,
    combustivel ENUM('alcool' , 'gasolina', 'flex'),
    potencia int(9) not null,
    porta_malas float not null   
)