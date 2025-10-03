-- schema.sql
CREATE DATABASE IF NOT EXISTS hotel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hotel_db;

-- users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- hotels
CREATE TABLE hotels (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  city VARCHAR(100) NOT NULL,
  address TEXT,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- rooms
CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  hotel_id INT NOT NULL,
  room_type VARCHAR(100) NOT NULL, -- e.g., 'Deluxe', 'Standard'
  price DECIMAL(10,2) NOT NULL,
  total_count INT NOT NULL DEFAULT 1,
  available_count INT NOT NULL DEFAULT 1,
  details TEXT,
  FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
);

-- bookings
CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  hotel_id INT NOT NULL,
  room_id INT NOT NULL,
  checkin_date DATE NOT NULL,
  checkout_date DATE NOT NULL,
  guests INT NOT NULL DEFAULT 1,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('booked','cancelled','completed') NOT NULL DEFAULT 'booked',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE,
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
);

-- Seed admin & sample user
INSERT INTO users (name,email,password,role)
VALUES ('Admin','admin@hotel.local', SHA2('admin123',256), 'admin'),
       ('Demo User','user@hotel.local', SHA2('user123',256), 'user');

-- Sample hotels
INSERT INTO hotels (name,city,address,description) VALUES
('Sunrise Hotel','Chennai','123 Beach Road, Chennai','Comfortable stay near the beach'),
('Hillview Resort','Kodaikanal','45 Hill Lane, Kodaikanal','Scenic views, cozy rooms');

-- Sample rooms
INSERT INTO rooms (hotel_id, room_type, price, total_count, available_count, details) VALUES
(1,'Standard',1500.00,10,10,'AC, Free WiFi, Breakfast included'),
(1,'Deluxe',2500.00,5,5,'AC, Free WiFi, Breakfast + Sea View'),
(2,'Cottage',3000.00,6,6,'Private garden, mountain view'),
(2,'Standard',1800.00,8,8,'AC, complimentary breakfast');
