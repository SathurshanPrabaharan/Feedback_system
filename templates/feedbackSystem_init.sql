CREATE DATABASE IF NOT EXISTS feedbackSystem;

USE feedbackSystem;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_no VARCHAR(20) UNIQUE NOT NULL,
    user_name VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    age INT,
    batch VARCHAR(20),
    academic_year VARCHAR(10),
    dob DATE,
    email VARCHAR(100),
    Status VARCHAR(10) DEFAULT 'PENDING' CHECK(Status IN ('PENDING', 'APPROVE', 'REJECT'))
);

CREATE TABLE IF NOT EXISTS lectures (
    lecture_id INT AUTO_INCREMENT PRIMARY KEY,
    lecture_name VARCHAR(100) NOT NULL,
    lecturer_name VARCHAR(100) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
     username VARCHAR(50),
    course VARCHAR(100),
    department VARCHAR(100),
    outlook_address VARCHAR(255),
    email VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS student_lectures (
    student_id INT,
    lecture_id INT,
    PRIMARY KEY (student_id, lecture_id),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (lecture_id) REFERENCES lectures(lecture_id)
);

CREATE TABLE IF NOT EXISTS course (
    department VARCHAR(100),
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255),
    course_code VARCHAR(50),
    semester VARCHAR(50),
    credits INT
);

CREATE TABLE IF NOT EXISTS lecture_Feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lecture_id INT,
    course VARCHAR(100),
    lecture_name VARCHAR(255),
    question VARCHAR(255),
    feedback VARCHAR(1000),
    level INT,
    FOREIGN KEY (lecture_id) REFERENCES lectures(lecture_id)
);

CREATE TABLE IF NOT EXISTS courseFeedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feedback_level VARCHAR(50),
    question VARCHAR(255),
    course_id INT,
     course_name VARCHAR(255),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);

CREATE TABLE IF NOT EXISTS managementAssistant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(50),
    Password VARCHAR(50),
    FirstName VARCHAR(50),
    LastName VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS feedback (
    feedback_no INT AUTO_INCREMENT PRIMARY KEY,
    management_id INT,
    course_id INT,
    feedback_date DATE,
    feedback_time TIME,
    FOREIGN KEY (management_id) REFERENCES managementAssistant(id),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);

CREATE TABLE IF NOT EXISTS lectureCourse (
    lecture_id INT,
    course_id INT,
    PRIMARY KEY (lecture_id, course_id),
    FOREIGN KEY (lecture_id) REFERENCES lectures(lecture_id),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);

CREATE TABLE IF NOT EXISTS studentCourse (
    student_id INT,
    course_id INT,
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);

CREATE TABLE IF NOT EXISTS studentAddress (
    student_id INT,
    address VARCHAR(255),
    PRIMARY KEY (student_id),
    FOREIGN KEY (student_id) REFERENCES students(id)
);