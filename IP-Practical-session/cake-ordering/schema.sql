CREATE DATABASE IF NOT EXISTS cake_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cake_db;

-- Users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  address TEXT,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

-- Cakes
CREATE TABLE cakes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  name VARCHAR(200) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  description TEXT,
  image VARCHAR(255),
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Cart
CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  cake_id INT NOT NULL,
  qty INT NOT NULL DEFAULT 1,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (cake_id) REFERENCES cakes(id) ON DELETE CASCADE
);

-- Orders
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  shipping_address TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  cake_id INT NOT NULL,
  qty INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (cake_id) REFERENCES cakes(id) ON DELETE CASCADE
);

-- Seed admin + user
INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@cake.local',SHA2('admin123',256),'admin'),
('User','user@cake.local',SHA2('user123',256),'user');

-- Seed categories
INSERT INTO categories (name) VALUES ('Birthday'),('Wedding'),('Chocolate');

-- Seed cakes
INSERT INTO cakes (category_id,name,price,description,image) VALUES
(1,'Chocolate Truffle',500.00,'Rich chocolate layered cake','choco.jpg'),
(2,'Wedding Vanilla',1200.00,'Classic vanilla with cream','vanilla.jpg'),
(3,'Dark Forest',800.00,'Delicious dark forest cake','forest.jpg');
