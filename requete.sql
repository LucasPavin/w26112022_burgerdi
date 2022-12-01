-- CREATE DATABASE burgerdi

CREATE TABLE `user` 
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    lastname VARCHAR(255),
    firstname VARCHAR(255),
    mail VARCHAR(255),
    numberPhone INT,
    city VARCHAR(255)
);

CREATE TABLE user
(
    id INT AUTO_INCREMENT NOT NULL, 
    lastname VARCHAR(255) NOT NULL, 
    fistname VARCHAR(255) NOT NULL, 
    email VARCHAR(255) NOT NULL,
    number_phone INT NOT NULL, 
    city VARCHAR(255) NOT NULL, 
    PRIMARY KEY(id)
) 
DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB


CREATE TABLE `meal`
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    descrip VARCHAR(255),
    price INT,
    type VARCHAR(255),
    calorie INT
);

CREATE TABLE agency 
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    address VARCHAR(255),
    city VARCHAR(255),
    site VARCHAR(255)
);

CREATE TABLE category 
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255)
);

INSERT INTO meal( id_agency_id, name, description, price, calorie) VALUES (2, 'CLASSIQUE JAMBON PIZZAS', 'Sauce tomate, mozzarella, jambon.', 7.99, 400)