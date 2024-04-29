CREATE DATABASE IF NOT EXISTS feedbackSystem;

USE feedbackSystem;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registrationNo VARCHAR(20) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    age INT,
    batch VARCHAR(20),
    academic_year VARCHAR(10),
    date_of_birth DATE
);

CREATE TABLE IF NOT EXISTS lecturers (
    lecture_id INT AUTO_INCREMENT PRIMARY KEY,
    lecture_name VARCHAR(100) NOT NULL,
    lecturer_name VARCHAR(100) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    username VARCHAR(50),
    course VARCHAR(100),
    department VARCHAR(100),
    outlook_address VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS student_lectures (
    student_id INT,
    lecture_id INT,
    PRIMARY KEY (student_id, lecture_id),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (lecture_id) REFERENCES Lecture(lecture_id)
);

CREATE TABLE IF NOT EXISTS Course (
    department VARCHAR(100),
    course_id INT PRIMARY KEY,
    course_name VARCHAR(255),
    course_code VARCHAR(50),
    semester VARCHAR(50),
    credits INT
);

CREATE TABLE IF NOT EXISTS LectureFeedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lecture_name VARCHAR(255),
    course VARCHAR(100),
    question VARCHAR(255),
    feedback VARCHAR(1000),
    level INT
);

CREATE TABLE IF NOT EXISTS CourseFeedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Feedback_level VARCHAR(50),
    Question VARCHAR(255),
    CourseCode VARCHAR(20),
    CourseName VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS ManagementAssistant (
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
    FOREIGN KEY (management_id) REFERENCES ManagementAssistant(id),
    FOREIGN KEY (course_id) REFERENCES Course(course_id)
);

CREATE TABLE IF NOT EXISTS LectureCourse (
    lecture_id INT,
    course_id INT,
    PRIMARY KEY (lecture_id, course_id),
    FOREIGN KEY (lecture_id) REFERENCES Lecture(lecture_id),
    FOREIGN KEY (course_id) REFERENCES Course(course_id)
);

CREATE TABLE IF NOT EXISTS StudentCourse (
    Student_ID INT,
    Course_ID INT,
    PRIMARY KEY (Student_ID, Course_ID),
    FOREIGN KEY (Student_ID) REFERENCES students(id),
    FOREIGN KEY (Course_ID) REFERENCES Course(course_id)
);

CREATE TABLE IF NOT EXISTS StudentAddress (
    Student_ID INT,
    Address VARCHAR(255),
    PRIMARY KEY (Student_ID),
    FOREIGN KEY (Student_ID) REFERENCES students(id)
);