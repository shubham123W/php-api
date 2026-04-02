# php-api
Project Structure
php-ecommerce-api/
│
├── api.php
├── config/
│   └── database.php
├── middleware/
│   └── auth.php
├── utils/
│   └── jwt.php
├── sql/
│   └── schema.sql
├── .env.example
├── .gitignore
└── README.md


1. Setup Project
Move project to:
htdocs (XAMPP)
www (Laragon)
2. Create Database
Open phpMyAdmin
Create database:
your_db
3. Import Database
Import file:
sql/schema.sql
4. Configure Database

Edit file:

config/database.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "your_db";
5. Run API
http://localhost/php-ecommerce-api/api.php
🔑 API Endpoints
📝 Register

POST /api.php

{
  "action": "register",
  "email": "test@gmail.com",
  "password": "123456"
}
🔐 Login

POST /api.php

{
  "action": "login",
  "email": "test@gmail.com",
  "password": "123456"
}

✅ Response:

{
  "status": "success",
  "token": "JWT_TOKEN"
}
📦 Get Products

GET

/api.php?type=phone
🛒 Add Order (Protected)

POST /api.php

{
  "action": "add_order",
  "token": "JWT_TOKEN",
  "pid": 1,
  "billno": "ORD123"
}
