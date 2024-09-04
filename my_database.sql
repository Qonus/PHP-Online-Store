CREATE DATABASE online_store_test;
use online_store_test;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM("Administrator", "Customer", "Manager") NOT NULL DEFAULT "Customer",
    first_name VARCHAR(32) NOT NULL,
    last_name VARCHAR(32) NOT NULL,
    email VARCHAR(64) UNIQUE NOT NULL CHECK (email LIKE "%@%.%"),
    phone VARCHAR(20) UNIQUE DEFAULT NULL,
    password VARCHAR(256) NOT NULL,
    salt CHAR(32) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE customers (
    user_id INT PRIMARY KEY,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE addresses (
    address_id INT AUTO_INCREMENT PRIMARY KEY,
    address_label VARCHAR(16) DEFAULT NULL,
    customer_id INT NOT NULL,
    address_line1 VARCHAR(256) NOT NULL,
    address_line2 VARCHAR(256) DEFAULT NULL,
    city VARCHAR(32) NOT NULL,
    state VARCHAR(32) DEFAULT NULL,
    postal_code VARCHAR(16) NOT NULL,
    country VARCHAR(32) NOT NULL,
    address_comment TEXT DEFAULT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(user_id) ON DELETE CASCADE
);

ALTER TABLE customers ADD COLUMN default_address_id INT DEFAULT NULL;
ALTER TABLE customers ADD FOREIGN KEY (default_address_id) REFERENCES addresses(address_id);

CREATE TABLE managers (
    user_id INT PRIMARY KEY,
    iin CHAR(12) UNIQUE NOT NULL,
    birthday DATE NOT NULL,
    status ENUM("Active", "Inactive") DEFAULT "Active",
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE brands (
    brand_id INT AUTO_INCREMENT PRIMARY KEY,
    brand_name VARCHAR(64) NOT NULL
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(64) NOT NULL,
    parent_category_id INT DEFAULT NULL
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    brand_id INT NOT NULL,
    category_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,

    age_range VARCHAR(32) NOT NULL,
    player_number VARCHAR(32) NOT NULL,
    weight DECIMAL(5, 2) NOT NULL,
    dimensions VARCHAR(32) NOT NULL,
    release_date DATE NOT NULL,
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'Shipped', 'Delivered', 'Canceled') DEFAULT 'Pending',
    total_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(user_id)
);

CREATE TABLE order_details (
    order_derail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);



CREATE TABLE product_photos (
    photo_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(256) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE discounts (
    discount_id INT AUTO_INCREMENT PRIMARY KEY,
    discount_code VARCHAR(32) UNIQUE,
    discount_type ENUM('Percentage', 'Fixed Amount') NOT NULL,
    discount_value DECIMAL(10, 2) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    min_purchase_amount DECIMAL(10, 2) DEFAULT 0,
    max_usage INT DEFAULT NULL,
    is_active BOOLEAN DEFAULT TRUE
);

CREATE TABLE delivery_methods (
    delivery_method_id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(64) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    estimated_delivery_time VARCHAR(32),
    is_active BOOLEAN DEFAULT TRUE
);

CREATE TABLE cart (
 user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- FUNCTIONS

DELIMITER //

CREATE FUNCTION get_cart_total(id INT) RETURNS DECIMAL(10, 2)
BEGIN
    DECLARE total DECIMAL(10, 2);
    
    SELECT SUM(price * quantity) INTO total
    FROM cart
    JOIN products ON cart.product_id = products.product_id
    WHERE user_id = id
    GROUP BY user_id;
    
    RETURN total;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE create_order(IN id INT)
BEGIN
 DECLARE order_id INT;
    DECLARE total DECIMAL(10, 2);
    -- Обработка исключения
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
     ROLLBACK;
    END;
    -- Начало транзакции:
    START TRANSACTION;
    -- Получение суммы товаров в корзине:
    SET total = (SELECT get_cart_total(id));
    -- Создание нового заказа:
 INSERT INTO orders (customer_id, total_amount) VALUES (id, total);
    -- Получение ID нового заказа:
    SET order_id = LAST_INSERT_ID();
    -- Перенос товаров:
    INSERT INTO order_details (order_id, product_id, quantity, unit_price, total_price)
    SELECT order_id, cart.product_id, cart.quantity, products.price, (cart.quantity * products.price)
    FROM cart
    JOIN products ON cart.product_id = products.product_id
    WHERE cart.user_id = id;
    -- Очистка корзины этого пользователя:
    DELETE FROM cart WHERE user_id = id;
    -- Завершение транзакции:
    COMMIT;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER create_customer
AFTER INSERT ON users
FOR EACH ROW 
BEGIN
 IF NEW.user_type = "Customer" THEN
  INSERT INTO customers (user_id, default_address_id)
     VALUES (NEW.user_id, NULL);
    END IF;
END//

DELIMITER ;


-- INSERTS

INSERT INTO users (user_type, first_name, last_name, email, phone, password, salt)
VALUES 
('Administrator', 'Admin', 'User', 'admin@onlinestore.com', '1234567890', 'hashedpassword', 'somesalt'),
('Customer', 'John', 'Doe', 'johndoe@example.com', '0987654321', 'hashedpassword', 'somesalt'),
('Customer', 'Jane', 'Doe', 'janedoe@example.com', '1112223333', 'hashedpassword', 'somesalt'),
('Manager', 'James', 'Smith', 'jamessmith@example.com', '4445556666', 'hashedpassword', 'somesalt');

INSERT INTO customers (user_id) VALUES (2), (3);

INSERT INTO addresses (address_label, customer_id, address_line1, city, state, postal_code, country)
VALUES 
('Home', 2, '123 Elm Street', 'Springfield', 'IL', '62704', 'USA'),
('Work', 3, '456 Oak Street', 'Springfield', 'IL', '62701', 'USA');

UPDATE customers SET default_address_id = 1 WHERE user_id = 2;
UPDATE customers SET default_address_id = 2 WHERE user_id = 3;

INSERT INTO managers (user_id, iin, birthday)
VALUES 
(4, '123456789012', '1980-01-01');

INSERT INTO brands (brand_name)
VALUES 
('Hasbro'),
('Mattel'),
('Lego'),
('Funko');

INSERT INTO categories (category_name, parent_category_id)
VALUES 
('Board Games', NULL),
('Card Games', NULL),
('Video Games', NULL),
('Outdoor Games', NULL),
('Party Games', 1),
('Strategy Games', 1),
('Children Games', 1),
('Classic Games', 1);

INSERT INTO products (product_name, description, brand_id, category_id, price, stock_quantity, age_range, player_number, weight, dimensions, release_date)
VALUES 
('Monopoly', 'Classic board game for property trading.', 1, 7, 19.99, 100, '8+', '2-6 players', 2.5, '10x10x2 inches', '1935-01-01'),
('Catan', 'Strategy game for trading and building.', 2, 6, 29.99, 50, '10+', '3-4 players', 3.0, '11x11x3 inches', '1995-06-01'),
('Uno', 'Popular card game for all ages.', 2, 2, 9.99, 200, '7+', '2-10 players', 0.5, '4x4x1 inches', '1971-01-01'),
('Jenga', 'Stacking game of physical skill.', 2, 4, 14.99, 150, '6+', '1+ players', 2.2, '8x3x3 inches', '1983-01-01'),
('Fortnite', 'Popular battle royale video game.', 3, 3, 59.99, 75, '12+', '1+ players', 0.0, 'Digital Download', '2017-07-21'),
('Clue', 'Mystery board game of deduction.', 1, 7, 24.99, 80, '8+', '3-6 players', 2.6, '10x10x2 inches', '1949-01-01'),
('Risk', 'Strategy game of global domination.', 1, 6, 29.99, 60, '10+', '2-6 players', 3.1, '12x12x3 inches', '1957-01-01'),
('Twister', 'Classic game of physical flexibility.', 2, 4, 16.99, 120, '6+', '2-4 players', 2.0, '10x10x2 inches', '1966-01-01'),
('Minecraft', 'Open-world video game.', 3, 3, 26.95, 100, '7+', '1+ players', 0.0, 'Digital Download', '2011-11-18'),
('Candy Land', 'Classic children’s board game.', 2, 8, 12.99, 140, '3+', '2-4 players', 2.0, '10x10x2 inches', '1949-01-01'),
('Ticket to Ride', 'Cross-country train adventure game.', 3, 6, 44.99, 50, '8+', '2-5 players', 3.0, '12x12x3 inches', '2004-01-01'),
('Scrabble', 'Classic word game.', 1, 7, 19.99, 110, '10+', '2-4 players', 2.5, '10x10x2 inches', '1938-01-01'),
('Bananagrams', 'Fast-paced word game.', 2, 4, 14.99, 90, '7+', '1-8 players', 1.0, '7x3x3 inches', '2006-01-01'),
('Exploding Kittens', 'Party game for people who are into kittens and explosions.', 4, 5, 19.99, 120, '7+', '2-5 players', 1.0, '8x4x2 inches', '2015-07-15'),
('Codenames', 'Party word game.', 1, 5, 15.99, 85, '10+', '2-8 players', 1.1, '9x6x2 inches', '2015-09-01'),
('Lego Star Wars', 'Buildable starships from the Star Wars series.', 3, 3, 49.99, 80, '8+', '1+ players', 3.0, 'N/A', '2005-04-02'),
('Dixit', 'A storytelling game.', 3, 5, 34.99, 60, '8+', '3-6 players', 2.0, '12x12x2 inches', '2008-09-01'),
('Boggle', 'Word game in a grid.', 1, 7, 9.99, 100, '8+', '1+ players', 1.5, '8x8x2 inches', '1972-01-01'),
('Pandemic', 'Cooperative game to save the world from diseases.', 2, 6, 39.99, 70, '8+', '2-4 players', 2.5, '12x12x3 inches', '2008-01-01'),
('Magic: The Gathering', 'Collectible card game.', 3, 2, 19.99, 130, '13+', '2+ players', 1.0, '4x3x2 inches', '1993-08-05'),
('Pokemon TCG', 'Collectible card game based on the Pokémon franchise.', 2, 2, 24.99, 110, '6+', '2+ players', 1.0, '5x4x3 inches', '1996-10-20');

INSERT INTO orders (customer_id, total_amount) VALUES (2, 49.97), (3, 24.99);

INSERT INTO order_details (order_id, product_id, quantity, unit_price, total_price)
VALUES 
(1, 1, 1, 19.99, 19.99),
(1, 2, 1, 29.99, 29.99),
(2, 3, 1, 9.99, 9.99),
(2, 4, 1, 14.99, 14.99);

INSERT INTO product_photos (product_id, image_url, is_primary)
VALUES 
(1, 'monopoly.jpg', TRUE),
(2, 'catan.jpg', TRUE),
(3, 'uno.jpg', TRUE),
(4, 'jenga.jpg', TRUE);

INSERT INTO discounts (discount_code, discount_type, discount_value, start_date, end_date, min_purchase_amount)
VALUES 
('SAVE10', 'Percentage', 10.00, '2024-08-01 00:00:00', '2024-08-31 23:59:59', 50.00),
('WELCOME5', 'Fixed Amount', 5.00, '2024-08-01 00:00:00', '2024-12-31 23:59:59', 20.00);

INSERT INTO delivery_methods (method_name, price, estimated_delivery_time)
VALUES 
('Standard Shipping', 5.99, '5-7 business days'),
('Express Shipping', 12.99, '2-3 business days'),
('Overnight Shipping', 19.99, '1 business day');
