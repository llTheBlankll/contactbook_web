CREATE DATABASE IF NOT EXISTS contact_book_web;

use contact_book_web;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(40),
    password TEXT,
    email VARCHAR(255),
    salt VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS user_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(40),
    action TEXT,
    date VARCHAR(255),
    user VARCHAR(40)
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(40),
    phone VARCHAR(24),
    email VARCHAR(64),
    fullname VARCHAR(40),
    phonetype VARCHAR(40),
    for_user VARCHAR(40)
);

