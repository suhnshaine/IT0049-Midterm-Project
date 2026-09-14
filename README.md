# Complete Point-of-Sale System (CodeIgniter)

# Project Description

This project is a Point-of-Sale (POS) System developed using CodeIgniter 4 and MySQL. The system follows the Model-View-Controller (MVC) architecture and demonstrates the topics covered in class, including database configuration, routes, controllers, views, models, query builder, and displaying database records.

The application uses a MySQL database consisting of four main tables:

- Products
- Customers
- Users
- Sales

The database schema follows the requirements specified in the project instructions.

---

# Features Implemented

## Database

- Database schema created
- Products table
- Customers table
- Users table
- Sales table
- Primary keys
- Foreign key relationships
- Database export included

## CodeIgniter Components

- Routes
- Controllers
- Models
- Views
- Database connection configuration

## Data Display

- Product list page
- Customer list page
- User list page
- Database records displayed using MVC architecture

---

# Technologies Used

- PHP
- CodeIgniter 4
- MySQL
- HTML
- CSS
- Composer
- XAMPP

---

# Installation Guide

## 1. Clone the Repository

```bash
git clone https://github.com/suhnshaine/IT0049-Midterm-Project.git
```

## 2. Open the Project Folder

```bash
cd IT0049-Midterm-Project
```

## 3. Install Dependencies

```bash
composer install
```

## 4. Create Database

Open phpMyAdmin and create a new database:

```sql
CREATE DATABASE midterm_pos_db;
```

## 5. Import the Database

The exported database file is located in:

```text
database/midterm_pos_db.sql
```

Steps:

1. Open phpMyAdmin
2. Select the `midterm_pos_db` database
3. Click **Import**
4. Choose:

```text
database/midterm_pos_db.sql
```

5. Click **Go**

The tables and sample data will be imported automatically.

## 6. Configure Database Settings

Rename:

```text
env
```

to:

```text
.env
```

Then update the database settings:

```env
database.default.hostname = localhost
database.default.database = midterm_pos_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

## 7. Start the Development Server

```bash
php spark serve
```

## 8. Open the Application

```text
http://localhost:8080
```

---

# Available Routes

```text
/products
/customers
/users
```

---

# MVC Workflow

```text
User Request
     ↓
Route
     ↓
Controller
     ↓
Model
     ↓
Database
     ↓
View
     ↓
Browser Output
```

---

# Project Structure

```text
project-root
│
├── app
│   ├── Controllers
│   │   ├── ProductController.php
│   │   ├── CustomerController.php
│   │   └── UserController.php
│   │
│   ├── Models
│   │   ├── ProductModel.php
│   │   ├── CustomerModel.php
│   │   └── UserModel.php
│   │
│   └── Views
│       ├── products
│       │   └── index.php
│       ├── customers
│       │   └── index.php
│       └── users
│           └── index.php
│
├── database
│   └── midterm_pos_db.sql
│
├── public
│
└── README.md
```

---

# Current Progress

### Completed

- [x] CodeIgniter Setup
- [x] Database Configuration
- [x] MySQL Connection
- [x] Database Schema Creation
- [x] Products Table
- [x] Customers Table
- [x] Users Table
- [x] Sales Table
- [x] Foreign Key Relationships
- [x] Models Creation
- [x] Routes Configuration
- [x] Controllers Creation
- [x] Views Creation
- [x] Retrieving Records from Database
- [x] Displaying Database Records
- [x] MVC Architecture Implementation

### To Be Implemented

- [ ] Product CRUD Operations
- [ ] Customer CRUD Operations
- [ ] User CRUD Operations
- [ ] Authentication System
- [ ] Image Upload
- [ ] Avatar Upload
- [ ] Record Sale Module
- [ ] Stock Management
- [ ] Sales History
- [ ] Deployment
