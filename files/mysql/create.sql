-- Create the database if it doesn't already exist
CREATE DATABASE IF NOT EXISTS lipus;

-- Select the database to use
USE lipus;

-- Create the table if it doesn't already exist
CREATE TABLE IF NOT EXISTS uzytkownicy_administracyjni(
    _id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    _imie VARCHAR(255) NOT NULL,
    _password CHAR(60) NOT NULL -- Assuming bcrypt hashes
);
