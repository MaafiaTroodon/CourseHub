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
('CSCI 1105', 'Intro to Computer Programming', 'Tue, Thu 10:05 AM - 11:25 AM', 'M. Barrera Machuca'),
('CSCI 1107', 'Social Computing', 'Mon, Wed 2:35 PM - 3:55 PM', 'J. Blustein'),
('CSCI 1120', 'Intro to Computer Systems', 'Mon, Wed, Fri 12:35 PM - 1:25 PM', 'C. DeGagne'),
('CSCI 1170', 'Intro to Web Design & Dev', 'Tue, Thu 5:35 PM - 6:55 PM', 'M. Barrera Machuca'),
('CSCI 1315', 'Discrete Math for CS', 'Mon, Wed, Fri 11:35 AM - 12:25 PM', 'C. DeGagne'),
('CSCI 3101', 'Ethics & Prof Issues in CS', 'Tue, Thu 10:05 AM - 11:25 AM', 'M. Fortney'),
('CSCI 3110', 'Algorithms I', 'Wed, Fri 4:05 PM - 5:25 PM', 'M. He'),
('CSCI 3120', 'Operating Systems', 'Tue, Thu 8:35 AM - 9:55 AM', 'Q. Ye'),
('CSCI 3130', 'Software Engineering', 'Mon, Wed 11:35 AM - 12:55 PM', 'M. Rahman'),
('CSCI 3161', 'Intro to Comp Graphics', 'Wed, Fri 10:05 AM - 11:25 AM', 'S. Brooks'),
('CSCI 3181', 'Advanced Topics in Machine Learning', 'Tue, Thu 10:05 AM - 11:25 AM', 'Zeh N.'),
('CSCI 3205', 'Distributed Systems', 'Wed, Fri 2:35 PM - 3:55 PM', 'Brooks S.'),
('CSCI 3250', 'Cybersecurity Threats', 'Tue, Thu 11:35 AM - 12:55 PM', 'Mosquera G.'),
('CSCI 3310', 'Data Structures and Algorithms', 'Mon, Wed 10:05 AM - 11:25 AM', 'He M.'),
('CSCI 3411', 'Ethics in Computing', 'Tue, Thu 2:35 PM - 3:55 PM', 'Rahman M.'),
('CSCI 3425', 'Blockchain Technologies', 'Mon, Wed 4:05 PM - 5:25 PM', 'Yang L.'),
('CSCI 3510', 'Introduction to Robotics', 'Tue, Thu 8:35 AM - 9:55 AM', 'Sampalli S.'),
('CSCI 3600', 'Intro to Quantum Computing', 'Mon, Wed 1:35 PM - 2:55 PM', 'Keselj V.'),
('CSCI 3701', 'Artificial Intelligence', 'Tue, Thu 4:05 PM - 5:25 PM', 'Copstein R.'),
('CSCI 3750', 'Mobile App Development', 'Wed, Fri 3:05 PM - 4:25 PM', 'Keselj V.'),
('CSCI 4113', 'Design and Analysis of Algorithms II', 'Mon, Wed, Fri 11:35 AM - 12:25 PM', 'Zeh N.'),
('CSCI 4119', 'Compact Data Structures', 'Tue, Thu 10:05 AM - 11:25 AM', 'Gagie T.'),
('CSCI 4140', 'Advanced Database Systems', 'Mon, Wed 11:35 AM - 12:55 PM', 'Bodorik P.'),
('CSCI 4152', 'Natural Language Processing', 'Mon, Wed 4:05 PM - 5:25 PM', 'Keselj V.'),
('CSCI 4157', 'Deep Speech Technologies', 'Tue, Thu 2:35 PM - 3:55 PM', 'Rudzicz F.'),
('CSCI 4163', 'Human-Computer Interaction', 'Mon, Wed 2:35 PM - 3:55 PM', 'Malloch J.'),
('CSCI 4171', 'Networks and Communication', 'Tue, Thu 4:05 PM - 5:25 PM', 'Sampalli S.'),
('CSCI 4178', 'Cyber Security & Defense', 'Tue, Thu 11:35 AM - 12:55 PM', 'Copstein R.'),
('CSCI 4192', 'Directed Studies', 'Consult Department', 'Arnold D.'),
('CSCI 4193', 'Technology Innovation', 'Fri 11:35 AM - 2:25 PM', 'Cochran A.');

 
-- Table structure for `schedule`
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`)
);