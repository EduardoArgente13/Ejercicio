-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2023 at 09:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repositories`
--

-- --------------------------------------------------------

--
-- Table structure for table `repos`
--

CREATE TABLE `repos` (
  `id` int(11) UNSIGNED NOT NULL,
  `repo_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `owner_login` varchar(255) NOT NULL,
  `owner_avatar_url` text NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repos`
--

INSERT INTO `repos` (`id`, `repo_id`, `name`, `full_name`, `description`, `created_at`, `updated_at`, `owner_login`, `owner_avatar_url`, `is_new`) VALUES
(1, 120158234, 'i2p.i2p', 'PimpTrizkit/i2p.i2p', 'My purpose here is to get my feet wet with i2pSnark. I\'m not trying to do anything real here... just yet. I\'m just seeing how interested I will be in working with i2pSnark. -------- I2P is an anonymizing network, offering a simple layer that identity-sensitive applications can use to securely communicate. All data is wrapped with several layers of encryption, and the network is both distributed and dynamic, with no trusted parties. This is a mirror of the official Monotone repository.', '2018-02-04 06:36:41', '2018-02-14 02:04:05', 'PimpTrizkit', 'https://avatars.githubusercontent.com/u/12415937?v=4', 0),
(2, 124007217, 'PJs', 'PimpTrizkit/PJs', 'Pimped Javascript - Just a library of my javascript functions, or shims. They are generally built for speed, size, versatility, and portability (copy and paste-able). Readability will be sacrificed. Because they are optimized for usage right out-of-the-box. ', '2018-03-06 03:16:21', '2023-08-09 00:11:36', 'PimpTrizkit', 'https://avatars.githubusercontent.com/u/12415937?v=4', 0),
(3, 222126115, 'binpack', 'majimboo/binpack', NULL, '2019-11-16 17:18:09', '2019-11-16 17:18:26', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(4, 30377059, 'buffer-crc32', 'majimboo/buffer-crc32', 'A pure javascript CRC32 algorithm that plays nice with binary data', '2015-02-05 21:35:44', '2015-02-09 23:05:42', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(5, 22294335, 'c-struct', 'majimboo/c-struct', 'a binary data packing & unpacking library for node.js', '2014-07-26 21:16:06', '2023-04-15 02:34:50', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(6, 24547023, 'ensemble', 'majimboo/ensemble', 'Simple, Elegant Discussion Board', '2014-09-28 03:33:24', '2014-09-28 03:35:23', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(7, 270338106, 'fb_createdate_approximator', 'majimboo/fb_createdate_approximator', 'Approximate the date a facebook account was created', '2020-06-07 16:53:34', '2023-07-18 16:04:51', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(8, 23196786, 'kamote', 'majimboo/kamote', 'Yet another RPC for Node.', '2014-08-21 19:41:41', '2021-08-15 02:27:32', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(9, 199174878, 'khan-3rdparty', 'majimboo/khan-3rdparty', NULL, '2019-07-27 16:27:23', '2022-06-24 14:08:43', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(10, 98222196, 'khxn-xttxck', 'majimboo/khxn-xttxck', 'for Erwin with love...', '2017-07-24 20:30:13', '2017-07-25 05:38:12', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(11, 56774487, 'login-checker', 'majimboo/login-checker', NULL, '2016-04-21 15:06:33', '2020-09-20 18:45:18', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(12, 81162069, 'logrus', 'majimboo/logrus', 'Structured, pluggable logging for Go.', '2017-02-07 04:27:34', '2017-02-07 04:27:36', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(13, 401290088, 'majimboo', 'majimboo/majimboo', NULL, '2021-08-30 11:39:13', '2021-08-30 11:46:23', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(14, 22349206, 'majimboo.github.io', 'majimboo/majimboo.github.io', NULL, '2014-07-28 18:13:28', '2017-07-06 06:15:20', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(15, 46245698, 'meteor-test-project', 'majimboo/meteor-test-project', 'snapzio', '2015-11-16 02:55:53', '2015-11-16 17:23:30', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(16, 91309689, 'mviewer', 'majimboo/mviewer', 'Reverse Engineer MView 3D File Format', '2017-05-15 09:49:21', '2023-08-05 19:12:20', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(17, 22129727, 'nexy', 'majimboo/nexy', 'Nexy is a middleware based TCP framework for Node', '2014-07-23 05:02:21', '2017-10-28 13:41:15', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(18, 22865135, 'node', 'majimboo/node', 'evented I/O for v8 javascript', '2014-08-12 06:49:56', '2014-08-12 07:11:09', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(19, 22830736, 'node-benchmarks', 'majimboo/node-benchmarks', 'Benchmarking various operations in Node.JS', '2014-08-11 09:34:21', '2023-04-13 16:26:29', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(20, 23061789, 'node-fast-buffer', 'majimboo/node-fast-buffer', 'A faster way of handling buffers.', '2014-08-18 09:00:42', '2014-10-03 05:49:04', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(21, 24496260, 'node-multistore', 'majimboo/node-multistore', 'For Marco Babes (re)Viewing Pleasure', '2014-09-26 12:53:51', '2014-10-20 17:57:46', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(22, 24577916, 'notes', 'majimboo/notes', 'Just Learning Stuff', '2014-09-29 04:59:55', '2014-09-29 06:21:29', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(23, 74562321, 'playcanvas-engine', 'majimboo/playcanvas-engine', 'JavaScript game engine built on WebGL and WebVR.', '2016-11-23 10:41:51', '2016-11-23 11:03:20', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(24, 73869851, 'py-mathutils', 'majimboo/py-mathutils', 'A fix of https://pypi.python.org/pypi/mathutils', '2016-11-16 02:05:58', '2023-04-17 10:51:01', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(25, 30586831, 'reloadjs', 'majimboo/reloadjs', 'Just another hotload module', '2015-02-10 11:22:58', '2019-03-03 06:45:46', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(26, 22465569, 'roBrowser', 'majimboo/roBrowser', 'roBrowser is a free and open-source implementation of the Ragnarok Online MMORPG for web browsers written from scratch using the latest web standards (WebGL, HTML5, File API, Javascript, Threads, ...).', '2014-07-31 12:31:18', '2018-02-14 00:53:53', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(27, 44723879, 'snappy', 'majimboo/snappy', 'The Rockettoise', '2015-10-22 07:23:10', '2015-10-22 08:04:44', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(28, 22260949, 'stream-frame', 'majimboo/stream-frame', 'a stream framing library for node.js', '2014-07-25 17:08:10', '2023-06-08 16:51:22', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(29, 19306876, 'tapsilog', 'majimboo/tapsilog', 'an asynchronous logging service', '2014-04-30 10:33:11', '2014-06-09 09:25:36', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(30, 17535387, 'thumborizer', 'majimboo/thumborizer', 'A image processing server in node', '2014-03-08 05:52:22', '2017-07-06 06:15:10', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(31, 24083017, 'weebchat', 'majimboo/weebchat', 'Dynamically Distributed Telnet Chat Server', '2014-09-16 04:55:29', '2016-08-31 01:01:49', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(32, 22672492, 'winston-couchbase', 'majimboo/winston-couchbase', 'A couchbase transport for winston.', '2014-08-06 08:43:38', '2018-01-03 07:03:46', 'majimboo', 'https://avatars.githubusercontent.com/u/6186420?v=4', 0),
(35, 0, 'hola', 'sefcsevrsv', 'ferfverv', '2023-08-01 13:03:00', '2023-08-03 13:03:00', 'verv', 'https://www.google.com/search?client=opera-gx&q=imagenes&sourceid=opera&ie=UTF-8&oe=UTF-8#vhid=aVgXecnmQ_f1MM&vssid=l', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `repos`
--
ALTER TABLE `repos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `repos`
--
ALTER TABLE `repos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
