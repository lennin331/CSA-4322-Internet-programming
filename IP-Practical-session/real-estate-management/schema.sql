CREATE DATABASE IF NOT EXISTS realestate_db;
USE realestate_db;

-- Users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','user') DEFAULT 'user'
);

-- Properties
CREATE TABLE properties (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200),
  type ENUM('rent','sale') DEFAULT 'rent',
  price DECIMAL(12,2),
  location VARCHAR(150),
  description TEXT
);

-- Inquiries
CREATE TABLE inquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  property_id INT,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- Seed admin
INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@home.local',SHA2('admin123',256),'admin');

-- Sample properties
INSERT INTO properties (title,type,price,location,description) VALUES
('2BHK Apartment','rent',15000,'Chennai','Near metro station'),
('Luxury Villa','sale',7500000,'Bangalore','4BHK with garden'),
('Office Space','rent',30000,'Hyderabad','1000 sqft in IT park');
