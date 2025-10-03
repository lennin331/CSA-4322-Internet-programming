CREATE DATABASE IF NOT EXISTS exam_db;
USE exam_db;

-- Users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','student') DEFAULT 'student'
);

-- Questions
CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question TEXT,
  opt1 VARCHAR(200),
  opt2 VARCHAR(200),
  opt3 VARCHAR(200),
  opt4 VARCHAR(200),
  answer INT
);

-- Results
CREATE TABLE results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  score INT,
  taken_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Seed admin
INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@exam.local',SHA2('admin123',256),'admin');

-- Sample questions
INSERT INTO questions (question,opt1,opt2,opt3,opt4,answer) VALUES
('Capital of India?','Mumbai','Delhi','Kolkata','Chennai',2),
('2 + 2 = ?','3','4','5','6',2),
('HTML stands for?','HyperText Makeup Language','HyperText Markup Language','HighText Machine Language','None',2);
