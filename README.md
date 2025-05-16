# 📅 DisplayTime – Timetable Display Web App

**DisplayTime** is a dynamic web application that allows educational institutions to manage and display class schedules efficiently. It features an admin panel for managing departments and timetables, and a public interface where students can view their schedule based on department and date.

---

## 🚀 Features

### 👨‍🏫 Admin Panel
- Secure admin login
- Manage departments (add/edit/delete)
- Manage timetables (add/edit/delete classes)
- Dashboard with quick access links

### 👩‍🎓 Public View
- Select department and date to view timetable
- Simple and responsive user interface
- Filtered table view of classes by time, course, teacher, and room

---

## 🛠 Tech Stack

- **Frontend**: HTML, Bootstrap 5, JavaScript
- **Backend**: PHP
- **Database**: MySQL (via `mysqli`)

---

## 🧱 Database Schema

### 1. `departments`
```sql
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);
````

### 2. `timetable`

```sql
CREATE TABLE timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT,
    date DATE,
    start_time TIME,
    end_time TIME,
    course_name VARCHAR(100),
    teacher VARCHAR(100),
    room VARCHAR(50),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);
```

---

## 📂 Project Structure

```
DisplayTime/
├── config.php
├── public/
│   └── index.php              # Public timetable view
├── admin/
│   ├── login.php              # Admin login
│   ├── logout.php             # Logout
│   ├── dashboard.php          # Admin dashboard
│   ├── manage_departments.php
│   ├── edit_department.php
│   ├── manage_timetable.php
│   ├── edit_timetable.php
│   └── auth_check.php         # Session validation
```

---

## 🔐 Admin Login

| Username | Password |
| -------- | -------- |
| admin    | admin123 |

> Credentials can be modified in `login.php`

---

## ✅ How to Run

1. Clone this repository or download the ZIP.
2. Import the SQL schema into your MySQL server.
3. Set your database credentials in `config.php`:

   ```php
   $conn = new mysqli("localhost", "username", "password", "your_database");
   ```
4. Start a local server (e.g. XAMPP, MAMP) and access:

    * Admin panel: `http://localhost/DisplayTime/admin/login.php`
    * Public view: `http://localhost/DisplayTime/public/index.php`

---

## 📌 Future Improvements (Suggestions)

* CSV Import/Export of timetables
* Multi-role login (teachers, students)
* Calendar view or week/day toggle
* Notification system for changes

---

## 📃 License

MIT License. Feel free to use and customize it for your institution or project.

---

## ✨ Author

Developed with ❤️ for educational scheduling needs.
