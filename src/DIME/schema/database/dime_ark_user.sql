-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2017 at 10:12 PM
-- Server version: 5.5.52-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dime_ark_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_user`
--

CREATE TABLE IF NOT EXISTS `ark_user` (
`id` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(255) NOT NULL DEFAULT '',
  `roles` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(100) DEFAULT NULL,
  `time_created` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(100) DEFAULT NULL,
  `isEnabled` tinyint(1) NOT NULL DEFAULT '1',
  `confirmationToken` varchar(100) DEFAULT NULL,
  `timePasswordResetRequested` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ark_user`
--

INSERT INTO `ark_user` (`id`, `email`, `password`, `salt`, `roles`, `name`, `time_created`, `username`, `isEnabled`, `confirmationToken`, `timePasswordResetRequested`) VALUES
(1, 'john@layt.net', '$2y$13$5bDc.gpJTrnpJmfQt.7MZOz.QaKH/c8blMJtjJAxuoBwju.P88x2q', 'rq65ui5ahg0cowcgogww40ogowcw0g0', 'ROLE_USER', 'John Layt', 1480940588, NULL, 1, NULL, 0),
(2, 'stuarteve@gmail.com', '$2y$13$F70UAv8DPo7LFJSm4y0h.eacYGcJuubZRSSYBUqUbgwl4bBq3w.IK', 'nkqf6zxm3sgossoc00wggg4cowgwwwc', 'ROLE_USER', 'Stuart Eve', 1484040483, NULL, 1, NULL, 0),
(3, 'm.johnson@lparchaeology.com', '$2y$13$cVYlJ12yc1dA6CTedS1HtuACE7sbD.gsc5/zHnXCk.ddDOEvRtIiK', 'if1c0lxgm5koo4sg8g8c0kgscgogg08', 'ROLE_USER', 'Mike Johnson', 1484140132, NULL, 1, NULL, 0),
(4, 'test@example.com', '$2y$13$v1mS2heom1llh8dttBrbaOKdQ7PfuWHnTpEHvsIqiRWD0RgFbz5Yu', 'hiwjp46knhck8s0s0sccgwsg4g4c0g4', 'ROLE_USER', NULL, 1485531006, NULL, 1, NULL, 0),
(5, 'stuarteve@lparchaeology.com', '$2y$13$CqYm4IE8GNonBHigXw4Rp.ZA.PhMRXIPtddsbMOVyU/RKmrZ2IGLO', 'xxlkdvzqic0c84kcokswkgc4sc848w', 'ROLE_USER', 'Stuart Eve', 1485531006, NULL, 1, 'R3HT-vvEK5BnZegKN1SXqTcFSg5JiHQtg4ebVclmCTg', 1485715539),
(6, 'farkado@cas.au.dk', '$2y$13$ZFjnuxJZWENioCLj4pP.Puha05uLX7rTMFENBhbI20TUoBSSRbfuO', 'mfswpj3lbi804cc4cgcgow0o4k0sc48', 'ROLE_USER', NULL, 1485531358, NULL, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_user_field`
--

CREATE TABLE IF NOT EXISTS `ark_user_field` (
  `user_id` int(11) unsigned NOT NULL,
  `attribute` varchar(50) NOT NULL DEFAULT '',
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_user`
--
ALTER TABLE `ark_user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique_email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ark_user_field`
--
ALTER TABLE `ark_user_field`
 ADD PRIMARY KEY (`user_id`,`attribute`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_user`
--
ALTER TABLE `ark_user`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
