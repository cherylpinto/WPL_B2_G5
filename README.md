# 🍽️ Aurelia's - Restaurant Table Reservation Website

**Aurelia's** is a responsive restaurant table reservation system that allows users to book tables and admins to manage reservations. The website features OTP-based email verification and real-time table availability tracking. Built using HTML, CSS, JavaScript, PHP, and MySQL, it runs on a local server environment using **XAMPP**.

---

## ✨ Features

### 👥 User Perspective
- Home page with sections: Home, Menu, Chefs, Feedback, Reserve Table, Footer
- Reservation system:
  - Fill out reservation form
  - Choose table via visual layout
  - OTP sent to email for verification
- Modify, cancel, and view reservations
- Conflicts avoided: User warned if a selected time conflicts with another reservation within 1 hour
- Booked tables marked in **red**
- User authentication (Login/Signup)

### 🛠️ Admin Perspective
- Secure login for admins
- View all reservations
- Approve or reject reservations
- Email notifications sent to users based on approval status

---

## 🧰 Tech Stack

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL  
- **Server**: XAMPP  
- **Email**: PHPMailer via Composer

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/cherylpinto/WPL_B2_G5.git
cd WPL_B2_G5

---
### 2️⃣ Start XAMPP
- Launch **XAMPP Control Panel**.
- Start the following modules:
  - **Apache**
  - **MySQL**

### 3️⃣ Set Up the Database

- Open [phpMyAdmin](http://localhost/phpmyadmin)
- Create a new database (e.g., `aurelias_db`)
- Import the provided `.sql` file(s) located in the project directory to set up the tables.

### 4️⃣ Configure PHPMailer

- Open a terminal in the project root and run the following command:

```bash
composer install

-This will install PHPMailer and required dependencies.
