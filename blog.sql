-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2024 at 05:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`id`, `user_id`, `followed_id`) VALUES
(35, 1, 3),
(33, 1, 4),
(36, 2, 4),
(40, 3, 163431),
(41, 4, 1),
(29, 4, 2),
(38, 163431, 2),
(39, 163431, 4);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `img_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `img`, `content`, `likes`, `published_at`, `img_id`) VALUES
(22, 1, 'A JavaScript Interview Question That 90% of People Get Wrong', 'https://ik.imagekit.io/nhx8dixrzg/phpF5E8_FLYwNrNK_.tmp', 'Did you think of an answer immediately? Hold on before you respond. Perhaps you’re already familiar with type conversions, but how do we calculate the length of the toString function? And how is the length of a normal function calculated?\r\n\r\nIn JavaScript, the length property of a function represents the number of arguments expected by the function when it was declared. It counts the number of expected arguments, not including the rest parameters operator (...) after it, nor considering default parameters. This property is often used in reflection and some functional programming scenarios to understand how many arguments a function expects to receive.', 149, '2024-07-30 09:36:40', '66ae3397e375273f60bdc502'),
(23, 1, 'How I would Learn to Code (if I could start over) - No BS', 'https://ik.imagekit.io/nhx8dixrzg/phpAC89_DLAZiC5-T.tmp', 'If you are not a Medium member then you can use below friendly link to read the complete story.\r\nIf you are not a Medium member then you can use below friendly link to read the complete story.', 10, '2024-07-30 09:55:55', '66ae3385e375273f60bd83ae'),
(24, 2, '3 Reasons Why You Fail in Interviews? (Coding and System Design)', 'https://ik.imagekit.io/nhx8dixrzg/php257E_gXRjXpeMoC.tmp', '3 Reasons Why You Fail in Interviews? (Coding and System Design)\r\n3 Reasons Why You Fail in Interviews? (Coding and System Design)', 15, '2024-07-30 09:57:12', '66af9c98e375273f60fb8466'),
(41, 4, 'Conversational Agents vs. Normal Agents', 'https://ik.imagekit.io/nhx8dixrzg/phpC81D_vo27AbmtX.tmp', 'Have you ever wondered why some AI chatbots feel like you’re chatting with a friend, while others seem as engaging as a refrigerator manual? Buckle up, because today we’re diving into the world of conversational agents versus regular agents, and how these digital buddies differ under the hood.\r\nConversational agents and traditional agents originate from different design philosophies. Think of conversational agents as single-task ninjas; they are designed to perform specific tasks such as booking a ticket or answering FAQs. Their responses are often predefined and lack flexibility. Whereas conversational agents understand and respond to human language naturally. They can handle a wide range of topics and adapt their responses based on context.', 5, '2024-08-02 16:37:41', '66af42a5e375273f605d19b6'),
(42, 4, 'Diving Deep into LLM Operations: Sync and Async Invokes, Streams, and Batches', 'https://ik.imagekit.io/nhx8dixrzg/php460B_cyq9ygBlj.tmp', 'Large Language Models (LLMs) like OpenAI’s GPT-4, Open LM have revolutionized the field of natural language processing, enabling a wide range of applications from chatbots to automated content generation. However, effectively interacting with these powerful models requires an understanding of different methods and techniques to optimize performance and efficiency.\r\n\r\nIn this story, we will explore various interaction methods for LLMs, including synchronous and asynchronous invocations, streaming, and batching. Each method has its unique advantages and use cases, and understanding these can help you make the most out of your LLM applications. We’ll dive into practical examples and explain how the output for each method looks, providing you with a comprehensive guide to master LLM interactions.', 25, '2024-08-02 16:38:12', '66af4284e375273f605cb21c'),
(43, 3, 'This Guy Makes $1M+ per Year With 0 Employees', 'https://ik.imagekit.io/nhx8dixrzg/php2EEC_SOO5MlsG2.tmp', 'Have you ever heard of Photopea, a FREE Photoshop-like image editor?\r\n\r\nYes the genius behind him is Ivan Kutskir. This project of his get:\r\n\r\n13M monthly visits\r\n1.5M monthly user hours\r\n$100K monthly ad revenue\r\nAmazingly, he solo-handled 500K daily users and scaled Photopea to $1M+ in revenue and he spends only $700/year for maintenance & keeps ALL the profit for himself.\r\n\r\nLet’s get into his story.', 2, '2024-08-02 16:40:47', '66af4343e375273f605f3f5e'),
(45, 163431, 'When the Cool Writer Kids Won’t Let You in Their Club, Create Your Own', 'https://ik.imagekit.io/nhx8dixrzg/php3AE9_Mu9ytaM3I.tmp', 'This may not be the kind of opinion one says out loud, but publishing is a clubby business. And like any other business, talent and hard work are tantamount, but your network is what breaks down all the doors. Years ago, when I was much younger and ambitious, I’d attend book launches, literary magazine events, and parties in the hopes of meeting people who, as one of my friends phrased it, were “good to know.”\r\n\r\nThese were the kind of people who ensured that your story submission climbed higher up the stack; they brokered important introductions and vouched for your work. They bragged about living in Brooklyn even though they whitewashed the borough where I grew up with their faux grit, expensive eyewear, F-train polemics, and dog-eared copies of A Heartbreaking Work of Staggering Genius', 4, '2024-08-04 08:47:48', '66af4033e375273f6055b1e6');

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`id`, `post_id`, `topic_id`) VALUES
(41, 22, 1),
(42, 23, 6),
(43, 23, 10),
(44, 23, 3),
(58, 42, 19),
(59, 42, 11),
(60, 43, 9),
(61, 43, 12),
(62, 43, 15),
(63, 43, 11),
(77, 24, 11),
(78, 24, 1),
(80, 45, 9),
(81, 45, 16),
(82, 45, 5),
(83, 45, 7),
(88, 41, 19),
(89, 41, 11),
(90, 41, 2),
(91, 41, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(19, 'Artificial Intelligence'),
(9, 'Business'),
(16, 'Culture'),
(5, 'Education'),
(13, 'English'),
(6, 'Entertainment'),
(10, 'Food'),
(18, 'Gaming'),
(3, 'Health'),
(12, 'Investment'),
(15, 'Leadership'),
(7, 'Lifestyle'),
(14, 'Marketing'),
(11, 'Programming'),
(2, 'Science'),
(8, 'Sports'),
(1, 'Technology'),
(4, 'Travel'),
(17, 'World');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `photo_id` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `photo`, `photo_id`, `bio`, `created_at`, `reset_token`, `token_expires_at`) VALUES
(1, 'ghassendds', 'ghassen@ahmed.com', '$2y$10$6oKhXxnIcbMv/UW4/BHlvOPRJYTYO9pO6Vc4tV7Muy2gqf1l0gVwy', 'https://ik.imagekit.io/nhx8dixrzg/phpE253_jFGkmPOJl.tmp', '66af9d0ae375273f60fd62ca', 'i\'m ghassen kjjk', '2024-08-04 15:23:55', NULL, NULL),
(2, 'admin', 'benaliosama3@gmail.com', '$2y$10$ntZd7UKqhrl8WR3VfVaxDebSBhOVk1iEeAuMXJ9cXsjR7K45M.eq2', 'https://ik.imagekit.io/nhx8dixrzg/phpAACC_3abtM1cq6.tmp', '66af9cbae375273f60fc1061', 'lkùlù', '2024-08-04 15:26:11', NULL, NULL),
(3, 'rami', 'rami@rami.com', '$2y$10$6oKhXxnIcbMv/UW4/BHlvOPRJYTYO9pO6Vc4tV7Muy2gqf1l0gVwy', 'https://ik.imagekit.io/nhx8dixrzg/php6508_1BnGBdJdG.tmp', '66af4498e375273f6065d58d', '', '2024-08-04 09:06:33', NULL, NULL),
(4, 'iyadh11', 'iaydh.25@iyadh.com', '$2y$10$6oKhXxnIcbMv/UW4/BHlvOPRJYTYO9pO6Vc4tV7Muy2gqf1l0gVwy', 'https://ik.imagekit.io/nhx8dixrzg/php8FCA_HxfggGSrV.tmp', '66af9d37e375273f60fe2733', 'i am iyadh working @Google', '2024-08-04 15:24:39', NULL, NULL),
(163431, 'ahmed13', 'ruut.ba12@gmail.com', '$2y$10$lrXeKG.W5saSkoxlDYTaxujWffYyQwpmPp2mvt2cs5BwHg/qUeSwK', 'https://ik.imagekit.io/nhx8dixrzg/phpBBF8_HtPBGr4UQ.tmp', '66af3fd2e375273f6054b30f', '', '2024-08-04 08:46:10', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`user_id`,`followed_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_ibfk_1` (`author_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `following_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `following_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
