-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2017 at 05:23 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `q_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `correct_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories_answered`
--

CREATE TABLE `categories_answered` (
  `user_id` int(11) NOT NULL,
  `q_cat_id` int(11) NOT NULL,
  `status` enum('answered','not_answered') NOT NULL DEFAULT 'not_answered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `q_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  `choice_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `college_courses`
--

CREATE TABLE `college_courses` (
  `desired_course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_abbrev` varchar(16) NOT NULL,
  `course_cut_off` int(11) NOT NULL DEFAULT '60'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `college_courses`
--

INSERT INTO `college_courses` (`desired_course_id`, `course_name`, `course_abbrev`, `course_cut_off`) VALUES
(1, 'Bachelor of Science in Information Technology', 'BSIT', 80);

-- --------------------------------------------------------

--
-- Table structure for table `examinee_group`
--

CREATE TABLE `examinee_group` (
  `examiner_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `examinee_group`
--

INSERT INTO `examinee_group` (`examiner_id`, `group_id`) VALUES
(6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `examiner_answer`
--

CREATE TABLE `examiner_answer` (
  `q_cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `answer_text` varchar(255) NOT NULL DEFAULT 'not_answered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `examiner_count_score`
-- (See below for the actual view)
--
CREATE TABLE `examiner_count_score` (
`user_id` int(11)
,`q_cat_id` int(11)
,`score` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `examiner_percentage`
--

CREATE TABLE `examiner_percentage` (
  `user_id` int(11) NOT NULL,
  `percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `examiner_question_results`
-- (See below for the actual view)
--
CREATE TABLE `examiner_question_results` (
`user_id` int(11)
,`q_cat_name` varchar(255)
,`q_text` text
,`correct_answer` varchar(255)
,`answer_text` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `examiner_score`
--

CREATE TABLE `examiner_score` (
  `user_id` int(11) NOT NULL,
  `q_cat_id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `total_items` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `q_cat_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `q_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question_category`
--

CREATE TABLE `question_category` (
  `q_cat_id` int(11) NOT NULL,
  `q_cat_name` varchar(255) NOT NULL,
  `q_cat_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question_category`
--

INSERT INTO `question_category` (`q_cat_id`, `q_cat_name`, `q_cat_desc`) VALUES
(1, 'Math', 'Math'),
(2, 'General Information', 'Description for General Information');

-- --------------------------------------------------------

--
-- Table structure for table `question_group`
--

CREATE TABLE `question_group` (
  `question_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `time_limit`
--

CREATE TABLE `time_limit` (
  `time_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `minutes` int(11) NOT NULL,
  `seconds` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `time_limit`
--

INSERT INTO `time_limit` (`time_id`, `hours`, `minutes`, `seconds`) VALUES
(1, 0, 7, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `userdetails`
-- (See below for the actual view)
--
CREATE TABLE `userdetails` (
`user_id` int(11)
,`username` varchar(255)
,`password` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`email` varchar(255)
,`birthday` varchar(73)
,`gender` enum('Male','Female')
,`date_of_testing` varchar(73)
,`age` bigint(21)
,`previous_school` varchar(255)
,`phone` varchar(11)
,`course_name` varchar(255)
,`status` enum('Approved','Pending','Finished','OngoingExamination','AttemptedCheating')
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`role_id`, `user_id`, `username`, `password`) VALUES
(1, 1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `date_of_testing` date NOT NULL,
  `previous_school` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `status` enum('Approved','Pending','Finished','OngoingExamination','AttemptedCheating') NOT NULL DEFAULT 'Pending',
  `desired_course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_description`) VALUES
(1, 'Administrator'),
(2, 'Examiner');

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewquestion`
-- (See below for the actual view)
--
CREATE TABLE `viewquestion` (
`q_cat_name` varchar(255)
,`q_id` int(11)
,`q_text` text
,`correct_answer` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_examiner_group`
-- (See below for the actual view)
--
CREATE TABLE `view_examiner_group` (
`user_id` int(11)
,`username` varchar(255)
,`password` varchar(255)
,`firstname` varchar(255)
,`middlename` varchar(255)
,`lastname` varchar(255)
,`email` varchar(255)
,`birthday` varchar(73)
,`gender` enum('Male','Female')
,`date_of_testing` varchar(73)
,`age` bigint(21)
,`previous_school` varchar(255)
,`phone` varchar(11)
,`course_name` varchar(255)
,`status` enum('Approved','Pending','Finished','OngoingExamination','AttemptedCheating')
,`group_id` int(11)
,`group_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_question_group`
-- (See below for the actual view)
--
CREATE TABLE `view_question_group` (
`group_id` int(11)
,`group_name` varchar(255)
,`q_cat_id` int(11)
,`q_id` int(11)
,`q_text` text
,`correct_answer` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `examiner_count_score`
--
DROP TABLE IF EXISTS `examiner_count_score`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `examiner_count_score`  AS  select `ea`.`user_id` AS `user_id`,`qc`.`q_cat_id` AS `q_cat_id`,count(`ea`.`q_cat_id`) AS `score` from (((`examiner_answer` `ea` join `question_category` `qc`) join `answer` `a`) join `question` `q`) where ((`ea`.`answer_text` = `a`.`correct_answer`) and (`ea`.`q_cat_id` = `qc`.`q_cat_id`) and (`ea`.`q_id` = `a`.`q_id`) and (`a`.`q_id` = `q`.`q_id`)) group by `ea`.`q_cat_id`,`ea`.`user_id` ;

-- --------------------------------------------------------

--
-- Structure for view `examiner_question_results`
--
DROP TABLE IF EXISTS `examiner_question_results`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `examiner_question_results`  AS  select `ea`.`user_id` AS `user_id`,`qc`.`q_cat_name` AS `q_cat_name`,`q`.`q_text` AS `q_text`,`a`.`correct_answer` AS `correct_answer`,`ea`.`answer_text` AS `answer_text` from (((`question_category` `qc` join `question` `q`) join `answer` `a`) join `examiner_answer` `ea`) where ((`qc`.`q_cat_id` = `q`.`q_cat_id`) and (`q`.`q_cat_id` = `ea`.`q_cat_id`) and (`q`.`q_id` = `a`.`q_id`) and (`ea`.`q_id` = `q`.`q_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `userdetails`
--
DROP TABLE IF EXISTS `userdetails`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `userdetails`  AS  select `users`.`user_id` AS `user_id`,`users`.`username` AS `username`,`users`.`password` AS `password`,`user_detail`.`firstname` AS `firstname`,`user_detail`.`middlename` AS `middlename`,`user_detail`.`lastname` AS `lastname`,`user_detail`.`email` AS `email`,date_format(`user_detail`.`birthday`,'%M %e, %Y') AS `birthday`,`user_detail`.`gender` AS `gender`,date_format(`user_detail`.`date_of_testing`,'%M %e, %Y') AS `date_of_testing`,timestampdiff(YEAR,`user_detail`.`birthday`,curdate()) AS `age`,`user_detail`.`previous_school` AS `previous_school`,`user_detail`.`phone` AS `phone`,`college_courses`.`course_name` AS `course_name`,`user_detail`.`status` AS `status` from ((`users` join `user_detail`) join `college_courses`) where ((`users`.`user_id` = `user_detail`.`user_id`) and (`user_detail`.`desired_course_id` = `college_courses`.`desired_course_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `viewquestion`
--
DROP TABLE IF EXISTS `viewquestion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewquestion`  AS  select `qc`.`q_cat_name` AS `q_cat_name`,`q`.`q_id` AS `q_id`,`q`.`q_text` AS `q_text`,`a`.`correct_answer` AS `correct_answer` from ((`question` `q` join `question_category` `qc`) join `answer` `a`) where ((`q`.`q_id` = `a`.`q_id`) and (`qc`.`q_cat_id` = `q`.`q_cat_id`)) order by `q`.`q_cat_id`,`q`.`q_id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_examiner_group`
--
DROP TABLE IF EXISTS `view_examiner_group`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_examiner_group`  AS  select `userdetails`.`user_id` AS `user_id`,`userdetails`.`username` AS `username`,`userdetails`.`password` AS `password`,`userdetails`.`firstname` AS `firstname`,`userdetails`.`middlename` AS `middlename`,`userdetails`.`lastname` AS `lastname`,`userdetails`.`email` AS `email`,`userdetails`.`birthday` AS `birthday`,`userdetails`.`gender` AS `gender`,`userdetails`.`date_of_testing` AS `date_of_testing`,`userdetails`.`age` AS `age`,`userdetails`.`previous_school` AS `previous_school`,`userdetails`.`phone` AS `phone`,`userdetails`.`course_name` AS `course_name`,`userdetails`.`status` AS `status`,`groups`.`group_id` AS `group_id`,`groups`.`group_name` AS `group_name` from ((`userdetails` join `examinee_group`) join `groups`) where ((`userdetails`.`user_id` = `examinee_group`.`examiner_id`) and (`examinee_group`.`group_id` = `groups`.`group_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_question_group`
--
DROP TABLE IF EXISTS `view_question_group`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_question_group`  AS  select `groups`.`group_id` AS `group_id`,`groups`.`group_name` AS `group_name`,`question`.`q_cat_id` AS `q_cat_id`,`question`.`q_id` AS `q_id`,`question`.`q_text` AS `q_text`,`answer`.`correct_answer` AS `correct_answer` from (((`groups` join `question`) join `question_group`) join `answer`) where ((`groups`.`group_id` = `question_group`.`group_id`) and (`question`.`q_id` = `question_group`.`question_id`) and (`answer`.`q_id` = `question`.`q_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `q_id` (`q_id`);

--
-- Indexes for table `categories_answered`
--
ALTER TABLE `categories_answered`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `q_cat_id` (`q_cat_id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`choice_id`),
  ADD KEY `q_id` (`q_id`);

--
-- Indexes for table `college_courses`
--
ALTER TABLE `college_courses`
  ADD PRIMARY KEY (`desired_course_id`);

--
-- Indexes for table `examinee_group`
--
ALTER TABLE `examinee_group`
  ADD KEY `examiner_id` (`examiner_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `examiner_answer`
--
ALTER TABLE `examiner_answer`
  ADD KEY `q_cat_id` (`q_cat_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `q_id` (`q_id`);

--
-- Indexes for table `examiner_percentage`
--
ALTER TABLE `examiner_percentage`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `examiner_score`
--
ALTER TABLE `examiner_score`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `q_cat_id` (`q_cat_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`q_id`),
  ADD KEY `q_cat_id` (`q_cat_id`);
ALTER TABLE `question` ADD FULLTEXT KEY `q_text` (`q_text`);
ALTER TABLE `question` ADD FULLTEXT KEY `q_text_2` (`q_text`);

--
-- Indexes for table `question_category`
--
ALTER TABLE `question_category`
  ADD PRIMARY KEY (`q_cat_id`);

--
-- Indexes for table `question_group`
--
ALTER TABLE `question_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `time_limit`
--
ALTER TABLE `time_limit`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `desired_course_id` (`desired_course_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `college_courses`
--
ALTER TABLE `college_courses`
  MODIFY `desired_course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `question_category`
--
ALTER TABLE `question_category`
  MODIFY `q_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `question_group`
--
ALTER TABLE `question_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `time_limit`
--
ALTER TABLE `time_limit`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories_answered`
--
ALTER TABLE `categories_answered`
  ADD CONSTRAINT `categories_answered_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_answered_ibfk_2` FOREIGN KEY (`q_cat_id`) REFERENCES `question_category` (`q_cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `examiner_answer`
--
ALTER TABLE `examiner_answer`
  ADD CONSTRAINT `examiner_answer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `examiner_percentage`
--
ALTER TABLE `examiner_percentage`
  ADD CONSTRAINT `examiner_percentage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `examiner_score`
--
ALTER TABLE `examiner_score`
  ADD CONSTRAINT `examiner_score_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examiner_score_ibfk_2` FOREIGN KEY (`q_cat_id`) REFERENCES `question_category` (`q_cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`q_cat_id`) REFERENCES `question_category` (`q_cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD CONSTRAINT `user_detail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_detail_ibfk_2` FOREIGN KEY (`desired_course_id`) REFERENCES `college_courses` (`desired_course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
