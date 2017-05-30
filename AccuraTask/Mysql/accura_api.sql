-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 17, 2017 at 09:42 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accura_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(23) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `encrypted_password` varchar(255) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unique_id`, `name`, `email`, `mobile`, `encrypted_password`, `salt`, `created_at`) VALUES
(1, '591c067adfbc47.70284876', 'hager', 'hager@gmail.com', '0100', 'V/GkB9r275bXsHa94UTufoJ8Tc1hOGU3ZTkyMjA2', 'a8e7e92206', '2017-05-17 10:14:50'),
(3, '591c71b41c4698.42140071', 'hager', 'hager39@gmail.com', '0100', 'vMNB6rh2B+ggCcyf92wBDoWXuTs0ZWZkZDQzMjQ1', '4efdd43245', '2017-05-17 17:52:20'),
(5, '591c73a523dd57.53496753', 'someone', 'someone@gmail.com', '0101235877888', 'qKnyTTCN5l4afWf3ghSL1PluFgc2NDgyMjA2NjFj', '648220661c', '2017-05-17 18:00:37'),
(7, '591c7714162477.31622160', 'accura', 'accura@gmail.com', '010123456789', 'lzaLuuVgi/srAa6X9LQlDQNLVtExOTkyYTU1Mzcz', '1992a55373', '2017-05-17 18:15:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
