-- MySQL schema for M-Store
CREATE DATABASE IF NOT EXISTS `m_store` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `m_store`;

-- Users
CREATE TABLE IF NOT EXISTS users (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(64) NOT NULL UNIQUE,
	password_hash VARCHAR(255) NOT NULL,
	role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Products
CREATE TABLE IF NOT EXISTS products (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	category VARCHAR(128) NULL,
	price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	stock INT NOT NULL DEFAULT 0,
	low_stock_threshold INT NOT NULL DEFAULT 5,
	expires_at DATE NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	INDEX idx_products_name (name),
	INDEX idx_products_category (category)
) ENGINE=InnoDB;

-- Product price history
CREATE TABLE IF NOT EXISTS product_price_history (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	product_id INT UNSIGNED NOT NULL,
	old_price DECIMAL(10,2) NOT NULL,
	new_price DECIMAL(10,2) NOT NULL,
	changed_by_user_id INT UNSIGNED NULL,
	changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
	FOREIGN KEY (changed_by_user_id) REFERENCES users(id) ON DELETE SET NULL,
	INDEX idx_pph_product (product_id)
) ENGINE=InnoDB;

-- Inventory movements (for audit and low stock)
CREATE TABLE IF NOT EXISTS inventory_movements (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	product_id INT UNSIGNED NOT NULL,
	change_qty INT NOT NULL,
	reason VARCHAR(128) NOT NULL,
	reference_type VARCHAR(64) NULL,
	reference_id INT UNSIGNED NULL,
	user_id INT UNSIGNED NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
	INDEX idx_im_product (product_id)
) ENGINE=InnoDB;

-- Sales (header)
CREATE TABLE IF NOT EXISTS sales (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NULL,
	total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	paid_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	change_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
	INDEX idx_sales_created (created_at)
) ENGINE=InnoDB;

-- Sale items (details) with snapshot values
CREATE TABLE IF NOT EXISTS sale_items (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	sale_id INT UNSIGNED NOT NULL,
	product_id INT UNSIGNED NULL,
	product_name_snapshot VARCHAR(255) NOT NULL,
	unit_price_snapshot DECIMAL(10,2) NOT NULL,
	quantity INT NOT NULL,
	line_total DECIMAL(10,2) NOT NULL,
	FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
	FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
	INDEX idx_si_sale (sale_id)
) ENGINE=InnoDB;

-- Expenses
CREATE TABLE IF NOT EXISTS expenses (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	category VARCHAR(128) NULL,
	description VARCHAR(255) NULL,
	amount DECIMAL(10,2) NOT NULL,
	expense_date DATE NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	INDEX idx_expense_date (expense_date)
) ENGINE=InnoDB;

-- Customers
CREATE TABLE IF NOT EXISTS customers (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(128) NOT NULL,
	phone VARCHAR(32) NULL,
	notes VARCHAR(255) NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	INDEX idx_customers_name (name)
) ENGINE=InnoDB;

-- Customer credits (Utang)
CREATE TABLE IF NOT EXISTS customer_credits (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	customer_id INT UNSIGNED NOT NULL,
	sale_id INT UNSIGNED NULL,
	amount DECIMAL(10,2) NOT NULL,
	status ENUM('unpaid','partial','paid') NOT NULL DEFAULT 'unpaid',
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
	FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE SET NULL,
	INDEX idx_cc_customer (customer_id),
	INDEX idx_cc_status (status)
) ENGINE=InnoDB;

-- Payments against credits
CREATE TABLE IF NOT EXISTS payments (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	customer_credit_id INT UNSIGNED NOT NULL,
	amount DECIMAL(10,2) NOT NULL,
	paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	notes VARCHAR(255) NULL,
	FOREIGN KEY (customer_credit_id) REFERENCES customer_credits(id) ON DELETE CASCADE,
	INDEX idx_payments_credit (customer_credit_id)
) ENGINE=InnoDB;

-- Seed admin user (password: admin) - change immediately in production
INSERT INTO users (username, password_hash, role)
VALUES ('admin', '$2y$10$2WvH2E6g0tO3mVqkVqFZ4uT2V2aQ6mQ4mM4JgFq1m7o5JmQqjZk8e', 'admin')
ON DUPLICATE KEY UPDATE username = username;
