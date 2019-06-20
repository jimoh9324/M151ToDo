CREATE DATABASE IF NOT EXISTS `151todolist`;
USE `151todolist`;

CREATE TABLE IF NOT EXISTS `users` (
    `userid` INT NOT NULL AUTO_INCREMENT,
    `firstname` VARCHAR(30) NOT NULL,
    `lastname` VARCHAR(30) NOT NULL,
    `username` VARCHAR(30) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOt NULL,
    PRIMARY KEY (`userid`)
);

CREATE TABLE IF NOT EXISTS `todo` (
    `todoid` INT NOT NULL AUTO_INCREMENT,
    `task` VARCHAR(100) NOT NULL,
    `userid` INT NOT NULL,
    `target` DATE NOT NULL,
    `priority` TINYINT(4) NOT NULL,
    `status` VARCHAR(50) NOt NULL,
    PRIMARY KEY (`todoid`),
    FOREIGN KEY (`userid`) REFERENCES `users`(`userid`)
);

CREATE USER IF NOT EXISTS 'todouser'@'localhost' IDENTIFIED BY '4TcKZm8ZDm$WuHcAX?9^x';
GRANT SELECT, INSERT, UPDATE, DELETE ON `151todolist`.* TO 'todouser'@'localhost';