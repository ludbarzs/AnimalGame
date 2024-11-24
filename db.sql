CREATE DATABASE IF NOT EXISTS `web_projekts`;
USE `web_projekts`;
CREATE TABLE `Animals` (
    `animal_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `species` VARCHAR(150) NOT NULL,
    `image` LONGBLOB NOT NULL,
    `description` TEXT NOT NULL
);

CREATE TABLE `Attributes` (
    `attribute_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(60) NOT NULL
);

CREATE TABLE `AnimalAttributes` (
    `animalAttribute_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `id_animal` INT,
    `id_attribute` INT,
    `value` INT NOT NULL,
    FOREIGN KEY (`id_animal`) REFERENCES Animals(`animal_id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_attribute`) REFERENCES Attributes(`attribute_id`) ON DELETE CASCADE
);

CREATE TABLE `Users` (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(100) NOT NULL,
    `role` ENUM("admin", "user") DEFAULT "user",
    `session_id` VARCHAR(255)
);

CREATE TABLE `Collections` (
    `collection_id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `id_user` INT,
    `id_animal` INT,
    `date_added` DATE NOT NULL,
    FOREIGN KEY (`id_user`) REFERENCES Users(`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_animal`) REFERENCES Animals(`animal_id`) ON DELETE CASCADE
);
