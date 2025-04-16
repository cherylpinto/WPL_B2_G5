CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE otp_expiry (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    otp VARCHAR(10) NOT NULL,
    is_expired TINYINT(1) DEFAULT 0,
    create_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    table_id INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    people INT NOT NULL,
    requests TEXT,
    status ENUM('Pending', 'Approved', 'Cancelled') DEFAULT 'Pending',
    name VARCHAR(100),
    phone VARCHAR(15),
    email VARCHAR(100)
);


CREATE TABLE tables (
    table_id INT PRIMARY KEY,
    capacity INT NOT NULL,
    location VARCHAR(100),
    status ENUM('available', 'reserved', 'occupied') DEFAULT 'available'
);


CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);