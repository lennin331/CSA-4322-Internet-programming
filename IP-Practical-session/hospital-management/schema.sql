CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

-- Users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','patient') DEFAULT 'patient'
);

-- Doctors
CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  specialty VARCHAR(100)
);

-- Appointments
CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  doctor_id INT,
  date DATE,
  time TIME,
  status ENUM('booked','cancelled') DEFAULT 'booked',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- Seed admin
INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@hospital.local',SHA2('admin123',256),'admin');

-- Seed doctors
INSERT INTO doctors (name,specialty) VALUES
('Dr. Ramesh','Cardiology'),
('Dr. Priya','Dermatology'),
('Dr. Kumar','Orthopedics');
