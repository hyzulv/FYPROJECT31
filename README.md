# FYPROJECT31 - Restaurant Ordering System

## 📖 Project Overview

The Restaurant Ordering System is a web-based application developed to streamline and automate restaurant operations. The system allows customers to browse menus, place orders, make payments, and track order status online. Administrators and staff can efficiently manage menus, orders, customers, and feedback through a centralized dashboard.

### Detail

| Detail | Value |
|---------|---------|
| **System** | Web-Based Restaurant Ordering System |
| **Technology** | HTML, CSS, JavaScript, PHP, Laravel, MySQL |
| **Framework** | Laravel, Bootstrap |
| **Database** | MySQL |
| **User Roles** | Administrator, Staff, Customer |

---

## ⚙️ Installation Manual

Follow these steps to set up and run the project locally.

### Step 1: Install Required Software

The project requires the following software:

- Laravel Herd
- GitHub Desktop
- Visual Studio Code
- Composer
- Node.js & NPM
- MySQL

### Step 2: Set Up Project Files

1. Open GitHub Desktop.
2. Clone the repository:

```text
https://github.com/hyzulv/FYPROJECT31.git
```

3. Open the project folder in Visual Studio Code.

### Step 3: Install Dependencies

Open the VS Code terminal and run:

```bash
composer install
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### Step 4: Database Setup

1. Create a new MySQL database.
2. Update the database credentials in `.env`.

Example:

```env
DB_DATABASE=restaurant_ordering_system
DB_USERNAME=root
DB_PASSWORD=
```

3. Run migrations:

```bash
php artisan migrate
```

Or import the provided SQL file if applicable.

### Step 5: Access the System

Run the application:

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

Or through Laravel Herd:

```text
http://fyproject31.test
```

---

## 🔗 Project Links

### GitHub Repository (Source Code)

https://github.com/hyzulv/FYPROJECT31

### Live Project Website

https://matrock.shop/

---

## 🔑 Access Credentials

### Administrator

```text
Email:
Password:
```

### Staff

```text
Email:
Password:
```

### Customer

```text
Email:
Password:
```
