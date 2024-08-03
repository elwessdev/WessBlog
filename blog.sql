-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 09:23 PM
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
(30, 4, 1),
(29, 4, 2),
(28, 4, 3);

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
  `published_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `img`, `content`, `likes`, `published_at`) VALUES
(22, 1, 'A JavaScript Interview Question That 90% of People Get Wrong', 'uploads/1/pexels-luis-gomes-546819.jpg', 'Did you think of an answer immediately? Hold on before you respond. Perhaps you’re already familiar with type conversions, but how do we calculate the length of the toString function? And how is the length of a normal function calculated?\r\n\r\nIn JavaScript, the length property of a function represents the number of arguments expected by the function when it was declared. It counts the number of expected arguments, not including the rest parameters operator (...) after it, nor considering default parameters. This property is often used in reflection and some functional programming scenarios to understand how many arguments a function expects to receive.', 120, '2024-07-30 09:36:40'),
(23, 1, 'How I would Learn to Code (if I could start over) - No BS', 'uploads/1/1_NtaSipGCzfPHY8u-U-IVWA.png', 'If you are not a Medium member then you can use below friendly link to read the complete story.\r\nIf you are not a Medium member then you can use below friendly link to read the complete story.', 10, '2024-07-30 09:55:55'),
(24, 2, '3 Reasons Why You Fail in Interviews? (Coding and System Design)', 'uploads/2/1_ogiyP9d6iPsBxkkGD95PbA.png', '3 Reasons Why You Fail in Interviews? (Coding and System Design)\r\n3 Reasons Why You Fail in Interviews? (Coding and System Design)', 15, '2024-07-30 09:57:12'),
(25, 2, 'How to Practice LeetCode Problems (The Right Way)', 'uploads/2/1_K6zJRlhUvwZMM_AzO_fd-A.jpg', 'The struggle is real\r\nHave you been tackling LeetCode problems but don’t feel like you’re actually getting better in interviews? Feel like you’re able to come up with solutions but never make it to the optimal one? Do you keep running out of time before you can finish the question? Are you constantly having a tough time making it through difficult questions?', 80, '2024-07-30 10:03:04'),
(26, 2, 'Your Tech Resume is Garbage: Here’s How To Fix It', 'uploads/2/1_cWkbqrBlnnFKyZ0rBWfRKQ.jpg', 'Your Tech Resume is Garbage: Here’s How To Fix It\r\nYour Tech Resume is Garbage: Here’s How To Fix It', 78, '2024-07-30 10:03:47'),
(27, 2, 'Interviewing at Google? Here’s 6 Things You Absolutely Need To Do', 'uploads/2/1_kPmnuMLO4-7NG9IHB8OdDQ.jpg', 'Stop and think about various approaches. If you’ve put in time studying algorithms and data structures, this is where it really starts to pay off (Cracking the Coding Interview, anyone?). Think about trade offs using Big-O analysis and think out loud. Don’t stop with the first solution that comes to mind. Always ask yourself what’s the best you can do. Trust me, we always will!', 50, '2024-07-30 10:04:29'),
(41, 4, 'Conversational Agents vs. Normal Agents', 'https://ik.imagekit.io/nhx8dixrzg/phpCCE1__frM8D9a4.tmp', 'Have you ever wondered why some AI chatbots feel like you’re chatting with a friend, while others seem as engaging as a refrigerator manual? Buckle up, because today we’re diving into the world of conversational agents versus regular agents, and how these digital buddies differ under the hood.\r\nConversational agents and traditional agents originate from different design philosophies. Think of conversational agents as single-task ninjas; they are designed to perform specific tasks such as booking a ticket or answering FAQs. Their responses are often predefined and lack flexibility. Whereas conversational agents understand and respond to human language naturally. They can handle a wide range of topics and adapt their responses based on context.', 5, '2024-08-02 16:37:41'),
(42, 4, 'Diving Deep into LLM Operations: Sync and Async Invokes, Streams, and Batches', 'https://ik.imagekit.io/nhx8dixrzg/php4510_sO597MZZL.tmp', 'Large Language Models (LLMs) like OpenAI’s GPT-4, Open LM have revolutionized the field of natural language processing, enabling a wide range of applications from chatbots to automated content generation. However, effectively interacting with these powerful models requires an understanding of different methods and techniques to optimize performance and efficiency.\r\n\r\nIn this story, we will explore various interaction methods for LLMs, including synchronous and asynchronous invocations, streaming, and batching. Each method has its unique advantages and use cases, and understanding these can help you make the most out of your LLM applications. We’ll dive into practical examples and explain how the output for each method looks, providing you with a comprehensive guide to master LLM interactions.', 0, '2024-08-02 16:38:12'),
(43, 3, 'This Guy Makes $1M+ per Year With 0 Employees', 'https://ik.imagekit.io/nhx8dixrzg/phpA383_u5qbMslG4.tmp', 'Have you ever heard of Photopea, a FREE Photoshop-like image editor?\r\n\r\nYes the genius behind him is Ivan Kutskir. This project of his get:\r\n\r\n13M monthly visits\r\n1.5M monthly user hours\r\n$100K monthly ad revenue\r\nAmazingly, he solo-handled 500K daily users and scaled Photopea to $1M+ in revenue and he spends only $700/year for maintenance & keeps ALL the profit for himself.\r\n\r\nLet’s get into his story.', 0, '2024-08-02 16:40:47');

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
(51, 27, 11),
(52, 26, 11),
(53, 25, 11),
(54, 24, 11),
(55, 41, 19),
(56, 41, 11),
(57, 41, 1),
(58, 42, 19),
(59, 42, 11),
(60, 43, 9),
(61, 43, 12),
(62, 43, 15),
(63, 43, 11);

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
  `bio` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `photo`, `bio`, `created_at`) VALUES
(1, 'ghassendds', 'ghassen@ahmed.com', '$2y$10$xU3zCQT7eY76nbxLTqhNee1ofKWrSYdLrf..TL0Q2FCx.EMv1MQc.', 'https://ik.imagekit.io/nhx8dixrzg/profiles_phpF790_7qlmOiGmK.tmp', 'i\'m ghassen kjjk', '2024-08-02 15:38:55'),
(2, 'admin', 'admin@admin.com', '$2y$10$xU3zCQT7eY76nbxLTqhNee1ofKWrSYdLrf..TL0Q2FCx.EMv1MQc.', 'https://ik.imagekit.io/nhx8dixrzg/profiles_php594D_-jpnktS3P.tmp', 'test', '2024-08-02 15:39:09'),
(3, 'rami', 'rami@rami.com', '$2y$10$xU3zCQT7eY76nbxLTqhNee1ofKWrSYdLrf..TL0Q2FCx.EMv1MQc.', 'https://ik.imagekit.io/nhx8dixrzg/phpFA91_VJ0Z3aFYx.tmp', '', '2024-08-02 16:39:07'),
(4, 'iyadh12d', 'iyadh@gmail.com', '$2y$10$xU3zCQT7eY76nbxLTqhNee1ofKWrSYdLrf..TL0Q2FCx.EMv1MQc.', 'https://ik.imagekit.io/nhx8dixrzg/phpABD9_rdSsjeqJ6.tmp', 'i\'m iyadh', '2024-08-02 15:39:07');

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
