-- Database: dalhousie_timetable
CREATE DATABASE IF NOT EXISTS dalhousie_timetable;
USE dalhousie_timetable;
 
-- Table structure for `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
-- Insert sample data into `users`
INSERT INTO `users` (`username`, `password`) VALUES
('john_doe', 'hashed_password1'),
('jane_smith', 'hashed_password2');
 
-- Table structure for `courses`
CREATE TABLE IF NOT EXISTS `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_code` VARCHAR(10) NOT NULL,
  `course_name` VARCHAR(100) NOT NULL,
  `schedule` VARCHAR(50) NOT NULL,
  `instructor` VARCHAR(50) NOT NULL
);
 
-- Insert sample data into `courses`
INSERT INTO `courses` (`course_code`, `course_name`, `schedule`, `instructor`) VALUES
('CSCI 2110', 'Data Structures', 'Tue, Thu 9:00 AM - 10:30 AM', 'Dr. Srini Sampalli'),
('CSCI 2141', 'Databases', 'Mon, Wed 10:00 AM - 11:30 AM', 'Bharat Shankaranarayanan'),
('CSCI 2201', 'Information Security', 'Tue, Thu 10:00 AM - 11:30 AM', 'Dr. Israat Haque'),
('CSCI 2170', 'Server Side Scripting', 'Mon, Wed 10:00 AM - 11:30 AM', 'Dr. Raghav Sampangi'),
('CSCI 3172', 'Web-Centric Computing', 'Mon, Wed 10:00 AM - 11:30 AM', 'Gabriella Mosquera');
 
-- Table structure for `schedule`
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`)
);