CREATE
DATABASE displaytime;
USE
displaytime;

CREATE TABLE departments
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE timetable
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT,
    course_name   VARCHAR(100),
    teacher       VARCHAR(100),
    room          VARCHAR(50),
    start_time    TIME,
    end_time      TIME,
    date          DATE,
    FOREIGN KEY (department_id) REFERENCES departments (id)
);

CREATE TABLE admin_users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL -- hashed passwords
);

INSERT INTO admin_users (username, password)
VALUES ('admin', SHA2('admin123', 256));
