

CREATE TABLE app_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE logins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES app_users(id)
);

CREATE TABLE signups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  signup_time DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES app_users(id)
);

CREATE TABLE cart_orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  address VARCHAR(255) NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  payment_method VARCHAR(50) NOT NULL,
  order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES app_users(id)
);

CREATE TABLE payment_details (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  cardholder_name VARCHAR(100),
  card_number VARCHAR(20),
  expiration_date DATE,
  cvv VARCHAR(10),
  paypal_email VARCHAR(100),
  mobile_number VARCHAR(20),
  provider VARCHAR(50),
  FOREIGN KEY (order_id) REFERENCES cart_orders(id)
);

