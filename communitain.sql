-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2020 at 06:54 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `communitain`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `catImagePath` tinytext NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `page_key` varchar(36) NOT NULL,
  `showInMenu` tinyint(1) NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `page_key`, `showInMenu`, `title`, `content`) VALUES
(1, 'home', 1, 'Communitain!', '<p>Welcome! As fellow content creators we want to see what you\'ve got to share! Here\'s the latest contributions! </p>\r\n\r\n<main id=\"userContent\">\r\n<h1>  </h1><br/><img id=\'submissionImg\' src=\'\'/><br/><p>submission Desc</p>\"\r\n</main> '),
(2, 'login', 1, 'Sign in', '<?php\r\n    if(isset($user)) {\r\n        echo $user[\'msg\'];\r\n    }\r\n?>\r\n        <form action=\"login.php\" method=\"post\">\r\n            <input type=\"hidden\" name=\"action\" value=\"login\" />\r\n            <div>\r\n                <div>Username: </div>\r\n                <div>\r\n                    <input type=\"text\" name=\"username\" />\r\n                </div>\r\n                <div>Password: </div>\r\n                <div>\r\n                    <input type=\"password\" name=\"pass\" />\r\n                </div>\r\n                <input type=\"submit\" value=\"Login\" name=\"submit\" />\r\n            </div>\r\n        </form>\r\n<h3> Need an account? </h3>\r\n<a href=\"http://localhost:5000/projects/phpnew/?p=create_account\">Register here! </a>\r\n'),
(3, 'contribute', 1, 'Contribute', '<h2> You can submit your content here! Just provide file, name and description. </h2>\r\n<textarea id=\"story\" name=\"story\"\r\n          rows=\"5\" cols=\"33\">\r\n</textarea>\r\n<form method=\"post\" action=\"./includes/util/upload.php\" enctype=\"multipart/form-data\">\r\n<label>Category</label>\r\n             <select id = \"category\">\r\n               <option value = \"cat\">$categoryName</option>\" ?>\r\n             </select>\r\n\r\n  <input type=\"file\" id=\"myFile\" name=\"file\">\r\n  <input id=\"imgSubmit\" type=\"submit\" \r\nvalue=\"Upload!\" name=\"upload\" >\r\n</form>'),
(4, 'create_account', 0, 'Register', '<?php\r\n        if(isset($res)) {\r\n            echo $res[\'user\'][\'name\'].\':\'.$res[\'msg\'];\r\n        }\r\n    if(isset($_POST[\'username\']) && isset($_POST[\'pass\']) && \r\n        isset($_POST[\'pass_re\']) && \r\n        ($_POST[\'pass\'] === $_POST[\'pass_re\'])\r\n    ) {\r\n\r\n        $result = User::create($_POST[\'username\'],$_POST[\'pass\']);\r\n\r\n        echo $result[\'msg\'];\r\n    } else {\r\n\r\n?>\r\n        <form action=\"./includes/create_account.php\" method=\"post\">\r\n            <div>\r\n                <div>Username: </div>\r\n                <div>\r\n                    <input type=\"text\" name=\"username\" />\r\n                </div>\r\n                <div>Password: </div>\r\n                <div>\r\n                    <input type=\"password\" name=\"pass\" />\r\n                </div>\r\n                <div>Re-enter Password: </div>\r\n                <div>\r\n                    <input type=\"password\" name=\"pass_re\" />\r\n                </div>\r\n\r\n                <input type=\"submit\" value=\"Create\" name=\"submit\" />\r\n            </div>\r\n        </form>\r\n        <?php } ?>\r\n        \r\n\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `subImage` mediumblob NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(10) UNSIGNED NOT NULL,
  `username` varchar(36) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `passHash` varchar(60) NOT NULL,
  `cookieHash` varchar(60) DEFAULT NULL,
  `dateModified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nacl` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `username`, `name`, `passHash`, `cookieHash`, `dateModified`, `nacl`) VALUES
(1, 'bob', 'Bob', '$2y$10$KgIEowLY7LzcNWMe7g.p0u/oH7bF79hC31Z1LxRELc3JmxB2KvHOa', '$2y$10$xgk1H2sVP./n7oucY9DQ4e3zPhslimUMPs..riTYQu4z9XWGV7cdO', '2020-02-26 12:32:18', ''),
(2, 'bob2', NULL, '$2y$10$1MZqqjNV5Mbnwsalllj0Bu.ib6CLclD0/JN/UA7nchIwTcG1jD626', NULL, '2020-02-25 11:44:40', ''),
(3, 'kek', NULL, '$2y$10$UDzoRk9Z0QCF.zo8ZCJ3IuvLGdfEfnhQlzE9dywlW9DOjx2C8Um8S', NULL, '2020-02-25 13:48:34', ''),
(4, 'dirst', NULL, '$2y$10$NNOgiyXBWgRVb4cwfzBew.wFc7OZi2PeUyoV1vNBfsD7stllCs.lq', NULL, '2020-02-25 13:53:17', ''),
(5, 'fef', NULL, '$2y$10$KT2xsW4q1r2J9lc5UhZxHOwT.5nHwI6PNo5grVnLRi729zN4Qv2Qy', NULL, '2020-02-25 14:08:58', ''),
(6, 'geckw', NULL, '$2y$10$ITF7JydTmtfNbRkhty0iC.Ybg4S8FG5WNocuXuBznlAhVkJtW2elO', NULL, '2020-02-26 11:58:43', ''),
(7, 'geckws', NULL, '$2y$10$4DykzIM9aNAwAIzxFQOYEO5sau12wkg4kEpvB39C0nOTuUVn.rJp.', NULL, '2020-02-26 11:59:40', ''),
(8, 'hello', NULL, '$2y$10$Kk2AQ2gB8lgzIxPiHvBfbuU747vkjoTOdD6EEUoaHvMbIO9IVB2Ky', '$2y$10$43/Dsd7Krrb.5nQVOa.tLu2pdQG7lO3ywvRfKmZZfjMUiZt19WV7W', '2020-02-26 12:03:06', ''),
(9, 'foo', NULL, '$2y$10$pKSeb4w.UkIu2mXMGouc3elK1jnMhdOC4NKzr0vyHBJddxdAWxvgS', '$2y$10$dDS8LIbDZtvbAK3TBAjFTOmWMbpmd2fBH8lvmFSxW7xjUu8NNr3ae', '2020-02-26 12:03:31', ''),
(10, 'ggg', NULL, '$2y$10$N8QZxQ32rw0QQneqlAgJHOdPIwQs.y7R0TOvcGe6U23wUMXZe6Wqu', NULL, '2020-02-26 12:04:43', ''),
(11, 'hhh', NULL, '$2y$10$WEhN4U/nIbAy1BNxdd6xL.tZyDsXdxEzbk95kf/9faEc6LrnNQhAO', NULL, '2020-02-26 12:05:18', ''),
(12, 'hhh2', NULL, '$2y$10$e6za2i8L0EjdQDe2ODGJwuQwF4wyamrVeDEY1l4P7ZfpKEvxjqyna', NULL, '2020-02-26 12:05:44', ''),
(13, 'hhh3', NULL, '$2y$10$pj3KjCj3HSza0lDBH0zSneK2U1IjKqwjjxDxfyhFGtHOzgwZG61K.', NULL, '2020-02-26 12:06:11', ''),
(14, 'hhh5', NULL, '$2y$10$2e4dqwjYjaTcGP4m/kblruDFUOyR6jOUq0ixpOyR4./RJdtmMatpW', NULL, '2020-02-26 12:07:08', ''),
(15, 'ddd', NULL, '$2y$10$qnS/HUS.HMAjYvsDlvzPPuqby5Pjxq.0d96KdtE.PGDmpRZ/IeAZ2', NULL, '2020-02-26 12:28:33', ''),
(16, 'qwerty', NULL, '$2y$10$kQgY.Eo5V4CLEpl.OCPaw.Yb9KvOi26OtYkTUe9ohD7JNH/9fqaGS', '$2y$10$ojxWpfeXGy.SJdtP5EAgZO/5Y2JQ3bbTdwJ/CSuTZ4K9Yit43vKtW', '2020-02-26 12:31:00', ''),
(17, 'geralt', NULL, '$2y$10$8.gJPBcHZMQhY6.s6M1XF.6Gd2pFUbvqggQiCXMnSqsl13oLEyZYO', NULL, '2020-02-26 12:34:32', ''),
(18, 'GeraltoR', NULL, '$2y$10$OC7kl8WLpBApEGMxDbbUxeokdY35B9BKu7ziP2H6lHq/2KtTYOjI2', '$2y$10$i5FRtP4S/wHD7OXK7LgNAeHi3Fi10Ekor3vbMbupkBI8MVSpiXCeO', '2020-02-26 12:35:53', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cat_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `fk_cat_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;