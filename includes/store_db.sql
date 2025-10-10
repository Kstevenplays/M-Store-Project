-- SQL to create the database and products table
CREATE DATABASE IF NOT EXISTS mstore;
USE mstore;
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);