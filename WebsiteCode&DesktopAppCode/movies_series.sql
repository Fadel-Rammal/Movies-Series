-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 08:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movies&series`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowed`
--

CREATE TABLE `allowed` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowed`
--

INSERT INTO `allowed` (`id`, `user_id`, `movie_id`, `state`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 1, 8, 0),
(4, 1, 9, 1),
(5, 1, 13, 1),
(6, 1, 10, 1),
(7, 2, 13, 1),
(8, 2, 8, 0),
(9, 2, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `roomnb` int(11) NOT NULL,
  `shownb` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `time_booking` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `seat_id` varchar(255) NOT NULL,
  `movietitle` varchar(255) NOT NULL,
  `locationlink` varchar(500) NOT NULL,
  `cinemaloc` varchar(255) NOT NULL,
  `cinemanam` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL DEFAULT current_timestamp(),
  `end_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`roomnb`, `shownb`, `booking_id`, `user_id`, `time_booking`, `seat_id`, `movietitle`, `locationlink`, `cinemaloc`, `cinemanam`, `user`, `start_time`, `end_time`) VALUES
(1, 1, 1, '1', '2024-05-05 23:08:19', 'A-09,A-10', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Tyre', 'TyreCinema', 'fadel', '2024-05-12 23:00:00', '2024-05-13 00:30:00'),
(1, 1, 2, '1', '2024-05-05 23:29:19', 'A-01', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Tyre', 'TyreCinema', 'fadel', '2024-05-12 23:00:00', '2024-05-13 00:30:00'),
(1, 1, 3, '3', '2024-05-06 22:31:46', 'J-01,J-02,J-03,J-04,J-05,J-06,J-07,J-08,J-09,J-10', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Tyre', 'TyreCinema', 'zainab', '2024-05-12 23:00:00', '2024-05-13 00:30:00'),
(1, 1, 4, '1', '2024-05-12 19:24:26', 'A-02', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Tyre', 'TyreCinema', 'fadel', '2024-05-12 23:00:00', '2024-05-13 00:30:00'),
(1, 1, 5, '1', '2024-05-12 19:37:10', 'A-03', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Tyre', 'TyreCinema', 'fadel', '2024-05-12 23:00:00', '2024-05-13 00:30:00'),
(3, 2, 6, '1', '2024-05-14 23:39:41', 'A-02,A-09', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Nabatieh', 'NabatiehCinema', 'fadel', '2024-05-16 18:00:00', '2024-05-16 19:00:00'),
(4, 1, 7, '1', '2024-05-14 23:44:44', 'D-01', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Beirut', 'BeirutCinema', 'fadel', '2024-05-17 21:00:00', '2024-05-17 22:10:00'),
(1, 1, 8, '1', '2024-05-18 18:49:21', 'A-04', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Tyre', 'TyreCinema', 'fadel', '2024-05-12 23:00:00', '2024-05-13 00:30:00'),
(1, 1, 9, '1', '2024-05-18 18:49:41', 'E-05,E-06', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Tyre', 'TyreCinema', 'fadel', '2024-05-12 23:00:00', '2024-05-13 00:30:00'),
(3, 2, 10, '1', '2024-05-19 17:37:40', 'A-03', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Nabatieh', 'NabatiehCinema', 'fadel', '2024-05-16 18:00:00', '2024-05-16 19:00:00'),
(2, 1, 11, '1', '2024-05-21 09:11:50', 'A-01,A-02', 'Monkey Man', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Nabatieh', 'NabatiehCinema', 'fadel', '2024-05-17 13:00:00', '2024-05-17 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categorie_id` int(10) UNSIGNED NOT NULL,
  `categorie_name` varchar(191) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categorie_id`, `categorie_name`) VALUES
(1, 'action'),
(2, 'adventure'),
(3, 'comedy'),
(4, 'drama'),
(5, 'fantasy'),
(6, 'horror'),
(7, 'musicals'),
(8, 'mystery'),
(9, 'romance'),
(10, 'science fiction'),
(11, 'sports'),
(12, 'thriller');

-- --------------------------------------------------------

--
-- Table structure for table `changemovie`
--

CREATE TABLE `changemovie` (
  `roomnb` int(11) NOT NULL,
  `cinemaloc` varchar(255) NOT NULL,
  `cinemanam` varchar(255) NOT NULL,
  `maplink` varchar(500) NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `changeID` int(11) NOT NULL,
  `start_time` datetime NOT NULL DEFAULT current_timestamp(),
  `end_time` datetime NOT NULL DEFAULT current_timestamp(),
  `shownb` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `changemovie`
--

INSERT INTO `changemovie` (`roomnb`, `cinemaloc`, `cinemanam`, `maplink`, `movie_name`, `changeID`, `start_time`, `end_time`, `shownb`) VALUES
(1, 'Tyre', 'TyreCinema', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Monkey Man', 1, '2024-05-12 23:00:00', '2024-05-13 00:30:00', 1),
(1, 'Tyre', 'TyreCinema2', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Monkey Man', 4, '2024-05-15 11:30:00', '2024-05-15 12:30:00', 1),
(3, 'Nabatieh', 'NabatiehCinema', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Monkey Man', 5, '2024-05-16 18:00:00', '2024-05-16 19:00:00', 2),
(4, 'Beirut', 'BeirutCinema', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Monkey Man', 6, '2024-05-17 21:00:00', '2024-05-17 22:10:00', 1),
(2, 'Nabatieh', 'NabatiehCinema', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.775177849509!2d35.49448187478212!3d33.37693505308791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151e94b700394065%3A0x3dd2fe4a0549d02c!2sLebanese%20International%20University%2C%20Nabatieh%20Campus!5e0!3m2!1sen!2slb!4v1714246776689!5m2!1sen!2slb', 'Monkey Man', 7, '2024-05-17 13:00:00', '2024-05-17 14:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedbackform`
--

CREATE TABLE `feedbackform` (
  `movie_title` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `feedid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedbackform`
--

INSERT INTO `feedbackform` (`movie_title`, `rating`, `feedback`, `feedid`, `username`) VALUES
('Kung Fu Panda 4', 3, 'fa5emmmmm', 1, 'fadel'),
('Tom & Jerry', 4, 'Best children movie', 2, 'fadel');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(10) UNSIGNED NOT NULL,
  `movie_title` varchar(191) NOT NULL,
  `durations` varchar(50) NOT NULL,
  `movie_image` varchar(254) NOT NULL,
  `categorie_id` int(10) UNSIGNED NOT NULL,
  `rating` text DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `movie_status` varchar(20) NOT NULL,
  `release_date` varchar(50) DEFAULT NULL,
  `url_trailer` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_title`, `durations`, `movie_image`, `categorie_id`, `rating`, `description`, `movie_status`, `release_date`, `url_trailer`) VALUES
(1, 'Kung Fu Panda 4', '1h 30 minutes', 'kungfu.jpg', 2, '6.3', 'To defeat the Chameleon, Po must accept the help of a quick-witted thieving fox (Awkwafina), and they set out on a quest to protect the Valley of Peace and prevent their enemies from coming back.', 'online', '2024-03-08', '<iframe width=\"1499\" height=\"543\" src=\"https://www.youtube.com/embed/_inKs4eeHiI\" title=\"KUNG FU PANDA 4 | Official Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(2, 'Monkey Man', '1h 30 minutes', 'monkey-man.jpg', 1, '7', 'Inspired by the legend of Hanuman, an icon embodying strength and courage, Monkey Man stars Dev Patel as Kid, an anonymous young man who ekes out a meager living in an underground fight club where, night after night, wearing a gorilla mask, he is beaten bloody by more popular fighters for cash', 'oncinema', '2024-05-12', '<iframe width=\"853\" height=\"480\" src=\"https://www.youtube.com/embed/g8zxiB5Qhsc\" title=\"Monkey Man | Official Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(3, 'Bad Boys: Ride or Die', '1h 50 minutes', 'bad boys rider.jpg', 1, '8', 'This Summer, the world\'s favorite Bad Boys are back with their iconic mix of edge-of-your seat action and outrageous comedy but this time with a twist: Miami\'s finest are now on the run.', 'oncinema', '2024-06-07', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/ZTQyMmz-cQE\" title=\"BAD BOYS: RIDE OR DIE – Final Trailer (HD)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(4, 'bala hayba', '1h 54 minutes', 'bala hayba.jpg', 3, '8.5', 'Abbas Jaafar will defy his own clan to gain Stephanie\'s heart in the much awaited comedy movie Bala Hayba.', 'oncinema', '2019-08-08', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/_TZGYdy0f3s\" title=\"BALA HAYBA Official Trailer - In cinemas August 8\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(5, 'Ghostbusters: Frozen Empire', '1h 55 minutes', 'ghost busters.jpg', 2, '6.2', 'When the discovery of an ancient artifact unleashes an evil force, Ghostbusters new and old must join forces to protect their home and save the world from a second ice age.', 'oncinema', '2024-03-22', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/HpOBXh02rVc\" title=\"GHOSTBUSTERS: FROZEN EMPIRE - Official Trailer (HD)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(6, 'Interstellar', '2h 49 minutes', 'interstellar.jpg', 4, '8.7', 'When Earth becomes uninhabitable in the future, a farmer and ex-NASA pilot, Joseph Cooper, is tasked to pilot a spacecraft, along with a team of researchers, to find a new planet for humans.', 'oncinema', '2014-11-06', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/2LqzF5WauAw\" title=\"Interstellar Movie - Official Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(7, 'Under Paris', '1h 41 minutes', 'under paris .jpg', 6, '8.7', 'Sophia, a brilliant scientist comes to know that a large shark is swimming deep in the river.', 'oncinema', '2024-06-05', '<iframe width=\"400\" height=\"225\" src=\"https://www.youtube.com/embed/Z3mBJqDHdjc\" title=\"UNDER PARIS Trailer (2024) Netflix Shark Movie\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(8, 'Chucky', '42 minutes', 'chucky.jpg', 6, '7.3', 'After a vintage Chucky doll turns up at a suburban yard sale, an idyllic American town is thrown into chaos as a series of horrifying murders begin to expose the town\'s hypocrisies and secrets.', 'online', '2021-10-12', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/BDSa0JhIUMI\" title=\"CHUCKY Trailer (2021)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(9, 'The Dark Knight', '2h 32 minutes', 'dark knight .jpg', 1, '9', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.', 'online', '2008-07-24', '<iframe width=\"929\" height=\"395\" src=\"https://www.youtube.com/embed/EXeTwQWrcwY\" title=\"The Dark Knight (2008) Official Trailer #1 - Christopher Nolan Movie HD\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(10, 'Harry Potter and the Deathly Hallows: Part 2', '2h 10 minutes', 'harry potter and the deathly hallows 2.jpg', 2, '8.1', 'Harry, Ron, and Hermione search for Voldemort\'s remaining Horcruxes in their effort to destroy the Dark Lord as the final battle rages on at Hogwarts.', 'online', '2011-07-15', '<iframe width=\"929\" height=\"395\" src=\"https://www.youtube.com/embed/mObK5XD8udk\" title=\"&quot;Harry Potter and the Deathly Hallows - Part 2&quot; Trailer 1\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(11, 'Mower Minions', '04 minutes', 'Mower minions.jpg', 3, '6.7', 'The Minions need to raise $20 to purchase an as seen on TV banana blender, so they take up lawn mowing at an old folks home, with hilarious antics.', 'online', '2016-07-08', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/gL4cKDNu5NU\" title=\"MOWER MINIONS Trailer (2016)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(12, 'Tom & Jerry', '1h 41 minutes', 'tom and jerry.jpg', 2, '5.3', 'A chaotic battle ensues between Jerry Mouse, who has taken refuge in the Royal Gate Hotel, and Tom Cat, who is hired to drive him away before the day of a big wedding arrives.', 'online', '2021-02-26', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/ig1AWUbw0hQ\" title=\"TOM AND JERRY Trailer (2021)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(13, 'The Fault in Our Stars', '2h 00 minutes', 'the fault in our stars.jpg', 9, '7.7', 'Hazel and Gus are teenagers who meet at a cancer support group and fall in love. They both share the same acerbic wit and a love of books, especially \"An Imperial Affliction\", so they embark on a journey to visit an author in Amsterdam.', 'online', '2014-06-06', '<iframe width=\"929\" height=\"523\" src=\"https://www.youtube.com/embed/C99rqP-lMjM\" title=\"The Fault in Our Stars | Extended Trailer [HD] | 20th Century FOX\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(16, 'Fast X', '2h 21 minutes', 'fast x.jpg', 1, '5.8', 'Dom Toretto and his family are targeted by the vengeful son of drug kingpin Hernan Reyes.', 'oncinema', '2023-05-19', '<iframe width=\"882\" height=\"496\" src=\"https://www.youtube.com/embed/32RAq6JzY-w\" title=\"FAST X | Official Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(17, 'The Smurfs', '1h 43 minutes', 'the smurfs.jpg', 3, '5.4', 'When the evil wizard Gargamel chases the tiny blue Smurfs out of their village, they tumble from their magical world into New York City.', 'online', '2011-07-29', '<iframe width=\"882\" height=\"496\" src=\"https://www.youtube.com/embed/yhBpgqXwrt8\" title=\"The Smurfs - Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(15, 'Dayaa Dayaa', '10 minutes', 'day3a.png', 3, '9.6', 'The interesting, funny, and symbolic events in a Syrian village inhabited by its simple and good hearted citizens.', 'online', '2008-06-17', '<iframe width=\"882\" height=\"496\" src=\"https://www.youtube.com/embed/grn5zMuDdLs\" title=\"اسعد وجودة الشروط والمكدوس - مقطع مضحك جداً - ضيعة ضايعة - HD\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>'),
(18, 'Avatar: The Way of Water', '3h 12 minutes', 'avatar.jpg', 5, '7.5', 'Jake Sully lives with his newfound family formed on the extrasolar moon Pandora. Once a familiar threat returns to finish what was previously started, Jake must work with Neytiri and the army of the Na\'vi race to protect their home.', 'oncinema', '2022-12-16', '<iframe width=\"882\" height=\"496\" src=\"https://www.youtube.com/embed/d9MyW72ELq0\" title=\"Avatar: The Way of Water | Official Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `m_state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`id`, `user_id`, `m_state`) VALUES
(1, 1, 'disabled'),
(4, 2, 'disabled'),
(5, 3, 'disabled');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `credits` int(11) NOT NULL,
  `encryption_key` varchar(255) NOT NULL,
  `status` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `end_subscription_today` tinyint(1) NOT NULL DEFAULT 0,
  `start_subscription` datetime DEFAULT NULL,
  `end_subscription` datetime DEFAULT NULL,
  `deduction_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `firstName`, `lastName`, `email`, `password`, `credits`, `encryption_key`, `status`, `end_subscription_today`, `start_subscription`, `end_subscription`, `deduction_time`) VALUES
(1, 'fadel', 'ra', 'fadel@gmail.com', '$2y$10$S5XgoY5T52B8.24uUHD/DOIph/xR2K/1ytoZu/QDsP5DcIBChDH6G', 40, 'dac7c9677fd9b3e0c5a54cf3096104a3', 'active', 0, '2024-05-19 23:28:11', NULL, '2024-05-19 23:31:30'),
(2, 'fadell', 'raa', 'fadell@gmail.com', '$2y$10$u/xmIH0AMb8Q2XTOBFWSDethpbChw0nOwAquW3h9FrhVJwe0y/OKO', 1023, '23bba4fc49b51dcab35022941eef38d4', 'active', 0, '2024-05-20 15:19:57', NULL, NULL),
(3, 'zainab', 'fa', 'zainab@gmail.com', '$2y$10$ooW44oark.2Ftkxk7Fvhqeaz.lvE..SM3wIA6R5NgTq4UvcYgg.Py', 98, 'fdc214b6b3ceaa7d1395daa57b120c3d', 'active', 0, '2024-05-06 18:11:30', NULL, '2024-05-19 23:31:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowed`
--
ALTER TABLE `allowed`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_movie` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `changemovie`
--
ALTER TABLE `changemovie`
  ADD PRIMARY KEY (`changeID`);

--
-- Indexes for table `feedbackform`
--
ALTER TABLE `feedbackform`
  ADD PRIMARY KEY (`feedid`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD KEY `category_id` (`categorie_id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowed`
--
ALTER TABLE `allowed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `changemovie`
--
ALTER TABLE `changemovie`
  MODIFY `changeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedbackform`
--
ALTER TABLE `feedbackform`
  MODIFY `feedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
