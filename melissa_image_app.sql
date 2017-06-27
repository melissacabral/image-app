-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2017 at 09:07 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `melissa_image_app`
--
CREATE DATABASE IF NOT EXISTS `melissa_image_app` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `melissa_image_app`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
`category_id` smallint(6) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Portraits'),
(2, 'Landcsapes'),
(3, 'Macro Shots'),
(4, 'Product Photography');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
`comment_id` smallint(6) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `date` datetime NOT NULL,
  `body` text NOT NULL,
  `post_id` smallint(6) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `date`, `body`, `post_id`, `is_approved`) VALUES
(1, 1, '2017-05-31 09:36:11', 'HI, this is bob commenting on post number 1', 1, 1),
(2, 2, '2017-05-31 09:36:11', 'HI, this is mary commenting on post 2', 2, 1),
(3, 1, '2017-06-05 09:36:56', 'hi this is a comment', 1, 1),
(4, 2, '2017-06-05 09:44:16', 'hi this is a comment', 1, 1),
(5, 1, '2017-06-05 11:30:13', 'commmenting on post number 7', 7, 1),
(6, 1, '2017-06-05 11:33:34', 'hi there im commenting on 6/5 on post number 7\r\n', 7, 1),
(7, 1, '2017-06-23 08:31:53', 'Melissa leaving a comment on post 11', 11, 1),
(8, 1, '2017-06-23 08:33:18', 'Melissa leaving a comment on post 11', 11, 1),
(9, 1, '2017-06-23 08:37:09', 'love thissss', 8, 1),
(10, 1, '2017-06-23 09:00:00', 'yay i love wednesday', 10, 1),
(11, 1, '2017-06-23 09:43:17', 'yaya', 23, 1),
(12, 1, '2017-06-27 11:40:08', 'Just commenting on my own photo, No big deal.', 5, 1),
(13, 1, '2017-06-27 11:40:22', 'This looks incredible!', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
`post_id` smallint(6) NOT NULL,
  `title` varchar(256) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(256) NOT NULL,
  `date` datetime NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `image`, `date`, `category_id`, `user_id`, `allow_comments`, `is_published`) VALUES
(1, 'Beach Shot', 'A candid photo that came out pretty nice', 'sample1', '2017-06-23 12:00:06', 1, 1, 1, 1),
(2, 'Fractal Coast', 'Drone shot of the ocean', 'sample2', '2017-06-23 12:00:06', 2, 2, 1, 1),
(3, 'Strawberries', 'A macro at the market', 'sample3', '2017-06-22 00:00:00', 3, 1, 1, 1),
(4, 'Short Pier', 'Good place for a long walk', 'sample4', '2017-06-21 00:00:00', 2, 1, 1, 1),
(5, 'Cloudy Day', 'Some reflected clouds and mountain skyline. Shot with Canon EOS 5D', 'sample5', '2017-06-26 11:26:38', 3, 1, 1, 1),
(6, 'I just enjoy bacon', 'You can really see the grease in this macro shot of bacon...', 'e34862ef84efb50e51f7be5708825698e74574d6', '2017-06-27 12:03:15', 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE IF NOT EXISTS `post_tags` (
`post_tag_id` mediumint(9) NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `tag_id` mediumint(9) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`post_tag_id`, `post_id`, `tag_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 2, 3),
(5, 3, 1),
(6, 3, 3),
(7, 2, 4),
(8, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
`tag_id` mediumint(9) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`) VALUES
(1, 'happymonday'),
(2, 'dailyinspiration'),
(3, 'taggitytag'),
(4, 'photographersclub');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`user_id` tinyint(4) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(254) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `bio` varchar(256) NOT NULL,
  `profile_pic` varchar(40) NOT NULL,
  `join_date` datetime NOT NULL,
  `secret_key` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `is_admin`, `bio`, `profile_pic`, `join_date`, `secret_key`) VALUES
(1, 'Melissa', 'c829dcc9ea9aa7407a5aafbb04e3c17d57f75e63', 'melissacabral@gmail.com', 1, 'I mostly take pictures of Trees', 'dummyuser1', '2017-06-13 10:42:10', '4e9b5bef15dba517127849a0e8be5092cf6744f2'),
(2, 'User 2', 'ff7c4fcb36c21ba04c0a5a1981aca8a8936ac51b', 'user2@gmail.com', 0, 'Wedding Photographer', 'dummyuser2', '2017-06-13 10:42:26', ''),
(7, 'Tres', 'c829dcc9ea9aa7407a5aafbb04e3c17d57f75e63', 'Threes@mail.com', 0, '', 'default', '2017-06-23 12:03:09', '44dc5e1979ff9b7a793441805e762507c4caf0f1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
 ADD PRIMARY KEY (`post_tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `comment_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
MODIFY `post_tag_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
