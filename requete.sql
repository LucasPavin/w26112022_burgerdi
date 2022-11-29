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

