CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(100),
 password VARCHAR(255)
);

CREATE TABLE products (
 id INT AUTO_INCREMENT PRIMARY KEY,
 productname VARCHAR(100),
 price VARCHAR(50),
 mrp VARCHAR(50),
 description TEXT,
 type VARCHAR(50),
 imag TEXT
);

CREATE TABLE porder (
 id INT AUTO_INCREMENT PRIMARY KEY,
 productid INT,
 productname VARCHAR(100),
 price VARCHAR(50),
 mrp VARCHAR(50),
 description TEXT,
 qty INT,
 billno VARCHAR(100),
 img2 TEXT,
 status INT
);
