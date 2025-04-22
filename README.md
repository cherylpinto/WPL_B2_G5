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
- User authentication (Login/Signup) : MVC

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
```

### 2️⃣ Move Project to XAMPP's htdocs Folder

Copy or move the entire `WPL_B2_G5/` folder to your XAMPP installation directory's `htdocs` folder:

```bash
C:/xampp/htdocs/
```

### 3️⃣ Start XAMPP

1. Launch the **XAMPP Control Panel**.
2. Start the following modules:
   - **Apache**
   - **MySQL**

### 4️⃣ Set Up the Database

1. Open [phpMyAdmin](http://localhost/phpmyadmin) in your browser.
2. Create a new database (e.g., `restaurant_db`).
3. Import the `.sql` file provided in the project directory:
   - Click on the new database.
   - Go to the **Import** tab.
   - Choose the `.sql` file.
   - Click **Go** to import.

### 5️⃣ Configure PHPMailer

1. Open a terminal in the project root directory.
2. Run the following command to install PHPMailer and its dependencies:

```bash
composer install
```

> 📦 This installs **PHPMailer** and required dependencies.

### 6️⃣ Edit Configuration (if needed)

- Update database credentials in your PHP files:

  
    -> `database.php` (app/config/)
  
    -> `connect.php`(public/reservation/)
  
    -> `otp.php` (public)

  

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant_db";
```

- Update mail settings (SMTP host, port, user, and password) in the mail-related PHP file.

### 7️⃣ Access the Website

Navigate to the login page:

```url
http://localhost/WPL_B2_G5/public/index.php
```

---

## 📧 Email Setup Notes

- OTPs and confirmation mails are sent using PHPMailer.
- If using Gmail SMTP:
  - Enable **2-Step Verification**
  - Generate an **App Password**
- Ensure your hosting or local server supports SMTP connections.

---

## ✅ Future Enhancements

- Reservation history for users
- Table QR code for in-place confirmation
- Responsive improvements
- Notification system for admins

---

Feel free to contribute or report any issues.  
Enjoy reserving with **Aurelia's**! 🍽️
