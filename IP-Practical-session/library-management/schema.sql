-- schema.sql
CREATE DATABASE IF NOT EXISTS library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library_db;

-- users: both admins and students
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','student') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- books
CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(150) NOT NULL,
  isbn VARCHAR(50) DEFAULT NULL,
  year YEAR DEFAULT NULL,
  copies INT NOT NULL DEFAULT 1,
  available INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- issues: track which user issued which book
CREATE TABLE issues (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  book_id INT NOT NULL,
  issue_date DATE NOT NULL,
  due_date DATE NOT NULL,
  return_date DATE DEFAULT NULL,
  fine DECIMAL(8,2) DEFAULT 0,
  status ENUM('issued','returned') NOT NULL DEFAULT 'issued',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- sample admin user
INSERT INTO users (name,email,password,role)
VALUES ('Admin','admin@library.local', SHA2('admin123',256), 'admin');

-- sample student
INSERT INTO users (name,email,password,role)
VALUES ('Test Student','student@library.local', SHA2('student123',256), 'student');

-- sample books
INSERT INTO books (title,author,isbn,year,copies,available)
VALUES
('Introduction to Algorithms','Cormen, Leiserson, Rivest, Stein','9780262033848',2009,3,3),
('Clean Code','Robert C. Martin','9780132350884',2008,2,2),
('Operating System Concepts','Silberschatz, Galvin, Gagne','9781118063330',2018,4,4);
