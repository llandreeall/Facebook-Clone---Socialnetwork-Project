-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: ian. 07, 2020 la 05:15 PM
-- Versiune server: 10.4.10-MariaDB
-- Versiune PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `socialnetwork`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `posted_at` datetime NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `comments`
--

INSERT INTO `comments` (`id`, `comment`, `id_user`, `posted_at`, `post_id`) VALUES
(10, 'Vreau si eu', 13, '2020-01-04 12:31:57', 19),
(11, 'Little birb', 13, '2020-01-04 12:32:24', 16),
(12, 'Ca pasarea cerului', 14, '2020-01-04 12:38:29', 17),
(13, 'cip cip', 14, '2020-01-04 12:39:25', 16),
(14, 'yassss', 15, '2020-01-04 12:42:30', 20);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `followers`
--

CREATE TABLE `followers` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `follower_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `followers`
--

INSERT INTO `followers` (`id`, `id_user`, `follower_id`) VALUES
(11, 12, 13),
(12, 11, 13),
(13, 11, 14),
(14, 12, 14),
(15, 13, 14),
(16, 11, 15),
(17, 12, 15),
(18, 13, 15),
(19, 14, 15);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `login_cookies`
--

CREATE TABLE `login_cookies` (
  `id` int(10) UNSIGNED NOT NULL,
  `cookies` char(64) NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `body` varchar(200) NOT NULL,
  `posted_at` datetime NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL,
  `postimg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `posts`
--

INSERT INTO `posts` (`id`, `body`, `posted_at`, `id_user`, `likes`, `postimg`) VALUES
(16, '', '2020-01-04 11:55:37', 11, 2, 'https://i.imgur.com/BSyLlpC.jpg'),
(17, 'Liber', '2020-01-04 12:01:10', 11, 2, 'https://i.imgur.com/8NwNGkH.jpg'),
(18, '', '2020-01-04 12:10:52', 12, 2, 'https://i.imgur.com/iV9BL2k.jpg'),
(19, '', '2020-01-04 12:12:34', 12, 2, 'https://i.imgur.com/HUjZ8oX.jpg'),
(20, 'ARTA', '2020-01-04 12:15:01', 13, 1, 'https://i.imgur.com/ghYcSCh.jpg'),
(21, '', '2020-01-04 12:34:49', 14, 1, 'https://i.imgur.com/ku7sr8u.png'),
(22, 'Nimic nu se compara cu o cana de ceai', '2020-01-04 12:36:23', 14, 1, 'https://i.imgur.com/4yTaeCh.jpg'),
(23, 'Vand', '2020-01-04 12:36:57', 14, 0, 'https://i.imgur.com/6wipXBZ.jpg'),
(24, '', '2020-01-04 12:37:34', 14, 1, 'https://i.imgur.com/aQIh368.jpg');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `id_user`) VALUES
(45, 18, 13),
(46, 17, 13),
(48, 19, 13),
(49, 16, 13),
(50, 21, 14),
(51, 22, 14),
(52, 24, 14),
(55, 17, 14),
(56, 19, 14),
(57, 18, 14),
(58, 16, 14),
(59, 20, 15);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `profileimg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `profileimg`) VALUES
(11, 'pecataaa', '$2y$10$MWTIAAITzC0JBxKGJlAd0OYNb/Bz48qvzF/2RRmzgx1gZ2gpIpyyK', 'pecataaa@yahoo.com', 'https://i.imgur.com/zcCapAK.png'),
(12, 'oleacamoldova', '$2y$10$XZok6Yiz8rnDuwZCJENzrOmiivKluek.u7cVoNYtHOisBcTPM3XYO', 'oleacamoldova@yahoo.com', 'https://i.imgur.com/JYU8s4t.png'),
(13, 'opendoors', '$2y$10$JpiXmajijqIk.CLgNFTMFexVBbf.kTMsJdHUmzJTYQoS7Rru9xEFy', 'opendoors@yahoo.com', 'https://i.imgur.com/n2KJCse.png'),
(14, 'roxyfoxy', '$2y$10$bBCdvBRVGFfw833BPwIBs.It9qWjF838VxLWAkMCkgEKpdfq1QaYa', 'roxyfoxy@yahoo.com', 'https://i.imgur.com/vMUvdjH.jpg'),
(15, 'florentinatuca', '$2y$10$XB6EtTV0x3pah/bPfhl2t.UsPVRgIrvTqhkpwbM2K8C7ANJtPAfge', 'florentinatuca@yahoo.com', 'https://i.imgur.com/2JJVTNr.png');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexuri pentru tabele `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `login_cookies`
--
ALTER TABLE `login_cookies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cookies` (`cookies`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexuri pentru tabele `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexuri pentru tabele `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pentru tabele `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pentru tabele `login_cookies`
--
ALTER TABLE `login_cookies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pentru tabele `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pentru tabele `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constrângeri pentru tabele `login_cookies`
--
ALTER TABLE `login_cookies`
  ADD CONSTRAINT `login_cookies_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constrângeri pentru tabele `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
